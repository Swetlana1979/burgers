<?php
$user = ['0' => ['name' => 'Светлана','email' => 'uzer1874@rambler.ru', 'phone' => '89508104196'],'1' => ['name' => 'Елена','email' => 'semlena1812@yandex.ru', 'phone'=>'89225285141']];//Slect_all('users');
$order =['0' =>['id_user' => '0','adress'=>'прлллллллллллллл', 'comment' => 'комент хороший', 'payment' => 'card', 'callback' => 'да']]; //Slect_all('orders');
$orders=[];
foreach ($order as $key => $value){
    $value = [$user[$key]['name'],$value['adress'],$value['comment'], $value['payment']];
    $orders[] = $value;
}


function print_all($array,$array2){

    echo '<table style = "border:1;border-color:blueviolet; color:blue">';
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
$array = ['имя','емайл','телефон'];
echo 'Список зарегистрированных пользователей';
print_all($user,$array);
echo '</div>';
$array = ['имя','aдресс','комментарий','оплата'];

echo 'Список заказов';
print_all($orders,$array);