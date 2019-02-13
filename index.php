<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
$title = 'Главная';

include_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Александр'; // укажите здесь ваше имя

$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

$lots = [
    [
        'name_lot' => '2014 Rossignol District Snowboard',
        'categorie' => 'Доски и лыжи',
        'price' => 10999,
        'url_img' => 'img/lot-1.jpg'
    ],
    [
        'name_lot' => 'DC Ply Mens 2016/2017 Snowboard',
        'categorie' => 'Доски и лыжи',
        'price' => 159999,
        'url_img' => 'img/lot-2.jpg'
    ],
    [
        'name_lot' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'categorie' => 'Крепления',
        'price' => 8000,
        'url_img' => 'img/lot-3.jpg'
    ],
    [
        'name_lot' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'categorie' => 'Ботинки',
        'price' => 10999,
        'url_img' => 'img/lot-4.jpg'
    ],
    [
        'name_lot' => 'Куртка для сноуборда DC Mutiny Charocal',
        'categorie' => 'Одежда',
        'price' => 7500,
        'url_img' => 'img/lot-5.jpg'
    ],
    [
        'name_lot' => 'Маска Oakley Canopy',
        'categorie' => 'Разное',
        'price' => 5400,
        'url_img' => 'img/lot-6.jpg'
    ]
];

$db = require_once 'openserver/phpmyadmin/db_structure.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");

$categories_select = [];
$content = '';

if($link) {
    $sql = 'SELECT * FROM category ORDER BY name ASC';
    $result_select = mysqli_query($link, $sql);

    if ($result_select) {
        $categories_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);
    } else {
        return print ('error');
    }
} else {
    return print ('error');
}

function space_price($price) {
    $around_price = ceil($price);
    if ($around_price > 1000) {
        $make_space = number_format ($around_price, 0, 0, " ");
        return $make_space ." ₽";
    }
    return $around_price ." ₽";
};

function check_hakers($typing) {
    $haker = strip_tags($typing);
    return $haker;
};

function show_date() {
    $date_now = date_create("now");
    $date_next = date_create("tomorrow");
    $date_diff = date_diff($date_next, $date_now);
    $date_count = date_interval_format($date_diff, "%h:%i");
    return $date_count;
}

$content_main = include_template ('index.php', ['categories_select' => $categories_select, 'lots'=>$lots]);
$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories, 'content_main' => $content_main]);

print ($layout);

?>
