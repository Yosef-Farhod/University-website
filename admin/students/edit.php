<?php
session_start();
if (!isset($_SESSION['login'])) {
    header(header:"location:../../login.php");
}
if ($_SESSION['login']['role'] != 'admin') {
    header(header:"location: show.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'university_lms');
    $data = mysqli_query($connection,"SELECT * FROM `students` WHERE `student_id`=$id;");
    $reslt = mysqli_fetch_assoc($data);
    if (!$reslt) {
        die("Student not found.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>Edit Student Data</h1>
    <a href="show.php">Show student</a>

    <form action="editphp.php" method="post">
        <input type="hidden" name="student_id" value="<?=$reslt['student_id']?>">
        
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" value="<?=$reslt['full_name']?>"><br>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?=$reslt['email']?>"><br>

        <label for="level">Level</label>
        <select name="level">
            <option value="1" <?= $reslt['level'] == 1 ? 'selected' : '' ?>>Level 1</option>
            <option value="2" <?= $reslt['level'] == 2 ? 'selected' : '' ?>>Level 2</option>
            <option value="3" <?= $reslt['level'] == 3 ? 'selected' : '' ?>>Level 3</option>
            <option value="4" <?= $reslt['level'] == 4 ? 'selected' : '' ?>>Level 4</option>
        </select><br>

        <label for="department">Department</label>
        <select name="department">
            <option value="Computer Science" <?= $reslt['department'] == 'Computer Science' ? 'selected' : '' ?>>Computer Science</option>
            <option value="Information Technology" <?= $reslt['department'] == 'Information Technology' ? 'selected' : '' ?>>Information Technology</option>
            <option value="Software Engineering" <?= $reslt['department'] == 'Software Engineering' ? 'selected' : '' ?>>Software Engineering</option>
            <option value="Cyber Security" <?= $reslt['department'] == 'Cyber Security' ? 'selected' : '' ?>>Cyber Security</option>
        </select><br>

        <input type="submit">
    </form>
</body>

</html>
