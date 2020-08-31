<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use App\LabUtils\Util;

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

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class AppointmentController extends Controller
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
        if (!auth()->user()->can('appointment.view') && !auth()->user()->can('appointment.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        if (request()->ajax()) {
            $purchases = Transaction::leftJoin('contacts', 'transactions.contact_id', '=', 'contacts.id')
                    ->join(
                        'business_locations AS BS',
                        'transactions.location_id',
                        '=',
                        'BS.id'
                    )
                    ->leftJoin(
                        'transaction_payments AS TP',
                        'transactions.id',
                        '=',
                        'TP.transaction_id'
                    )
                    ->leftJoin(
                        'transactions AS PR',
                        'transactions.id',
                        '=',
                        'PR.return_parent_id'
                    )
                    ->leftJoin(
                        'appointments AS APPO',
                        'transactions.appointment_id',
                        '=',
                        'APPO.id'
                    )
                    ->leftJoin('users as u', 'transactions.doctor_id', '=', 'u.id')
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'doctor_fee')
                    ->select(
                        'transactions.id',
                        'transactions.document',
                        'APPO.id as app_id',
                        'transactions.transaction_date',
                        'APPO.appointment_id as ref_no',
                        'contacts.name',
                        'APPO.status as status',
                        'APPO.fee_status as fee_status',
                        'transactions.payment_status',
                        'transactions.final_total',
                        'APPO.token_no as location_name',
                        'transactions.pay_term_number',
                        'transactions.pay_term_type',
                        'PR.id as return_transaction_id',
                        DB::raw('SUM(TP.amount) as amount_paid'),
                        DB::raw('(SELECT SUM(TP2.amount) FROM transaction_payments AS TP2 WHERE
                        TP2.transaction_id=PR.id ) as return_paid'),
                        DB::raw('COUNT(PR.id) as return_exists'),
                        DB::raw('COALESCE(PR.final_total, 0) as amount_return'),
                        DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by")
                    )
                    ->groupBy('transactions.id');                     
           
            if (!empty(request()->patient_id)) {
                
                $purchases->where('transactions.contact_id', request()->patient_id);
            }
          
            if (!empty(request()->input('payment_status')) && request()->input('payment_status') != 'overdue') {
                $purchases->where('transactions.payment_status', request()->input('payment_status'));
            } elseif (request()->input('payment_status') == 'overdue') {
                $purchases->whereIn('transactions.payment_status', ['due', 'partial'])
                    ->whereNotNull('transactions.pay_term_number')
                    ->whereNotNull('transactions.pay_term_type')
                    ->whereRaw("IF(transactions.pay_term_type='days', DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number DAY) < CURDATE(), DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number MONTH) < CURDATE())");
            }

            if (!empty(request()->status)) {
                $purchases->where('transactions.status', request()->status);
            }
            
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $purchases->whereDate('transactions.transaction_date', '>=', $start)
                            ->whereDate('transactions.transaction_date', '<=', $end);
            }
           
            return Datatables::of($purchases)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                                data-toggle="dropdown" aria-expanded="false">' .
                                __("messages.actions") .
                                '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">';
                
                  
                    if (auth()->user()->can("purchase.update")) {
                        $html .= '<li><a href="#" data-href="' . action('Lab\AppointmentController@edit', [$row->app_id]) . '" class="appointment_edit_button" data-container=".view_modal"><i class="fas fa-eye" aria-hidden="true"></i>' . __("messages.edit") . '</a></li>';

                   
                    }
                    if (auth()->user()->can("purchase.delete")) {
                        $html .= '<li><a href="' . action('Lab\AppointmentController@destroy', [$row->app_id]) . '" class="appointment_delete_button"><i class="fas fa-trash"></i>' . __("messages.delete") . '</a></li>';
                    }


                 
                                        
                    if (auth()->user()->can("purchase.create")) {
                        $html .= '<li class="divider"></li>';
                        if ($row->payment_status != 'paid') {
                            $html .= '<li><a href="' . action('Lab\TransactionPaymentController@addPayment', [$row->id]) . '" class="add_payment_modal"><i class="fas fa-money-bill-alt" aria-hidden="true"></i>' . __("purchase.add_payment") . '</a></li>';
                        }
                        $html .= '<li><a href="' . action('Lab\TransactionPaymentController@show', [$row->id]) .
                        '" class="view_payment_modal"><i class="fas fa-money-bill-alt" aria-hidden="true" ></i>' . __("purchase.view_payments") . '</a></li>';
                    }


                    if (auth()->user()->can("purchase.update") || auth()->user()->can("purchase.update_status")) {
                        $html .= '<li><a href="#" data-purchase_id="' . $row->id .
                        '" data-status="' . $row->status . '" class="update_status"><i class="fas fa-edit" aria-hidden="true" ></i>' . __("lang_v1.update_status") . '</a></li>';
                    }

                

                    $html .=  '</ul></div>';
                    return $html;
                })
                ->removeColumn('id','app_id')
              
                ->editColumn(
                    'final_total',
                    '<span class="display_currency final_total" data-currency_symbol="true" data-orig-value="{{$final_total}}">{{$final_total}}</span>'
                )
                ->editColumn('transaction_date', '{{@format_datetime($transaction_date)}}')
                ->editColumn(
                    'status',
                    '<a href="#" @if(auth()->user()->can("purchase.update") || auth()->user()->can("purchase.update_status")) class="update_status no-print" data-purchase_id="{{$id}}" data-status="{{$status}}" @endif><span class="label @appointment_status($status) status-label" data-status-name="{{$status}}" data-orig-value="{{$status}}">{{ $status}}
                        </span></a>'
                )
                ->editColumn(
                    'payment_status',
                    function ($row) {
                        $payment_status = Transaction::getPaymentStatus($row);
                        return (string) view('Laboratory/sell.partials.payment_status', ['payment_status' => $payment_status, 'id' => $row->id, 'for_purchase' => true]);
                    }
                )
                ->addColumn('payment_due', function ($row) {
                    $due = $row->final_total - $row->amount_paid;
                    $due_html = '<strong>' . __('lang_v1.purchase') .':</strong> <span class="display_currency payment_due" data-currency_symbol="true" data-orig-value="' . $due . '">' . $due . '</span>';

                    if (!empty($row->return_exists)) {
                        $return_due = $row->amount_return - $row->return_paid;
                        $due_html .= '<br><strong>' . __('lang_v1.purchase_return') .':</strong> <a href="' . action("Lab\TransactionPaymentController@show", [$row->return_transaction_id]) . '" class="view_purchase_return_payment_modal no-print"><span class="display_currency purchase_return" data-currency_symbol="true" data-orig-value="' . $return_due . '">' . $return_due . '</span></a><span class="display_currency print_section" data-currency_symbol="true">' . $return_due . '</span>';
                    }
                    return $due_html;
                })
                ->setRowAttr([
                    'data-href' => function ($row) {
                        if (auth()->user()->can("purchase.view")) {
                            return  action('Lab\PurchaseController@show', [$row->id]) ;
                        } else {
                            return '';
                        }
                    }])
                ->rawColumns(['final_total', 'action', 'payment_due', 'payment_status', 'status','ref_no','fee_status' ])
                ->make(true);
        }

        $business_locations = BusinessLocation::labforDropdown($business_id);
        $suppliers = Contact::suppliersDropdown($business_id, false);
        $orderStatuses = $this->productUtil->orderStatuses();
        $business_locations = BusinessLocation::labforDropdown($business_id);
            $suppliers = Contact::suppliersDropdown($business_id, false);
            
            $customers = Contact::customersDropdown($business_id,false);
            $doctor=User::allDoctorDropdown($business_id);
            $users = User::allDoctorDropdown($business_id);
            $default_datetime = $this->businessUtil->format_date('now', true);
            $appointment_status=['Pending Confirmation','Confirmed','Treated','cancelled'];
         
        return view('clanic/appointment.index')
            ->with(compact('business_locations', 'suppliers', 'orderStatuses', 'suppliers', 'orderStatuses',
                     'customers','users','default_datetime','appointment_status','doctor'));
    }
    /**
    * Update Appointment status.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function updateStatus(Request $request)
   {
       if (!auth()->user()->can('appointment.update') && !auth()->user()->can('appointment.update_status')) {
           abort(403, 'Unauthorized action.');
       }
   
       try {
           $business_id = request()->session()->get('user.business_id');
           
           $transaction = Transaction::where('business_id', $business_id)
                               ->where('type', 'doctor_fee')
                               
                               ->findOrFail($request->input('purchase_id'));
            
            $appointment = Appointment::where('business_id', $business_id)->find($transaction->appointment_id);
            $appointment->status = $request->input('status');;

           DB::beginTransaction();

           //update transaction
           $appointment->save();
        

           DB::commit();

           $output = ['success' => 1,
                           'msg' => __('purchase.purchase_update_success')
                       ];
       } catch (\Exception $e) {
           DB::rollBack();
           \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
           
           $output = ['success' => 0,
                           'msg' => $e->getMessage()
                       ];
       }

       return $output;
   }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     if (!auth()->user()->can('appointment.view') && !auth()->user()->can('appointment.create')) {
    //         abort(403, 'Unauthorized action.');
    //     }
    //     $business_id = request()->session()->get('user.business_id');
    //     if (request()->ajax()) {
    //         $Appointment = Appointment::join(
    //             'contacts as pat',
    //             'appointments.contact_id',
    //             '=',
    //             'pat.id'
    //         )
    //         ->select(['doctor_id',  'appointments.id',
    //             'pat.name','appointments.appointment_id','appointments.sequence','appointments.get_date_time',
    //             'appointments.note','appointments.status','appointments.fee_status','appointments.user_id','appointments.token_no'])
    //             ->orderBy('date', 'desc');
    //             if (!empty(request()->patient_id)) {
    //                 $Appointment->where('appointments.contact_id', request()->patient_id);
                   
    //             }
    //             if (!empty(request()->location_id)) {
    //                 $Appointment->where('appointments.doctor_id', request()->location_id);
    //             }
    //             if (!empty(request()->start_date) && !empty(request()->end_date)) {
    //                 $start = request()->start_date;
    //                 $end =  request()->end_date;
    //                 $Appointment->whereDate('appointments.date', '>=', $start)
    //                             ->whereDate('appointments.date', '<=', $end);
    //             }
    //             if (!empty(request()->status)) {
    //                 if(request()->status == 0){
    //                     request()->status='Pending Confirmation';
    //                     $Appointment->where('appointments.status', request()->status);  
    //                 }
    //                 elseif(request()->status == 1){
    //                     request()->status='Confirmed';
    //                     $Appointment->where('appointments.status', request()->status);   
    //                 }
    //                 elseif(request()->status == 2){
    //                     request()->status='Treated';
    //                     $Appointment->where('appointments.status', request()->status);   
    //                 }
    //                 elseif(request()->status == 3){
    //                     request()->status='cancelled';
    //                     $Appointment->where('appointments.status', request()->status);   
    //                 }
                   
                
    //             }
    //             return Datatables::of($Appointment)
    //             ->addColumn(
    //                 'action',
    //                 '@can("appointment.update")
    //                 <button data-href="{{action(\'Lab\\AppointmentController@edit\', [$id])}}" class="btn btn-xs btn-primary appointment_edit_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
    //                     &nbsp;
    //                 @endcan
    //                 @can("appointment.delete")
    //                     <button data-href="{{action(\'Lab\\AppointmentController@destroy\', [$id])}}" class="btn btn-xs btn-danger appointment_delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
    //                 @endcan'
    //             )
    //             ->editColumn('sequence', '{{@format_time($sequence)}}')
    //             ->editColumn('doctor_id', function ($row) {
    //                 if (!empty($row->doctor_id)) {
    //                     $query = User::where('type','doctor')
    //                     ->find($row->doctor_id);
                
    //                     return $query->surname.' '.$query->first_name.' '.$query->last_name;
    //                 }
                   
    //             })
    //             ->editColumn('user_id', function ($row) {
    //                 if (!empty($row->user_id)) {
    //                     $query = User::find($row->user_id);
                
    //                     return $query->surname.' '.$query->first_name.' '.$query->last_name;
    //                 }
                   
    //             })
              
    //             ->removeColumn('appointments.id')
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
        
    //     $business_locations = BusinessLocation::labforDropdown($business_id);
    //     $suppliers = Contact::suppliersDropdown($business_id, false);
    //     $orderStatuses = $this->productUtil->orderStatuses();
    //     $customers = Contact::customersDropdown($business_id,false);
    //     $doctor=User::allDoctorDropdown($business_id);
    //     $users = User::allDoctorDropdown($business_id);
    //     $default_datetime = $this->businessUtil->format_date('now', true);
    //     $appointment_status=['Pending Confirmation','Confirmed','Treated','cancelled'];
    //     return view('clanic/appointment.index')
    //         ->with(compact('business_locations', 'suppliers', 'orderStatuses',
    //         'customers','users','default_datetime','appointment_status','doctor'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('appointment.create')) {
            abort(403, 'Unauthorized action.');
        }
  
        $business_id = request()->session()->get('user.business_id');
  
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
        $default_datetime = $this->businessUtil->format_date('now', true);
        $customers = Contact::customersDropdown($business_id,$prepend_none = false);
        $doctor=User::allDoctorDropdown($business_id);
        $users = User::allDoctorDropdown($business_id);

        return view('clanic/appointment.create')
                ->with(compact('quick_add', 'default_datetime','users','customers','doctor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('appointment.create')) {
            abort(403, 'Unauthorized action.');
        }
           try {
            if ($request->ajax()) {
                $validatedData = $request->validate(
                    [
                    'doctor_id' => 'required',
                    'date' => 'required',
                    'patient' => 'required',
                    'sequence' => 'required'
                   
                    ]
                );
                
                $input = $request->input(); 
                $business_id = request()->session()->get('user.business_id');
                $user_id = request()->session()->get('user.id');
                $final=$input['doctor_fee'];
                $ref_count = $this->commonUtil->setAndGetReferenceCount(' appointment');
                //Generate reference number
                 $appointment_id ='AP'.$this->commonUtil->generateReferenceNumber(' appointment', $ref_count);
               
                 $sequence=explode("/",$input['sequence']);
                 
                  $savedata = array(
                     'doctor_id' => $input['doctor_id'] , 
                     'contact_id' => $input['patient'] , 
                     'appointment_id' =>  $appointment_id , 
                     'schedul_id' => $input['schedul_id'] , 
                     'business_id'=>$business_id,
                     'get_date_time' => date("Y-m-d h:i:s") , 
                     'date' =>$this->commonUtil->uf_date($input['date'],false) ,
                     'note' =>$input['note'] ,
                     'status'=>$input['status'],
                     'sequence' =>$sequence[0] ,
                     'token_no' =>$sequence[2],
                     'fee_status'=>$input['fee_status'] ,
                     'user_id'=> $user_id
                     );
                     DB::beginTransaction();
                     $Appointment =Appointment::where('doctor_id', $input['doctor_id'])
                     ->where('date',$this->commonUtil->uf_date($input['date'],false) ) 
                     ->where('contact_id', $input['patient'])->get();
                     $user = User::findOrFail($input['doctor_id']);
                     if(!empty($user)){
                      $acc_id=$user->custom_field_1;
                     }
                     else{
                        $acc_id=null;
                     }
                     if($Appointment->isEmpty()){
                        $Appointment = Appointment::create($savedata);
                        $transaction_data = array(
                            "contact_id" => $input['patient'],
                            "doctor_id" => $input['doctor_id'],
                            "ref_no" => null,
                            'appointment_id'=>$Appointment->id,
                            "transaction_date" => date("Y-m-d h:i:s"),
                            "status" => "received",
                            "location_id" => "2",
                            "exchange_rate" => "1",
                            "pay_term_number" => null,
                            "pay_term_type" => null,
                            "total_before_tax" => "$final",
                            "discount_type" => null,
                            "discount_amount" => "0",
                            "tax_id" => null,
                            "tax_amount" => "0.00",
                            "shipping_details" => null,
                            "shipping_charges" => "0",
                            "final_total" => "$final",
                            "additional_notes" => null);
                            
                            $payment= array(
                              0 =>[
                              "amount" => $final,
                              "method" => "cash",
                              "account_id" => $acc_id,
                              "card_number" => null,
                              "card_holder_name" => null,
                              "card_transaction_number" => null,
                              "card_type" => "credit",
                              "card_month" => null,
                              "card_year" => null,
                              "card_security" => null,
                              "cheque_number" => null,
                              "bank_account_number" => null,
                              "transaction_no_1" => null,
                              "transaction_no_2" => null,
                              "transaction_no_3" => null,
                              "note" => null]);
                              
                    $currency_details = $this->transactionUtil->purchaseCurrencyDetails($business_id);
                    $exchange_rate = $transaction_data['exchange_rate'];
                   
                    
                  
                    //Update business exchange rate.
                    Business::update_business($business_id, ['p_exchange_rate' => ($transaction_data['exchange_rate'])]);
                    //unformat input values
                    $transaction_data['total_before_tax'] = $this->productUtil->num_uf($transaction_data['total_before_tax'], $currency_details)*$exchange_rate;
        
                    // If discount type is fixed them multiply by exchange rate, else don't
                    if ($transaction_data['discount_type'] == 'fixed') {
                        $transaction_data['discount_amount'] = $this->productUtil->num_uf($transaction_data['discount_amount'], $currency_details)*$exchange_rate;
                    } elseif ($transaction_data['discount_type'] == 'percentage') {
                        $transaction_data['discount_amount'] = $this->productUtil->num_uf($transaction_data['discount_amount'], $currency_details);
                    } else {
                        $transaction_data['discount_amount'] = 0;
                    }
        
                    $transaction_data['tax_amount'] = $this->productUtil->num_uf($transaction_data['tax_amount'], $currency_details)*$exchange_rate;
                    $transaction_data['shipping_charges'] = $this->productUtil->num_uf($transaction_data['shipping_charges'], $currency_details)*$exchange_rate;
                    $transaction_data['final_total'] = $this->productUtil->num_uf($transaction_data['final_total'], $currency_details)*$exchange_rate;
        
                    $transaction_data['business_id'] = $business_id;
                    $transaction_data['created_by'] = $user_id;
                    $transaction_data['type'] = 'doctor_fee';
                    $transaction_data['payment_status'] = 'paid';
                   
                    
                        $transaction = Transaction::create($transaction_data);
                        $this->transactionUtil->createOrUpdatePaymentLines($transaction, $payment);
        
                        //update payment status
                        $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);
                        DB::commit();
                        $output = ['success' => 1,
                        'msg' => trans("lang_v1.added_success"),
                    ];
                     }
                     else{
                         
                        $output = ['success' => 0,
                        'msg' => trans("this Patient have already boook this date appointment
                        from this Doctor"),
                    ]; 
                     }
                     
                    
                    
                   
                }
            
          } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' =>  "Message:" . $e->getMessage()
                        ];
          }
        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('appointment.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $appointment = Appointment::where('business_id', $business_id)->find($id);
            $customers = Contact::customersDropdown($business_id,false);
            $doctor=User::allDoctorDropdown($business_id);
            $transaction = Transaction::where('business_id', $business_id)
                    ->where('appointment_id', $id)->first();
            return view('clanic/appointment.edit')
                ->with(compact('appointment',
                'customers','doctor','transaction'));
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
        if (!auth()->user()->can('appointment.update')) {
            abort(403, 'Unauthorized action.');
        }
       
        if (request()->ajax()) {
            try{
          $business_id = $request->session()->get('user.business_id');
  
          $Appointment = Appointment::where('business_id', $business_id)->findOrFail($id);
          
          $input = $request->input();
          
          
          $Appointment->doctor_id = $this->commonUtil->uf_date($input['date'],false) ;
          $Appointment->doctor_id = $input['doctor_id'] ;
          $Appointment->contact_id = $input['patient'] ;
          $Appointment->status = $input['status'] ;
      
       
         
          $Appointment->fee_status = $input['fee_status'] ;
          $Appointment->note = $input['note'] ;
          
          if(!empty($input['sequence'])){
            $sequence=explode("/",$input['sequence']);
            $Appointment->sequence =$sequence[0];
            $Appointment->token_no =$sequence[2];
          }
         if(!empty($input['schedul_id'])){
            $Appointment->schedul_id = $input['schedul_id'] ;
         }
         
          $Appointment->save();
          $transaction = Transaction::where('business_id', $business_id)
          ->where('appointment_id', $id)->first();
          $transaction->final_total=$input['doctor_fee'];
          $transaction->save();
          $output = ['success' => true,
          'msg' => __("Appointment updated successfuly")
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('appointment.delete')) {
            abort(403, 'Unauthorized action.');
        }
  
        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;
  
                $Appointment = Appointment::where('business_id', $business_id)->findOrFail($id);
                $transaction = Transaction::where('business_id', $business_id)
                ->where('appointment_id', $id)->first();
                $transaction->delete();            
                    $Appointment->delete();
                    $output = ['success' => true,
                            'msg' => __("deleted_success")
                            ];    
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => '__("messages.something_went_wrong")'
                        ];
            }
  
            return $output;
        
      }
    }
      /**
     * Retrieves schedule list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSchedules()
    {
        if (request()->ajax()) {
            $doctor_id = request()->doctor;
            $date=request()->date;
          
            $re = $this->chackSchedulDate_doctor($doctor_id,$date);
            
            if($re==false){
                $timestamp = strtotime($date);
                $day1 = date('D', $timestamp);     
            }
            else{
             
                foreach ($re as $key => $value) {
    
                   
                    $start_time = strtotime($value->start_time);

                    $end_time = strtotime($value->end_time);
    
                    $total_m =  round(abs($end_time- $start_time) / 60,2);
    
                   $per_patient_time = $total_m / $value->per_patient_time;
                  
                
                        
                   for ($i = 1; $i <= $per_patient_time; $i++) {

                     $m_time = $i-1;
                     $time = ($m_time * $value->per_patient_time);
                                          
                     //Carbon::parse($input['sequence'])->format('H:i:s')
                     $patient_time =date('h:i A', strtotime($value->start_time)+$time*60);
                     $button_color='';
                     $button_color = $this->Appointment_checker($doctor_id,$date,$patient_time);
                     //print_r($button_color); exit;
                       if ($button_color == 'btn-danger') {
                          if($i==1 ||$i==2 ||$i==3 ||$i==4 ||$i==5 ||$i==6 ||$i==7 ||$i==8 ||$i==9 ){
                            echo '<button type="button" style="margin:1px;" disabled class="btn '.$button_color.'">'.$patient_time.''.'/Token/0'.$i.'</button>';

                          }else{
                            echo '<button type="button" style="margin:1px;" disabled class="btn '.$button_color.'">'.$patient_time.''.'/Token/'.$i.'</button>';

                          }
                         } else {
                            if($i==1 ||$i==2 ||$i==3 ||$i==4 ||$i==5 ||$i==6 ||$i==7 ||$i==8 ||$i==9 ){
                                echo '<button style="margin:1px;" id="t_'.$i.'" type="button" class="btn btn-success" onclick="myBooking('.$i.')">'.$patient_time.''.'/Token/0'. $i.'</button>';   
    
                              }else{
                                echo '<button style="margin:1px;" id="t_'.$i.'" type="button" class="btn btn-success" onclick="myBooking('.$i.')">'.$patient_time.''.'/Token/'. $i.'</button>';   
    
                              } 

                        }
                   }

         echo '<input type="hidden" name="sequence" id="serial_no" value="">';

         echo '<input type="hidden" name="schedul_id" value="' . $value->id . '">';
                }
            }
            
        }
        }



   // Chack date doctor

   public function chackSchedulDate_doctor($doctor_id,$date)

   {    

      $timestamp = strtotime($date);
      $day1 = date('D', $timestamp);
  
      $day=$this->day_to_de($day1);
 
    #  get serial set id from serial_setup table #
            $Schedule =Schedule::where('doctor_id', $doctor_id)
            ->where('day',$day )->get();
           
            if($Schedule->isEmpty()){
             return false;
            }
            else{
                return $Schedule;
            }
          
        

    }
    public function Appointment_checker($doctor_id,$date,$sequence) {  

        $timestamp = strtotime($date);
        $day1 = date('D', $timestamp);
        $day=$this->day_to_de($day1);
        $Appointment =Appointment::where('doctor_id', $doctor_id)
        ->where('date', $this->commonUtil->uf_date($date,false) )
        ->where('sequence', $sequence)->get();
      
        if($Appointment->isEmpty()){
            return 'btn-primary';
        }
        else{
            
            return 'btn-danger';   
        }
       

  }
  public function day_to_de($day){
    if($day == "Sat"){
        return $day = 1;
    }
    elseif ($day == "Sun") {
        return $day = 2;
    }elseif ($day == "Mon") {
        return $day = 3;
    }elseif ($day == "Tue") {
        return $day = 4;
    }elseif ($day == "Wed") {
        return $day = 5;
    }elseif ($day == "Thu") {
        return $day = 6;
    }else {
        return $day = 7;
    }
}

}