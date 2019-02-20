<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");

$title = 'Лот';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jpg = $_POST['jpg'];

        $filename = uniqid() . '.jpg';
        $jpg['path'] = $filename;
        move_uploaded_file($_FILES['file-upload']['tmp_name'], 'img/' . $filename);

        $sql = 'INSERT INTO lots (date_create, name, description, picture_link, start_price, date_close, step_bet, id_user, id_category)
        VALUES (NOW(), ?, ?, ?, ?, ?, ?, 1, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, [$jpg['name'], $jpg['description'], $jpg['path'], $jpg['start_price'], $jpg['date_close'], $jpg['step_bet'], $jpg['category']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $jpg_id = mysqli_insert_id($link);

            header("Location: add.php?id=" . $jpg_id);
        }
        else {
            $content_main = include_template ('error.php', ['categories_select' => $categories_select, 'lot_select' => $lot_select]);
        }
    }

$content_main = include_template ('add.php', ['categories_select' => $categories_select, 'lot_select' => $lot_select]);

$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories_select' => $categories_select, 'content_main' => $content_main]);

print ($layout);

?>
