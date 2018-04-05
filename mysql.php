<?php


function getConnection()
{
    $dsn = 'mysql:dbname=burgers;host=127.0.0.1';
    $db = new PDO($dsn, 'root', '');
    return $db;
}


function Select($query, $par)
{

    $db = getConnection();
    if ($db) {
        $data = $db->prepare($query);
        $data->execute([$par]);

        while ($row = $data->fetch()) {
            $arr[] = $row;
        }
        return $arr;
    } else {
        echo 'Соединение не установлено';
    }

}

function Insert($sql)
{
    $db = getConnection();
    if ($db) {
        try {

            $statement = $db->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Ошибка: " . $e->getMessage() . "<br>";
            echo "На линии: " . $e->getLine();
        }

    } else {
        echo 'Соединение не установлено';
    }

}

