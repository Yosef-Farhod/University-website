<?php
require "../classes/Dbsql.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['role'] != 'student') {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['login']['id'];
$db = new Dbsql("127.0.0.1", "root", "", "university_lms", "students");

// 1. جلب بيانات الطالب (student_id) بناءً على (user_id) من السيشن
$student = $db->select("student_id, full_name")->where("user_id", "=", $user_id)->get();

if (!$student) {
    die("Student profile not found. Please contact admin.");
}

$student_id = $student['student_id'];

// 2. جلب الكورسات والمواد الدراسية (Materials) الخاصة بهذا الطالب فقط
$db_m = new Dbsql("127.0.0.1", "root", "", "university_lms", "materials");
$my_materials = $db_m->select("materials.*, courses.course_name, courses.course_code")
    ->join("INNER", "courses", "materials.course_id", "courses.course_id")
    ->join("INNER", "student_courses", "courses.course_id", "student_courses.course_id")
    // ملاحظة: تأكد أن جدول student_courses يحتوي فعلاً على عمود student_id
    ->where("student_courses.student_id", "=", $student_id)
    ->all();

// 3. جلب الدرجات الخاصة بالطالب
$db_g = new Dbsql("127.0.0.1", "root", "", "university_lms", "grades");
$my_grades = $db_g->select("grades.*, courses.course_name")
    ->join("INNER", "courses", "grades.course_id", "courses.course_id")
    ->where("grades.student_id", "=", $student_id)
    ->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        .material-card { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 8px; }
        .badge { background: #007bff; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8em; }
        .grade-box { background: #f4f4f4; padding: 10px; margin-top: 20px; border-left: 5px solid #28a745; }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?= $student['full_name'] ?></h1>
        <p>Your Academic Portal</p>
        <nav>
            <a href="../logout.php">Logout</a>
        </nav>
    </header>

    <section>
        <h2>Newly Dropped Materials</h2>
        <?php if (empty($my_materials)): ?>
            <p>No materials uploaded for your registered courses yet.</p>
        <?php else: ?>
            <?php foreach ($my_materials as $mat): ?>
                <div class="material-card">
                    <span class="badge"><?= $mat['course_code'] ?> - <?= $mat['course_name'] ?></span>
                    <h3><?= $mat['title'] ?></h3>
                    <p><?= $mat['description'] ?></p>
                    <small>Uploaded on: <?= $mat['upload_date'] ?></small><br><br>
                    <a href="../uploads/materials/<?= $mat['file_path'] ?>" target="_blank" class="button">Download/View PDF</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <hr>

    <section>
        <h2>My Grades</h2>
        <?php if (empty($my_grades)): ?>
            <p>No grades published yet.</p>
        <?php else: ?>
            <table>
                <tr><th>Course</th><th>Grade</th></tr>
                <?php foreach ($my_grades as $grade): ?>
                    <tr><td><?= $grade['course_name'] ?></td><td><strong><?= $grade['grade'] ?></strong></td></tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </section>
</body>
</html>