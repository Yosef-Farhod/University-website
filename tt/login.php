<?php
session_start();

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo "email : ", $email, "<br>";
    echo "password : ", $password, "<br>";

    $connection = mysqli_connect(hostname:'127.0.0.1',username: 'root',password : '',database: 'test');
    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password';";
    $reslt=  mysqli_query($connection,$sql); 
    $user = mysqli_fetch_assoc($reslt);

    if (!empty($user)) {
        $_SESSION['login'] = $user;
        header("location: show.php");
    }else{
        echo"try again";
    }
    
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>System Mangmet student </h1>

    <form action="login.php" method="post">
        <label for="email">Enter your email </label>
        <input type="text" name="email" placeholder="email"><br>

        <label for="password">Enter password? </label>
        <input type="password" name="password" placeholder="password"><br>

        <input type="submit" value="login">

    </form>
</body>

</html>
