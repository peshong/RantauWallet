<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['user_id', 'name', 'amount', 'due_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(BillPayment::class);
    }

    public function totalPaid()
    {
        return $this->payments()->sum('amount');
    }

    public function remaining()
    {
        return $this->amount - $this->totalPaid();
    }
}