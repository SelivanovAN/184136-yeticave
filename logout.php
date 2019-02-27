<?php
/*
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');
include_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
mysqli_set_charset($link, "utf8");*/

session_start();
unset($_SESSION['user']);
header("Location: /index.php");
die();
?>
