<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedUserId'])) {
    $loggedUserid = $_SESSION['loggedUserId'];

    $loggedUser = new User();

    $loggedUser->loadFromDB($conn, $loggedUserid);

} elseif (isset($_SESSION['loggedAdminId'])) {

}else{
    header('Location:login.php');
}


if (isset($_GET['orderId'])) {
    $itemsInOrder = ItemOrder::GetAllItemsOfOrder($conn, $_GET['orderId']);
    //var_dump($itemsInOrder);
    $items = [];
    foreach ($itemsInOrder as $itemInOrder) {
        $item = new Item();
        $item->loadFromDB($conn, $itemInOrder->getIdItem());
        $item->setQuantity($itemInOrder->getQuantity());
        $items[] = $item;
    }

    $order = new Order();
    $order->loadFromDb($conn, $_GET['orderId']);

    //var_dump($items);
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
    <script src="js/app.js"></script>
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
                <li class=""><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Kategorie <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        $groups = ItemGroup::GetAllGroups($conn);
                        //var_dump($groups);
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
        </div>
    </div>
</nav>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Przedmiot:</th>
                        <th>Ilość:</th>
                        <th>Cena:</th>
                        <th>Razem:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($items as $item){
                            echo "<tr>";
                            echo "<th><a href='item.php?id={$item->getId()}'> {$item->getName()}</a></th>";
                            echo "<th>{$item->getQuantity()}</th>";
                            echo "<th>{$item->getPrice()}</th>";
                            echo "<th>".$item->getPrice() * $item->getQuantity()." zł</th>";
                        }

                    ?>
                    </tbody>
                </table>
                <h3>Razem: <?php echo $order->getCost() . 'zł'?></h3>
            </div>
        </div>
    </div>
</section>
</body>

</html>

<?php

$conn->close();
$conn = null;

?>
