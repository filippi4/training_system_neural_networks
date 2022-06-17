<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use Parsedown;
use Session;

class LessonController extends Controller
{
    public function allData() {
        $data = Lesson::all(); 
        return view('lessons', compact('data'));
    }
    
    public function showLesson($id) {
        $lesson = Lesson::find($id);
        $data['lesson'] = $lesson;
        if (Session::has('loginId')) {
            $user = User::find(Session::get('loginId'));
            $data['delivered'] = (in_array($id, explode(",", $user->delivered_lessons))) ? true : false;
        }

        return view('one-lesson', compact('data'));
    }

    public function deliveredLesson($id, Request $req) {
        /**
         * BAG: с помощью браузера можно вернуться на предыдущую страницу
         * и еще раз добавить id прочитанной страницы к списку
         */
        $user = User::find(Session::get('loginId'));
        if ($user->delivered_lessons == NULL) {
            $user->delivered_lessons = $req->input('lesson-id');
        } else {
            $user->delivered_lessons .= "," . $req->input('lesson-id');
        }
        $user->save();

        return redirect()->route('lessons');
    }

    public function editLessons() {
        $data = Lesson::all();
        return view('lessons.edit-lessons', compact('data'));
    }

    public function addLesson(Request $req) {
        $lesson = new Lesson;
        $lesson->title = $req->input('lesson-title');
        $lesson->content = $req->input('lesson-content');  
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
        $lesson->save();
        return redirect()->route('edit-lessons');
    }

    public function removeLesson($id) {
        Lesson::find($id)->delete();
        return redirect()->route('edit-lessons');
    }
}
