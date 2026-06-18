<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: ../../login.php");
    exit();
}

$db_students = new Dbsql("127.0.0.1", "root", "", "university_lms", "students");
$students = $db_students->select()->all();

$db_courses = new Dbsql("127.0.0.1", "root", "", "university_lms", "courses");
$courses = $db_courses->select()->all();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db_grades = new Dbsql("127.0.0.1", "root", "", "university_lms", "grades");
    $result = $db_grades->insert($_POST)->execute();

    if ($result) {
        $success = "Grade added successfully!";
    } else {
        $error = "Failed to add grade.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Grade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Assign Grade to Student</h1>
    <a href="show.php">View All Grades</a> | <a href="../dashboard.php">Dashboard</a>

    <?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form action="form.php" method="post">
        <label>Select Student:</label>
        <select name="student_id" required>
            <option value="">-- Choose Student --</option>
            <?php foreach($students as $s): ?>
                <option value="<?= $s['student_id'] ?>"><?= $s['full_name'] ?> (<?= $s['university_no'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <label>Select Course:</label>
        <select name="course_id" required>
            <option value="">-- Choose Course --</option>
            <?php foreach($courses as $c): ?>
                <option value="<?= $c['course_id'] ?>"><?= $c['course_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Grade:</label>
        <input type="number" step="0.01" name="grade" min="0" max="100" required placeholder="e.g. 95.5">

        <input type="submit" value="Save Grade">
    </form>
</body>
</html>