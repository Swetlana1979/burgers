<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная страница
    </title>
    <!--<link rel="stylesheet" href="./css/vendors.min.css">-->
    <link rel="stylesheet" href="../css/main.min.css">
</head>
<body>
<?php
require_once('mysql.php');

$query = "SELECT * FROM `orders` WHERE 1";
$par = " ";
$query1 = "SELECT * FROM `users` WHERE 1";

$order = Select($query, $par);
$user = Select($query1, $par);


if ($order !== NULL && $user !== NULL) {
    foreach ($user as $key => $value) {
        $array[$value['id']] = $value['name'];
    }

    foreach ($order as $key => $value) {

        $id = $value['id_user'];
        $id1 = $id - 1;


        $order[$key]['id_user'] = $array[$id];

    }
}



function print_all($array, $array2)
{

    echo '<table style = "border:1;border-color:blueviolet; color:blue">';
    foreach ($array as $key => $value) {
        $l = count($value) / 2;

        for ($i = 0; $i < $l; $i++) {
            unset($array[$key][$i]);
        }
    }
    $array1 = array_keys($array[0]);
    $arr = array_combine($array1, $array2);
    echo '<tr>';
    foreach ($arr as $value) {
        echo '<td>' . $value . '</td>';
    }
    echo '</tr>';
    //print_r($array1);
    foreach ($array as $key => $value) {
        echo '<tr>';
        foreach ($value as $key => $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '<table>';

}

echo '<div style="text-align: center;">' . '<br>';
$array = ['№', 'емайл', 'имя', 'телефон'];
echo 'Список зарегистрированных пользователей';
if ($user !== NULL) {
    print_all($user, $array);
} else {
    echo "Нет зарегистрированных пользователей";
}
echo '</div>';
$array = ['номер заказа', 'заказчик', 'aдресс', 'комментарий'];
foreach ($order as $key => $value) {
    unset($order[$key]['payment']);
    unset($order[$key][4]);
    unset($order[$key]['collback']);
    unset($order[$key][5]);
}

echo 'Список заказов';
if ($order !== NULL) {
    print_all($order, $array);
} else {
    echo "Нет заказов";
}
?>
</body>
</html>