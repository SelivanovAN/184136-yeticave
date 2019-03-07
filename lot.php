<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();

if($link) {

    if (!isset($_GET['value_id'])) { //проверяет наличие ключа
            $lot_id = 0;
        } else {
            $lot_id = (int)$_GET['value_id'];
        }

    $lot_sql = 'SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.description, l.step_bet, l.date_close, l.id_user
    FROM lots l JOIN category c ON l.id_category = c.id LEFT JOIN bets b ON l.id = b.id WHERE l.id = '.$lot_id.' GROUP BY l.id';
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

$bets_select = [];

if($link) {

    $bets_sql = "SELECT b.date_place, b.price_buy, u.name, b.id_user FROM bets b JOIN users u ON b.id_user = u.id WHERE b.id_lot = $lot_id ORDER BY b.date_place DESC";
    $result_bets = mysqli_query($link, $bets_sql);

    if ($result_select) {
        $bets_select = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);
    } else {
        print ('Произошла ошибка при выполнении запроса! Обратитесь к администратору, либо попробуйте снова.');
        die();
    }
} else {
    print ('Произошла ошибка подключения, недоступна база данных! Обратитесь к администратору, либо попробуйте снова.');
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
	$form_add_bet = $_POST['add_bet'] ?? [];

	$required = ['cost'];
    $dict = ['cost' => 'Ставка'];
	$errors = [];

	foreach ($required as $field) {
	    if (empty($form_add_bet[$field])) {
	        $errors[$field] = 'Это поле надо заполнить';
        }
    }

    if (!empty($lot_select['MAX(b.price_buy)'])) {
        $current_bet = $lot_select['MAX(b.price_buy)'] + $lot_select['step_bet'];
    }
    else {
        $current_bet = $lot_select['start_price'] + $lot_select['step_bet'];
    }

    if (!count($errors) && $form_add_bet['cost'] < $current_bet) {
         $errors['cost'] = 'ставка не должа быть меньше текущей цены';
    }

    if (count($errors) == 0) {
        $bet_add = 'INSERT INTO bets (price_buy, id_user, id_lot) VALUES (?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $bet_add, [$form_add_bet['cost'], $_SESSION['user']['id'], $lot_id]);
        $res = mysqli_stmt_execute($stmt);

        if ($res && empty($errors)) {
            header("Location: /lot.php?value_id=$lot_id");
            exit();
        }
    }
}

$time_finish = strtotime($lot_select['date_close']) < time();

if (isset($_SESSION['user']['id'])) {
    $bet_user = "SELECT * FROM bets WHERE id_user = ".$_SESSION['user']['id']." AND id_lot = $lot_id";
    $result_bet_user = mysqli_query($link, $bet_user);
    $user_has_bet = count(mysqli_fetch_array($result_bet_user, MYSQLI_ASSOC) ?? []);
}
else {
    $user_has_bet = false;
}


if ($lot_select) {
    $content_main = include_template ('lot.php', ['categories_select' => show_categories_select(), 'lot_select' => $lot_select, 'errors' => $errors ?? [], 'bets_select' => $bets_select, 'time_finish' => $time_finish, 'user_has_bet' => $user_has_bet]);
} else {
    $content_main = include_template ('error.php', ['categories_select' => show_categories_select(), 'lot_select' => $lot_select]);
}

$layout = include_template ('layout.php', ['title' => $title['lot'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
