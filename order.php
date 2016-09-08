<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedUserId'])) {
    $loggedUserid = $_SESSION['loggedUserId'];

    $loggedUser = new User();

    $loggedUser->loadFromDB($conn, $loggedUserid);

} else {
    header('Location:login.php');
}

$items = [];

if (isset($_SESSION['cart'])) {


    foreach ($_SESSION['cart'] as $item) {
        /*
        $key = array_search($_GET['idToDelete'], $item);
        var_dump($key);
        */

        $newItem = new Item();
        $newItem->loadFromDB($conn, $item['id']);

        $newItem->setQuantity($item['quantity']);

        $items[] = $newItem;

    }

}
if (!empty($_POST && !empty($_SESSION['cart']))) {
    $order = new Order();
    $order->setIdUser($loggedUserid);
    $order->setPaymentType($_POST['paymentType']);
    $order->saveToDb($conn);

    foreach ($items as $item) {
        $itemOrder = new ItemOrders();
        $itemOrder->setIdItem($item->getId());
        $itemOrder->setQuantity($item->getQuantity());
        $itemOrder->setIdOrder($order->getId());
        $itemOrder->saveToDb($conn);
        var_dump($itemOrder);
    }

    echo "Zamówienie zosotało przekazane do realizacji";
    unset($_SESSION['cart']);
} else {

}

if (isset($_GET['orderId'])) {
    $itemsInOrder = ItemOrder::GetAllItemsOfOrder($conn, $_GET['orderId']);
    var_dump($itemsInOrder);
}

$orderFromUser = Order::GetAllOrdersFromUser($conn, $loggedUserid);


?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
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

        if (isset($_GET['action'])) {
            echo "<div class=\"row\">
                                  <div class=\"col-lg-12\">
                                     <table class=\"table table-striped table-bordered table-hover\">
                                       <thead>
                                            <tr>
                                                <th>Przedmiot:</th>
                                                <th>Cena:</th>
                                                <th>Ilość:</th>
                                                <th>Razem:</th>
                                            </tr>
                                       </thead>
                                       <tbody>";
            if (isset($_SESSION['cart'])) {


                foreach ($items as $item) {
                    $key = array_search($item, $items);

                    echo "<tr>";
                    echo "<th>{$item->getName()}</th>";
                    echo "<th>{$item->getPrice()} zł</th>";
                    echo "<th>{$item->getQuantity()}</th>";
                    echo "<th>" . $item->getQuantity() * $item->getPrice() . " zł</th>";


                }
            }
            echo "</tbody></table></div></div>";
        } else {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nr</th>';
            echo '<th>Status</th>';
            echo '<th>Rodzaj płatności</th>';
            echo '<th>Data złożenia zamówienia</th><th></th></tr></thead>';
            echo '<tbody>';
            foreach ($orderFromUser as $order) {
                echo "<tr>";
                echo "<th>{$order->getId()}</th>";
                echo "<th>{$order->getStatus()}</th>";
                echo "<th>{$order->getPaymentType()}</th>";
                echo "<th>{$order->getOrderDate()}</th><th><a href='order.php?orderId={$order->getId()}'><button class='btn btn-success'>Pokaż</button></a> </th></tr>";
            }
            echo "</tobody>";
        }
        ?>

        <div class="row">
            <div class="col-lg-4">
                <span style="font-size: 20px;">Adres do wysyłki:</span><br>
                <span><?php echo $loggedUser->getName() . ' ' . $loggedUser->getSurname() ?></span><br>
                <span><?php echo $loggedUser->getAddress() ?></span>
            </div>
            <?php
            if (isset($_GET['action'])) {
                echo "<div class=\"col-lg-6\">
                        <form action='order.php' method='post'>
                                <label>Metoda płatności</label>
                                <select name='paymentType'>
                                  <option value='Przelew'>Przelew</option>
                                  <option value='Za pobraniem'>Za pobraniem</option>
                                  <option value='Odbiór osobisty'>Odbiór osobisty</option>                   
                                </select>
                                <button class='btn btn-success' type='submit'>Potwierdź zamówienie</button>
                          
                        </form>
                      </div>";


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
