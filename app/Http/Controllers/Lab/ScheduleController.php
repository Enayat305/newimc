<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\BusinessLocation;
use App\Contact;
use App\CustomerGroup;
use App\Restaurant\Booking;
use App\User;
use App\LabUtils\Util;
use DB;
use Yajra\DataTables\Facades\DataTables;
class ScheduleController extends Controller
{
    protected $commonUtil;

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
        if (!auth()->user()->can('schedule.view') && !auth()->user()->can('schedule.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $user_id = request()->session()->get('user.id');

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $Schedule = Schedule::where('business_id', $business_id)
            
            ->select(['doctor_id',  'id',
                'start_time','end_time','day','per_patient_time']);

                return Datatables::of($Schedule)
                ->addColumn(
                    'action',
                    '@can("schedule.update")
                    <button data-href="{{action(\'Lab\\ScheduleController@edit\', [$id])}}" class="btn btn-xs btn-primary schedule_edit_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("schedule.delete")
                        <button data-href="{{action(\'Lab\\ScheduleController@destroy\', [$id])}}" class="btn btn-xs btn-danger schedule_diet_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
                ->editColumn('start_time', '{{@format_time($start_time)}}')
                ->editColumn('end_time', '{{@format_time($end_time)}}')
                ->editColumn('doctor_id', function ($row) {
                    if (!empty($row->doctor_id)) {
                        $query = User::where('type','doctor')
                        ->find($row->doctor_id);
                
                        return $query->surname.' '.$query->first_name.' '.$query->last_name;
                    }
                   
                })
                ->editColumn('day', function ($row) {
                    if (!empty($row->day)) {
                        if ($row->day==3) {
                            return 'Monday';
                        }
                        elseif($row->day==4){
                            return 'Tuesday';
                        }
                        elseif($row->day==5){
                            return 'Wednesday';
                        }
                        elseif($row->day==6){
                            return 'Thursday';
                        }
                        elseif($row->day==7){
                            return 'Friday';
                        }
                        elseif($row->day==1){
                            return 'Saturday';
                        }
                        elseif($row->day==2){
                            return 'Sunday';
                        }

                        
                    }
                   
                })
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make(true);
        }
        $query = User::where('business_id', $business_id)
        ->where('type','doctor');
        $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');
        $business_locations = BusinessLocation::labforDropdown($business_id);
        $customer_groups = CustomerGroup::forDropdown($business_id);
      
        return view('clanic/schedule.index', compact('users'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        if (!auth()->user()->can('schedule.create')) {
            abort(403, 'Unauthorized action.');
        }
          try {
            if ($request->ajax()) {
                $validatedData = $request->validate(
                    [
                    'doctor_id' => 'required',
                    'day' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'per_patient_time' => 'required',
                    'visible' => 'required',
                    ]
                );
                $business_id = request()->session()->get('user.business_id');
                $user_id = request()->session()->get('user.id');

                $input = $request->input();
          
            //     $booking_end = $this->commonUtil-> uf_time($input['start_time']);
            //    dd($booking_end);
                $d_name['day'] =$input['day'];
	      	 
                for($i=0; $i<count( $d_name['day']); $i++) {
    
                    $savedata = array(
                     'doctor_id' => $input['doctor_id'] , 
                     'start_time' => \Carbon::parse($input['start_time'])->format('H:i:s'),
                     
                     'end_time' =>  \Carbon::parse($input['end_time'])->format('H:i:s') , 
                     'day' => $d_name['day'][$i] , 
                     'business_id'=>1,
                     'per_patient_time' => $input['per_patient_time'] , 
                     'visibility' =>$input['visible'] 
                     );
                     $Schedule = Schedule::create($savedata);
                    }
                    
                    $output = ['success' => 1,
                        'msg' => trans("lang_v1.added_success"),
                    ];
                }
            
         } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => 0,
                            'msg' => "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage()
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
        if (!auth()->user()->can('schedule.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $Schedule = Schedule::where('business_id', $business_id)->find($id);
            $query = User::where('business_id', $business_id)
            ->where('type','doctor');
            $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"));
    
            $users = $all_users->pluck('full_name', 'id');
            $business_locations = BusinessLocation::labforDropdown($business_id); 
            $day=[ 1=>'saturday',2=>'sunday',3=>'monday',4=>'tuesday',5=>'wednesday',6=>'thursday',7=>'friday'];
            return view('clanic/schedule.edit')
                ->with(compact('Schedule','users','day'));
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
      
      if (!auth()->user()->can('schedule.update')) {
          abort(403, 'Unauthorized action.');
      }

      if (request()->ajax()) {
         try{
        $business_id = $request->session()->get('user.business_id');

        $Schedule = Schedule::where('business_id', $business_id)->findOrFail($id);
        $input = $request->input();
        $Schedule->doctor_id = $input['doctor_id'] ;
        $Schedule->start_time = \Carbon::parse($input['start_time'])->format('H:i:s');           
        $Schedule->end_time = \Carbon::parse($input['end_time'])->format('H:i:s');
        $Schedule->day =$input['day'];
        $Schedule->business_id =$business_id;
        $Schedule->per_patient_time = $input['per_patient_time'] ;
        $Schedule->visibility =$input['visible'] ;
        $Schedule->save();
        $output = ['success' => true,
        'msg' => __("Schedule updated successfuly")
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
      if (!auth()->user()->can('schedule.delete')) {
          abort(403, 'Unauthorized action.');
      }

      if (request()->ajax()) {
          try {
              $business_id = request()->user()->business_id;

              $Schedule = Schedule::where('business_id', $business_id)->findOrFail($id);            
                  $Schedule->delete();
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

}





