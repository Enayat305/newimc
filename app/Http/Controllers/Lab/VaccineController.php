<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\vaccine;
use App\LabUtils\Util;
use Yajra\DataTables\Facades\DataTables;

class VaccineController extends Controller
{
    
      /**
     * All LabUtils instance.
     *
     */
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductLabUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('vaccine.view') && !auth()->user()->can('vaccine.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');

       
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $vaccine = vaccine::where('business_id', $business_id)
            ->with(['base_vaccine'])
            ->select(['actual_name',  'id',
                'base_id']);

                return Datatables::of($vaccine)
                ->addColumn(
                    'action',
                    '@can("vaccine.update")
                    <button data-href="{{action(\'Lab\\VaccineController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_vaccine_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("vaccine.delete")
                        <button data-href="{{action(\'Lab\\VaccineController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_vaccine_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
             
                ->editColumn('actual_name', function ($row) {
                    if (!empty($row->base_id)) {
                        return  $row->actual_name .' ('. $row->base_vaccine->actual_name . ')';
                    }
                    return  $row->actual_name;
                })
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('clanic/vaccine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('vaccine.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }

        $vaccines = vaccine::forDropdown($business_id);

        return view('clanic/vaccine.create')
                ->with(compact('quick_add', 'vaccines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('vaccine.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['actual_name']);
            $input['business_id'] = $request->session()->get('user.business_id');
            $input['created_by'] = $request->session()->get('user.id');

            if ($request->has('define_base_vaccine')) {
                if (!empty($request->input('base_vaccine_id'))) {
            
                    $input['base_id'] = $request->input('base_vaccine_id');
                       
                    }
                }
            
           
            $vaccine = vaccine::create($input);
            $output = ['success' => true,
                        'data' => $vaccine,
                        'msg' => __("vaccine success")
                    ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                        'msg' => __("messages.something_went_wrong")
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
        if (!auth()->user()->can('vaccine.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $vaccine = vaccine::where('business_id', $business_id)->find($id);

            $vaccines = vaccine::forDropdown($business_id);
            
            return view('clanic/vaccine.edit')
                ->with(compact('vaccine', 'vaccines'));
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
        
        if (!auth()->user()->can('vaccine.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['actual_name']);
                $business_id = $request->session()->get('user.business_id');

                $vaccine = vaccine::where('business_id', $business_id)->findOrFail($id);
                $vaccine->actual_name = $input['actual_name'];
               
                if ($request->has('define_base_vaccine')) {
                    if (!empty($request->input('base_vaccine_id')) ) {
                        
                        $vaccine->base_id = $request->input('base_vaccine_id');
                    }
                } else {
                    $vaccine->base_id = null;
                    
                }

                $vaccine->save();

                $output = ['success' => true,
                            'msg' => __("vaccine updated_success")
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
        if (!auth()->user()->can('vaccine.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                $vaccine = vaccine::where('business_id', $business_id)->findOrFail($id);

                //check if any product associated with the unit
                // $exists = Product::where('unit_id', $unit->id)
                //                 ->exists();
                // if (!$exists) {
                    $vaccine->delete();
                    $output = ['success' => true,
                            'msg' => __("deleted_success")
                            ];
                // } else {
                //     $output = ['success' => false,
                //             'msg' => __("lang_v1.unit_cannot_be_deleted")
                //             ];
                // }
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => '__("messages.something_went_wrong")'
                        ];
            }

            return $output;
        }
    }
}
