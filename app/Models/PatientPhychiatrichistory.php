<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPhychiatrichistory extends Model
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
    public function phychiatrichistories()
    {
        return $this->belongsTo(\App\Models\phychiatrichistory::class, 'phychiatrichistorie_id');
    }
}
