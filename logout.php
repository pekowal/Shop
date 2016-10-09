<?php

session_start();

if(isset($_SESSION['loggedUserId'])){
    unset($_SESSION['loggedUserId']);
    header("Location:index.php");
}else{

    unset($_SESSION['loggedAdminId']);
    header("Location:admin/panel.php");
}

