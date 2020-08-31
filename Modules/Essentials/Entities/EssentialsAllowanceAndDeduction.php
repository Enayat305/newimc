<?php

namespace Modules\Essentials\Entities;

use Illuminate\Database\Eloquent\Model;

class EssentialsAllowanceAndDeduction extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'essentials_allowances_and_deductions';

    public function employees()
    {
        return $this->belongsToMany(\App\User::class, 'essentials_user_allowance_and_deductions', 'allowance_deduction_id', 'user_id');
    }
}
