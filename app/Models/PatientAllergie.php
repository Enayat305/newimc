<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientAllergie extends Model
{
     /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
   
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id');
    }
    public function allergie()
    {
        return $this->belongsTo(\App\Models\allergie::class, 'allergie_id');
    }
}
