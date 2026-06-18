<?php
require "../../classes/Dbsql.php";
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']['role'] == 'admin' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $db = new Dbsql("127.0.0.1", "root", "", "university_lms", "courses");
    
    $db->delete()->where('course_id', '=', $id)->execute(); // Use course_id
}

header("location: show.php");
exit();
