<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientNonpathological extends Model
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
    public function nonpathologicalhistory()
    {
        return $this->belongsTo(\App\Models\nonpathologicalhistory::class, 'nonpathological_id');
    }
}
