<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");

$title = 'Главная';
$is_auth = rand(0, 1);
$user_name = 'Александр'; // укажите здесь ваше имя

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
    $lots_sql = 'SELECT l.id, l.name, l.start_price, l.picture, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description FROM lots l JOIN category c ON l.id_category = c.id_lot JOIN bets b ON l.id = b.id_lot GROUP BY l.id ORDER BY l.date_create DESC';
    $result_select = mysqli_query($link, $lots_sql);

    if ($result_select) {
        $lots_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);

    } else {
        print ('Произошла ошибка при выполнении запроса! Обратитесь к администратору, либо попробуйте снова.');
    }
} else {
    print ('Произошла ошибка подключения, недоступна база данных! Обратитесь к администратору, либо попробуйте снова.');
}

function space_price($price) {
    $around_price = ceil($price);
    if ($around_price > 1000) {
        $make_space = number_format ($around_price, 0, 0, " ");
        return $make_space ." ₽";
    }
    return $around_price ." ₽";
};

function check_hakers($typing) {
    $haker = strip_tags($typing);
    return $haker;
};

function show_date() {
    $date_now = date_create("now");
    $date_next = date_create("tomorrow");
    $date_diff = date_diff($date_next, $date_now);
    $date_count = date_interval_format($date_diff, "%h:%i");
    return $date_count;
}

$content_main = include_template ('index.php', ['categories_select' => $categories_select, 'lots_select'=>$lots_select]);
$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories_select' => $categories_select, 'content_main' => $content_main]);

print ($layout);

?>
