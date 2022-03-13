<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/css/app.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> -->
</head>
<body>
    <div class="container mt-5 d-flex justify-content-center">
        <form action="{{ route('login-form') }}" method="post">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Введите email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль" id="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
    
</body>
</html>