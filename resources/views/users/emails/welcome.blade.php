<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    .button-container {
        text-align: center;
        margin-top: 80px;
        margin-bottom: 32px;
    }

    .button{
        padding: 24px;
        color: #fff;
        background-color: #eb6100;
        border-radius: 100vh;
        text-decoration: none
    }

    .button:hover{
        color: #fff;
        background: #f56500;
    }
</style>
<body>
    <h1 style="text-align: center">Welcome to Insta App!</h1>
    <hr>
    <p style="font-weight: bold">Hello, {{$name}}</p>
    <p>Thank you for registering.</p>
    <p>To start, please access the website. <br>
    <div class="button-container">
    <a href="{{$app_url}}" class="button">Confirm by Logging in here.</a></p>
    </div>
    <p>Thank you.</p>
</body>
</html>