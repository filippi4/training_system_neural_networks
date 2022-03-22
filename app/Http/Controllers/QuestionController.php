<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function showAllQuestions() {
        $questions = Question::all();
        $data = [];
        foreach ($questions as $question) {
            $data[$question->id] = [ 
                'title' => $question->title,
                'answers' => explode(";", $question->answers)
            ];
        }
        return view('tests.test', compact('data'));
    }
}
