<?php

/*function startup()
{
    // Языковая настройка.
    setlocale(LC_ALL, 'ru_RU.UTF8');	*/

    // Настройки подключения к БД.
    $params = ['host' => '127.0.0.1','dbname' => 'burgers', 'user' => 'root', 'password' => ''];

$dsn = 'mysql:dbname=burgers;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}
	

	// Открытие сессии.
	//session_start();
	
	/*mb_internal_encoding("UTF-8");*/
		
//}
