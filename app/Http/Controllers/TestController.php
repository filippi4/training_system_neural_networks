<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestResults;
use App\Models\User;
use Session;

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
        if (Session::has('loginId')) {
            $current_user = User::find(Session::get('loginId'));
            $test_results = TestResults::where('email', '=', $current_user->email)->first();
            if ($test_results == null) {
                $t_results = new TestResults;
                $t_results->email = $current_user->email;
                $tmp_result = "";
                $tmp_result .= date('Y-m-d H:i') . PHP_EOL;
                foreach ($result as $key => $value) {
                    $tmp_result .= explode('-', $key)[1] . ':' . (($value) ? '1' : '0') . ' ';
                }
                $tmp_result[-1] = ';';
                $t_results->results = $tmp_result;
                $t_results->save();
            } else {
                $tmp_result = $test_results->results;
                $tmp_result .= PHP_EOL;
                $tmp_result .= date('Y-m-d H:i') . PHP_EOL;
                foreach ($result as $key => $value) {
                    $tmp_result .= explode('-', $key)[1] . ':' . (($value) ? '1' : '0') . ' ';
                }
                $tmp_result[-1] = ';';
                $test_results->results = $tmp_result;
                $test_results->save();
            }
            
        }

        $data = $result;
        return view('tests.test-results', compact('data'));
    }

    public function showUserTestResults() {
        $current_user = User::find(Session::get('loginId'));
        $test_results = TestResults::where('email', '=', $current_user->email)->first();
        if ($test_results == null) {
            return view('tests.user-test-results')->with('message', 'Нет результатов тестирования.');
        }
        else {
            $tmp_results = explode(';', $test_results->results);
            array_pop($tmp_results); // удалить последний эл-т массива, пустая строка из-за стоящего в конце символа ';'
            $results = [];
            foreach ($tmp_results as $res) {
                [$r_date, $r_res] = explode("\n", trim($res)); // trim - удалить '\n' в начале и в конце строки
                $tmp_res = explode(' ', $r_res);
                $r_res = [];
                foreach ($tmp_res as $r) {
                    $r_res[] = explode(':', $r)[1];
                }
                $results[$r_date] = $r_res;
            }
            $data['results'] = $results;
            $max_count = 0;
            foreach ($results as $date => $res)
                $max_count = max($max_count, count($res));
            $data['count'] = $max_count;
            return view('tests.user-test-results', compact('data'));
        }
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
