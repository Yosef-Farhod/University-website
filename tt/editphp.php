<?php

$editUser = $_POST;

$connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');

mysqli_query($connection, "UPDATE `users` SET `name` = '$editUser[name]',`age`= $editUser[age] WHERE `users`.`id` = $editUser[id];");

if (mysqli_affected_rows($connection)) {
    header("location: show.php");
}