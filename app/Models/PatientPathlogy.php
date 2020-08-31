<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPathlogy extends Model
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
    public function pathologicalhistory()
    {
        return $this->belongsTo(\App\Models\pathologicalhistory ::class, 'patient_pathlogies_id');
    }
}
