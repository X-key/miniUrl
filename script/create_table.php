<?php

const HOST = "localhost"; // Хост БД
const USER = "root"; // Пользователь БД
const PASS = "142128"; // Пароль БД
const NAME = "links"; // Имя БД


$DBH = new PDO("mysql:host=".HOST.";dbname=".NAME, USER, PASS); // подключение к БД

// Объявил класс и занес его в переменную db

$query = "CREATE TABLE link (

    id INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
    redirect CHAR (100) NOT NULL,
    short CHAR (100) UNIQUE  NOT NULL,
    time_life CHAR(100) DEFAULT NULL,
    autogenerate_flag INT (10) DEFAULT NULL ,
    PRIMARY KEY (id)
);";

$STH = $DBH->prepare($query);
$STH->execute();




