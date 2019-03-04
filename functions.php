<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

function return_name_title() {
    $title = ['index' => 'Главная', 'add' => 'Добавление', 'lot' => 'Лот', 'sign-up' => 'Регистрация', 'login' => 'Вход',];
    return $title;
}

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);
        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

function connect_to_db() {
    $link = mysqli_connect('localhost', 'root', '', '184136_yeticave');
    mysqli_set_charset($link, "utf8");

    return $link;
}

function show_categories_select() {
    $link = connect_to_db();

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
    return $categories_select;
};

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

function show_date_close($date) {
    $date_now = strtotime("now");
    $date_next = strtotime($date);
    return floor(($date_next - $date_now) / 3600) . ':' . floor(($date_next - $date_now) % 3600 / 60);
};

function show_date_end_bet($time) {
    $lot_time_sec = strtotime($time);
    $secs_passed = strtotime('now') - $lot_time_sec;
    $days = floor($secs_passed / 86400);

    if ($days == 0) {
        $hours = floor($secs_passed / 3600);
        if ($hours > 0) {
            $result = $hours . ' часов назад';
            if (((($hours % 10) == 1 ) && ($hours != 11 )) || ($hours == 21)) {
                $result = $hours . ' час назад';
            } else if ((($hours > 1 ) && ($hours < 5)) || (( $hours >= 22) && ( $hours <=23 ))) {
                $result = $hours . ' часа назад';
            } else if (($hours >= 5) && ($hours < 21)) {
                $result = $hours . ' часов назад';
            }
        }
        $minutes = floor(($secs_passed % 3600)/60);
        if ((($minutes % 10) == 1) && ($minutes != 11)) {
            $result = $minutes . ' минуту назад';
        }
        $result = $minutes . ' минут(ы) назад';
    }
    else {
        $result = date_format(date_create($time), "d.m.y в H:i");
    }
    return $result;
}

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
