<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
<?php
include_once('mysql.php');

function input_correct($array, $array1)
{
    foreach ($array as $value) {
        if (empty($array1[$value])) {
            return false;
        }
    }
    return true;
}

function login($email)
{
    $query = "SELECT `id` FROM `users` WHERE `email`='$email'";
    $par = ['email', $email];
    $array = Select($query, $par);

    if (!$array) {
        /*$query = "SELECT COUNT(`id`) FROM `users` WHERE 1";
        $par = [];
        $id = Select($query, $par);

        $id = $id[0]["COUNT(`id`)"];
        $id = $id + 1;*/
        $id = false;
        $bool = false;
    } else {
        $array = $array[0];
        $id = $array['id'];

        $bool = true;
    }
    return $id_arr = ['id' => $id, 'bool' => $bool];
}

function data($array, $id, $bool)
{
    if ($array['submit'] === 'Заказать') {
        $user = ($bool) ? [] : ['email' => $array['email'], 'name' => $array['name'], 'phone' => $array['phone']];
        $adress = ['street' => 'ул ' . $array['street'], 'home' => 'д ' . $array['home'], 'part' => $part = (!empty($array['part'])) ? 'кор. ' . $array['part'] : " ",
            'appt' => 'кв. ' . $array['appt'], 'floor' => 'эт. ' . $array['floor']];
        $adress = implode(' ', $adress);
        if (($array['callback']) === 'on') {
            $callback = true;
        } else {
            $callback = false;
        }
        $payment = $array['payment'];
        $order = ['id_user' => $id, 'adress' => $adress, 'comment' => $_REQUEST['comment'], 'payment' => $payment, 'callback' => $callback];
    }
    $arr = [$order, $user, $adress];
    return $arr;
}

function letter_to_send($email, $adress, $num, $name)
{
    $text = ($num > 1) ? 'Спасибо, это ваш ' . $num . '-й заказ' : 'Спасибо, это ваш первый заказ';
    $message = 'Здравствуйте,' . $name . '. Ваш заказ будет доставлен по адресу: ' . $adress . ' DarkBeefBurger за 500 рублей, 1 шт ' . $text;
    $message = wordwrap($message, 150, "\r\n");
    $header = 'Заказ №' . $num;
    $file = 'email/mail.txt';
    $date = date('Y-m-d h:i:s');
    $time = date('h:i', strtotime($date));
    $data = [$email, $header, $message, $time];
    $data = implode($data, "\r\n");
    file_put_contents($file, $data);
    return true;
}

function hello($bool, $name)
{
    if ($bool) {
        echo 'Рады снова видеть вас,' . $name . ', ';
    } else {
        echo 'Приветсвуем вас,' . $name . ', ';
    }
}

function num_order($id, $bool)
{
    if ($bool) {
        $query = "SELECT COUNT(`id_user`) FROM `orders` WHERE `id_user`= $id";
        $par = ['id', $id];
        $num = Select($query, $par);
		$num = $num[0]["COUNT(`id_user`)"];
    } else {
        $num = 0;
    }
	echo $num;
    return $num = $num + 1;
}

function start($res, $email, $adress, $name)
{
    if ($res) {
        $id_arr = login($email);
        $bool = $id_arr['bool'];
        $id = $id_arr['id'];
        hello($bool, $name);
        $num = num_order($id, $bool);
        $arr = data($_REQUEST, $id, $bool);

        $adress = $arr[2];
        if (!empty($arr[1])) {
            $arr1 = $arr[1];
            foreach ($arr1 as $value) {
                $array1[] = $value;

            }
            $email = $array1[0];
            $name = $array1[1];
            $phone = $array1[2];
            $sql1 = "INSERT INTO `users`(`email`, `name`, `phone`) VALUES ('$email','$name','$phone')";
            Insert($sql1);
        }

        if (!empty($arr[0])) {
            $array = $arr[0];
            foreach ($array as $value) {
                $array[] = $value;

            }
            if ($array[0]) {
                $id_user = $array[0];
            } else {
                $id_user = Select("SELECT `id` FROM `users` WHERE `email`='$email'", [['email', $email]]);
                $id_user = $id_user[0]['id'];
            }

            $adress = $array[1];
            $comment = $array[2];
            $payment = $array[3];
            $collback = $array[4];
            $sql = "INSERT INTO `orders`( `id_user`, `adress`, `comment`, `payment`, `collback`) VALUES ($id_user,'$adress','$comment','$payment','$collback')";

            Insert($sql);

        }


        $mail = letter_to_send($email, $adress, $num, $name);


        echo "ваш заказ получен";
        echo "<br><a href='index.php'>Назад</a>";

    } else {
        echo 'Вы не заполнили обязательные поля';
        echo "<br><a href='index.php'>Назад</a>";
    }
}

$input_array = ['email', 'name', 'phone', 'street', 'home', 'payment'];
$res = input_correct($input_array, $_REQUEST);
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$array = $_REQUEST;


//$start_array = [$email,$adress,$name,$num];
start($res, $email, $adress, $name, $num);

?>
</body>
</html>