<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
session_start();

include_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");

$title = 'Вход';
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
	$form_enter = $_POST['enter'];

	$required = ['email', 'password'];
    $dict = ['email' => 'Эл. почта', 'password' => 'Пароль'];
	$errors = [];

	foreach ($required as $field) {
	    if (empty($form_enter[$field])) {
	        $errors[$field] = 'Это поле надо заполнить';
        }
    }

    /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail адрес указан неверно - нет знака собаки';
    } else {*/
        $email = mysqli_real_escape_string($link, $form_enter['email']);
    	$sql = "SELECT * FROM users WHERE email = '$email'";
    	$res = mysqli_query($link, $sql);

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!count($errors) and $user) {
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

// }
    if (count($errors)) {
		$content_main = include_template('login.php', ['categories_select' => $categories_select, 'form_enter' => $form_enter, 'errors' => $errors]);
	}
	else {
		header("Location: /index.php");
		exit();
	}
}
else {
    if (isset($_SESSION['user'])) {
        $content_main = include_template('index.php', ['categories_select' => $categories_select, 'username' => $_SESSION['user']['name']]);
    }
    else {
        $content_main = include_template('login.php', ['categories_select' => $categories_select, 'form_enter' => $form_enter, 'errors' => $errors]);
    }
}

$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories_select' => $categories_select, 'content_main' => $content_main]);

print ($layout);

?>
