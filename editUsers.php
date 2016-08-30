<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedAdminId'])) {
    $adminId = $_SESSION['loggedAdminId'];

    $loggedAdmin = new Admin();
    $loggedAdmin->loadFromDB($conn, $adminId);

} else {
    header("Location:panel.php");
}


if (isset($_GET['idToDelete'])) {
    $userToDelete = new User();
    $userToDelete->loadFromDB($conn, $_GET['idToDelete']);
    $userToDelete->deleteFromDB($conn);
}

if (isset($_GET['id'])) {
    $userToEdit = new User();
    $userToEdit->loadFromDB($conn, $_GET['id']);

}


$allUsers = User::GetAllUsers($conn);

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

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
                    <a class="navbar-brand" href="index.php">Shop</a>
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
                    echo "<li><a href='panel.php'>" . $loggedAdmin->getEmial() . "</a></li>";
                    echo "<li><a href='logout.php'>Wyloguj</a></li>";
                }

                ?>


            </ul>
        </div>

</nav>

<section>
    <div class="container">
        <div class="row">
            <?php
            if(isset($_GET['id'])){

                echo "";
            }
            ?>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Id:</th>
                    <th>Imię:</th>
                    <th>Nazwisko:</th>
                    <th>Email:</th>
                    <th>Adres:</th>
                    <th>Data utworzenia:</th>
                    <th>Edycja:</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($allUsers as $user) {
                    echo "<tr>";
                    echo "<th>" . $user->getId() . "</th>";
                    echo "<th>" . $user->getName() . "</th>";
                    echo "<th>" . $user->getSurname() . "</th>";
                    echo "<th>" . $user->getEmail() . "</th>";
                    echo "<th>" . $user->getAddress() . "</th>";
                    echo "<th>" . $user->getCreationDate() . "</th>";
                    echo "<th><a href='editUsers.php?id={$user->getId()}'><button class='btn btn-info'>Edytuj</button></a>
                          <a href='editUsers.php?idToDelete={$user->getId()}'><button class='btn btn-danger'>Usuń</button></a></th>";
                    echo "</tr>";
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>


</section>

</body>
</html>

<?php

$conn->close();
$conn = null;

?>




