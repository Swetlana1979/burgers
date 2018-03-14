<?php



    function getConnection()
    {
        $dsn = 'mysql:dbname=burgers;host=127.0.0.1';
        $db = new PDO($dsn,'root','');
        return $db;
    }


function Select($query){

    $db = getConnection();
    //$qry = "SELECT * FROM users";
    $stmt = $db->prepare($query);
    $stmt -> execute(['email'=> $email]);
    $data = $stmt->fetch();
var_dump($data);
return $data;
}


