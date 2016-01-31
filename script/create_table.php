<?php

include "../config.php";

$query = "CREATE TABLE link (

    id INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
    redirect CHAR (100) NOT NULL,
    short CHAR (100) UNIQUE  NOT NULL,
    time_life CHAR(100) DEFAULT NULL,
    autogenerate_flag INT (10) DEFAULT NULL ,
    PRIMARY KEY (id)
);";


try
{

    $DBH = new PDO("mysql:host=".HOST.";dbname=".NAME, USER, PASS); // подключение к БД
    $STH = $DBH->prepare($query);
    $STH->execute();
    echo "таблица создана";
    header('Refresh:1; URL=http://localhost/miniurl2/');

}
catch(PDOException $e)
{
    echo 'ERROR: ' . $e->getMessage();
}






