<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use Session;

class HomeController extends Controller
{
    public function showLessons() {
        $data = [];
        $lessons = Lesson::all();
        if (Session::has('loginId')) {
            $user = User::find(Session::get('loginId'));
            $delivered_lessons = explode(",", $user->delivered_lessons);
            foreach ($lessons as $lesson) {
                if (in_array($lesson->id, $delivered_lessons)) {
                    $data[] = [
                        'id' => $lesson->id,
                        'title' => $lesson->title,
                        'delivered' => true
                    ];
                } else {
                    $data[] = [
                        'id' => $lesson->id,
                        'title' => $lesson->title,
                        'delivered' => false
                    ];
                }
            }
        } else {
            foreach ($lessons as $lesson) {
                $data[] = [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                ];
            }
        }
        
        return view('home', compact('data'));
    }
}
