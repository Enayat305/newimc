<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestSell extends Model
{
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class );
    }
    public function tests()
    {
        return $this->belongsTo(\App\Models\Test::class,'test_id');
    }
    public function report_test_particular()
    {
        return $this->hasMany(\App\Models\ReportTestParticular::class,'test_sell_id');
    }
    public function departments()
    {
        return $this->belongsTo(\App\Models\Department::class,'department_id');
    }
    public function contact()
    {
        return $this->belongsTo(\App\Contact::class, 'patient_id');
    }
    public function doctor()
    {
        return $this->belongsTo(\App\User::class, 'ref_by');
    }
}

    
