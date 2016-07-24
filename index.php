<?php

require_once './src/connectionDB.php';

$user = new User();

$id = $user->getId();

$user->loadFromDB($conn, $id);

var_dump($user);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

</body>
</html>