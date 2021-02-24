<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("06.06 - Camada de manipulação pt1");

require __DIR__ . "/../source/autoload.php";

/*
 * [ string helpers ] Funções para sintetizar rotinas com strings
 */
fullStackPHPClassSession("string", __LINE__);

$string = "Essa é uma stringm nela temos um under_score e um guarda-chuva! <script></script>";

$message = new Source\Core\Message();

echo $message->info(str_slug($string));
echo $message->info(str_study_case($string));
echo $message->info(str_camel_case($string));