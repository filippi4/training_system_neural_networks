<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Session;

class TestController extends Controller
{
    public function pageTesting() {
        return view('testing', ['tests' => Test::all()]);
    }

    public function pageTest(Test $test) {
        return view('tests.test', ['test' => $test]);
    }

    public function checkTest(Test $test, Request $req) {
        if (count(array_unique(array_map(function ($item) { return explode('_', $item)[1]; }, array_map(function ($item) { return explode('-', $item)[0]; }, preg_grep('/^question_\d+-answer_\d+$/', array_keys($req->all()))))))
            !== $test->questions()->get()->count()) {
            return redirect()->back()->with('error', 'Ответьте на все вопросы');
        }

        $request_test = [];
        $test_control = [];
        foreach ($test->questions()->get() as $question) {
            $test_control["question_{$question->id}"] =
                array_merge((isset($test_control["question_{$question->id}"]))? $test_control["question_{$question->id}"] : [],
                    $question->answers_right()->get()->map(function ($item) { return $item->id; })->all());
            foreach($question->answers()->get() as $answer) {
                if ($req->input("question_{$question->id}-answer_{$answer->id}") !== null) {
                    $request_test["question_{$question->id}"] = 
                        array_merge((isset($request_test["question_{$question->id}"])) ? $request_test["question_{$question->id}"] : [], [$answer->id]);
                }

            }
        }

        $number = 0;
        foreach ($test_control as $question => $answers_right) {
            if ($test_control[$question] === $request_test[$question]) {
                $number++;
            }
        }

        $scale = round($number / count($test_control), 2);
        $score = '';
        if ($scale == 1.0) $score = 'отлично';
        if ($scale < 1.0 && $scale >= 0.75) $score = 'хорошо';
        if ($scale < 0.75 && $scale >= 0.50) $score = 'удовлетворительно';
        if ($scale < 0.50) $score = 'неудовлетворительно';

        // echo $number . '/' . count($test_control) . ' ' . $score; die();

        $test_result = new TestResult;
        $test_result->test()->associate($test);
        // $test_result->user()->associate(User::find(1));
        $test_result->tries += 1;
        $test_result->amount_right_questions = $number;
        $test_result->score = $score;
        $test_result->updated_at = date('Y-m-d H:s:i');
        // $test_result->save();

        return view('tests.test-result', ['test_result' => $test_result]);
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

    public function pageAddTest() {
        return view('tests.add-test');
    }

    public function addTest(Request $req) {
        Test::create(['name' => $req->input('name')]);
        return redirect()->route('edit-tests');
    }

    public function pageEditTests() {
        return view('tests.edit-tests', ['tests' => Test::all()]);
    }

    public function pageEditTest(Test $test) {
        return view('tests.change-test', ['test' => $test]);
    }

    public function pageAddQuestion() {
        return view('tests.add-question');
    }

    public function pageChangeQuestion(Question $question) {
        return view('tests.change-question', ['question' => $question]);
    }

    public function deleteTest(Test $test) {
        $test->delete();
        return redirect()->back();
    }

    public function addQuestion(Request $req) {
        // dd($req->all());
        // $question = new Question(['description' => $req->input('question-description')]);
        // for ($i = 0; $i < (int)$req->input('answers-count'); $i++) {
        //     ;
        //     // $answer = Answer;
        // }
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
        return view('tests.delete-question', compact('data'));
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

    public function deleteQuestion($id, Request $req) {
        Test::find($id)->delete();
        return redirect()->route('edit-test');
    }
}