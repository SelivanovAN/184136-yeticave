<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");

$title = 'Главная';

$categories_select = [];

$lots_select = [];

if($link) {
    $categories_sql = 'SELECT * FROM category ORDER BY name ASC';
    $result_select = mysqli_query($link, $categories_sql);

    if ($result_select) {
        $categories_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);
    } else {
        print ('Произошла ошибка при выполнении запроса! Обратитесь к администратору, либо попробуйте снова.');
        die();
    }
} else {
    print ('Произошла ошибка подключения, недоступна база данных! Обратитесь к администратору, либо попробуйте снова.');
    die();
}

if($link) {
    $lots_sql = 'SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description FROM lots l JOIN category c ON l.id_category = c.id_lot LEFT JOIN bets b ON l.id = b.id_lot GROUP BY l.id ORDER BY l.date_create DESC';
    $result_select = mysqli_query($link, $lots_sql);

    if ($result_select) {
        $lots_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);

    } else {
        print ('Произошла ошибка при выполнении запроса! Обратитесь к администратору, либо попробуйте снова.');
        die();
    }
} else {
    print ('Произошла ошибка подключения, недоступна база данных! Обратитесь к администратору, либо попробуйте снова.');
    die();
}

$content_main = include_template ('index.php', ['categories_select' => $categories_select, 'lots_select'=>$lots_select]);
$layout = include_template ('layout.php', ['title' => $title, 'categories_select' => $categories_select, 'content_main' => $content_main]);

//unset($_SESSION['user']);

print ($layout);

?>
