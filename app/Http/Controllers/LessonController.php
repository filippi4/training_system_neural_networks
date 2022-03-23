<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use Parsedown;

class LessonController extends Controller
{
    public function addLesson(Request $req) {
        $lesson = new Lesson;
        $lesson->title = $req->input('lesson-title');

        if ($req->input('syntax-type') === 'markdown') {
            $parsedown = new Parsedown();
            $lesson->content = $parsedown->text($req->input('lesson-content'));
        }
        else {
            $lesson->content = $req->input('lesson-content');
        }
        
        $lesson->save();
  
        return redirect()->route('lessons');
    }

    public function allData() {
        return view('lessons', ['data' => Lesson::all()]);
    }
    
    public function showLesson($id) {
        return view('one-lesson', ['data' => Lesson::find($id)]);
    }
}
