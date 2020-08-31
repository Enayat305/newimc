<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVaccine extends Model
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
    public function vaccine()
    {
        return $this->belongsTo(\App\Models\vaccine::class, 'vaccines_id');
    }
}
