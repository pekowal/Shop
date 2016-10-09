<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedUserId'])) {
    $loggedUserId = $_SESSION['loggedUserId'];

    $loggedUser = new User();

    $loggedUser->loadFromDB($conn, $loggedUserId);

}

if (isset($_GET['id'])) {
    $group = new ItemGroup();
    $group->loadFromDB($conn, $_GET['id']);
    $allItemsOfGroup = Item::GetAllProductsOfGroup($conn, $_GET['id']);

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

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class=""><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><?php echo $group->getName()?><span class="caret"></span></a>
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
                        echo "<li><a href='messages.php'>Wiadomości</a></li>";                        
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
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<section>
    <div class="container">

            <?php
            if (isset($_GET['id'])){
                foreach ($allItemsOfGroup as $item){
                    $photo = ItemPhoto::LoadOnePhotoOfItemFromDB($conn, $item->getId());
                    echo "<div class=\"row\">";
                    echo "<div class='col-lg-4'><div class='group-product'><img class='img img-responsive' src='{$photo->getSrc()}'></div></div>";
                    echo "<div class='col-lg-4'>{$item->getName()}</div>";
                    echo "<div class='col-lg-2 right'><span>Cena: </span>{$item->getPrice()}</div>";
                    echo "<div class='col-lg-2 right'><a href='item.php?id={$item->getId()}'><button class='btn btn-default'>Pokaż</button></a></div><br>";
                    echo "</div>";
                }

            }
            ?>
        </div>
    </div>

</section>

</body>
</html>

<?php

$conn->close();
$conn = null;

?>
