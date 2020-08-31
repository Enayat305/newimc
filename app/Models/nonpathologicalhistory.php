<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class nonpathologicalhistory extends Model
{
    
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $table = 'nonpathologicalhistories';
    protected $guarded = ['id'];

    /**
     * Return list of Diets for a business
     *
     * @param int $business_id
     * @param boolean $show_none = true
     *
     * @return array
     */
    public static function forDropdown($business_id, $show_none = false, $only_base = true)
    {
        $query = nonpathologicalhistory::where('business_id', $business_id);
        if ($only_base) {
            $query->whereNull('base_id');
        }

        
        $dropdown = $query->pluck('actual_name', 'id');
        if ($show_none) {
            $dropdown->prepend(__('messages.please_select'), '');
        }
        
        return $dropdown;
    }

    public function sub_nonpathologicalhistory()
    {
        return $this->hasMany(\App\Models\nonpathologicalhistory::class, 'base_id');
    }
   
    public function base_nonpathologicalhistory()
    {
        return $this->belongsTo(\App\Models\nonpathologicalhistory::class, 'base_id');
    }
}
