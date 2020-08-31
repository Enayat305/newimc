<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ReportHead extends Model
{
    use SoftDeletes;
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
    public function test_head()
    {
        return $this->hasMany(\App\Models\TestHead::class);
    }
    public function test_particular()
    {
        return $this->hasMany(\App\Models\TestParticular::class);
    }
}
