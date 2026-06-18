<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: ../../login.php");
    exit();
}

$db = new Dbsql("127.0.0.1", "root", "", "university_lms", "grades");
$grades = $db->select("grades.*, students.full_name, courses.course_name")
             ->join("INNER", "students", "grades.student_id", "students.student_id")
             ->join("INNER", "courses", "grades.course_id", "courses.course_id")
             ->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Grades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Grades Record</h1>
    <a href="form.php">Add New Grade</a> | <a href="../dashboard.php">Dashboard</a>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Course</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($grades as $g): ?>
                <tr>
                    <td><?= $g['full_name'] ?></td>
                    <td><?= $g['course_name'] ?></td>
                    <td><strong><?= $g['grade'] ?></strong></td>
                    <td>
                        <a href="delete.php?id=<?= $g['grade_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>