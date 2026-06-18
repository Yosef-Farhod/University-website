<?php
require "../../classes/Dbsql.php";
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']['role'] == 'admin' && isset($_GET['id'])) {
    $db = new Dbsql("127.0.0.1", "root", "", "university_lms", "grades");
    $db->delete()->where('grade_id', '=', $_GET['id'])->execute();
}

header("location: show.php");
exit();
?>