<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestSell;
use App\Models\UseProductTest;
use App\Models\ReportTestParticular;
use App\Contact;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;




use App\Account;
use App\Brands;
use App\Business;
use App\BusinessLocation;
use App\Category;

use App\CustomerGroup;
use App\Media;
use App\Product;
use App\SellingPriceGroup;
use App\TaxRate;

use App\TransactionSellLine;
use App\TypesOfService;
use App\User;
use App\LabUtils\BusinessUtil;
use App\LabUtils\CashRegisterUtil;
use App\LabUtils\ContactUtil;
use App\LabUtils\ModuleUtil;
use App\LabUtils\NotificationUtil;
use App\LabUtils\ProductUtil;
use App\LabUtils\TransactionUtil;
use App\Variation;
use App\Warranty;
use App\Unit;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class TestReportController extends Controller
{
    /**
     * All LabUtils instance.
     *
     */
    protected $contactUtil;
    protected $productUtil;
    protected $businessUtil;
    protected $transactionUtil;
    protected $cashRegisterUtil;
    protected $moduleUtil;
    protected $notificationUtil;

    /**
     * Constructor
     *
     * @param ProductLabUtils $product
     * @return void
     */
    public function __construct(
        ContactUtil $contactUtil,
        ProductUtil $productUtil,
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        CashRegisterUtil $cashRegisterUtil,
        ModuleUtil $moduleUtil,
        NotificationUtil $notificationUtil
    ) {
        $this->contactUtil = $contactUtil;
        $this->productUtil = $productUtil;
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->moduleUtil = $moduleUtil;
        $this->notificationUtil = $notificationUtil;

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
        if (!auth()->user()->can('lab_test_report.view') && !auth()->user()->can('lab_test_report.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
       
       
        if (request()->ajax()) {
            $test_sell = TestSell::leftjoin(
                'transactions as t',
                'test_sells.transaction_id',
                '=',
                't.id'
            )
                            ->leftjoin(
                                'contacts as p',
                                'test_sells.patient_id',
                                '=',
                                'p.id'
                            )
                            ->leftjoin(
                                'departments as d',
                                'test_sells.department_id',
                                '=',
                                'd.id'
                            )
                            ->leftjoin(
                                'users as pv',
                                'test_sells.ref_by',
                                '=',
                                'pv.id'
                            )
                            ->leftjoin(
                                'tests as tv',
                                'test_sells.test_id',
                                '=',
                                'tv.id'
                            )
                            
                            ->select(
                                'test_sells.id',
                                'tv.name as test_name',
                                'p.name as patient_name',
                                'test_sells.report_code',
                                'test_sells.test_comment',
                                'test_sells.test_result',
                                'test_sells.reported_dated',
                                'test_sells.report_date',
                                'test_sells.file',
                                'test_sells.status',
                                DB::raw("CONCAT(COALESCE(pv.surname, ''),' ',COALESCE(pv.first_name, ''),' ',COALESCE(pv.last_name,'')) as ref_by")
                            )
                            ->groupBy('test_sells.id');
                            
           

            if (!empty(request()->test_id)) {
                $test_sell->where('tv.id', request()->test_id);
            }
            if (!empty(request()->patient_id)) {
                $test_sell->where('p.id', request()->patient_id);
            }
            

            if (!empty(request()->status)) {
                $test_sell->where('test_sells.status', request()->status);
            }
            
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $test_sell->whereDate('test_sells.report_date', '>=', $start)
                            ->whereDate('test_sells.report_date', '<=', $end);
            }
            return Datatables::of($test_sell)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                                data-toggle="dropdown" aria-expanded="false">' .
                                __("messages.actions") .
                                '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">';
                    if (auth()->user()->can("lab_test_report.view")) {
                        $html .= '<li><a href="#" data-href="' . action('Lab\TestReportController@show', [$row->id]) . '" class="btn-modal" data-container=".view_modal"><i class="fas fa-eye" aria-hidden="true"></i>' . __("messages.view") . '</a></li>';
                    }
                    if (auth()->user()->can("lab_test_report.print")) {
                        if ($row->status == 'Waiting') {
                        }
                        else{
                            $html .= '<li><a href="#" class="print-invoice" data-href="' . action('Lab\TestReportController@printInvoice', [$row->id]) . '"><i class="fas fa-print" aria-hidden="true"></i>'. __("messages.print") .'</a></li>';

                        }
                    }
                    if (auth()->user()->can("lab_test_report.update")) {
                        $html .= '<li><a href="' . action('Lab\TestReportController@edit', [$row->id]) . '"><i class="fas fa-edit"></i>' . __("messages.edit") . '</a></li>';
                    }
                    // if (auth()->user()->can("purchase.delete")) {
                    //     $html .= '<li><a class="test_edit" href="' . action('Lab\PurchaseController@destroy', [$row->id]) . '" class="delete-purchase"><i class="fas fa-trash"></i>' . __("messages.delete") . '</a></li>';
                    // }


                
                                        
               

                 

                  

                    $html .=  '</ul></div>';
                    return $html;
                })
                ->removeColumn('id')
              
                ->editColumn('report_date', '{{@format_datetime($report_date)}}')
                ->editColumn('reported_dated', '{{@format_datetime($reported_dated)}}')
                ->editColumn(
                    'status',
                    function ($row) {
                        if ($row->status == 'Waiting') {
                         return $html='<span class="p-3 bg-yellow btn">'.$row->status.'</span>';
                        }
                        elseif($row->status == 'Complete'){
                            return $html='<span class="p-3 bg-green btn">'.$row->status.'</span>';
                        }
                    }
                )
                ->addColumn('mass_delete', function ($row) {
                    return  '<input type="checkbox" class="row-select" value="' . $row->id .'">' ;
                })       
                // ->setRowAttr([
                //     'data-href' => function ($row) {
                //         if (auth()->user()->can("purchase.view")) {
                //             return  action('Lab\TestReportController@show', [$row->id]) ;
                //         } else {
                //             return '';
                //         }
                //     }])
                ->rawColumns([ 'action', 'status','mass_delete'])
                ->make(true);
        }
        $test=Test::pluck('name', 'id');
        $customersDropdown = Contact::customersDropdown($business_id, false, false);
        $status = ['Complete'=>'Complete','Waiting'=>'Waiting'];
        return view('Laboratory/tests_report.index')
             ->with(compact('test','customersDropdown','status'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test_sell = TestSell::where('id', $id)->first();
      
        if (!empty($test_sell)) {
            $receipt = $this->receiptContent($test_sell->id, true);

            $title = $test_sell->tests->name . ' | ' . $test_sell->report_code;
            $top_postion = true;
            return view('Laboratory/tests_report.show_invoice')
                    ->with(compact('receipt', 'title','top_postion'));
        } else {
            die(__("messages.something_went_wrong"));
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
        if (!auth()->user()->can('lab_test_report.update')) {
            abort(403, 'Unauthorized action.');

        }
        $query = TestSell::where('id', $id)
        ->with(['contact','tests','tests.test_head.reports_head','report_test_particular','departments','doctor','transaction'])->first();
      
        if($query->test_id==72 || $query->test_id==81){
            return view('Laboratory/tests_report.widalcreate')
            ->with(compact('query'));
        }
        else{
            return view('Laboratory/tests_report.edit')
            ->with(compact('query'));
        }
        
        
    }

    /**
     * Shows form to edit multiple products at once.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkEdit(Request $request)
    {
        if (!auth()->user()->can('lab_test_report.update')) {
            abort(403, 'Unauthorized action.');
        }
       
        $selected_products_string = $request->input('selected_products');
        
        if (!empty($selected_products_string)) {
           
           
          
            $receipt = $this->multireceiptContent($selected_products_string,$break=false);
            $top_postion = true;
                                
            return view('Laboratory/tests_report.multi-edit')->with(compact(
                'receipt'
                ,'top_postion'
              
            ));
        }
    }
    
    /**
     * Shows form to edit multiple products at once.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkprint(Request $request)
    {
        if (!auth()->user()->can('lab_test_report.update')) {
            abort(403, 'Unauthorized action.');
        }
       
        $selected_products_string = $request->input('selected_products');
        
        if (!empty($selected_products_string)) {
           
           
          
            $receipt = $this->multireceiptContent($selected_products_string,$break=true);
            $top_postion = true;
                         
            return view('Laboratory/tests_report.multi-edit')->with(compact(
                'receipt'
                ,'top_postion'
              
            ));
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
    private function multireceiptContent($id,$break)

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

        $selected_products = explode(',', $id);
        $receipt_details = TestSell::whereIn('id', $selected_products)
        ->with(['contact','tests','tests.test_head.reports_head','report_test_particular','departments','doctor','transaction'])->get();
        
        $code='';
        $departments=false;
        $tests='';
        foreach ($receipt_details as $key => $value) {
            $code .=$value->report_code;
            
            $departments[]=$value->departments->name;
            $tests .=$value->tests->name .'  +  ';
            
           
        }
      
        // dd($departments);
        // $array1 = array("a" => "green", "red", "blue", "red");
        // $array2 = array("b" => "green", "yellow", "red");
        $result = array_unique($departments);
       
        //If print type browser - return the content, printer - return printer config data, and invoice format config
        if ($receipt_printer_type == 'printer') {
            $output['print_type'] = 'printer';
            $output['printer_config'] = $this->businessUtil->printerConfig($business_id, $location_details->printer_id);
            $output['data'] = $receipt_details;
        } else {
            $top_postion =  true;
            
            if($break == false){
                
                $output['html_content'] = view('Laboratory/tests_report.multislim', compact('receipt_details','top_postion','code','departments','tests','result'))->render();

            }
            else{
                $output['html_content'] = view('Laboratory/tests_report.multi_print', compact('receipt_details','top_postion','code','departments','tests','result'))->render();
  
            }

            
       
        }
        
        return $output;
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
            if (!auth()->user()->can('lab_test_report.update')) {
            abort(403, 'Unauthorized action.');
        }
         try {
            $input = $request->except('_token');
            $is_direct_sale = false;
            DB::beginTransaction();
        $TestSell=TestSell::findOrFail($id);
        $TestSell->status='Complete';
        $TestSell->reported_dated=\Carbon::now()->toDateTimeString();
        $TestSell->test_comment=$input['test_comment'];
        $result=null;
        if(!empty($input['test'])){
            if($input['test']==0){
                $result='Negative';
            }
            elseif($input['test']==1){
                $result='Positive';
            }
        }
        $TestSell->test_result=$result;
        $TestSell->save();
        if(!empty($request->particular)){
        foreach($request->particular as $value){
            $ReportTestParticular=ReportTestParticular::findOrFail($value['id']);
            $ReportTestParticular->result = $value['result'];
            $ReportTestParticular->unit = $value['unit'];
            if($TestSell->test_id==72 || $TestSell->test_id==81){
            $ReportTestParticular->male= $value['malerange'];
            $ReportTestParticular->female = $value['femalerange'];

            }
            else{
            if(!empty($value['malerange'])){
            $ReportTestParticular->male= $value['malerange'];
            }
            else{
                $ReportTestParticular->female = $value['femalerange'];

            }
            }
            $ReportTestParticular->high_range = $value['highrange'];
            $ReportTestParticular->low_range = $value['lowrange'];
            $ReportTestParticular->save();
        }
    }
        DB::commit();
      
    
            $url = $this->getInvoiceUrl($TestSell->id);
           
            return redirect()->to($url . '?print_on_load=true');
           
} catch (\Exception $e) {
           DB::rollBack();
           \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
           $msg = trans("messages.something_went_wrong");
}


    }

    /**
     * Prints invoice for sell
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function printInvoice(Request $request, $id)
    {
        if (request()->ajax()) {
            try {
                $output = ['success' => 0,
                        'msg' => trans("messages.something_went_wrong")
                        ];


                $printer_type = 'browser';
            
                $receipt = $this->receiptContent($id,false);
                
                if (!empty($receipt)) {
                    $output = ['success' => 1, 'receipt' => $receipt];
                }
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                
                $output = ['success' => 0,
                        'msg' => trans("messages.something_went_wrong")
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
        //
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

    
        $receipt_details = TestSell::where('id', $id)
        ->with(['contact','tests','tests.test_head.reports_head','report_test_particular','departments','doctor','transaction'])->first();
        //If print type browser - return the content, printer - return printer config data, and invoice format config
        if ($receipt_printer_type == 'printer') {
            $output['print_type'] = 'printer';
            $output['printer_config'] = $this->businessUtil->printerConfig($business_id, $location_details->printer_id);
            $output['data'] = $receipt_details;
        } else {
            $top_postion =  $postion;
            if($receipt_details->test_id==72 ||$receipt_details->test_id==81){
            $output['html_content'] = view('Laboratory/tests_report.widal', compact('receipt_details','top_postion'))->render();
            }
            else{
                $output['html_content'] = view('Laboratory/tests_report.slim', compact('receipt_details','top_postion'))->render();

            }
       
        }
        
        return $output;
    }
    /**
     * Shows invoice to guest user.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function showInvoice($token)
    {
        $test_sell = TestSell::where('invoice_token', $token)->first();
      
        if (!empty($test_sell)) {
            $receipt = $this->receiptContent($test_sell->id, true);

            $title = $test_sell->tests->name . ' | ' . $test_sell->report_code;
            $top_postion = true;
            return view('Laboratory/tests_report.show_invoice')
                    ->with(compact('receipt', 'title','top_postion'));
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
        $TestSell=TestSell::findOrFail($TestSell_id);
                            
       
        if (empty($TestSell->invoice_token)) {
            $TestSell->invoice_token = $this->generateToken();
            $TestSell->save();
        }

        return route('lab_show_invoice', ['token' => $TestSell->invoice_token]);
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
}
//$output['html_content'] = view('Laboratory/tests_report.slim')->render();