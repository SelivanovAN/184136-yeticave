<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jpg = $_POST['jpg'];

    $required = ['name', 'category', 'description', 'start_price', 'step_bet', 'date_close'];
    $dict = ['name' => 'Название', 'category' => 'Категория', 'description' => 'Описание', 'start_price' => 'Начальная цена', 'step_bet' => 'Шаг ставки', 'date_close' => 'Дата окончания'];
    $errors = [];

    foreach ($required as $key) {
        if (empty($jpg[$key])) { // проверяет значение в ключе и наличие ключа
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    if (isset($jpg['date_close'])) { //проверяет наличие ключа
        $date_close = strtotime($jpg['date_close']);
        $date_diff = $date_close - time();

        if ($date_diff < (60*60*24)) {
            $errors['date_close'] = 'Дата должна быть больше текущей как минимум на одни сутки';
        }
    }

    if (isset($_FILES['file-upload']['name']) && $_FILES['file-upload']['name']) {
		$tmp_name = $_FILES['file-upload']['tmp_name'];

        $file_type = mime_content_type($tmp_name);

        if ($file_type !== "image/jpg" && $file_type !== "image/jpeg" && $file_type !== "image/png") {
            $errors['file-upload'] = 'Загрузите картинку в формате JPG / JPEG / PNG';
        }
        else {
            $filename = uniqid() . '.jpg';
            $jpg['path'] = 'img/' .$filename;

            move_uploaded_file($tmp_name, 'img/' . $filename);
        }
    } // если пользователь не загрузил файл то это неошибка else {$errors['file-upload'] = 'Вы не загрузили файл'; }

    if (count($errors) != 0) { // считает количество элементов в массиве
        $content_main = include_template('add.php', ['categories_select' => show_categories_select(), 'jpg' => $jpg, 'errors' => $errors, 'dict' => $dict]);
    }
    else {
        $sql = 'INSERT INTO lots (date_create, name, description, picture_link, start_price, date_close, step_bet, id_user, id_category)
        VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, [$jpg['name'], $jpg['description'], $jpg['path'], $jpg['start_price'], $jpg['date_close'], $jpg['step_bet'], $_SESSION['user']['id'], $jpg['category']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $jpg_id = mysqli_insert_id($link);

            header("Location: lot.php?value_id=" . $jpg_id);
            die();
        }
        else {
            $content_main = include_template ('error.php', ['categories_select' => show_categories_select()]);
        }

        $content_main = include_template('add.php', ['categories_select' => show_categories_select(), 'jpg' => $jpg]);
    }

}
else {
	$content_main = include_template('add.php', ['categories_select' => show_categories_select()]);
}

$layout = include_template ('layout.php', ['title' => $title['add'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
