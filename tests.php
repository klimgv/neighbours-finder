<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighbours Tests</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="list-group">     
        <a href="index.php" class="list-group-item list-group-item-action list-group-item-success">Главная страница с параметрами (по умолчанию) - [index.php]</a>
        <a href="index.php?x=100&y=100&m=45&k=11" class="list-group-item list-group-item-action list-group-item-success">Главная страница с параметрами (введёными вручную) - [index.php?x=100&y=100&m=45&k=11]</a>
        <a href="index.php?x=2500&y=2500&m=10&k=5" class="list-group-item list-group-item-action list-group-item-success">Главная страница с отсутствием соседей - [index.php?x=2500&y=2500&m=10&k=5]</a>
        <a href="index.php?x=100&y=100&m=-56&k=11" class="list-group-item list-group-item-action list-group-item-danger">Главная страница с неправильными параметрами (m - отрицательное число) - [index.php?x=100&y=100&m=-56&k=11]</a>
        <a href="methods.php?action=delete&x=130&y=66" class="list-group-item list-group-item-action list-group-item-success">GET-запрос на удаление существующей точки - [methods.php?action=delete&x=130&y=66]</a>
        <a href="methods.php?action=delete&x=123&y=90" class="list-group-item list-group-item-action list-group-item-danger">GET-запрос на удаление несуществующей точки - [methods.php?action=delete&x=123&y=90]</a>
        <a href="methods.php?action=add&x=123&y=90" class="list-group-item list-group-item-action list-group-item-success">GET-запрос на добавление точки - [methods.php?action=add&x=123&y=90]</a>
        <a href="methods.php?action=add&x=130&y=66" class="list-group-item list-group-item-action list-group-item-danger">GET-запрос на добавление уже существующей точки - [methods.php?action=add&x=130&y=66]</a>
        <a href="methods.php?action=change&x=115&y=90&x0=120&y0=90" class="list-group-item list-group-item-action list-group-item-success">GET-запрос на изменение координат точки - [methods.php?action=change&x=115&y=90&x0=120&y0=90]</a>
        <a href="methods.php?action=change&x=115&y=90&x0=115&y0=60" class="list-group-item list-group-item-action list-group-item-danger">GET-запрос на изменение координат точки на уже существующие - [methods.php?action=change&x=115&y=90&x0=115&y0=60]</a>
        <a href="methods.php?action=find&x=0&y=16&m=100&k=100" class="list-group-item list-group-item-action list-group-item-success">GET-запрос на нахождение ближайших соседей по параметрам - [methods.php?action=find&x=0&y=16&m=100&k=100]</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>