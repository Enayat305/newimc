<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTestParticular extends Model
{
      /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function Tests_sell()
    {
        return $this->belongsTo(\App\Models\TestSell::class);
    }
    
}
