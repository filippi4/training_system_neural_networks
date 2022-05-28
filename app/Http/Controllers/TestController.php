<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Test;
use App\Models\TestResults;
use App\Models\User;
use Session;

class TestController extends Controller
{
    public function showTest($question_type) {
        $test = Test::all();
        $data = [];
        foreach ($test as $question) {
            // записывает вопросы нужного типа
            if ($question->question_type == $question_type) {
                $data[$question->title] = explode(";", str_replace('@', '', $question->answers));
            }
        }
        return view('tests.test', compact('data'))->with('question_type', $question_type);
    }

    public function checkTest($question_type, Request $req) {
        $test = Test::all();
        $test_correspond_type = [];
        foreach ($test as $question) {
            if ($question->question_type == $question_type) {
                $test_correspond_type[] = $question;
            }
        }
        if ((count($req->all()) - 1) != count($test_correspond_type)) {
            return redirect()->back()->with('error', "Ответьте на все вопросы.");
        }
        $result = [];
        $number = 1;
        foreach ($test_correspond_type as $question) {
            $answers = explode(";", $question->answers);
            $right_answer = [];
            foreach ($answers as $answer) {
               $right_answer[] = gettype(strpos($answer, "@")) === "integer";
            }
            // TODO: переписать
            $user_answer = array_fill(0, count($answers), false);
            foreach ($req->input("question-$number") as $answer)
                for ($i = 1; $i <= count($answers); $i++) {
                    $user_answer[$i-1] |= $answer == (string)($i-1);
                }
            $result["$number"] = $right_answer == $user_answer;
            $number++;
        }
        if (Session::has('loginId')) {
            $current_user = User::find(Session::get('loginId'));
            $test_results = TestResults::where('email', '=', $current_user->email)->first();
            if ($test_results == null) {
                $t_results = new TestResults;
                $t_results->email = $current_user->email;
                $tmp_result = "";
                $tmp_result .= date('Y-m-d H:i:s') . ' ' . $question_type . PHP_EOL;
                foreach ($result as $key => $value) {
                    $tmp_result .= $key . ':' . (($value) ? '1' : '0') . ' ';
                }
                $tmp_result[-1] = ';';
                $t_results->results = $tmp_result;
                $t_results->save();
            } else {
                $tmp_result = $test_results->results;
                $tmp_result .= PHP_EOL;
                $tmp_result .= date('Y-m-d H:i:s') . ' ' . $question_type . PHP_EOL;
                foreach ($result as $key => $value) {
                    $tmp_result .= $key . ':' . (($value) ? '1' : '0') . ' ';
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
                [$header, $r_res] = explode("\n", trim($res)); // trim - удалить '\n' в начале и в конце строки
                $header = explode(" ", $header); // разделение заголовка на дату, время и тип теста
                $r_date = $header[0] . ' ' . $header[1];
                $r_question_type = $header[2];
                $tmp_res = explode(' ', $r_res);
                $r_res = [];
                foreach ($tmp_res as $r) {
                    $r_res[] = explode(':', $r)[1];
                }
                $results[$r_date] = [
                    'type' => $r_question_type,
                    'result' => $r_res
                ];
            }
            $data['tests_results'] = $results;
            $max_count = 0;
            foreach ($results as $key => $value)
                $max_count = max($max_count, count($value['result']));
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
                    'type' => $question->question_type,
                    'answers' => explode(";", $question->answers)
                ];
            }
            return view('tests.edit-test', compact('data'));
        }
    }

    public function addQuestion(Request $req) {
        // TODO: переписать с помошью validate
        $error = "Заполните все поля формы";
        $correct_input = true;
        if ($req->input('question-description') == null) {
            $correct_input = false;
        }
        $answers_count = (int)$req->input('answers-count');
        for ($i = 1; $i <= $answers_count; $i++) {
            if ($req->input("answer-$i") == null) {
                $correct_input = false;
            }
        }
        if ($req->input('right-answers-count') == "one") {
            if ($req->input('radio-right-answer') == null) {
                $correct_input = false;
                $error .= " и выберите правильный вариант ответа";
            }
        } else if ($req->input('right-answers-count') == "several") {
            if ($req->input('checkbox-right-answer') == null) {
                $correct_input = false;
                $error .= " и выберите правильные варианты ответа";
            }
        }
        if ($correct_input == false) {
            return redirect()->back()->with('error', $error . '.');
        } else {
            $test = new Test;
            $test->title = $req->input('question-description');
            $test->question_type = $req->input('question-type');

            $answers = "";
            for ($i = 1; $i <= $answers_count; $i++) {
                $answers .= $req->input("answer-$i");
                if ($req->input('right-answers-count') == "one") {
                    if ((int)$req->input('radio-right-answer') == $i) {
                        $answers .= '@';
                    }
                } 
                else if ($req->input('right-answers-count') == "several") {
                    if (in_array((string)$i, $req->input('checkbox-right-answer'))) {
                        $answers .= '@';
                    }
                }
                $answers .= ';';
            }
            $answers = mb_substr($answers, 0, -1);
            $test->answers = $answers;
            $test->save();
            return redirect()->route('edit-test');
        }
    }

    public function editTestRemove() {
        $test = Test::all();
        $data = [];
        foreach ($test as $question) {
            $data[$question->id] = $question->title;
        }
        return view('tests.remove-question', compact('data'));
    }

    public function changeQuestion($id, Request $req) {
        $question = Test::find($id);
        $right_answer = [];
        foreach (explode(";", $question->answers) as $answer) {
            $right_answer[] = gettype(strpos($answer, "@")) === "integer" ? "true" : "false";
        }
        $data = [
            'id' => $question->id,
            'title' => $question->title,
            'answers' => explode(';', str_replace('@', '', $question->answers)),
            'answers-count' => "" . count(explode(";", $question->answers)),
            'question-type' => $question->question_type,
            'right-answer' => $right_answer,
            'right-answers-count' => "" .
            (count(array_filter($right_answer, function($s) { 
                if ($s == "true") {
                    return true;
                } else if ($s == "false") {
                    return false;
                }
            })) > 1 ? 'several' : 'one')
        ];
        return view('tests.change-question', compact('data'));
    }

    public function saveChangeQuestion($id, Request $req) {
        // TODO: переписать с помошью validate
        $error = "Заполните все поля формы";
        $correct_input = true;
        if ($req->input('question-description') == null) {
            $correct_input = false;
        }
        $answers_count = (int)$req->input('answers-count');
        for ($i = 1; $i <= $answers_count; $i++) {
            if ($req->input("answer-$i") == null) {
                $correct_input = false;
            }
        }
        if ($req->input('right-answers-count') == "one") {
            if ($req->input('radio-right-answer') == null) {
                $correct_input = false;
                $error .= " и выберите правильный вариант ответа";
            }
        } else if ($req->input('right-answers-count') == "several") {
            if ($req->input('checkbox-right-answer') == null) {
                $correct_input = false;
                $error .= " и выберите правильные варианты ответа";
            }
        }
        if ($correct_input == false) {
            return redirect()->back()->with('error', $error . '.');
        } else {
            $test = Test::find($id);
            $test->title = $req->input('question-description');
            $test->question_type = $req->input('question-type');

            $answers = "";
            for ($i = 1; $i <= $answers_count; $i++) {
                $answers .= $req->input("answer-$i");
                if ($req->input('right-answers-count') == "one") {
                    if ((int)$req->input('radio-right-answer') == $i) {
                        $answers .= '@';
                    }
                } 
                else if ($req->input('right-answers-count') == "several") {
                    if (in_array((string)$i, $req->input('checkbox-right-answer'))) {
                        $answers .= '@';
                    }
                }
                $answers .= ';';
            }
            $answers = mb_substr($answers, 0, -1);
            $test->answers = $answers;
            $test->save();
            return redirect()->route('edit-test');
        }
    }

    public function removeQuestion($id, Request $req) {
        Test::find($id)->delete();
        return redirect()->route('edit-test');
    }
}
