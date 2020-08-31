<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\allergie;
use App\Models\Appointment;
use App\Models\Schedule;
use App\LabUtils\Util;
use App\Models\Test;
use App\AccountTransaction;
use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\CustomerGroup;
use App\Product;
use App\PurchaseLine;
use App\TaxRate;
use App\Transaction;
use App\User;
use App\LabUtils\BusinessUtil;

use App\LabUtils\ModuleUtil;
use App\LabUtils\ProductUtil;
use App\LabUtils\TransactionUtil;

use App\Variation;

use App\Models\Prescription;
use App\Models\TestSell;
use App\Models\Prescription_History;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class PrescriptionController extends Controller
{
 /**
     * All LabUtils instance.
     *
     */
    protected $productUtil;
    protected $transactionUtil;
    protected $moduleUtil;
    protected $commonUtil;
    

    /**
     * Constructor
     *
     * @param ProductLabUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil, BusinessUtil $businessUtil, ModuleUtil $moduleUtil,Util $commonUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->dummyPaymentLine = ['method' => 'cash', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
        'is_return' => 0, 'transaction_no' => ''];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (!auth()->user()->can('prescription.view') && !auth()->user()->can('prescription.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        if (request()->ajax()) {
            $Prescription = Prescription::leftJoin('contacts', 'prescriptions.contact_id', '=', 'contacts.id')
            ->join(
                'prescription__histories AS PH',
                'prescriptions.id',
                '=',
                'PH.prescription_id'
            )
            ->leftJoin('users as u', 'prescriptions.doctor_id', '=', 'u.id')
            ->leftJoin(
                'appointments AS APPO',
                'prescriptions.appointments_id',
                '=',
                'APPO.id'
            )
            ->where('prescriptions.business_id', $business_id)
            ->select([
                   'contacts.name',
                   
                   'prescriptions.id as id',
                   'APPO.appointment_id as appointments_id',
                   'APPO.token_no as token_no',
                   'prescriptions.date as date',
                   'prescriptions.advice as advice',
                   'prescriptions.note as note',
                   'PH.weight as weight',
                   'PH.temperature as temperature',
                   DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by")

                    ])
                    ->groupBy('prescriptions.id')
                    ->orderBy('date','desc');
                    
            
                if (!empty(request()->patient_id)) {
                    $Prescription->where('prescriptions.contact_id', request()->patient_id);
                   
                }
                if (!empty(request()->doctor_id )) {
                    $Prescription->where('prescriptions.doctor_id', request()->doctor_id);
                  
                }
                if (!empty(request()->start_date) && !empty(request()->end_date)) {
                    $start = request()->start_date;
                    $end =  request()->end_date;
                    $Prescription->whereDate('prescriptions.date', '>=', $start)
                                ->whereDate('prescriptions.date', '<=', $end);
                }
             
                
               

                $Prescription->get();
                return Datatables::of($Prescription)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                                data-toggle="dropdown" aria-expanded="false">' .
                                __("messages.actions") .
                                '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">';
                          
                    if (auth()->user()->can("prescription.view")) {
                       
                        $html .= '<li><a href="#" data-href="' . action('Lab\PrescriptionController@show', [$row->id]) . '" class="btn-modal" data-container=".view_modal"><i class="fas fa-eye" aria-hidden="true"></i>' . __("messages.view") . '</a></li>';
                    
                     }
                        
                    if (auth()->user()->can("prescription.update")) {
                
                        
                                $html .= '<li><a href="' . action('Lab\PrescriptionController@edit', [$row->id]) . '"><i class="fas fa-edit"></i>' . __("messages.edit") . '</a></li>';

                    }
                    if (auth()->user()->can("prescription.delete")) {
                        $html .= '<li><a href="' . action('Lab\PrescriptionController@destroy', [$row->id]) . '" class="delete-purchase"><i class="fas fa-trash"></i>' . __("messages.delete") . '</a></li>';
                    }
                  $html .=  '</ul></div>';
                    return $html;
                })
             
                // ->editColumn('doctor_id', function ($row) {
                //     if (!empty($row->doctor_id)) {
                //         $query = User::where('type','doctor')
                //         ->find($row->doctor_id);
                
                //         return $query->surname.' '.$query->username.' '.$query->last_name;
                //     }
                   
                // })
                // ->editColumn('appointments_id', function ($row) {
                //     if (!empty($row->appointments_id)) {
                //         $query = Appointment::where('id',$row->appointments_id)->first();
                //         if (!empty($query->appointment_id)) {
                //         return $query->appointment_id;
                //         }
                //     }
                   
                // })
            
            
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make(true);
        }
        
        $business_locations = BusinessLocation::labforDropdown($business_id);
        $suppliers = Contact::suppliersDropdown($business_id, false);
        $orderStatuses = $this->productUtil->orderStatuses();
        $customers = Contact::customersDropdown($business_id,false);
        $doctor=User::allDoctorDropdown($business_id);
      

        $appointment_status=['Pending Confirmation','Confirmed','Treated','cancelled'];
        return view('clanic/prescription.index')
            ->with(compact('business_locations', 'suppliers', 'orderStatuses',
            'customers','appointment_status','doctor'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('prescription.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        //Check if subscribed or not
        if (!$this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse();
        }
        $customers = Contact::customersDropdown($business_id,false);
        $doctor=User::allDoctorDropdown($business_id);
        $tests=Test::pluck('name','id');
        $default_datetime = $this->businessUtil->format_date('now', true);
        $users = User::allDoctorDropdown($business_id);
        return view('clanic/prescription.create')
        ->with(compact(
            'customers','doctor','tests','default_datetime','users'));
            
    }


    public function store(Request $request)
    {
        if (!auth()->user()->can('prescription.update')) {
            abort(403, 'Unauthorized action.');
        }
    
      
      try{
        $business_id = request()->session()->get('user.business_id');

        $input = $request->only(['height' ,'weight' ,'temperature' ,'respiratory_rate' ,'systole' ,'diastole' ,'heart_rate' ,
       'head_circumference' ,
       'oxygen_saturiation' ,
       'body_mass' ,
       'lean_body_mass' ,
       'body_fat_per' ,
        ]);
        $msg='';
        $Prescription = $request->only(['advice','test','medicine','clinical_record','validity','doctor_id','contact_id']);
        if(!empty($request->appointment_id)){
           
            $Appointment=Appointment::where('appointment_id',$request->appointment_id)->first();
            $Prescription['appointments_id']=$Appointment->id;
            $Prescription['business_id']=$business_id;
            $Prescription['date']=\Carbon::now()->toDateTimeString();
            DB::beginTransaction();
            $pre=Prescription::create($Prescription);
            $input['prescription_id']=$pre->id;
            $Prescription_History=Prescription_History::create($input);
            DB::commit();
            $url = $this->getInvoiceUrl($pre->id);
            $output = ['success' => 1,
            $msg => __('purchase.purchase_add_success')
        ];
            return redirect()->to($url . '?print_on_load=true');
        }
        else{  
              
            $output = ['success' => 0,
                            $msg => __("messages.something_went_wrong")
                        ];
        }
  
    
       
       
  } catch (\Exception $e) {
       DB::rollBack();
       \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
       $output = ['success' => 0,
       'msg' => $msg
   ];
  }
  
}
 /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('prescription.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = request()->session()->get('user.business_id');

        $pre=Prescription::where('id',$id)
        ->where('business_id',$business_id)
        ->with(['prescription_history','contact','appointment'])->first();
       
        $customers = Contact::customersDropdown($business_id,false);
        $doctor=User::allDoctorDropdown($business_id);
        $tests=Test::pluck('name','id');
        
        return view('clanic/prescription.edit')
            ->with(compact('pre','customers','doctor','tests'));


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
      
      if (!auth()->user()->can('prescription.update')) {
          abort(403, 'Unauthorized action.');
      }
      try {
      $input = $request->except('_token');
     
      $business_id = request()->session()->get('user.business_id');
      DB::beginTransaction();
      $Appointment=Appointment::where('appointment_id',$input['appointment_id'])->first();
      $input['appointments_id']=$Appointment->id;
      $input['business_id']=$business_id;
      $pre = Prescription::where('business_id', $business_id)->findOrFail($id);
      $pre->advice=$input['advice'];
      if(!empty($input['test'])){
        $pre->test=$input['test'];
      }
      else{
        $pre->test=null;
      }
      
      if(!empty($input['medicine'])){
      $pre->medicine=$input['medicine'];
    }
    else{
        $pre->medicine=null;
      }
      $pre->clinical_record=$input['clinical_record'];
      if(!empty($input['validity'])){
      $pre->validity=$input['validity'];
      }
      $pre->doctor_id=$input['doctor_id'];
      $pre->contact_id=$input['contact_id'];
      $pre->save();
      $prehis = Prescription_History::where('prescription_id', $id)->first();
      $prehis->height=$input['height'];
      $prehis->weight= $input['weight'];
      $prehis->temperature=$input['temperature'];
      $prehis->respiratory_rate=$input['respiratory_rate'];
      $prehis->systole=$input['systole'];
      $prehis->diastole=$input['diastole'];
      $prehis->heart_rate=$input['heart_rate'];
      $prehis->head_circumference=$input['head_circumference'];
      $prehis->oxygen_saturiation=$input['oxygen_saturiation'];
      $prehis->body_mass=$input['body_mass'];
      $prehis->lean_body_mass=$input['lean_body_mass'];
      $prehis->body_fat_per=$input['body_fat_per'];
      $prehis->save();


      DB::commit();
      
    
      $url = $this->getInvoiceUrl($pre->id);
     
      return redirect()->to($url . '?print_on_load=true');
     
} catch (\Exception $e) {
     DB::rollBack();
     \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
     $msg = trans("messages.something_went_wrong");
}

    }
        /**
     * Returns the content for the receipt
     *
     * @param  int  $business_id
     * @param  int  $location_id
     * @param  int  $transaction_id
     * @param string $printer_type = null
     *
     * @return array
     */
    private function receiptContent($id, $postion)

     {
        $output = ['is_enabled' => false,
                    'print_type' => 'browser',
                    'html_content' => null,
                    'printer_config' => [],
                    'data' => []
                ];


  
        //Check if printing of invoice is enabled or not.
        //If enabled, get print type.
        $output['is_enabled'] = true;


        //Check if printer setting is provided.
        $receipt_printer_type = null;

    
        $receipt_details = Prescription::where('id', $id)
        ->with(['prescription_history','contact','appointment'])->first();
        $tests=Test::get();
    
        
        //If print type browser - return the content, printer - return printer config data, and invoice format config
        if ($receipt_printer_type == 'printer') {
            $output['print_type'] = 'printer';
            $output['printer_config'] = $this->businessUtil->printerConfig($business_id, $location_details->printer_id);
            $output['data'] = $receipt_details;
        } else {
            $top_postion =  $postion;
          
                $output['html_content'] = view('clanic/prescription.slim', compact('receipt_details','tests','top_postion'))->render();

            
       
        }
        
        return $output;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('prescription.delete') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                
                $pres = Prescription::where('id',$id)->first();
                $pres->delete();
                    $output = ['success' => true,
                                'msg' => __("Prescription deleted successfully")
                                ];
                
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
     * Shows invoice to guest user.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function showInvoice($token)
    {
        $test_sell = Prescription::where('sub_unit_ids', $token)
        ->with(['prescription_history','contact','appointment'])->first();
      
        if (!empty($test_sell)) {
             $receipt = $this->receiptContent($test_sell->id, true);
        
            $title = $test_sell->contact->name . ' | ' . $test_sell->id;
            $top_postion = true;
            return view('clanic/prescription.show_invoice')
                    ->with(compact('receipt','title','top_postion'));
        } else {
            die(__("messages.something_went_wrong"));
        }
    }
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  if (!auth()->user()->can('prescription.view') ) {
        abort(403, 'Unauthorized action.');
    }

        $test_sell = Prescription::where('id', $id)
        ->with(['prescription_history','contact','appointment'])->first();
      
        if (!empty($test_sell)) {
            $receipt = $this->receiptContent($test_sell->id, true);

            $title = $test_sell->contact->name. ' | ' . $test_sell->id;
            $top_postion = true;
          
            return view('clanic/prescription.show_invoice')
            ->with(compact('receipt','title','top_postion'));
        } else {
            die(__("messages.something_went_wrong"));
        }
    }
 /**
     * Generates invoice url for the transaction
     *
     * @param int $transaction_id, int $business_id
     *
     * @return string
     */
    public function getInvoiceUrl($TestSell_id)
    {   
        $TestSell=Prescription::findOrFail($TestSell_id);
                            
       
        if (empty($TestSell->sub_unit_ids)) {
            $TestSell->sub_unit_ids = $this->generateToken();
            $TestSell->save();
        }

        return route('cal_show_invoice', ['token' => $TestSell->sub_unit_ids]);
    }
    /**
     * Generates unique token
     *
     * @param void
     *
     * @return string
     */
    public function generateToken()
    {
        return md5(rand(1, 10) . microtime());
    }
 /**
     * Retrieves schedule list.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_Patient()
    {
        if (request()->ajax()) {
            $patient_id= request()->patient;
            $doctor_id= request()->doctor;
            $date=\Carbon::now()->toDateString();
            $patients  = Contact::where('id',$patient_id)->get();
            $Appointment  = Appointment::where('contact_id',$patient_id)
            ->where('doctor_id',$doctor_id)
            ->where('date',$date)->latest()->first();
            
            if($Appointment==[]){
             return '';
            }
            else{
            $li='';
            foreach ($patients as $patient) {
              $li .= '<div class="text-center">'.'<h6>'. $patient->name.'</h6>'.' </div>';
            $li .='	<div class="" style="padding:20px">
            <ul class="nav">
                <li>P_ID<span class="pull-right">'. $patient->contact_id.'</span></li>
                <li>Age<span class="pull-right">'. $patient->age.'</span></li>
                <li>Gender<span class="pull-right">'. $patient->gender.'</span></li>
                <li>Marital<span class="pull-right">'. $patient->marital_status.'</span></li>
                <li>Address<span class="pull-right">'. $patient->city.' '. $patient->state.' '. $patient->country.'</span></li>
                <hr>'; 
            
                $li .='<li><span class="text-center">'.  $Appointment->appointment_id.'</span></li>';
              
                echo '<input type="hidden" readonly name="appointment_id" required value="' . $Appointment->appointment_id. '">';
                }
             
                $li .= '</ul></div>';

                return $li;
        }
 
        
            
                    
   
       
    }
}

    /**
     * Retrieves products list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts()
    {
        if (request()->ajax()) {
            $term = request()->term;

            $check_enable_stock = true;
            if (isset(request()->check_enable_stock)) {
                $check_enable_stock = filter_var(request()->check_enable_stock, FILTER_VALIDATE_BOOLEAN);
            }

            if (empty($term)) {
                return json_encode([]);
            }

            $business_id = request()->session()->get('user.business_id');
            $q = Product::leftJoin(
                'variations',
                'products.id',
                '=',
                'variations.product_id'
            )
                ->where(function ($query) use ($term) {
                    $query->where('products.name', 'like', '%' . $term .'%');
                    $query->orWhere('sku', 'like', '%' . $term .'%');
                    $query->orWhere('sub_sku', 'like', '%' . $term .'%');
                })
                ->active()
                ->where('business_id', $business_id)
                ->whereNull('variations.deleted_at')
                ->select(
                    'products.id as product_id',
                    'products.name',
                    'products.type',
                    // 'products.sku as sku',
                    'variations.id as variation_id',
                    'variations.name as variation',
                    'variations.sub_sku as sub_sku'
                )
                ->groupBy('variation_id');

            if ($check_enable_stock) {
                $q->where('enable_stock', 1);
            }
            if (!empty(request()->location_id)) {
                $q->ForLocation(request()->location_id);
            }
            $products = $q->get();
                
            $products_array = [];
            foreach ($products as $product) {
                $products_array[$product->product_id]['name'] = $product->name;
                $products_array[$product->product_id]['sku'] = $product->sub_sku;
                $products_array[$product->product_id]['type'] = $product->type;
                $products_array[$product->product_id]['variations'][]
                = [
                        'variation_id' => $product->variation_id,
                        'variation_name' => $product->variation,
                        'sub_sku' => $product->sub_sku
                        ];
            }

            $result = [];
            $i = 1;
            $no_of_records = $products->count();
            if (!empty($products_array)) {
                foreach ($products_array as $key => $value) {
                    if ($no_of_records > 1 && $value['type'] != 'single') {
                        $result[] = [ 'id' => $i,
                                    'text' => $value['name'] . ' - ' . $value['sku'],
                                    'variation_id' => 0,
                                    'product_id' => $key
                                ];
                    }
                    $name = $value['name'];
                    foreach ($value['variations'] as $variation) {
                        $text = $name;
                        if ($value['type'] == 'variable') {
                            $text = $text . ' (' . $variation['variation_name'] . ')';
                        }
                        $i++;
                        $result[] = [ 'id' => $i,
                                            'text' => $text . ' - ' . $variation['sub_sku'],
                                            'product_id' => $key ,
                                            'variation_id' => $variation['variation_id'],
                                        ];
                    }
                    $i++;
                }
            }
            
            return json_encode($result);
        }
    }

    
    /**
     * Retrieves products list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseEntryRow(Request $request)
    {
        if (request()->ajax()) {
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $business_id = request()->session()->get('user.business_id');

            $hide_tax = 'hide';
            if ($request->session()->get('business.enable_inline_tax') == 1) {
                $hide_tax = '';
            }

            $currency_details = $this->transactionUtil->purchaseCurrencyDetails($business_id);

            if (!empty($product_id)) {
                $row_count = $request->input('row_count');
              
                $product = Product::where('id', $product_id)
                                    ->with(['unit'])
                                    ->first();
                
                $sub_units = $this->productUtil->getSubUnits($business_id, $product->unit->id, false, $product_id);

                $query = Variation::where('product_id', $product_id)
                                        ->with(['product_variation']);
                if ($variation_id !== '0') {
                    $query->where('id', $variation_id);
                }

                $variations =  $query->get();
                
                $taxes = TaxRate::where('business_id', $business_id)
                            ->get();

                return view('clanic/prescription.purchase_entry_row')
                    ->with(compact(
                        'product',
                        'variations',
                        'row_count',
                        'variation_id',
                        'taxes',
                        'currency_details',
                        'hide_tax',
                        'sub_units'
                    ));
            }
        }
    }
    
    
}
