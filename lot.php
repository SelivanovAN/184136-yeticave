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

    if (!isset($_GET['value_id'])) {
            $lot_id = 0;
        } else {
            $lot_id = (int)$_GET['value_id'];
        }

    $lot_sql = 'SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.description, l.step_bet, l.date_close FROM lots l JOIN category c ON l.id_category = c.id_lot LEFT JOIN bets b ON l.id = b.id_lot WHERE l.id = '.$lot_id.' GROUP BY l.id';
    $result_select = mysqli_query($link, $lot_sql);

    if ($result_select) {
        $lot_select = mysqli_fetch_array($result_select, MYSQLI_ASSOC);

        if (!$lot_select) {
            http_response_code(404);
        }

    } else {
        print ('Произошла ошибка при выполнении запроса! Обратитесь к администратору, либо попробуйте снова.');
        die();
    }
} else {
    print ('Произошла ошибка подключения, недоступна база данных! Обратитесь к администратору, либо попробуйте снова.');
    die();
}

if ($lot_select) {
    $content_main = include_template ('lot.php', ['categories_select' => $categories_select, 'lot_select' => $lot_select]);
} else {
    $content_main = include_template ('error.php', ['categories_select' => $categories_select, 'lot_select' => $lot_select]);
}

$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories_select' => $categories_select, 'content_main' => $content_main]);

print ($layout);

?>
