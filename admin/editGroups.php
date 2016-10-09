<?php

require_once 'connectionDB.php';


if (isset($_SESSION['loggedAdminId'])) {
    $adminId = $_SESSION['loggedAdminId'];

    $loggedAdmin = new Admin();
    $loggedAdmin->loadFromDB($conn, $adminId);

} else {
    header("Location:panel.php");
}

if(isset($_GET['id'])){
    $idGroup = $_GET['id'];
    $groupToEdit = new ItemGroup();
    $groupToEdit->loadFromDB($conn, $idGroup);

    if (isset($_GET['delete'])){
        $groupToEdit->deleteFromDB($conn);
    }

}

if(!empty($_POST)){
    if (isset($_GET['id'])){
        $groupToEdit->setName($_POST['name']);
        $groupToEdit->saveToDB($conn);
    }else{
        $newGroup = new ItemGroup();
        $newGroup->setName($_POST['name']);
        $newGroup->saveToDB($conn);
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
            if (isset($_GET['id'])){
                echo "<form class='form-horizontal' method='post' action='editGroups.php?{$groupToEdit->getId()}'>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">Nazwa grupy:</label>
                            <div class=\"col-sm-10\">
                              <input class='form-control' type='text' name='name' value='{$groupToEdit->getName()}'>
                            </div>
                      </div>";
                echo "<div class=\"col-sm-offset-2 col-sm-10\"><button type=\"submit\" class=\"btn btn-default\">Zapisz zmiany</button></div><br>";
            }else{
                echo "<form class='form-horizontal' method='post' action='editGroups.php'>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">Nazwa grupy:</label>
                            <div class=\"col-sm-10\">
                              <input class='form-control' type='text' name='name' placeholder='Podaj nazwę grupy'>
                            </div>
                      </div>";
                echo "<div class=\"col-sm-offset-2 col-sm-10\"><button type=\"submit\" class=\"btn btn-default\">Dodaj grupę</button></div>";
            }
            ?>
        </div>
    </div>
</section>
<br>
<br>
<section>
    <div class="container">
        <div class="row">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Id:</th>
                    <th>Nazwa:</th>
                    <th>Edycja:</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $allGroups = ItemGroup::GetAllGroups($conn);
                foreach ($allGroups as $group) {
                    echo "<tr>";
                    echo "<th>" . $group->getId() . "</th>";
                    echo "<th>" . $group->getName() . "</th>";
                    echo "<th><a href='editGroups.php?id={$group->getId()}'>Edytuj</a>
                              <a href='editGroups.php?id={$group->getId()}&delete=1'>Usuń</a></th>";
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
