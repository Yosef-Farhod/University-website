<?php
require "../../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'admin') {
    header("location: ../../login.php");
    exit();
}

$db_courses = new Dbsql("127.0.0.1", "root", "", "university_lms", "courses");
$courses = $db_courses->select()->all();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['material_file'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $upload_dir = "../../uploads/materials/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . "_" . $_FILES['material_file']['name'];
    $target_file = $upload_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($file_type != "pdf") {
        $error = "Sorry, only PDF files are allowed.";
    } else {
        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $target_file)) {
            $db_materials = new Dbsql("127.0.0.1", "root", "", "university_lms", "materials");
            $data = [
                'course_id' => $course_id,
                'title' => $title,
                'description' => $description,
                'file_path' => $file_name
            ];
            $db_materials->insert($data)->execute();
            $success = "Material uploaded and linked successfully!";
        } else {
            $error = "Error uploading file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Material</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Upload Course Material (PDF)</h1>
    <a href="show.php">View All Materials</a> | <a href="../dashboard.php">Dashboard</a>

    <?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form action="form.php" method="post" enctype="multipart/form-data">
        <label>Select Course:</label>
        <select name="course_id" required>
            <?php foreach($courses as $course): ?>
                <option value="<?= $course['course_id'] ?>"><?= $course['course_name'] ?> (<?= $course['course_code'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <label>Material Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <label>Select PDF File:</label>
        <input type="file" name="material_file" accept=".pdf" required>

        <input type="submit" value="Upload Material">
    </form>
</body>
</html>