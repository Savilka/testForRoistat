<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестовое задание</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        form {
            display: flex;
            flex-wrap: wrap;
        }
        label {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin: 10px 30%;
        }
        #button {
            width: 100%;
            margin: 0 30%;
        }
    </style>
</head>
<body>
<form action="/api/createRequest" method="post">
    <label>Имя
        <input type="text" name="name">
    </label>
    <label>E-Mail
        <input type="text" name="email">
    </label>
    <label>Телефон
        <input type="text" name="phone">
    </label>
    <label>Цена
        <input type="text" name="price">
    </label>
    <input id="button" type="submit">
</form>
</body>
</html>
