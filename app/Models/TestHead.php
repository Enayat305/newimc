<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestHead extends Model
{
    
  /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function tests()
    {
        return $this->belongsTo(\App\Models\Test::class);
    }
    public function reports_head()
    {
        return $this->belongsTo(\App\Models\ReportHead::class,'report_head_id');
    }
}
