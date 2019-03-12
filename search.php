<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();


	$form_search = $_GET['search'] ?? '';

    $lots_select = [];

	if ($form_search) {
        $lots_sql = "SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description
        FROM lots l JOIN category c ON l.id_category = c.id LEFT JOIN bets b ON l.id = b.id_lot WHERE l.date_close > NOW() AND MATCH(l.name, l.description) AGAINST(?) GROUP BY l.id ORDER BY l.date_create DESC";



		$stmt = db_get_prepare_stmt($link, $lots_sql, [$form_search]); // подготовка запроса
		mysqli_stmt_execute($stmt); // выполнение запроса
		$lots_select = mysqli_stmt_get_result($stmt); // получение результата

        // VAR_dump($lots_select);
        // die();
	}

	$content_main = include_template('search.php', ['categories_select' => show_categories_select(), 'lots_select' => $lots_select, 'form_search' => $form_search]);



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




$layout = include_template ('layout.php', ['title' => $title['search'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
