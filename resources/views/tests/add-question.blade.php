@extends('layouts.app')

@section('title-block')Добавление вопроса@endsection

@section('content')
<form action="{{ route('add-edit-test-form') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="question-description">Введите текст вопроса</label>
        <textarea class="form-control" name="question-description" id="question-description" cols="40" rows="1"></textarea>
    </div>
    <div class="form-group">
    <label for="question-type">Выберите тип вопроса</label>
    <select class="form-control" name="question-type" id="question-type">
            <option selected value="theor">Теоретический</option>
            <option value="math">Математический</option>
        </select>
    </div>
    <div class="form-group">
    <label for="answers-count">Выберите количество правильных ответов</label>
    <select class="form-control" name="right-answers-count" id="right-answers-count" onchange="change_true_answers_count(value)">
            <option selected value="one">один</option>
            <option value="several">несколько</option>
        </select>
    </div>
    <div class="form-group">
        <label for="answers-count">Выберите количество вариантов ответов</label>
        <select class="form-control" name="answers-count" id="answers-count" onchange="change_answers_count(value)">
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
                    <td><input type="text" class="form-control" name="answer-1" id="answer-1" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-1" value="1"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-1" value="1" style="display: none"></td>
                </tr>
                <tr id="tr-answer-2">
                    <td>2) </td>
                    <td><input type="text" class="form-control" name="answer-2" id="answer-2" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-2" value="2"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-2" value="2" style="display: none"></td>
                </tr>
                <tr id="tr-answer-3">
                    <td>3) </td>
                    <td style="margin-left: 20px"><input type="text" class="form-control" name="answer-3" id="answer-3" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-3" value="3"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-3" value="3" style="display: none"></td>
                </tr>
                <tr id="tr-answer-4">
                    <td>4) </td>
                    <td><input type="text" class="form-control" name="answer-4" id="answer-4" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-4" value="4"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-4" value="4" style="display: none"></td>
                </tr>
                <tr id="tr-answer-5" style="display: none">
                    <td>5) </td>
                    <td><input type="text" class="form-control" name="answer-5" id="answer-5" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-5" value="5"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-5" value="5" style="display: none"></td>
                </tr>
                <tr id="tr-answer-6" style="display: none">
                    <td>6) </td>
                    <td><input type="text" class="form-control" name="answer-6" id="answer-6" style="width: 400px"></td>
                    <td><input type="radio" name="radio-right-answer" id="radio-answer-6" value="6"></td>
                    <td><input type="checkbox" name="checkbox-right-answer[]" id="checkbox-answer-6" value="6" style="display: none"></td>
                </tr>
            </table>
        </label>
    </div>
    <br>
    <button class="btn btn-primary" type="submit">Добавить</button>
</form>
<script>
    // изменение кол-ва вариантов ответов после перезагрузки страницы
    window.addEventListener("load", function(){
        document.getElementById("right-answers-count").value = "one";
        document.getElementById("answers-count").value = 4;
        change_true_answers_count("one");
        change_answers_count(4);
    }, false);

    function change_true_answers_count(value) {
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