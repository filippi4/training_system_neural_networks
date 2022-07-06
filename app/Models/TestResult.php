<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['test_id', 'user_id', 'tries', 'score'];

    public function test() {
        return $this->belongsTo(Test::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
