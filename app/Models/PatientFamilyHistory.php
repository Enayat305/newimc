<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientFamilyHistory extends Model
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
    public function family_history()
    {
        return $this->belongsTo(\App\Models\FamilyHistory::class, 'family_history_id');
    }
}
