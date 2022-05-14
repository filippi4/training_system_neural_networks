<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function showTest() {
        $test = Test::all();
        $data = [];
        foreach ($test as $question) {
            $data[$question->id] = [ 
                'title' => $question->title,
                'answers' => explode(";", str_replace('@', '', $question->answers))
            ];
        }
        return view('tests.test', compact('data'));
    }

    public function checkTest(Request $req) {
        $count = Test::count();
        $result = [];
        for ($i = 1; $i <= $count; $i++) {
            if ($req->input("question-$i") == null) {
                return redirect()->back()->with('error', "Ответьте на все вопросы.");
            }
            $current = Test::find($i);
            $answers = explode(";", $current->answers);
            $result["question-$i"] = gettype(strpos($answers[$req->input("question-$i")], "@")) === "integer" ? true : false;
        }
        $data = $result;
        return view('tests.result-test', compact('data'));
    }

    public function editTest() {
        $test = Test::all();
        if ($test->isEmpty()) {
            return view('tests.edit-test')->with('message', 'Тест не создан, воспользуйтесь базой данных для создания теста.');
        }
        else {
            $data = [];
            foreach ($test as $question) {
                $data[$question->id] = [ 
                    'title' => $question->title,
                    'answers' => explode(";", $question->answers)
                ];
            }
            return view('tests.edit-test', compact('data'));
        }
    }

    public function changeTest(Request $req) {
        $input = $req->all();
        $tmp_test = [];
        $title = "";
        $answers = "";
        foreach ($input as $key => $value) {
            /**
             * BAD: Сильная зависимость от структуры данных
             */
            if (preg_match("/question/i", $key)) {
                $answers = "";
                $title = $value;
            }
            if (preg_match("/answer/i", $key)) {
                $answers .= $value . ';';
                $tmp_test[$title] = $answers;
            }
        }

        $test_count = Test::count();
        $tmp_test_keys = array_keys($tmp_test);
        for ($i = 1; $i <= $test_count; $i++) {
            $current = Test::find($i); // BAD: id мб не последовательным
            $current->title = $tmp_test_keys[$i-1];
            $current->answers = mb_substr($tmp_test[$tmp_test_keys[$i-1]], 0, -1);
            $current->save();
        }

        return redirect()->back();
    }
}
