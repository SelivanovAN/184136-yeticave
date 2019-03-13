<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = connect_to_db();
$title = return_name_title();

	$form_search = trim($_GET['search'] ?? '');

    $lots_select = [];

	if ($form_search) {
        $lots_sql = "SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description
        FROM lots l JOIN category c ON l.id_category = c.id LEFT JOIN bets b ON l.id = b.id_lot WHERE l.date_close > NOW() AND MATCH(l.name, l.description) AGAINST(?)
        GROUP BY l.id ORDER BY l.date_create DESC";

		$stmt = db_get_prepare_stmt($link, $lots_sql, [$form_search]); // подготовка запроса
		mysqli_stmt_execute($stmt); // выполнение запроса
		$lots_select = mysqli_stmt_get_result($stmt); // получение результата

	}
    
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;

    // $result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lots");
    $items_count = mysqli_fetch_assoc($lots_select);
    // $items_count = mysqli_fetch_assoc($result)['cnt'];

    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

    $pages = range(1, $pages_count);

    // запрос на показ результата поиска с пагинацией
    $lots_pagination_sql = "SELECT l.id, l.name, l.start_price, l.picture_link, MAX(b.price_buy), MAX(c.name), l.date_create, l.date_close, l.description
        FROM lots l JOIN category c ON l.id_category = c.id LEFT JOIN bets b ON l.id = b.id_lot WHERE l.date_close > NOW() AND MATCH(l.name, l.description) AGAINST(?)
        GROUP BY l.id ORDER BY l.date_create DESC LIMIT . $page_items . ' OFFSET ' . $offset";

    if ($lots = mysqli_query($link, $lots_pagination_sql)) {
        $tpl_data = ['lots' => $lots, 'pages' => $pages, 'pages_count' => $pages_count, 'cur_page' => $cur_page];

        $content = include_template('main.php', $tpl_data);
    }
    else {
        show_error($content, mysqli_error($link));
    }

$content_main = include_template('search.php', ['categories_select' => show_categories_select(), 'lots_select' => $lots_select, 'form_search' => $form_search]);

$layout = include_template ('layout.php', ['title' => $title['search'], 'categories_select' => show_categories_select(), 'content_main' => $content_main]);

print ($layout);

?>
