<?php

require_once 'connectionDB.php';


if (isset($_SESSION['loggedAdminId'])) {
    $adminId = $_SESSION['loggedAdminId'];

    $loggedAdmin = new Admin();
    $loggedAdmin->loadFromDB($conn, $adminId);

}

if (!empty($_POST)) {

    var_dump($_POST);
    $emailAdmin = $_POST['email'];
    $passAdmin = $_POST['password1'];

    if (strlen($_POST['email']) > 2) {
        $loggedAdmin = Admin::LogIn($conn, $emailAdmin, $passAdmin);

        if ($loggedAdmin != null) {
            $_SESSION['loggedAdminId'] = $loggedAdmin->getId();
            header("Location:panel.php");
        } else {
            echo "Nie udało się zalogować";
        }

    } else {
        echo "Wypełnij poprawnie formularz";
    }

}



?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="nav navbar-nav">
                <li class="active">
                    <a class="navbar-brand" href="/Shop/index.php">Shop</a>
                </li>
            </ul>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="editGroups.php">Grupy</a></li>
                <li><a href="editItems.php">Przedmioty</a></li>
                <li><a href="editUsers.php">Użytkownicy</a></li>
                <li><a href="editOrders.php">Zamówienia</a></li>
            </ul>
            <ul class="navbar-right navbar-nav nav">

                    <?php
                    if (isset($_SESSION['loggedAdminId'])) {
                        echo "<li><a href='panel.php'>".$loggedAdmin->getEmial()."</a></li>";
                        echo "<li><a href='../logout.php'>Wyloguj</a></li>";
                    }
                                       
                    ?>

                
            </ul>
        </div>

</nav>


<?php
if (!isset($_SESSION['loggedAdminId'])){


    echo "
<section>
    <div class=\"container\">
        <form class=\"form-horizontal\" action=\"#\" method=\"post\">

            <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">Email</label>
                <div class=\"col-sm-10\">
                    <input class=\"form-control\" type=\"email\" name=\"email\" pattern=\"^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-
                            ]+(\.[a-zA-Z0-9-]{1,})*\.([a-zA-Z]{2,}){1}$\" placeholder=\"Podaj email\"><br>
                </div>
            </div>

            <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">Hasło</label>
                <div class=\"col-sm-10\">
                    <input class=\"form-control\" type=\"password\" name=\"password1\" placeholder=\"Podaj hasło\"><br>
                </div>
            </div>
            <div class=\"form-group\">
                <div class=\"col-sm-offset-2 col-sm-10\">
                    <button type=\"submit\" class=\"btn btn-default\">Zaloguj</button>
                </div>
            </div>

        </form>
    </div>

</section>";
}else{
    echo "<div class=\"container\">
                <div class=\"jumbotron\">
                    <h1>Witaj, {$loggedAdmin->getEmial()} </h1>
                    <p>tutaj możesz zarządzać swoim sklepem :)</p>
                   
                </div>
           </div>";
}
?>

</body>
</html>

<?php

$conn->close();
$conn = null;

?>
