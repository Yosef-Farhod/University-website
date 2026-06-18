<?php
$editUser = $_POST;
$connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'university_lms');

$full_name = $editUser['full_name'];
$email = $editUser['email'];
$level = $editUser['level'];
$dept = $editUser['department'];
$id = $editUser['student_id'];

$sql = "UPDATE `students` SET `full_name` = '$full_name', `email` = '$email', `level` = $level, `department` = '$dept' WHERE `student_id` = $id;";
mysqli_query($connection, $sql);

header("location: show.php");
exit();