<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Department extends Model
{
    use SoftDeletes;

  /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
 
    // public function employees()
    // {
    //     return $this->hasMany('App\Models\Employee');
    // }
    // public function services()
    // {
    //     return $this->hasMany('App\Models\Service');
    // }
    // public function doctors()
    // {
    //     return $this->hasMany('App\Models\Doctor');
    // }
    
    //  public function labs()
    // {
    //     return $this->hasMany('App\Models\Lab');
    // }
    //


     /**
     * Return list of Departments for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($business_id, $show_none = false)
    {
        $Departments = Department::where('business_id', $business_id)
                    ->pluck('name', 'id');

        if ($show_none) {
            $Departments->prepend(__('lang_v1.none'), '');
        }

        return $Departments;
    }
}
