@extends('layouts.app')

@section('title-block')Изменение теста@endsection

@section('content')
<form action="{{ route('save-change-question-form', $data['id']) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="question-description">Введите текст вопроса</label>
        <textarea class="form-control" name="question-description" id="question-description" cols="40" rows="1">{{ $data['title'] }}</textarea>
    </div>
    <div class="form-group">
    <label for="question-type">Выберите тип вопроса</label>
    <select class="form-select" name="question-type" id="question-type" style="width: 11em">
            <option selected value="theor">Теоретический</option>
            <option value="math">Математический</option>
        </select>
    </div>
    <div class="form-group">
        <label for="answers-count">Выберите количество правильных ответов</label>
        <select class="form-select" name="right-answers-count" id="right-answers-count" onchange="change_right_answers_count(value)" style="width: 8em">
            <option value="one">один</option>
            <option value="several">несколько</option>
        </select>
    </div>
    <div class="form-group">
        <label for="answers-count">Выберите количество вариантов ответов</label>
        <select class="form-select" name="answers-count" id="answers-count" onchange="change_answers_count(value)" style="width: 4em">
            <option value="2">2</option>
            <option value="3">3</option>
            <option selected value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>
    </div>
    <div class="form-group">
        <label>Введите варианты ответов
            <table>
                <tr id="tr-answer-1">
                    <td>1) </td>
                    <td><input type="text" class="form-control" name="answer-1" id="answer-1" value="{{ $data['answers'][0] }}" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-1" value="1"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-1" value="1"style="display: none"></td>
                </tr>
                <tr id="tr-answer-2">
                    <td>2) </td>
                    <td><input type="text" class="form-control" name="answer-2" id="answer-2" value="{{ $data['answers'][1] }}" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-2" value="2"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-2" value="2" style="display: none"></td>
                </tr>
                <tr id="tr-answer-3">
                    <td>3) </td>
                    <td><input type="text" class="form-control" name="answer-3" id="answer-3" value="{{ $data['answers'][2] ?? ''}}" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-3" value="3" ></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-3" value="3" style="display: none"></td>
                </tr>
                <tr id="tr-answer-4">
                    <td>4) </td>
                    <td><input type="text" class="form-control" name="answer-4" id="answer-4" value="{{ $data['answers'][3] ?? ''}}" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-4" value="4"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-4" value="4" style="display: none"></td>
                </tr>
                <tr id="tr-answer-5" style="display: none">
                    <td>5) </td>
                    <td><input type="text" class="form-control" name="answer-5" id="answer-5" value="{{ $data['answers'][4] ?? ''}}" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-5" value="5"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-5" value="5" style="display: none"></td>
                </tr>
                <tr id="tr-answer-6" style="display: none">
                    <td>6) </td>
                    <td><input type="text" class="form-control" name="answer-6" id="answer-6" value="{{ $data['answers'][5] ?? ''}}" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-6" value="6"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-6" value="6" style="display: none"></td>
                </tr>
            </table>
        </label>
    </div>
    <br>
    <button class="btn btn-success" type="submit">Сохранить</button>
</form>
<script>
    var question_type = "<?php echo $data['question-type']; ?>";
    var right_answers_count = "<?php echo $data['right-answers-count']; ?>";
    var answers_count = "<?php echo $data['answers-count']; ?>";
    <?php 
    $json_value = json_encode($data['right-answer']);
    echo "var right_answer = " . $json_value . ";\n";
    ?>
    // изменение кол-ва вариантов ответов после перезагрузки страницы
    window.addEventListener("load", function(){
        document.getElementById("question-type").value = question_type;
        document.getElementById("right-answers-count").value = right_answers_count;
        document.getElementById("answers-count").value = answers_count;
        document.getElementById("checkbox-answer-3").checked = false;
        change_right_answers_count(right_answers_count);
        change_answers_count(answers_count);
        set_checked_value();
    }, false);

    function set_checked_value() {
        for (let i = 0; i < right_answer.length; i++) {
            if (right_answers_count == "one") {
                if (right_answer[i] == "true") {
                    document.getElementById("radio-answer-" + (i + 1)).checked = true;
                }
            } else if (right_answers_count == "several") {
                if (right_answer[i] == "true") {
                    document.getElementById("checkbox-answer-" + (i + 1)).checked = true;
                } else if (right_answer[i] == "false") {
                    document.getElementById("checkbox-answer-" + (i + 1)).checked = false;
                }
            }
        }
    }

    function change_right_answers_count(value) {
        if (value == "one") {
            document.getElementById("radio-answer-1").style.display = "";
            document.getElementById("radio-answer-2").style.display = "";
            document.getElementById("radio-answer-3").style.display = "";
            document.getElementById("radio-answer-4").style.display = "";
            document.getElementById("radio-answer-5").style.display = "";
            document.getElementById("radio-answer-6").style.display = "";
            document.getElementById("checkbox-answer-1").style.display = "none";
            document.getElementById("checkbox-answer-2").style.display = "none";
            document.getElementById("checkbox-answer-3").style.display = "none";
            document.getElementById("checkbox-answer-4").style.display = "none";
            document.getElementById("checkbox-answer-5").style.display = "none";
            document.getElementById("checkbox-answer-6").style.display = "none";
            
        } else if (value == "several") {
            document.getElementById("radio-answer-1").style.display = "none";
            document.getElementById("radio-answer-2").style.display = "none";
            document.getElementById("radio-answer-3").style.display = "none";
            document.getElementById("radio-answer-4").style.display = "none";
            document.getElementById("radio-answer-5").style.display = "none";
            document.getElementById("radio-answer-6").style.display = "none";
            document.getElementById("checkbox-answer-1").style.display = "";
            document.getElementById("checkbox-answer-2").style.display = "";
            document.getElementById("checkbox-answer-3").style.display = "";
            document.getElementById("checkbox-answer-4").style.display = "";
            document.getElementById("checkbox-answer-5").style.display = "";
            document.getElementById("checkbox-answer-6").style.display = "";
        }
    }

    // BAD: можно переписать код лучше
    function change_answers_count(value) {
        if (value == "2") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "none";
            document.getElementById("tr-answer-4").style.display = "none";
            document.getElementById("tr-answer-5").style.display = "none";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (value == "3") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "none";
            document.getElementById("tr-answer-5").style.display = "none";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (value == "4") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "";
            document.getElementById("tr-answer-5").style.display = "none";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (value == "5") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "";
            document.getElementById("tr-answer-5").style.display = "";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (value == "6") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "";
            document.getElementById("tr-answer-5").style.display = "";
            document.getElementById("tr-answer-6").style.display = "";
        }
    }
</script>
@endsection