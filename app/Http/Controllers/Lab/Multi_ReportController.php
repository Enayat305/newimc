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

class Multi_ReportController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('multi_report.create')) {
            abort(403, 'Unauthorized action.');
        }
        $test=2;
      
        $default_date = \Carbon::now()->toDateString();
        $contact = Contact::leftjoin('transactions AS t', 'contacts.id', '=', 't.contact_id')
       
        ->where('t.type', 'lab_sell')
        ->onlyCustomers()
        ->pluck('contacts.name', 'contacts.id');
       
        return view('Laboratory/multi_tests_report.create')->with(compact(
        'test',
        'contact'
          
        ));
    

    }
      /**
     * Retrieves products list.
     *
     * @param  string  $q
     * @param  boolean  $check_qty
     *
     * @return JSON
     */
    public function getinvoice()
    {
        if (request()->ajax()) {
        
         $search_term = request()->input('term', '');
         $default_date = \Carbon::now()->toDateString();
         $query = Contact::leftjoin('transactions AS t', 'contacts.id', '=', 't.contact_id')
       
        ->where('t.type', 'lab_sell')
        ->onlyCustomers()
        ->Where('contacts.name', 'like', '%' . $search_term .'%')
        ->orWhere('t.invoice_no', 'like', '%' . $search_term .'%');
            $result= $query->select(
                    't.id as id',
                    'contacts.name as name',
                    't.invoice_no as test_code',
                    't.invoice_no as final_total'
                )->get();
          
            return json_encode($result);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    {     if (!auth()->user()->can('multi_report.edit')) {
        abort(403, 'Unauthorized action.');
       }
        $query = TestSell::where('id', $id)
        ->with(['contact','tests','tests.test_head.reports_head','report_test_particular','departments','doctor','transaction'])->first();
      
        if($query->tests->id==72 || $query->tests->id==81){
            return view('Laboratory/multi_tests_report.widalcreate')
            ->with(compact('query'));
        }
        else{
            return view('Laboratory/multi_tests_report.edit')
            ->with(compact('query'));
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
     
        if (!auth()->user()->can('multi_report.update')) {
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
                if(!empty($value['femalerange'])){
                    $ReportTestParticular->female = $value['femalerange'];
    
                }
                }
                
            $ReportTestParticular->high_range = $value['highrange'];
            $ReportTestParticular->low_range = $value['lowrange'];
            $ReportTestParticular->save();
        }
    }
        DB::commit();
        $output = ['success' => true,
        'data' => $TestSell,
        'msg' => __("Report added successfully")
    ];
    
            // $url = $this->getInvoiceUrl($TestSell->id);
           
            // return redirect()->to($url . '?print_on_load=true');
           
}  catch (\Exception $e) {
    \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
    
    $output = ['success' => false,
                    'msg' => __("messages.something_went_wrong")
                ];
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
        //
    }

    
    
    /**
     * Returns the HTML row for a product in POS
     *
     * @param  int  $variation_id
     * @param  int  $location_id
     * @return \Illuminate\Http\Response
     */
    public function getRow($variation_id)
    {
        $output = [];
     
        try {
            // $row_count = request()->get('product_row');
            // $row_count = $row_count + 1;
         
            // //Get lot number dropdown if enabled
            // $lot_numbers = [];
           //dd($customer_id);
           $output['success'] = true;
 
           $default_date = \Carbon::now()->toDateString(); 
           $transaction = Transaction::where('type', 'lab_sell')
           ->where('id', $variation_id)->first();
           //dd($transaction);
            $sell_details = TestSell::where('transaction_id', $transaction->id)
                ->with(['tests'])->get();
           
                $output['html_content'] =  view('Laboratory/multi_tests_report.product_row')
                            ->with(compact('sell_details'))
                            ->render();
            
            
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output['success'] = false;
            //$output['msg'] = __('lang_v1.item_out_of_stock');
            $output['msg'] = "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage();
        }

        return $output;
    }

}
