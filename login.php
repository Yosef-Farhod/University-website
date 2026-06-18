<?php
require "classes/Dbsql.php";

session_start();

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new Dbsql("127.0.0.1", "root", "", "university_lms", "users");
    $user = $db->select()
               ->where('username', '=', $username)
               ->AndWhere('password', '=', $password)
               ->get();
               

    if (empty($user)) {
        $error = "Invalid username or password!";
    } else {
        $_SESSION['login'] = $user;
        if($user['role'] == 'admin'){
            header("location: admin/dashboard.php");
            exit();
        }else {
            header("location: student/dashboard.php");
            exit();
        }
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

    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form action="login.php" method="post">
        <label for="username">Enter your email </label>
        <input type="text" name="username" placeholder="username"><br>

        <label for="password">Enter password? </label>
        <input type="password" name="password" placeholder="password"><br>

        <input type="submit" value="login">

    </form>
</body>

</html>
