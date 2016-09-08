<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedUserId'])) {
    $loggedUserid = $_SESSION['loggedUserId'];

    $loggedUser = new User();

    $loggedUser->loadFromDB($conn, $loggedUserid);

}

if (isset($_GET['gid'])) {
    $allItemsOfGroup = Item::GetAllProductsOfGroup($conn, $_GET['gid']);

    var_dump($allItemsOfGroup);
}

if (isset($_GET['id'])) {
    $itemToShow = new Item();
    $itemToShow->loadFromDB($conn, $_GET['id']);
    $itemPhotos = new ItemPhoto();
    $itemPhotos = $itemPhotos->loadAllPhotosOfItemFromDB($conn, $_GET['id']);

}

if (!empty($_POST)) {
    $_SESSION['cart'][] = array('id' => $itemToShow->getId(),
        'quantity' => $_POST['quantity']);
    var_dump($_SESSION);

   // unset($_SESSION['cart']);
}

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">


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

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class=""><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Kategorie <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        $groups = ItemGroup::GetAllGroups($conn);
                        for ($i = 0; $i < count($groups); $i++) {
                            echo "<li><a href='group.php?id=" . $groups[$i]->getId() . "'>" . $groups[$i]->getName() . "</a></li>";
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><?php if (isset($_SESSION['loggedUserId'])) {
                        echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\"
                       aria-expanded=\"false\">{$loggedUser->getEmail()}<span class=\"caret\"></span></a>";
                        echo "<ul class=\"dropdown-menu\">";
                        echo "<li><a href='editUser.php'>Edytuj profil</a></li>";
                        echo "<li><a href='order.php'>Zamówienia</a></li>";
                        echo "<li><a href='logout.php'>Wyloguj</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href=\"login.php\">Logowanie</a>";
                    }
                    ?>
                </li>
                <?php if (!isset($_SESSION['loggedUserId'])) {
                    echo "<li>
                             <a href = 'register.php' > Rejestracja</a >
                          </li>";
                } ?>
                <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
            </ul>
        </div>
    </div>
</nav>
<?php
if(!empty($_POST)){
    echo "<div class=\"alert alert-success\">
             <strong>OK.</strong> Pomyślnie dodano produkt do koszyka.
          </div>";
}
?>
<section>
    <div class="container">
        <div class="row">
            <div class='col-lg-4 text-center'>

                <?php

                foreach ($itemPhotos as $itemPhoto) {
                    echo "<div class='product'>
                              <img class='img img-responsive' src='{$itemPhoto->getSrc()}' width='300' height='300'>
                          </div>";
                }
                ?>


                <span style="font-size: 2em" class="left glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span style="font-size: 2em" class="right glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

            </div>


            <div class="col-lg-4 text-center well itemDesc">
                <h2><?php echo $itemToShow->getName() ?></h2><br><br>
                <h3>Opis:</h3>
                <p>
                    <?php echo $itemToShow->getDesc() ?>
                </p>
            </div>
            <div class="col-lg-4">
                <br>
                <br>
                <br>
                <form action="item.php?id=<?php echo $itemToShow->getId() ?>" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cena:</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo $itemToShow->getPrice() ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ilość:</label>
                        <div class="col-sm-9">
                            <input type="number" name="quantity" value="1" min="1"
                                   max="<?php echo $itemToShow->getQuantity() ?>" class="form-control" id="inputCount">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input class="form-control" type="submit" value="Dodaj do koszyka">
                        </div>
                    </div>
                </form>

            </div>
        </div>

</section>

</body>
<script src="js/app.js"></script>
</html>

<?php

$conn->close();
$conn = null;

?>
