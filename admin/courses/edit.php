<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: show.php");
    exit();
}

$id = $_GET['id'] ?? null;
$db = new Dbsql("127.0.0.1", "root", "", "university_lms", "courses");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'course_name' => $_POST['course_name'],
        'course_code' => $_POST['course_code'],
        'semester' => $_POST['semester'],
        'doctor_name' => $_POST['doctor_name']
    ];
    $db->update($data)->where('course_id', '=', $_POST['id'])->execute(); // Use course_id
    header("location: show.php");
    exit();
}

if ($id) {
    $course = $db->select()->where('course_id', '=', $id)->get(); // Use course_id
} else {
    header("location: show.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Edit Course</h1>
    <a href="show.php">Cancel</a>

    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?= $course['course_id'] ?>">

        <label for="course_name">Course Name</label>
        <input type="text" name="course_name" value="<?= $course['course_name'] ?>" required>

        <label for="course_code">Course Code</label>
        <input type="text" name="course_code" value="<?= $course['course_code'] ?>" required>

        <label for="semester">Semester</label>
        <input type="text" name="semester" value="<?= $course['semester'] ?>" required>

        <label for="doctor_name">Doctor Name</label>
        <input type="text" name="doctor_name" value="<?= $course['doctor_name'] ?>" required>

        <!-- Removed description field as per new schema -->
        <!-- <label for="description">Description</label>
        <textarea name="description"><?= $course['description'] ?></textarea> -->

        <input type="submit" value="Update Course">
    </form>
</body>
</html>
