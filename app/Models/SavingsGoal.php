<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    protected $fillable = ['user_id', 'name', 'target_amount', 'current_amount', 'deadline', 'priority'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
