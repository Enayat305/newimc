<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ReportHead;
use App\Models\TestParticular;
use Illuminate\Support\Facades\DB;
class TestParticularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  if (!auth()->user()->can('testparticular.view') && !auth()->user()->can('testparticular.create')) {
        abort(403, 'Unauthorized action.');
    }
        if (request()->ajax()) {           
            $report_head=ReportHead::select(['id', 'name']);
            return Datatables::of($report_head)
            ->addColumn('action', function ($row) {
                $html = '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs"
                            data-toggle="dropdown" aria-expanded="false">' .
                            __("messages.actions") .
                            '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';
                if($row->id==17 || $row->id==29){

                }
                else{
                if (auth()->user()->can("testparticular.update")) {
                    
                    $html .= '<li><a href="' . action('Lab\TestParticularController@edit', [$row->id]) . '"><i class="fas fa-edit"></i>' . __("messages.edit") . '</a></li>';
                }
                if (auth()->user()->can("testparticular.delete")) {
                    $html .= '<li><a href="' . action('Lab\TestParticularController@destroy', [$row->id]) . '"class="delete_particulars_button"><i class="fas fa-trash"></i>' . __("messages.delete") . '</a></li>';
                }
            }


                $html .=  '</ul></div>';
                return $html;
            })
            ->editColumn('id', function ($row) {
                $Testparticular=TestParticular::where('report_head_id',$row->id)->get();
                $testparticular=TestParticular::where('report_head_id',$row->id)->first();

                if($testparticular['report_head_id']==82 || $testparticular['report_head_id']==29){
                    $html='<table class="table table-condensed table-bordered table-th-green text-center table-striped" id="test_particular_entry_table">
                <thead>
                    <tr>';
                    $html .= '<th>Types</th>';
                    $html .= '<th>1:20</th>';
                    $html .= '<th>1:40</th>';
                    $html .= '<th>1:80</th>';
                    $html .= '<th>1:160</th>';
                    $html .= '<th>1:320</th>';
                    $html .= '<th>1:640</th>';
                   
                  
                    
                  
                $html .='</tr>	
                </thead>
                <tbody>';
                 foreach ($Testparticular as $key => $value) {
                   
                        
                    $html .= '<tr>';
                    $html .= '<td>'.$value->name.'</td>';
                    $html .= '<td>'.$value->result.'</td>';
                    $html .= '<td>'.$value->unit.'</td>';
                    $html .= '<td>'.$value->male.'</td>';
                    $html .= '<td>'.$value->female.'</td>';
                    $html .= '<td>'.$value->high_range.'</td>';
                    if(!empty($value->low_range)){
                    $html .= '<td>'.$value->low_range.'</td>';
                    
                    $html .= '</tr>';
                    }
                 }
              
                 $html .='</tbody>
                 </table>';
                return $html;
                }
                else{
                $html='<table class="table table-condensed table-bordered table-th-green text-center table-striped" id="test_particular_entry_table">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Result</th>
                    <th>Unit</th>
                    <th>Male Range</th>
                    <th>Female Range</th>
                    <th>High Range</th>
                    <th>Low Range</th>
                </tr>	
                </thead>
                <tbody>';
                 foreach ($Testparticular as $key => $value) {
                    $html .= '<tr>';
                    $html .= '<td>'.$value->name.'</td>';
                    $html .= '<td>'.$value->result.'</td>';
                    $html .= '<td>'.$value->unit.'</td>';
                    $html .= '<td>'.$value->male.'</td>';
                    $html .= '<td>'.$value->female.'</td>';
                    $html .= '<td>'.$value->high_range.'</td>';
                    $html .= '<td>'.$value->low_range.'</td>';
                    $html .= '</tr>';
                 }
              
                 $html .='</tbody>
                 </table>';
                return $html;
            }
            })
          
            ->rawColumns(['action','id'])
            ->make(true);
    }
       
        return view('Laboratory/testparticular.index');
                
    }

 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('testparticular.create')) {
            abort(403, 'Unauthorized action.');
        }

        $report_head = ReportHead::pluck('name', 'id');
        
        return view('Laboratory/testparticular.create')
                ->with(compact('report_head'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        if (!auth()->user()->can('testparticular.create')) {
            abort(403, 'Unauthorized action.');
        }
        
       
          try {
            // $business_id = $request->session()->get('user.business_id');

            // //Check if subscribed or not
            // if (!$this->moduleUtil->isSubscribed($business_id)) {
            //     return $this->moduleUtil->expiredResponse(action('PurchaseController@index'));
            // }
           
            if(!empty($request->input('is_show'))){
                $is_show =$request->input('is_show');
            }
            else{
                $is_show=0;
            }
            DB::beginTransaction();
            $particular= $request->input('particular');
            $report_head = [
                'name' => $request->input('name'),
                'test_id' => null,
                "is_show"=> $is_show,

            ];
        
            $ReportHead=ReportHead::create($report_head);
            foreach ($particular as $key => $value) {
               
                $particular= [
                    "report_head_id"=>$ReportHead->id,
                    "name" => $value['name'],
                    "result" => $value['result'],
                    "unit" => $value['unit'],
                    'male'=> $value['malerange'],
                    "female" => $value['femalerange'],
                    "high_range" => $value['highrange'],
                    "low_range" => $value['lowrange']
                ];
                
              $TestParticular=TestParticular::create($particular);


            }


            
            DB::commit();

            $output = ['success' => 1,
                            'msg' => __('added_success')
                        ];
          } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
           }

         return redirect('lab/testparticular')->with('status', $output);
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
        if (!auth()->user()->can('testparticular.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        $report_heads= ReportHead::where('id',$id)->with('test_particular')->first();
        
        $report_head = ReportHead::pluck('name', 'id');
        return view('Laboratory/testparticular.edit')
                ->with(compact('report_head','report_heads'));
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
        if (!auth()->user()->can('department.update')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            
            DB::beginTransaction();
            $testparticular=TestParticular::where('report_head_id',$id)
            ->delete();
            $particular= $request->input('particular');
            $reporthead=ReportHead::findorFail($id);
            $reporthead->name=$request->input('name');
            $reporthead->is_show=$request->input('is_show');
            $reporthead->save();
            foreach ($particular as $key => $value) {
               
                $particular= [
                    "report_head_id"=>$reporthead->id,
                    "name" => $value['name'],
                    "result" => $value['result'],
                    "unit" => $value['unit'],
                    'male'=> $value['malerange'],
                    "female" => $value['femalerange'],
                    "high_range" => $value['highrange'],
                    "low_range" => $value['lowrange']
                ];
                
                $TestParticular=TestParticular::create($particular);


            }
            DB::commit();

            $output = ['success' => 1,
                            'msg' => __('updated_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => $e->getMessage()
                        ];
            return back()->with('status', $output);
        }

        return redirect('lab/testparticular')->with('status', $output);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if (!auth()->user()->can('testparticular.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                
               
                $testparticular=TestParticular::where('report_head_id',$id)->first()->delete();;
                $reporthead=ReportHead::findorFail($id);
                   
                if (!empty($testparticular)) {
                    $testparticular=TestParticular::where('report_head_id',$id)->delete();
                    $reporthead->delete();
              
                 $output = ['success' => true,
                            'msg' => __("deleted_success")
                            ];
                } 
               else{
                $output = ['success' => false,
                'msg' => __("The have not test particulars")
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
