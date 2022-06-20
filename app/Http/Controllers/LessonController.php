<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Tag;

use Parsedown;
use Session;

class LessonController extends Controller
{
    public function allData() {
        return view('lessons', 
                ['lessons' => Lesson::all()
                    ->filter(function ($value, $key) { 
                        // TODO: delete method first
                        return $value->tags()->get()->first()->name == 'Урок'; 
                    })]);
    }
    
    public function showLesson($id) {
        return view('one-lesson', ['lesson' => Lesson::find($id)]);
    }

    public function editLessons() {
        $data = Lesson::all();
        return view('lessons.edit-lessons', compact('data'));
    }

    public function pageAddLesson() {
        return view('lessons.add-lesson', ['tags' => Tag::all()]);
    }

    public function addLesson(Request $req) {
        $lesson = Lesson::create(['title' => $req->input('lesson-title'),
                                'content' => $req->input('lesson-content')]);   

        $tags_id = [];
        foreach ($req->input('tags') as $id => $checked) {
           $tags_id[] = $id;
        }
        $tags = Tag::find($tags_id);
        $lesson->tags()->attach($tags);

        return redirect()->route('edit-lessons');
    }

    public function changeLesson($id) {
        return view('lessons.change-lesson', 
                ['lesson' => Lesson::find($id), 'tags' => Tag::all()]);
    }

    public function saveChangeLesson($id, Request $req) {
        $lesson = Lesson::find($id);
        $lesson->title = $req->input('lesson-title');
        $lesson->content = $req->input('lesson-content');

        if ($lesson->tags()->get()->count()) {
            $lesson->tags()->detach();
        }

        if ($req->input('tags')) {
            $lesson->tags()->attach(Tag::find(array_keys($req->input('tags'))));
        }

        $lesson->save();

        return redirect()->route('edit-lessons');
    }

    public function removeLesson($id) {
        $lesson = Lesson::find($id);
        $lesson->tags()->detach();
        $lesson->delete();

        return redirect()->route('edit-lessons');
    }
}
