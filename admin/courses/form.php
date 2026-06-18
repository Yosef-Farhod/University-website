<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: show.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_name'])) {
    $db = new Dbsql("127.0.0.1", "root", "", "university_lms", "courses");
    $result = $db->insert($_POST)->execute();

    if ($result) {
        $message = "<div style='color:green;'>Course added successfully!</div>";
    } else {
        $message = "<div style='color:red;'>Error adding course.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Add New Course</h1>
    <a href="show.php">Back to List</a>
    
    <?= $message ?? "" ?>

    <form action="form.php" method="post">
        <label for="course_name">Course Name</label>
        <input type="text" name="course_name" required>

        <label for="course_code">Course Code</label>
        <input type="text" name="course_code" required>

        <label for="semester">Semester</label>
        <input type="text" name="semester" required>

        <label for="doctor_name">Doctor Name</label>
        <input type="text" name="doctor_name" required>
        
        <input type="submit" value="Save Course">
    </form>
</body>
</html>
