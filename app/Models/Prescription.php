<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{

    protected $casts = [
        'test' => 'array',
        'medicine' => 'array',
    ];
    
    
          /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function contact()
    {
        return $this->belongsTo(\App\Contact::class, 'contact_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'doctor_id');
    }
    public function appointment()
    {
        return $this->belongsTo(\App\Models\Appointment::class, 'appointments_id');
    }

    public function prescription_history()
    {
        return $this->hasMany(\App\Models\Prescription_History::class,'prescription_id');
    }
}
