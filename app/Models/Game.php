<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'won_prize',
        'reward',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
