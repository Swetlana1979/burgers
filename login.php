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

        function input_correct($array){
            foreach ($array as $value){
                if(empty($_REQUEST[$value])){
                     echo'Вы не заполнили обязательные поля';
                     echo "<br><a href='index.php'>Назад</a>";
                     return false;
                }
            }
             return true;
        }

        function login($email){
            $query = "SELECT `id` FROM `users` WHERE `email` = ".$email;
            $array = Select($query);
            var_dump($array);
            //$array = ['1' => 'uzer1874@rambler.ru', '2' => 'semlena1812@yandex.ru'];
		    foreach($array as $key => $value){
			    if($email === $value){
				    return $key;
				}
			}
			return false;
		}



        function data($array){
            if ($array['submit'] === 'Заказать') {
                $user = ['name' => $array['name'], 'email' => $array['email'], 'phone' => $array['phone']];
                 $adress = ['street' => 'ул '.$array['street'], 'home' => 'д '.$array['home'], 'part' => '-'.$array['part'],
                'appt' => '-'.$array['appt'], 'floor' => '-'.$array['floor']];
                 $adress = implode(' ', $adress);
                 if (isset($array['callback'])) {
                     $callback === true;
                 } else {
                    $callback === false;
                 }
                  $payment = $array['payment'];

                 $order = ['adress' => $adress, 'comment' => $_REQUEST['comment'], 'callback' => $callback, 'payment' => $payment];
            }
            $arr = [$order, $user,$adress];
            return $arr;
        }


         function letter_to_send($email,$adress, $num,$name){
             $text = ($num > 1) ? 'Спасибо, это ваш ' . $num . '-й заказ' : 'Спасибо, это ваш первый заказ';
             $message = 'Здравствуйте,'.$name.'. Ваш заказ будет доставлен по адресу: ' . $adress . ' DarkBeefBurger за 500 рублей, 1 шт ' . $text;
             $message = wordwrap($message, 70, "\r\n");
             $header = 'Заказ №'.$num;
             $file = 'email/mail.txt';
             $date = date('Y-m-d h:i:s');
             $time = date('h:i',strtotime($date));

             $data = [$email, $header, $message, $time];
             $data = implode($data, "\r\n");

             file_put_contents($file,$data);
             return true;
         }

         function hello($id,$name){
             if($id){
                 echo 'Рады снова видеть вас,'.$name. ', ';
             } else {
                 echo 'Приветсвуем вас,'.$name . ', ';
             }
         }

         function start($res,$email,$adress,$name,$num){
             if($res){

                 $id = login($email);

                 hello($id,$name);

                 $arr = data($array);

                 $mail = letter_to_send($email,$adress, $num,$name);

                 //if ($mail) {
                     echo "ваш заказ получен";
                     echo "<br><a href='index.php'>Назад</a>";
                 /*} else {
                     echo 'извините, возникла ошибка, попробуйте снова';
                     echo "<br><a href='index.php'>Назад</a>";
                 }*/
             }
         }
         $input_array = ['email','name','phone','street','home','payment'];
         $res = input_correct($input_array);
         $email = $_REQUEST['email'];
         $name = $_REQUEST['name'];
         $array = $_REQUEST;
         $arr = data($array);
         $adress = $arr[2];
         $num = 4;
         start($res,$email,$adress,$name,$num);




         ?>
     </body>
</html>