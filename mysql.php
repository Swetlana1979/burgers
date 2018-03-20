<?php



    function getConnection()
    {
        $dsn = 'mysql:dbname=burgers;host=127.0.0.1';
        $db = new PDO($dsn,'root','');
        return $db;
    }


function Select($query,$par){

    $db = getConnection();
    if($db) {
        //$qry = "SELECT * FROM users";
        $data = $db->prepare($query);
        $data->execute(/*[$par]*/);

        while ($row = $data->fetchAll()) {
            $arr[] = $row;
        }
        return $arr;
    }else{
        echo 'Соединение не установлено';
    }

}

function Insert ($table, $array)
{

    $db = getConnection();
    if ($db) {
        foreach ($array as $key => $value) {
            echo $key = $value;
        }
        /*$query = "INSERT INTO `orders`(`id`, `id_user`, `adress`, `comment`, `payment`, `collback`) VALUES ()";
        $data = $db->prepare($query);
        $data->execute($array);

        while ($row = $data->fetchAll()) {
            $arr[] = $row;
        }
        return $arr;
    }else{
        echo 'Соединение не установлено';
    }*/

    }
}
