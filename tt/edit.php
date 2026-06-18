<?php
session_start();
if (!isset($_SESSION['login'])) {
    header(header:"location: login.php");
}
if ( !($_SESSION['login']['admin'])) {
    header(header:"location: show.php");
}

$id = $_GET['id'];

$connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $data = mysqli_query($connection,"SELECT * FROM `users` WHERE `users`.`id`=$id;");
    $reslt = mysqli_fetch_assoc($data);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>Welcom to my web </h1>
    <a href="show.php">Show student</a>
    <h2>Add student</h2>

    <form action="editphp.php" method="post">
        <label for="name">Enter your name </label>
        <input type="text" name="name" value="<?=$reslt['name']?>"><br>

        <label for="age">Enter age ? </label>
        <input type="text" name="age" value="<?=$reslt['age']?>"><br>

        <label>Enter course :</label><br>
        <input type="radio" name="courses_id" value="1" id="course1" <?= ($reslt['courses_id'] == 1) ? 'checked' : '' ?>>
        <label for="course1">HTML</label><br>

        <input type="radio" name="courses_id" value="2" id="course2" <?= ($reslt['courses_id'] == 2) ? 'checked' : '' ?>>
        <label for="course2">MY SQL</label><br>

        <input type="hidden" name="id" value="<?=$reslt['id']?>">

        <input type="submit">

    </form>
</body>

</html>
