<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

include_once 'functions.php';

$title = 'Главная';

$link = connect_to_db();
$title = return_name_title();
$lots_select = [];

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

$content_main = include_template ('index.php', ['categories_select' => show_categories_select(), 'lots_select'=>$lots_select]);
$layout = include_template ('layout.php', ['title' => $title['index'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
