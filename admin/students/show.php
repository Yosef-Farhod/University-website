<?php
require "../../classes/Dbsql.php";

session_start();


if (!isset($_SESSION['login'])) {
    header("location: ../../login.php");
    exit();
}
$admin = ($_SESSION['login']['role'] == 'admin');

$db = new Dbsql(
    "127.0.0.1",
    "root",
    "",
    "university_lms",
    "students"
);

$students = $db
    ->select()
    ->all();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>Students Management</h1>
    <?php if ($admin) : ?>
        <a href="form.php">Add student</a>
    <?php endif; ?>
    <a href="../courses/show.php">Show Courses</a>
    <a href="../../logout.php">Log out</a>

    <table>
        <thead>
            <tr>
                <th>Uni No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>Department</th>
                <?php if ($admin) : ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $value) : ?>
                <tr>
                    <td><?= $value['university_no']; ?></td>
                    <td><?= $value['full_name']; ?></td>
                    <td><?= $value['email']; ?></td>
                    <td>Level <?= $value['level']; ?></td>
                    <td><?= $value['department']; ?></td>
                    <?php if ($admin) : ?>
                        <td>
                            <a href="edit.php?id=<?= $value['student_id'] ?>">Edit</a> | 
                            <a href="delete.php?id=<?= $value['student_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>