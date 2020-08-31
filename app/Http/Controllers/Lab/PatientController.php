<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\CustomerGroup;
use App\Notifications\CustomerNotification;
use App\PurchaseLine;
use App\Transaction;
use App\TransactionPayment;
use App\User;
use App\LabUtils\ModuleUtil;
use App\LabUtils\NotificationUtil;
use App\LabUtils\TransactionUtil;
use App\LabUtils\Util;
use DB;
use Excel;
use App\Models\nonpathologicalhistory;
use App\Models\Diet;
use App\Models\FamilyHistory;
use App\Models\pathologicalhistory;
use App\Models\phychiatrichistory;
use App\Models\allergie;
use App\Models\vaccine;
use App\Models\PatientDiet;
use App\Models\PatientVaccine;
use App\Models\PatientPhychiatrichistory;
use App\Models\PatientPathlogy;
use App\Models\PatientNonpathological;
use App\Models\PatientFamilyHistory;
use App\Models\PatientAllergie;


use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    
    protected $commonUtil;
    protected $transactionUtil;
    protected $moduleUtil;
    protected $notificationUtil;

    /**
     * Constructor
     *
     * @param Util $commonUtil
     * @return void
     */
    public function __construct(
        Util $commonUtil,
        ModuleUtil $moduleUtil,
        TransactionUtil $transactionUtil,
        NotificationUtil $notificationUtil
    ) {
        $this->commonUtil = $commonUtil;
        $this->moduleUtil = $moduleUtil;
        $this->transactionUtil = $transactionUtil;
        $this->notificationUtil = $notificationUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {      
        if (!auth()->user()->can('patient.view')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            $business_id = request()->session()->get('user.business_id');
            $query = Contact::where('business_id', $business_id)
            ->onlyCustomers()
           ->select(['id', 'name','gender','age','mobile','contact_id',
           
           'contacts.marital_status','email','blood_group','created_at',
           'city', 'state', 'country', 'landmark','ref_by'
               ]);
        // $pathologicalhistory = pathologicalhistory::where('business_id', $business_id)
        // ->with(['base_pathologicalhistory'])
        // ->select(['actual_name',  'id',
        //     'base_id']);

            return Datatables::of($query)
            ->addColumn('address', '{{implode(array_filter([$landmark, $city, $state, $country]), ", ")}}')
            
            ->addColumn(
                'action',
                '<div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                        data-toggle="dropdown" aria-expanded="false">' .
                        __("messages.actions") .
                        '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                    @can("patient.update")
                    <li><a href="{{action(\'Lab\\PatientController@edit\', [$id])}}" class="edit_patient_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a></li>
                @endcan
                @can("patient.delete")
                    <li><a href="{{action(\'Lab\\PatientController@destroy\', [$id])}}" class="delete_patient_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a></li>
                @endcan
             
                </ul></div>'
            )
         
            ->filterColumn('address', function ($query, $keyword) {
                $query->whereRaw("CONCAT(COALESCE(landmark, ''), ', ', COALESCE(city, ''), ', ', COALESCE(state, ''), ', ', COALESCE(country, '') ) like ?", ["%{$keyword}%"]);
            })
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('clanic/patient.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('patient.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        //Check if subscribed or not
        if (!$this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse();
        }
        // $customer_groups = CustomerGroup::forDropdown($business_id);
       
        $types = ['Male','Female','Other'];
        $blood_group=['A+','A-','B+','AB+','AB-','B-','O+','O-'];
        
        $query = User::where('business_id', $business_id)
        ->where('type','doctor');
        $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');
        return view('clanic/patient.create')->with(compact(
    'types','blood_group','users'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if (!auth()->user()->can('patient.create')) {
            abort(403, 'Unauthorized action.');
        }
      
        
  
           try {
            $business_id = $request->session()->get('user.business_id');

            if (!$this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse();
            }
            // 'marital_status'blood_group','ref_by',',
            $input = $request->only(['type', 
                'name', 'gender',   'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'age', 'contact_id',   'email']);
            $input['business_id'] = $business_id;
            $input['created_by'] = $request->session()->get('user.id');

            $input['credit_limit'] = null;
           
            //Check Contact id
            $count = 0;
            if (!empty($input['contact_id'])) {
                $count = Contact::where('business_id', $input['business_id'])
                                ->where('contact_id', $input['contact_id'])
                                ->count();
            }

            if ($count == 0) {
                //Update reference count
                $ref_count = $this->commonUtil->setAndGetReferenceCount('contacts');

                if (empty($input['contact_id'])) {
                    //Generate reference number
                    $input['contact_id'] = $this->commonUtil->generateReferenceNumber('contacts', $ref_count);
                }

                
                $input['type'] = "customer";
              
                $contact = Contact::create($input);
                $diet_data = Diet::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                       foreach ($diet_data as $value) {
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $value->base_id,
                               "diet_id" => $value->id);
                               $Patient_Diet =PatientDiet::create($data);
                       }
                       
       
           
               $nonpathologicalhistory_data = nonpathologicalhistory::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                
                   foreach($nonpathologicalhistory_data  as $item){  
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $item->base_id,
                               "nonpathological_id" => $item->id);
                       
                       $PatientNonpathological =PatientNonpathological::create($data);
                   }

           
               $FamilyHistory_data = FamilyHistory::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                   
                       foreach ($FamilyHistory_data as $value) {
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $value->base_id,
                               "family_history_id" => $value->id);
                               $PatientFamily =PatientFamilyHistory::create($data);
                       }
                       
                   

           
           
           
               $pathologicalhistory_data = pathologicalhistory::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                   
                       foreach ($pathologicalhistory_data as $value) {
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $value->base_id,
                               "pathologicalhistory_id" => $value->id);
                               $PatientPathlogy =PatientPathlogy::create($data);
                       }
                     
                   

           

           
               $phychiatrichistory_data = phychiatrichistory::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                   
                       foreach ($phychiatrichistory_data as $value) {
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $value->base_id,
                               "phychiatrichistorie_id" => $value->id);
                               $PatientPhychiatrichistory =PatientPhychiatrichistory::create($data);
                       }
                       
                   

           
          
           
               $allergie_data = allergie::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                       foreach ($allergie_data as $value) {
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $value->base_id,
                               "allergie_id" => $value->id);
                               $PatientAllergie =PatientAllergie::create($data);
                       }
                       
               $vaccine_data = vaccine::where('business_id', $business_id)
                ->whereNotNull('base_id')->get();
                       foreach ($vaccine_data as $value) {
                           $data = array(
                               "contact_id" => $contact->id,
                               "business_id" =>  $business_id ,
                               "base_id" => $value->base_id,
                               "vaccines_id" => $value->id);
                               $PatientVaccine =PatientVaccine::create($data);
                       }
                //Add opening balance
                if (!empty($request->input('opening_balance'))) {
                    $this->transactionUtil->createOpeningBalanceTransaction($business_id, $contact->id, $request->input('opening_balance'));
                }

                $output = ['success' => true,
                            'data' => $contact,
                            'msg' => __("contact.added_success")
                        ];
            } else {
                throw new \Exception("Error Processing Request", 1);
            }
           } catch (\Exception $e) {
           
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' =>__("messages.something_went_wrong")
                        ];
           }
             
        return $output;
    }
          /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if (!auth()->user()->can('patient.update')){
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $contact = Contact::where('business_id', $business_id)
            ->with(['contact_nonpathologicalhistory','contact_patient_diet',
            'contact_patient_familyhistory'
            ,'contact_patientpathlogy',
            'contact_patientphychiatrichistory','contact_patientallergie','contact_patientvaccine'])->find($id);
            // dd($contact->contact_nonpathologicalhistory);
            $nonpathological= nonpathologicalhistory::where('business_id', $business_id)
            ->whereNull('base_id')
            ->select('id','base_id','actual_name')->get();
            
            $nonpathologicaldata = nonpathologicalhistory::where('business_id', $business_id)
            ->whereNotNull('base_id')
            ->select('id','base_id','actual_name')->get();
            
            if (!$this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse();
            }

       
     
      
        $query = User::where('business_id', $business_id)
        ->where('type','doctor');
       
        $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');
      
        
       $diet= Diet::where('business_id', $business_id)
       ->whereNull('base_id')
       ->select('id','base_id','actual_name')->get();
       
       $diet_data = Diet::where('business_id', $business_id)
       ->whereNotNull('base_id')
       ->select('id','base_id','actual_name')->get();
       $Patient_Diet =PatientDiet::where('business_id', $business_id)
       ->where('contact_id',$id)->get();
       
       $familyhistory=FamilyHistory::where('business_id', $business_id)
       ->whereNull('base_id')
       ->select('id','base_id','actual_name')->get();
       
       $familyhistory_data = FamilyHistory::where('business_id', $business_id)
       ->whereNotNull('base_id')
       ->select('id','base_id','actual_name')->get();
       $PatientFamilyHistory=PatientFamilyHistory::where('business_id', $business_id)
       ->where('contact_id',$id)->get();
       $pathologicalhistory=pathologicalhistory::where('business_id', $business_id)
       ->whereNull('base_id')
       ->select('id','base_id','actual_name')->get();
       
       $pathologicalhistory_data = pathologicalhistory::where('business_id', $business_id)
       ->whereNotNull('base_id')
       ->select('id','base_id','actual_name')->get();
       $PatientPathlogy=PatientPathlogy::where('business_id', $business_id)
       ->where('contact_id',$id)->get();
       $phychiatrichistory=phychiatrichistory::where('business_id', $business_id)
       ->whereNull('base_id')
       ->select('id','base_id','actual_name')->get();
       
       $phychiatrichistory_data = phychiatrichistory::where('business_id', $business_id)
       ->whereNotNull('base_id')
       ->select('id','base_id','actual_name')->get();
       $PatientPhychiatrichistory=PatientPhychiatrichistory::where('business_id', $business_id)
       ->where('contact_id',$id)->get();
       $allergie=allergie::where('business_id', $business_id)
       ->whereNull('base_id')
       ->select('id','base_id','actual_name')->get();
       
       $allergie_data = allergie::where('business_id', $business_id)
       ->whereNotNull('base_id')
       ->select('id','base_id','actual_name')->get();
       $PatientAllergie=PatientAllergie::where('business_id', $business_id)
       ->where('contact_id',$id)->get();
       $vaccine=vaccine::where('business_id', $business_id)
       ->whereNull('base_id')
       ->select('id','base_id','actual_name')->get();
       
       $vaccine_data = vaccine::where('business_id', $business_id)
       ->whereNotNull('base_id')
       ->select('id','base_id','actual_name')->get();
       $PatientVaccine=PatientVaccine::where('business_id', $business_id)
       ->where('contact_id',$id)->get();
        return view('clanic/patient.edit')
                ->with(compact(
                    'diet','diet_data',
                    'nonpathological','nonpathologicaldata',
                    'familyhistory','familyhistory_data','pathologicalhistory',
                    'pathologicalhistory_data','phychiatrichistory','phychiatrichistory_data',
                    'allergie','allergie_data','vaccine','vaccine_data',
                    'contact','users'));
        }
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('patient.update') ) {
            abort(403, 'Unauthorized action.');
        }
    
        if (request()->ajax()) {
              try {
               // '',
                $business_id = request()->session()->get('user.business_id');
                $input = $request->only(['type', 
                'name', 'gender', 'ref_by', 'blood_group', 'marital_status','mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'age', 'contact_id',   'email']);
                $input['business_id'] = $business_id;
                $input['created_by'] = $request->session()->get('user.id');

                $input['credit_limit'] = null;
                //Check Contact id
                if (!empty($input['contact_id'])) {
                    $count = Contact::where('business_id', $business_id)
                            ->where('contact_id', $input['contact_id'])
                            ->where('id', '!=', $id)
                            ->count();
                }
                
                if ($count == 0) {
                    $contact = Contact::where('business_id', $business_id)->findOrFail($id);
                    foreach ($input as $key => $value) {
                        $contact->$key = $value;
                    }
                    $contact->save();

                   
                    if (!empty($request['nonpathological'])) {
                       
                        foreach($request['nonpathological'] as $value){
                        $patientnonpathological= PatientNonpathological::where('business_id', $business_id)
                        ->where('contact_id',$id)
                        ->where('id',$value)->get();
                        
                        foreach ($patientnonpathological as $key => $values) {
                            $patient= PatientNonpathological::where('business_id', $business_id)
                            ->where('contact_id',$id)
                            ->where('base_id',$values->base_id)->get();
                           
                            foreach($patient as $item){ 
                            $PatientNonpathological =PatientNonpathological::findOrFail($item->id);
                            $PatientNonpathological->check_box=0;
                            $PatientNonpathological->save();
                            
                        } 
                        }

                            foreach ($patientnonpathological as $key => $values) {
                                $PatientNonpathological =PatientNonpathological::findOrFail($values->id);
                                $PatientNonpathological->check_box=1;
                                $PatientNonpathological->save();
                                

                            }  
                        }
                        }
                        if (!empty($request['diet'])) {
                       
                            foreach($request['diet'] as $value){
                            $PatientDiet= PatientDiet::where('business_id', $business_id)
                            ->where('contact_id',$id)
                            ->where('id',$value)->get();
                            
                            foreach ($PatientDiet as $key => $values) {
                                $patient= PatientDiet::where('business_id', $business_id)
                                ->where('contact_id',$id)
                                ->where('base_id',$values->base_id)->get();
                               
                                foreach($patient as $item){ 
                                $Patient_diet =PatientDiet::findOrFail($item->id);
                                $Patient_diet->check_box=0;
                                $Patient_diet->save();
                                
                            } 
                            }
    
                                foreach ($PatientDiet as $key => $values) {
                                    $Patient_diet =PatientDiet::findOrFail($values->id);
                                    $Patient_diet->check_box=1;
                                    $Patient_diet->save();
                                    
    
                                }  
                            }
                            } 
                            
                            if (!empty($request['familyhistory'])) {
                       
                                foreach($request['familyhistory'] as $value){
                                $PatientFamilyHistory= PatientFamilyHistory::where('business_id', $business_id)
                                ->where('contact_id',$id)
                                ->where('id',$value)->get();
                                
                                foreach ($PatientFamilyHistory as $key => $values) {
                                    $patient= PatientFamilyHistory::where('business_id', $business_id)
                                    ->where('contact_id',$id)
                                    ->where('base_id',$values->base_id)->get();
                                   
                                    foreach($patient as $item){ 
                                    $Patient_family_history =PatientFamilyHistory::findOrFail($item->id);
                                    $Patient_family_history->check_box=0;
                                    $Patient_family_history->save();
                                    
                                } 
                                }
        
                                    foreach ($PatientFamilyHistory as $key => $values) {
                                        $Patient_family_history =PatientFamilyHistory::findOrFail($values->id);
                                        $Patient_family_history->check_box=1;
                                        $Patient_family_history->save();
                                        
        
                                    }  
                                }
                                } 
                                if (!empty($request['pathologicalhistory'])) {
                       
                                    foreach($request['pathologicalhistory'] as $value){
                                    $PatientPathlogy = PatientPathlogy::where('business_id', $business_id)
                                    ->where('contact_id',$id)
                                    ->where('id',$value)->get();
                                    
                                    foreach ($PatientPathlogy as $key => $values) {
                                        $patient= PatientPathlogy::where('business_id', $business_id)
                                        ->where('contact_id',$id)
                                        ->where('base_id',$values->base_id)->get();
                                       
                                        foreach($patient as $item){ 
                                        $Patient_pathlogy =PatientPathlogy::findOrFail($item->id);
                                        $Patient_pathlogy->check_box=0;
                                        $Patient_pathlogy->save();
                                        
                                    } 
                                    }
            
                                        foreach ($PatientPathlogy as $key => $values) {
                                            $Patient_pathlogy =PatientPathlogy::findOrFail($values->id);
                                            $Patient_pathlogy->check_box=1;
                                            $Patient_pathlogy->save();
                                            
            
                                        }  
                                    }
                                    }
                                    if (!empty($request['phychiatrichistory'])) {
                       
                                        foreach($request['phychiatrichistory'] as $value){
                                        $PatientPhychiatrichistory = PatientPhychiatrichistory::where('business_id', $business_id)
                                        ->where('contact_id',$id)
                                        ->where('id',$value)->get();
                                        
                                        foreach ($PatientPhychiatrichistory as $key => $values) {
                                            $patient= PatientPhychiatrichistory::where('business_id', $business_id)
                                            ->where('contact_id',$id)
                                            ->where('base_id',$values->base_id)->get();
                                           
                                            foreach($patient as $item){ 
                                            $Patient_phychiatric =PatientPhychiatrichistory::findOrFail($item->id);
                                            $Patient_phychiatric->check_box=0;
                                            $Patient_phychiatric->save();
                                            
                                        } 
                                        }
                
                                            foreach ($PatientPhychiatrichistory as $key => $values) {
                                                $Patient_phychiatric =PatientPhychiatrichistory::findOrFail($values->id);
                                                $Patient_phychiatric->check_box=1;
                                                $Patient_phychiatric->save();
                                                
                
                                            }  
                                        }
                                        }
                                        if (!empty($request['allergie'])) {
                       
                                            foreach($request['allergie'] as $value){
                                            $PatientAllergie = PatientAllergie::where('business_id', $business_id)
                                            ->where('contact_id',$id)
                                            ->where('id',$value)->get();
                                            
                                            foreach ($PatientAllergie as $key => $values) {
                                                $patient= PatientAllergie::where('business_id', $business_id)
                                                ->where('contact_id',$id)
                                                ->where('base_id',$values->base_id)->get();
                                               
                                                foreach($patient as $item){ 
                                                $Patient_allergie =PatientAllergie::findOrFail($item->id);
                                                $Patient_allergie->check_box=0;
                                                $Patient_allergie->save();
                                                
                                            } 
                                            }
                    
                                                foreach ($PatientAllergie as $key => $values) {
                                                    $Patient_allergie =PatientAllergie::findOrFail($values->id);
                                                    $Patient_allergie->check_box=1;
                                                    $Patient_allergie->save();
                                                    
                    
                                                }  
                                            }
                                            }
                                            if (!empty($request['vaccine'])) {
                       
                                                foreach($request['vaccine'] as $value){
                                                $PatientVaccine = PatientVaccine::where('business_id', $business_id)
                                                ->where('contact_id',$id)
                                                ->where('id',$value)->get();
                                                
                                                foreach ($PatientVaccine as $key => $values) {
                                                    $patient= PatientVaccine::where('business_id', $business_id)
                                                    ->where('contact_id',$id)
                                                    ->where('base_id',$values->base_id)->get();
                                                   
                                                    foreach($patient as $item){ 
                                                    $Patient_vaccine =PatientVaccine::findOrFail($item->id);
                                                    $Patient_vaccine->check_box=0;
                                                    $Patient_vaccine->save();
                                                    
                                                } 
                                                }
                        
                                                    foreach ($PatientVaccine as $key => $values) {
                                                        $Patient_vaccine =PatientVaccine::findOrFail($values->id);
                                                        $Patient_vaccine->check_box=1;
                                                        $Patient_vaccine->save();
                                                        
                        
                                                    }  
                                                }
                                                }
                
                    $output = ['success' => true,
                                'msg' => __("contact.updated_success")
                                ];
                } else {
                    throw new \Exception("Error Processing Request", 1);
                }
              } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
             }

            return $output;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('patient.delete') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                //Check if any transaction related to this contact exists
                $count = Transaction::where('business_id', $business_id)
                                    ->where('contact_id', $id)
                                    ->count();
                if ($count == 0) {
                    $contact = Contact::where('business_id', $business_id)->findOrFail($id);
                    if (!$contact->is_default) {
                        $contact->delete();
                    }
                    $output = ['success' => true,
                                'msg' => __("contact.deleted_success")
                                ];
                } else {
                    $output = ['success' => false,
                                'msg' => __("lang_v1.you_cannot_delete_this_contact")
                                ];
                }
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }
}
