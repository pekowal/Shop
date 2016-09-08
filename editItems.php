<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedAdminId'])) {
    $adminId = $_SESSION['loggedAdminId'];

    $loggedAdmin = new Admin();
    $loggedAdmin->loadFromDB($conn, $adminId);

} else {
    header("Location:panel.php");
}

if (isset($_GET['id'])) {
    $idItem = $_GET['id'];
    $itemToEdit = new Item();
    $itemToEdit->loadFromDB($conn, $idItem);
    if (isset($_GET['idPhoto'])) {
        $idPhoto = $_GET['idPhoto'];
        $photoToDelete = new ItemPhoto();
        $photoToDelete->loadFromDB($conn, $idPhoto);
        $photoToDelete->deleteFromDB($conn);
    }

}
if (isset($_GET['idToDelete'])) {
    $deleteId = $_GET['idToDelete'];
    $itemToDelete = new Item();
    $itemToDelete->loadFromDB($conn, $deleteId);
    $itemToDelete->deleteFromDB($conn);
}

if (!empty($_POST)) {
    if ($_POST['action'] == 'saveEdit') {


        $itemToEdit->setName($_POST['name']);
        $itemToEdit->setDesc($_POST['desc']);
        $itemToEdit->setPrice($_POST['price']);
        $itemToEdit->setQuantity($_POST['count']);
        $itemToEdit->setIdGroup($_POST['idGroup']);
        $itemToEdit->saveToDB($conn);
    }

    if ($_POST['action'] == 'saveNew') {
        $newItem = new Item();
        $newItem->setName($_POST['name']);
        $newItem->setDesc($_POST['desc']);
        $newItem->setPrice($_POST['price']);
        $newItem->setQuantity($_POST['count']);
        $newItem->setIdGroup($_POST['idGroup']);
        $newItem->saveToDB($conn);

    }

}

if (!empty($_FILES['userfile']['name'])) {


    $name = $_FILES['userfile']['name'];
    $explodedName = explode('/', $_FILES['userfile']['type']);

    $md5name = md5($name);
    $md5name = $md5name . ".$explodedName[1]";

    $_FILES['userfile']['name'] = $md5name;
    $dirName = "itemPhotos";

    if (isset($_GET['id'])) {
        $secDir = $itemToEdit->getId();
    } else {
        $secDir = $newItem->getId();
    }


    $saveDir = './' . $dirName . '/' . $secDir;

    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0777, true);
    }

    $saveFile = $saveDir . '/' . basename($_FILES['userfile']['name']);

    if (!is_file($saveFile)) {
        $itemPhoto = new ItemPhoto();
        $itemPhoto->setIdItem($secDir);
        $itemPhoto->setSrc($saveFile);
        $itemPhoto->saveToDB($conn);
    }

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $saveFile)) {
        echo 'File is valid and was succesfully uploaded';
    } else {
        echo 'Possible file upload attack';
    }


}

if (isset($_GET['id'])){
    $itemPhotos = new ItemPhoto();
    $allPhotosOfItem = $itemPhotos->loadAllPhotosOfItemFromDB($conn, $itemToEdit->getId());
}

$allItems = Item::GetAllProducts($conn);
$allGroups = ItemGroup::GetAllGroups($conn);


?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
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
            if (isset($_GET['id'])) {


                echo "<form action='editItems.php?id={$itemToEdit->getId()}' method='POST' enctype='multipart/form-data'>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Grupa</label>
                    <div class=\"col-sm-10\">
                        <select name='idGroup' class=\"form-control\">";
                foreach ($allGroups as $group) {

                    if ($group->getId() == $itemToEdit->getIdGroup()) {
                        echo "<option selected value='{$group->getId()}'>{$group->getName()}</option>";
                    } else {
                        echo "<option value='{$group->getId()}'>{$group->getName()}</option>";
                    }


                }


                echo "</select><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Nazwa</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"text\" name=\"name\" value='{$itemToEdit->getName()}'><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Opis</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"text\" name=\"desc\" value='{$itemToEdit->getDesc()}'><br>
                    </div>
                </div>
                 <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Cena:</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"text\" name=\"price\" value='{$itemToEdit->getPrice()}'><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Ilość:</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"number\" name=\"count\" value='{$itemToEdit->getQuantity()}'><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Dodaj zdjęcie:</label>
                    <div class=\"col-sm-10\">
                    <input type=\"file\" name=\"userfile\" id=\"fileToUpload\">
                    </div>
                </div>
                <br>
                <br>
                <div class=\"form-group\">
                    <div class=\"col-sm-offset-2 col-sm-10\">
                    <input type='hidden' name='action' value='saveEdit'>
                        <input type=\"submit\" class=\"btn btn-default\" value='Zapisz zamiany'>
                    </div>
                </div></form>";

            } else {
                echo "<form action='editItems.php' method='POST' enctype='multipart/form-data'>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Grupa</label>
                    <div class=\"col-sm-10\">
                        <select name='idGroup' class=\"form-control\">";
                foreach ($allGroups as $group) {
                    echo "<option value='{$group->getId()}'>{$group->getName()}</option>";

                }
                echo "</select><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Nazwa</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"text\" name=\"name\" placeholder='Podaj nazwe'><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Opis</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"text\" name=\"desc\" placeholder='Podaj opis'><br>
                    </div>
                </div>
                 <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Cena:</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"text\" name=\"price\" placeholder='Podaj cenę'><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Ilość:</label>
                    <div class=\"col-sm-10\">
                        <input class=\"form-control\" type=\"number\" name=\"count\" placeholder='Podaj ilość'><br>
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Dodaj zdjęcie:</label>
                    <div class=\"col-sm-10\">
                    <input type=\"file\" name=\"userfile\" id=\"fileToUpload\">
                    </div>
                </div>
                <br>
                <br>
                
                    <div class=\"col-sm-offset-2 col-sm-10\">
                    <input type='hidden' name='action' value='saveNew'>
                        <input type=\"submit\" class=\"btn btn-default\" value='Zapisz nowy'>
                    </div>
                ";

            }
            ?>
        </div>
    </div>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <?php if (isset($_GET['id'])) {
                foreach ($allPhotosOfItem as $photo) {
                    echo "<div class='col-sm-2 text-center'>

                <img class='deleteImg' src='{$photo->getSrc()}' height='100' width='100'><br>
                <a href='editItems.php?id={$itemToEdit->getId()}&idPhoto={$photo->getId()}'>Usuń</a></div>";
                }

            }
            ?>
        </div>
    </div>

</section>
<br>

<section>
    <div class="container">
        <div class="row">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Id:</th>
                    <th>Id Grupy:</th>
                    <th>Nazwa:</th>
                    <th>Opis:</th>
                    <th>Cena:</th>
                    <th>Ilość:</th>
                    <th>Edycja:</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($allItems as $item) {
                    $group = new ItemGroup();
                    $group->loadFromDB($conn, $item->getIdGroup());
                    $groupName = $group->getName();
                    echo "<tr>";
                    echo "<th>" . $item->getId() . "</th>";
                    echo "<th>" . $groupName . "</th>";
                    echo "<th>" . $item->getName() . "</th>";
                    echo "<th>" . $item->getDesc() . "</th>";
                    echo "<th>" . $item->getPrice() . "</th>";
                    echo "<th>" . $item->getQuantity() . "</th>";
                    echo "<th><a href='editItems.php?id={$item->getId()}'>Edytuj</a>
                              <a href='editItems.php?idToDelete={$item->getId()}'>Usuń</a></th>";
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




