<?php

require_once 'vendor/autoload.php';

include "script/test5.php";

Twig_Autoloader::register();

$loder = new Twig_Loader_Filesystem('template');
$twig =  new Twig_Environment($loder);

$template = $twig->loadTemplate('index.php');
echo $template->render(array('auto_reload' => true,'customshortlink' => $shortlink));


