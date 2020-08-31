<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
     use SoftDeletes;

     /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public function use_product_tests()
    {
        return $this->hasMany(\App\Models\UseProductTest::class);
    }
    public function test_head()
    {
        return $this->hasMany(\App\Models\TestHead::class);
    }
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class);
    }

}
