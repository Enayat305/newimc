<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription_History extends Model
{
        /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function prescription()
    {
        return $this->belongsTo(\App\Models\Prescription::class);
    }
}
