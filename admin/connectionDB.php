<?php

session_start();

spl_autoload_register(function ($className){
   include '../src/'.$className.'.php';
});

$db_host = "localhost";
$db_user = "root";
$db_password = "268722qw";
$db_name = "Shop";

$conn = new mysqli($db_host,$db_user,$db_password,$db_name);
if($conn->connect_error != 0){
    die("Błąd połączenia bazy danych {$conn->error}");
}

?>