<?php

require_once './src/connectionDB.php';


if (isset($_SESSION['loggedUserId'])) {
    $loggedUserid = $_SESSION['loggedUserId'];

    $loggedUser = new User();

    $loggedUser->loadFromDB($conn, $loggedUserid);

}


if(!empty($_POST)){

    if($loggedUser->verifyPassword($_POST['oldPass'])){
        $loggedUser->setName($_POST['name']);
        $loggedUser->setSurname($_POST['surname']);
        $loggedUser->setEmail($_POST['email']);
        $loggedUser->setAddress($_POST['address']);
        $loggedUser->setPassword($_POST['newPass1'],$_POST['newPass2']);
        $loggedUser->saveToDB($conn);        
    }else{
        echo 'Podałeś złe hasło';
    }
    

        
}


?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
                            echo "<li><a href='item.php?gid=" . $groups[$i]->getId() . "'>" . $groups[$i]->getName() . "</a></li>";
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
                }?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<section>
    <div class="container">
        <form class="form-horizontal" action="#" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">Imię</label>
                <div class="col-sm-10">
                    <input class="form-control" value="<?php echo $loggedUser->getName()?>" type="text" name="name" placeholder="Podaj imię"><br>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nazwiska</label>
                <div class="col-sm-10">
                    <input class="form-control" value="<?php echo $loggedUser->getSurname()?>" type="text" name="surname" placeholder="Podaj nazwisko"><br>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input class="form-control" value="<?php echo $loggedUser->getEmail()?>" type="email" name="email" pattern="^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-
                            ]+(\.[a-zA-Z0-9-]{1,})*\.([a-zA-Z]{2,}){1}$" placeholder="Podaj email"><br>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Adres</label>
                <div class="col-sm-10">
                    <input class="form-control" value="<?php echo $loggedUser->getAddress()?>" type="text" name="address" placeholder="Podaj pełny adres"><br>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Stare hasło</label>
                <div class="col-sm-10">
                    <input class="form-control" type="password" name="oldPass" placeholder="Podaj hasło"><br>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Hasło</label>
                <div class="col-sm-10">
                    <input class="form-control" type="password" name="newPass1" placeholder="Podaj nowe hasło"><br>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Powtórz hasło</label>
                <div class="col-sm-10">
                    <input class="form-control" type="password" name="newPass2" placeholder="Powtórz Hasło"><br>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Zapisz zmiany</button>
                </div>
            </div>

        </form>
    </div>

</section>

</body>
</html>

<?php

$conn->close();
$conn = null;

?>
