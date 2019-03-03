<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();

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

        // $finfo = finfo_open(FILEINFO_MIME_TYPE); $file_type = finfo_file($finfo, $tmp_name);

        $file_type = mime_content_type($tmp_name);

        if ($file_type !== "image/jpg" && $file_type !== "image/jpeg" && $file_type !== "image/png") {
            $errors['file-upload'] = 'Загрузите картинку в формате JPG / JPEG / PNG';
        }
        else {
            $filename = uniqid() . '.jpg';
            $reg['path'] = 'img/' .$filename;

            move_uploaded_file($tmp_name, 'img/' . $filename);
        }
    }
    // если пользователь не загрузил файл то это неошибка else {$errors['file-upload'] = 'Вы не загрузили файл'; }

    if (empty($errors)) {

        $email = mysqli_real_escape_string($link, $reg['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        // $email_verif = $reg['email'];

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail адрес указан неверно - нет знака собаки';
        }
    }

        if (count($errors) != 0) { // считает количество элементов в массиве
            $content_main = include_template('sign-up.php', ['categories_select' => show_categories_select(), 'reg' => $reg, 'errors' => $errors, 'dict' => $dict]);
        }
        else {
            $password = password_hash($reg['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (email, name, password, contact, avatar) VALUES (?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($link, $sql, [$reg['email'], $reg['name'], $password, $reg['message'], $reg['path'] ?? ""]);
            $res = mysqli_stmt_execute($stmt);

            if ($res && empty($errors)) {
                header("Location: /login.php");
                exit();
            }
        }
}

else {
	$content_main = include_template('sign-up.php', ['categories_select' => show_categories_select()]);
}

$layout = include_template ('layout.php', ['title' => $title['sign-up'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
