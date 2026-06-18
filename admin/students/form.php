<?php
require "../../classes/Dbsql.php";

session_start();
if (!isset($_SESSION['login'])) {
    header(header: "location: login.php");
    exit(); // مهم جداً بعد الـ header
}
// if (($_SESSION['login']['role'] == "student")) {
//     header(header: "location: show.php");
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>System Mangmet student </h1>
    <a href="show.php">Show student</a>
    <h2>Add student</h2>

    <form action="form.php" method="post" enctype="multipart/form-data">
        <label for="full_name">Enter your full_name </label>
        <input type="text" name="full_name"><br>

        <label for="university_no">university_no ? </label>
        <input type="text" name="university_no"><br>

        <label for="email">Enter your email </label>
        <input type="text" name="email"><br>

        <label for="level">level</label>
        <select name="level">
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
            <option value="4">Level 4</option>
        </select><br>
        </label>

        <label for="department">Department</label>
        <select name="department">
            <option value="Computer Science">Computer Science</option>
            <option value="Information Technology">Information Technology</option>
            <option value="Software Engineering">Software Engineering</option>
            <option value="Cyber Security">Cyber Security</option>
        </select><br>


        <!-- <label for="my_image">Enter your photo </label>
        <input type="file" name="my_image[]" multiple><br> -->


        <input type="submit">

    </form>
</body>

</html>
<?php
if (isset($_POST['full_name'])) {
    $user = $_POST;

    $db = new Dbsql("127.0.0.1", "root", "", "university_lms", "students");

    
    $result = $db->insert($user)->execute();

    if ($result) {
        echo "<div style='color:green;'>Done! Student added successfully.</div>";
    } else {
        echo "<div style='color:red;'>Error: Failed to add student.</div>";
    }
}

    // $connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');
    // $upload_dir = "uploads/";
    // if (!is_dir($upload_dir)) {
    //     mkdir($upload_dir, 0777, true);
    // }

    // $uploaded_images = [];

    // // نستخدم Loop للمرور على كل الصور المرفوعة
    // foreach ($_FILES['my_image']['name'] as $key => $name) {
    //     if ($_FILES['my_image']['error'][$key] == 0) {
    //         $img_tmp = $_FILES['my_image']['tmp_name'][$key];
    //         $new_img_name = time() . "_" . $name;
    //         $upload_path = $upload_dir . $new_img_name;

    //         if (move_uploaded_file($img_tmp, $upload_path)) {
    //             $uploaded_images[] = $new_img_name;
    //         }
    //     }
    // }

    // تحويل مصفوفة الأسماء إلى نص مفصول بفاصلة لتخزينها في قاعدة البيانات
    // $images_string = implode(",", $uploaded_images);

    // $sql = "INSERT INTO `users` (`name`, `age`, `courses_id`, `image_name`) 
    //         VALUES ('$user[name]', '$user[age]', '$user[courses_id]', '$images_string');";

    // mysqli_query($connection, $sql);

?>