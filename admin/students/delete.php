<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: ../../login.php");
    exit();
}

$connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'university_lms');
$id = $_GET['id'];
mysqli_query($connection, "DELETE FROM `students` WHERE `student_id` = $id;");
header("location: show.php");
