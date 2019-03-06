<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$form_enter = $_POST['enter'] ?? [];

	$required = ['email', 'password'];
    $dict = ['email' => 'Эл. почта', 'password' => 'Пароль'];
	$errors = [];

	foreach ($required as $field) {
	    if (empty($form_enter[$field])) {
	        $errors[$field] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($link, $form_enter['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail адрес указан неверно - нет знака собаки';
    } else if (!count($errors) and $user) {
    		if (password_verify($form_enter['password'], $user['password'])) {
    			$_SESSION['user'] = $user;
    		}
    		else {
    			$errors['password'] = 'Вы ввели неверный пароль';
    		}
    	}
    	else {
    		$errors['email'] = 'Такой пользователь не найден';
    	}

    if (count($errors)) {
		$content_main = include_template('login.php', ['categories_select' => show_categories_select(), 'form_enter' => $form_enter, 'errors' => $errors]);
	}
	else {
		header("Location: /index.php");
		exit();
	}
}
else {
    if (isset($_SESSION['user'])) {
        $content_main = include_template('index.php', ['categories_select' => show_categories_select(), 'username' => $_SESSION['user']['name']]);
    }
    else {
        $content_main = include_template('login.php', ['categories_select' => show_categories_select()]);
    }
}

$layout = include_template ('layout.php', ['title' => $title['login'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
