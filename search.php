<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();

/*
$lots_select = [];

if($link) {
    $lots_sql = 'SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description
    FROM lots l JOIN category c ON l.id_category = c.id LEFT JOIN bets b ON l.id = b.id_lot WHERE l.date_close > NOW() GROUP BY l.id ORDER BY l.date_create DESC';

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
*/

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$form_search = $_GET['search'] ?? [];
/*
	$required = ['cost'];
    $dict = ['cost' => 'Ставка'];
	$errors = [];

	foreach ($required as $field) {
	    if (empty($form_add_bet[$field])) {
	        $errors[$field] = 'Это поле надо заполнить';
        }
    }*/

    $lots = [];

	//$search = $_GET['q'] ?? '';

	if ($form_search) {
        $lots_sql = "SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description
        FROM lots l JOIN category c ON l.id_category = c.id LEFT JOIN bets b ON l.id = b.id_lot WHERE l.date_close > NOW() GROUP BY l.id ORDER BY l.date_create DESC" . "WHERE MATCH(title, description) AGAINST(?)";

		/*$sql = "SELECT gifs.id, title, path, like_count, users.name FROM gifs "
		  . "JOIN users ON gifs.user_id = users.id "
		  . "WHERE MATCH(title, description) AGAINST(?)";*/

		$stmt = db_get_prepare_stmt($link, $lots_sql, [$form_search]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}

	$content_main = include_template('search.php', ['lots' => $lots, 'categories_select' => show_categories_select(), 'lots_select' => $lots_select]);

/*
    if (!empty($lot_select['MAX(b.price_buy)'])) {
        $current_bet = $lot_select['MAX(b.price_buy)'] + $lot_select['step_bet'];
    }
    else {
        $current_bet = $lot_select['start_price'] + $lot_select['step_bet'];
    }

    if (!count($errors) && $form_add_bet['cost'] < $current_bet) {
         $errors['cost'] = 'ставка не должа быть меньше текущей цены';
    }*/

    /*if (count($errors) == 0) {
        $bet_add = 'INSERT INTO bets (price_buy, id_user, id_lot) VALUES (?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $bet_add, [$form_add_bet['cost'], $_SESSION['user']['id'], $lot_id]);
        $res = mysqli_stmt_execute($stmt);

        if ($res && empty($errors)) {
            header("Location: /lot.php?value_id=$lot_id");
            exit();
        }
    }*/
}

// $content_main = include_template ('search.php', ['categories_select' => show_categories_select(), 'lots_select' => $lots_select]);

$layout = include_template ('layout.php', ['title' => $title['search'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
