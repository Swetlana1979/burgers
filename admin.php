<?php
require_once('mysql.php');

$query = "SELECT * FROM `orders` WHERE 1";
$par =" ";
$query1 = "SELECT * FROM `users` WHERE 1";

$order = Select($query,$par);
$order = $order[0];
//var_dump($order);
$user = Select($query1,$par);
$user = $user[0];
//var_dump($user);
if($order !== NULL){
    foreach ($order as $key => $value){
        if($value['id_user'] === $user[$key]['id']){
            $order[$key]['id_user'] = $user[$key]['name'];
        }
    }
}
function print_all($array,$array2){

    echo '<table style = "border:1;border-color:blueviolet; color:blue">';
    foreach ($array as $key => $value){
        $l=count($value)/2;

        for ($i=0;$i<$l;$i++){
            unset($array[$key][$i]);
        }
    }
    $array1 = array_keys($array[0]);
    $arr = array_combine($array1,$array2);
    echo '<tr>';
    foreach ($arr as $value){
        echo '<td>'.$value.'</td>';
    }
    echo '</tr>';
    //print_r($array1);
    foreach ($array as $key => $value){
        echo '<tr>';
            foreach($value as $key => $value){
                echo '<td>'.$value.'</td>';
            }
            echo '</tr>';
    }
    echo '<table>';

}

echo '<div style="text-align: center;">'.'<br>';
$array = ['№','имя','емайл','телефон'];
echo 'Список зарегистрированных пользователей';
if($user!== NULL){
    print_all($user,$array);
} else {
    echo "Нет зарегистрированных пользователей";
}
echo '</div>';
$array = ['номер заказа','пользователь','aдресс','комментарий','оплата','перезвонить'];

echo 'Список заказов';
if($order!== NULL){
    print_all($order,$array);
} else {
    echo "Нет заказов";
}
