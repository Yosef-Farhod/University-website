<?php
$connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');

$id = $_GET['id'];

mysqli_query($connection, "DELETE FROM `users` WHERE `id` = $id ;");
if (mysqli_affected_rows($connection)) {
    header("location: show.php");
}
