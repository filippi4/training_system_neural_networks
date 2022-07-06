<!-- DOES NOT WORK, ONLY FOR THE TEMPLATE -->
@extends('layouts.app')

@section('title-block')Изменение теста@endsection

@section('content')
<form action="{{ route('save-change-question-form', $question->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="question-description">Введите текст вопроса</label>
        <textarea class="form-control" name="question-description" id="question-description" cols="40" rows="1">{{ $question->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="answers-count">Выберите количество вариантов ответов</label>
        <select class="form-select" name="answers-count" id="answers-count" onchange="change_answers_display(value)" style="width: 4em">
            <option value="2">2</option>
            <option value="3">3</option>
            <option selected value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>
    </div>
    <div class="form-group">
        <label>Введите варианты ответов и выберите правильный(ые)
            <table>
                @php
                $answers = $question->answers()->get()->all();
                $answers_right_id = $question->answers_right()->get()->map(function ($item) { return $item->id; })->all();
                $checked = [];
                foreach($answers as $index => $answer) {
                    $checked[$index] = (in_array($answer->id, $answers_right_id)) ? true : false;
                }
                @endphp
                <tr id="tr-answer-1">
                    <td>1) </td>
                    <td><input type="text" class="form-control" name="answer-1" id="answer-1" value="{{ $answers[0]->text }}" style="width: 400px"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-1" value="{{ $checked[0] }}"></td>
                </tr>
                <tr id="tr-answer-2">
                    <td>2) </td>
                    <td><input type="text" class="form-control" name="answer-2" id="answer-2" value="{{ $answers[1]->text }}" style="width: 400px"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-2" value="{{ $checked[1] }}"></td>
                </tr>
                <tr id="tr-answer-3">
                    <td>3) </td>
                    <td><input type="text" class="form-control" name="answer-3" id="answer-3" value="{{ $answers[2]->text }}" style="width: 400px"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-3" value="{{ $checked[2] }}"></td>
                </tr>
                <tr id="tr-answer-4">
                    <td>4) </td>
                    <td><input type="text" class="form-control" name="answer-4" id="answer-4" value="@if (array_key_exists(3, $answer)) {{ $answers[3]->text }} @endif" style="width: 400px"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-4" value="@if (array_key_exists(3, $checked)) {{ $checked[3] }} @endif"></td>
                </tr>
                <tr id="tr-answer-5">
                    <td>5) </td>
                    <td><input type="text" class="form-control" name="answer-5" id="answer-5" value="@if (array_key_exists(4, $answer)) {{ $answers[4]->text }} @endif" style="width: 400px"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-5" value="@if (array_key_exists(4, $checked)) {{ $checked[4] }} @endif"></td>
                </tr>
                <tr id="tr-answer-6">
                    <td>6) </td>
                    <td><input type="text" class="form-control" name="answer-6" id="answer-6" value="@if (array_key_exists(5, $answer)) {{ $answers[5]->text }} @endif" style="width: 400px"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-6" value="@if (array_key_exists(5, $checked)) {{ $checked[5] }} @endif"></td>
                </tr>
            </table>
        </label>
    </div>
    <br>
    <button class="btn btn-success" type="submit">Сохранить</button>
</form>
<script>
    var answers_count = "<?php echo $question->answers()->get()->count(); ?>";
    <?php
    $json_value = json_encode($checked);
    echo "var checked = " . $json_value . ";\n";
    ?>
    // изменение кол-ва вариантов ответов после перезагрузки страницы
    window.addEventListener("load", function(){
        document.getElementById("answers-count").value = answers_count;
        change_answers_display(answers_count);
        set_checked_value();
    }, false);

    function set_checked_value() {
        for (let i = 0; i < checked.length; i++) {
            if (checked[i] == true) {
                document.getElementById("checkbox-answer-" + (i + 1)).checked = true;
            } else if (checked[i] == false) {
                document.getElementById("checkbox-answer-" + (i + 1)).checked = false;
            }
        }
    }

    // BAD: можно переписать код лучше
    function change_answers_display(count) {
        if (count == "2") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "none";
            document.getElementById("tr-answer-4").style.display = "none";
            document.getElementById("tr-answer-5").style.display = "none";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (count == "3") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "none";
            document.getElementById("tr-answer-5").style.display = "none";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (count == "4") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "";
            document.getElementById("tr-answer-5").style.display = "none";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (count == "5") {
            document.getElementById("tr-answer-1").style.display = "";
            document.getElementById("tr-answer-2").style.display = "";
            document.getElementById("tr-answer-3").style.display = "";
            document.getElementById("tr-answer-4").style.display = "";
            document.getElementById("tr-answer-5").style.display = "";
            document.getElementById("tr-answer-6").style.display = "none";
        } else if (count == "6") {
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