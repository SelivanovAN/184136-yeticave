<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");

$title = 'Регистрация';
$is_auth = rand(0, 1);
$user_name = 'Александр';

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
    $reg = $_POST['signup'];

    $req_fields = ['email', 'password', 'name', 'message'];
    $dict = ['email' => 'Эл. почта', 'password' => 'Пароль', 'name' => 'Имя', 'message' => 'Контактные данные'];
    $errors = [];

    foreach ($req_fields as $field) {
        if (empty($reg[$field])) { // проверяет значение в ключе и наличие ключа
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    if (isset($_FILES['file-upload']['name']) && $_FILES['file-upload']['name']) {
		$tmp_name = $_FILES['file-upload']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
    	$file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "image/jpg" && $file_type !== "image/jpeg" && $file_type !== "image/png") {
            $errors['file-upload'] = 'Загрузите картинку в формате JPG / JPEG / PNG';
        }
        else {
            $filename = uniqid() . '.jpg';
            $reg['path'] = 'img/' .$filename;

            move_uploaded_file($tmp_name, 'img/' . $filename);
        }
    }
    else {
        $errors['file-upload'] = 'Вы не загрузили файл';
    }

    if (empty($errors)) {

        $email = mysqli_real_escape_string($link, $reg['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
            //$content_main = include_template('sign-up.php', ['categories_select' => $categories_select, 'reg' => $reg, 'errors' => $errors, 'dict' => $dict]);
        }

        if (!filter_var($res, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail адрес указан неверно';
        }

    }

        if (count($errors) != 0) { // считает количество элементов в массиве
            $content_main = include_template('sign-up.php', ['categories_select' => $categories_select, 'reg' => $reg, 'errors' => $errors, 'dict' => $dict]);
        }
        else {
            $password = password_hash($reg['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (email, name, password, contact) VALUES (?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($link, $sql, [$reg['email'], $reg['name'], $password, $reg['message']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res && empty($errors)) {
                header("Location: /login.php");
                exit();
            }
        }

    // $content_main = include_template('sign-up.php', ['categories_select' => $categories_select, 'reg' => $reg]);
/*
    if (count($errors) != 0) { // считает количество элементов в массиве
        //$content_main = include_template('sign-up.php', ['categories_select' => $categories_select, 'reg' => $reg, 'errors' => $errors, 'dict' => $dict]);
    }
    else {
        $sql = 'INSERT INTO lots (email, name, password, avatar, contact) VALUES (?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, [$jpg['name'], $jpg['description'], $jpg['path'], $jpg['start_price'], $jpg['date_close'], $jpg['step_bet'], $jpg['category']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $jpg_id = mysqli_insert_id($link);

            header("Location: lot.php?value_id=" . $jpg_id);
            die();
        }
        else {
            $content_main = include_template ('error.php', ['categories_select' => $categories_select]);

        }

        $content_main = include_template('sign-up.php', ['categories_select' => $categories_select, 'jpg' => $jpg]);

    }*/

}

else {
	$content_main = include_template('sign-up.php', ['categories_select' => $categories_select, 'reg' => $reg]);

}

$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories_select' => $categories_select, 'content_main' => $content_main]);

print ($layout);

?>
