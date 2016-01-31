<?php

require_once "class.db.php" ;
// Объявил класс и занес его в переменную db
$db = new Db ;

$query = "CREATE TABLE link (

    id INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
    redirect CHAR (100) NOT NULL,
    short CHAR (100) UNIQUE  NOT NULL,
    time_life CHAR(100) DEFAULT NULL,
    autogenerate_flag INT (10) DEFAULT NULL ,
    PRIMARY KEY (id)
);";


$db ->Sql($query) ;// вызываем метод отправки запроса к бд и передаем ему запрос




