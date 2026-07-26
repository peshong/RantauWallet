<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
protected $fillable = ['user_id', 'category_id', 'type', 'source', 'to_source', 'amount', 'description', 'date'];    public function user() {
        return $this->belongsTo(User::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
