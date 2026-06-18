<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: ../../login.php");
    exit();
}

$db = new Dbsql("127.0.0.1", "root", "", "university_lms", "materials");
// نستخدم Join لجلب اسم المادة مع ملف الماتيريال
$materials = $db->select("materials.*, courses.course_name")
                ->join("INNER", "courses", "materials.course_id", "courses.course_id")
                ->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Materials</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Materials Management</h1>
    <a href="form.php">Upload New Material</a> | <a href="../dashboard.php">Dashboard</a>

    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Title</th>
                <th>Date</th>
                <th>File</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($materials as $m): ?>
                <tr>
                    <td><?= $m['course_name'] ?></td>
                    <td><?= $m['title'] ?></td>
                    <td><?= $m['upload_date'] ?></td>
                    <td><a href="../../uploads/materials/<?= $m['file_path'] ?>" target="_blank">View PDF</a></td>
                    <td>
                        <a href="delete.php?id=<?= $m['material_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>