<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Test;
use App\Models\ReportHead;
use App\Models\UseProductTest;
use App\BusinessLocation;
use App\Unit;
use App\Models\TestHead;
    use App\AccountTransaction;
    use App\Business;
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
    use App\LabUtils\Util;
    use App\Variation;
    use Illuminate\Support\Facades\DB;
    use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
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
        public function __construct(Util $commonUtil,ProductUtil $productUtil, TransactionUtil $transactionUtil, BusinessUtil $businessUtil, ModuleUtil $moduleUtil)
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
        if (!auth()->user()->can('test.view') && !auth()->user()->can('test.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');


        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $test = Test::leftjoin(
                'departments as d',
                'tests.department_id',
                '=',
                'd.id'
            )
            ->where('tests.business_id', $business_id)
                        ->select(['tests.id', 'tests.name',
                        'tests.test_code' ,
                        'tests.sample_require' ,'tests.carry_out' ,'tests.report_time_day' ,'d.name as department',
                        'tests.final_total']);
            
           if (!empty(request()->department_id)) {
                 $test ->where('tests.department_id', request()->department_id);
                }
            return Datatables::of($test)
          
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-xs"
                                data-toggle="dropdown" aria-expanded="false">' .
                                __("messages.actions") .
                                '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                    if (auth()->user()->can("test.update")) {
                        $html .= '<li><a href="' . action('Lab\TestController@edit', [$row->id]) . '"><i class="fas fa-edit"></i>' . __("messages.edit") . '</a></li>';
                    }
                    if (auth()->user()->can("test.delete")) {
                        $html .= '<li><a href="' . action('Lab\TestController@destroy', [$row->id]) . '"class="delete_test_button"><i class="fas fa-trash"></i>' . __("messages.delete") . '</a></li>';
                    }

  

                    $html .=  '</ul></div>';
                    return $html;
                })
                // ->editColumn(
                //     'final_total',
                //     '<span class="display_currency final_total" data-currency_symbol="true" data-orig-value="{{$final_total}}">{{$final_total}}</span>'
                // )
                ->removeColumn('id')
                ->rawColumns(['name','test_code','action'
                ,'sample_require' ,'carry_out' ,'report_time_day' ,'department'])
                ->make(true);
        }


        $department = Department::where('business_id', $business_id)
        ->pluck('name', 'id');
        return view('Laboratory/test_detail.index')
            ->with(compact('department'));
    }



      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('test.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $department = Department::where('business_id', $business_id)
                            ->pluck('name', 'id');

        $business_locations = BusinessLocation::labforDropdown($business_id);
        $report_head = ReportHead::pluck('name', 'id');
        

        //Check if subscribed or not
        if (!$this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse();
        }

        $taxes = TaxRate::where('business_id', $business_id)
                            ->get();
        $orderStatuses = $this->productUtil->orderStatuses();
       

        $currency_details = $this->transactionUtil->purchaseCurrencyDetails($business_id);

        $default_purchase_status = null;
        if (request()->session()->get('business.enable_purchase_status') != 1) {
            $default_purchase_status = 'received';
        }

        $types = [];
        if (auth()->user()->can('supplier.create')) {
            $types['supplier'] = __('report.supplier');
        }
        if (auth()->user()->can('customer.create')) {
            $types['customer'] = __('report.customer');
        }
        if (auth()->user()->can('supplier.create') && auth()->user()->can('customer.create')) {
            $types['both'] = __('lang_v1.both_supplier_customer');
        }
        $customer_groups = CustomerGroup::forDropdown($business_id);

        $business_details = $this->businessUtil->getDetails($business_id);
        $shortcuts = json_decode($business_details->keyboard_shortcuts, true);

        $payment_line = $this->dummyPaymentLine;
        $payment_types = $this->productUtil->payment_types();

        //Accounts
        $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

        return view('Laboratory/test_detail.create')
        ->with(compact('department','report_head','taxes','orderStatuses','business_locations', 'currency_details', 'default_purchase_status', 'customer_groups', 'types', 'shortcuts', 'payment_line', 'payment_types', 'accounts'));

    }

    public function store(Request $request)
    {

        if (!auth()->user()->can('test.create')) {
            abort(403, 'Unauthorized action.');
        }
      
         try {
             
            $business_id = $request->session()->get('user.business_id');

            //Check if subscribed or not
            if (!$this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action('PurchaseController@index'));
            }
            
            $test_data = $request->only([
                'name',
                'test_code' ,'sample_require' ,'carry_out' ,'report_time_day' ,'department_id',
                'description',
                'test_comment',
                'test_cast_amount',
                'more_amount' ,
                'final_total'
                 ]);
                 
                 $currency_details = $this->transactionUtil->purchaseCurrencyDetails($business_id);
                 $test_data ['final_total'] = $this->productUtil->num_uf($test_data ['final_total'], $currency_details)*1;
                
            if (empty($test_data['test_code'])) {
                $ref_count = $this->commonUtil->setAndGetReferenceCount('report');
                //Generate reference number
                    $test_data['test_code'] ='T'.$this->commonUtil->generateReferenceNumber(' report', $ref_count);
                }
            $test_data['business_id'] = $business_id;
            $test_data['created_by'] = $request->session()->get('user.id');
            DB::beginTransaction();
            $test=Test::create($test_data);

            $report_head= $request->input('report_head');
            foreach ($report_head as $key => $value) {

                $report_head = [
                    'report_head_id' => $value,
                    'test_id' => $test->id,

                ];
              $ReportHead=TestHead::create($report_head);


            }
            $purchases = $request->input('purchases');
            
            foreach ($purchases as $key => $value) {
                $sub_units=Unit::findOrFail($value['sub_unit_id']);
                $purchases = [
                    "product_id" => $value['product_id'],
                    'test_id' => $test->id,
                    "variation_id" => $value['variation_id'],
                    "quantity" => $value['quantity'],
                    'unit_id'=> $value['product_unit_id'],
                    "sub_unit_id" => $value['sub_unit_id'],
                    "purchase_price" => $value['purchase_price'],
                    "base_unit_multiplier" => $sub_unit=$sub_units->base_unit_multiplier


                ];
              $UseProductTest=UseProductTest::create($purchases);


            }
            DB::commit();

            $output = ['success' => 1,
                            'msg' => __('test.added_success')
                        ];
          } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
          }

         return redirect('lab/tests')->with('status', $output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('test.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = request()->session()->get('user.business_id');
        $business = Business::find($business_id);

        $currency_details = $this->transactionUtil->purchaseCurrencyDetails($business_id);

        $taxes = TaxRate::where('business_id', $business_id)
                            ->get();
        
        $test = Test::where('id', $id)
        ->with('test_head','use_product_tests.sub_unit','use_product_tests','use_product_tests.product','use_product_tests.product.unit','use_product_tests.variations','use_product_tests.variations.product_variation')->first();
    
        $business_locations = BusinessLocation::labforDropdown($business_id);
        $report_head = ReportHead::pluck('name', 'id');

        $department = Department::where('business_id', $business_id)
        ->pluck('name', 'id');
        return view('Laboratory/test_detail.edit')
            ->with(compact('department','report_head','currency_details','business_locations','test'));


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
        if (!auth()->user()->can('test.update')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $test = Test::findOrFail($id);
            $update_data = $request->only([
                'name',
                 'sample_require' ,'carry_out' ,'report_time_day' ,'department_id',
                'description',
                'test_comment',
                'test_cast_amount',
                'more_amount' ,
                'final_total'
                ]);
                $business_id = $request->session()->get('user.business_id');
            $currency_details = $this->transactionUtil->purchaseCurrencyDetails($business_id);
            $update_data['final_total'] = $this->productUtil->num_uf($update_data['final_total'], $currency_details)*1;
           
            DB::beginTransaction();
            $report_head=TestHead::where('test_id',$id)
            ->delete();
            $use_product_test=UseProductTest::where('test_id',$id)
            ->delete();

            $test->update($update_data);

            $report_head= $request->input('report_head');
            foreach ($report_head as $key => $value) {

                $report_head = [
                    'report_head_id' => $value,
                    'test_id' => $test->id,

                ];
              $ReportHead=TestHead::create($report_head);


            }
            $purchases = $request->input('purchases');
           
            foreach ($purchases as $key => $value) {
                $sub_units=Unit::findOrFail($value['sub_unit_id']);
                $purchases = [
                    "product_id" => $value['product_id'],
                    'test_id' => $test->id,
                    "variation_id" => $value['variation_id'],
                    "quantity" => $value['quantity'],
                    'unit_id'=> $value['product_unit_id'],
                    "sub_unit_id" => $value['sub_unit_id'],
                    "purchase_price" => $value['purchase_price'],
                    "base_unit_multiplier" => $sub_unit=$sub_units->base_unit_multiplier


                ];
              $UseProductTest=UseProductTest::create($purchases);
            }


      

            DB::commit();

            $output = ['success' => 1,
                            'msg' => __('test.updated_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => $e->getMessage()
                        ];
            return back()->with('status', $output);
        }

        return redirect('lab/tests')->with('status', $output);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!auth()->user()->can('test.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                
               
                $test = Test::findOrFail($id);
                $report_head=TestHead::where('test_id',$id)
                ->delete();
                $test->delete();

                $output = ['success' => true,
                            'msg' => __("test.deleted_success")
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

                return view('Laboratory/test_detail.purchase_entry_row')
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

    /**
     * Checks if ref_number and supplier combination already exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check_test_code(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');

        $ref_no = $request->input('test_code');


        $count = 0;
        if (!empty($ref_no)) {
            //check in transactions table
            $query = Test::where('business_id', $business_id)
                            ->where('test_code', $ref_no);


            $count = $query->count();
        }
        if ($count == 0) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }


        /**
     * Retrieves products list.
     *
     * @param  string  $q
     * @param  boolean  $check_qty
     *
     * @return JSON
     */
    public function getTests()
    {
        if (request()->ajax()) {
            $search_term = request()->input('term', '');
            $query = Test::where('name', 'like', '%' . $search_term .'%')
            ->orWhere('test_code', 'like', '%' . $search_term .'%');
            $result= $query->select(
                    'id as id',
                    'name',
                    'test_code',
                    'final_total' 
                )->get();
                
            return json_encode($result);
        }
    }
  

}

