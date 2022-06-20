<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Section;
use App\Models\Tag;

class Lesson extends Model
{
    // use HasFactory;

    protected $fillable = ['title', 'content'];

    // public function sections() {
    //     return $this->belongsToMany(Section::class);
    // }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
