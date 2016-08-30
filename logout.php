<?php

session_start();

if(isset($_SESSION['loggedAdminId'])){
    unset($_SESSION['loggedAdminId']);
    header("Location:panel.php");
}else{
    unset($_SESSION['loggedUserId']);
    header("Location:index.php");
}

