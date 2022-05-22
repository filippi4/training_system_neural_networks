<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use Parsedown;

class LessonController extends Controller
{
    public function allData() {
        $data = Lesson::all(); 
        return view('lessons', compact('data'));
    }
    
    public function showLesson($id) {
        $lesson = Lesson::find($id);
        if ($lesson->content_type == "markdown") {
            $parsedown = new Parsedown();
            $lesson->content = $parsedown->text($lesson->content);
        }
        $data = $lesson;
        return view('one-lesson', compact('data'));
    }

    public function editLessons() {
        $data = Lesson::all();
        return view('lessons.edit-lessons', compact('data'));
    }

    public function addLesson(Request $req) {
        $lesson = new Lesson;
        $lesson->title = $req->input('lesson-title');
        $lesson->content = $req->input('lesson-content');
        $lesson->content_type = $req->input('content-type');     
        $lesson->save();
        return redirect()->route('edit-lessons');
    }

    public function changeLesson($id) {
        $data = Lesson::find($id);
        return view('lessons.change-lesson', compact('data'));
    }

    public function saveChangeLesson($id, Request $req) {
        $lesson = Lesson::find($id);
        $lesson->title = $req->input('lesson-title');
        $lesson->content = $req->input('lesson-content');
        $lesson->content_type = $req->input('content-type');     
        $lesson->save();
        return redirect()->route('edit-lessons');
    }

    public function removeLesson($id) {
        Lesson::find($id)->delete();
        return redirect()->route('edit-lessons');
    }
}
