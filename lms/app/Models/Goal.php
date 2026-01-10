<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['user_id', 'goal', 'goal_deadline', 'target_hours'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
