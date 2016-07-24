<?php

session_start();
require_once __DIR__."/User.php";

$db_host = "localhost";
$db_user = "root";
$db_password = "root";
$db_name = "Shop";

$conn = new mysqli($db_host,$db_user,$db_password,$db_name);
if($conn->connect_error != 0){
    die("Błąd połączenia bazy danych {$conn->error}");
}

?>