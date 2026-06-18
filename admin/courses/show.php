<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("location: ../../login.php");
    exit();
}

$admin = ($_SESSION['login']['role'] == 'admin');

$db = new Dbsql("127.0.0.1", "root", "", "university_lms", "courses");
$courses = $db->select()->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Courses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Courses Management</h1>
    <?php if ($admin) : ?>
        <a href="form.php">Add New Course</a>
    <?php endif; ?>
    <a href="../students/show.php">Show Students</a>
    <a href="../../logout.php">Log out</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Semester</th>
                <th>Doctor Name</th>
                <?php if ($admin) : ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course) : ?>
                <tr>
                    <td><?= $course['course_id']; ?></td>
                    <td><?= $course['course_name']; ?></td>
                    <td><?= $course['course_code']; ?></td>
                    <td><?= $course['semester']; ?></td>
                    <td><?= $course['doctor_name']; ?></td>
                    <?php if ($admin) : ?>
                        <td>
                            <a href="edit.php?id=<?= $course['course_id'] ?>">Edit</a> | 
                            <a href="delete.php?id=<?= $course['course_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
