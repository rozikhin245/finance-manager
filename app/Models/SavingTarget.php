<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavingTarget extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'target_amount', 'allocated_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

