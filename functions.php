<?php

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
};

function show_date_close($date) {
    $date_now = strtotime("now");
    $date_next = strtotime($date);
    return floor(($date_next - $date_now) / 3600) . ':' . floor(($date_next - $date_now) % 3600 / 60);
};

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};
?>
