<?php
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

$content_main = include_template ('index.php', ['categories' => $categories, 'lots'=>$lots]);
$layout = include_template ('layout.php', ['title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories, 'content_main' => $content_main]);

print ($layout);

?>
