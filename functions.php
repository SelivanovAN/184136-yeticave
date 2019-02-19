<?php
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
