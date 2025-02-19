<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'category', 'amount', 'date', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
