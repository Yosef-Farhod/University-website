<?php
session_start();
if (!isset($_SESSION['login'])) {
    header(header: "location: login.php");
}
if (!($_SESSION['login']['admin'])) {
    header(header: "location: show.php");
}

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
        <label for="name">Enter your name </label>
        <input type="text" name="name"><br>

        <label for="age">Enter age ? </label>
        <input type="text" name="age"><br>

        <label>Enter course :</label><br>
        <input type="radio" name="courses_id" value="1" id="course1">
        <label for="course1">HTML</label><br>

        <input type="radio" name="courses_id" value="2" id="course2">
        <label for="course2">MY SQL</label><br><br>

        <label for="my_image">Enter your photo </label>
        <input type="file" name="my_image[]" multiple><br>


        <input type="submit">

    </form>
</body>

</html>
<?php
if (isset($_POST['name'])) {
    $user = $_POST;
    print_r($user);

    $connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');

    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $uploaded_images = [];
    
    // نستخدم Loop للمرور على كل الصور المرفوعة
    foreach ($_FILES['my_image']['name'] as $key => $name) {
        if ($_FILES['my_image']['error'][$key] == 0) {
            $img_tmp = $_FILES['my_image']['tmp_name'][$key];
            $new_img_name = time() . "_" . $name;
            $upload_path = $upload_dir . $new_img_name;

            if (move_uploaded_file($img_tmp, $upload_path)) {
                $uploaded_images[] = $new_img_name;
            }
        }
    }

    // تحويل مصفوفة الأسماء إلى نص مفصول بفاصلة لتخزينها في قاعدة البيانات
    $images_string = implode(",", $uploaded_images);

    $sql = "INSERT INTO `users` (`name`, `age`, `courses_id`, `image_name`) 
            VALUES ('$user[name]', '$user[age]', '$user[courses_id]', '$images_string');";
    
    mysqli_query($connection, $sql);

    if (mysqli_affected_rows($connection) > 0) {
        echo "done add a student";
    } else {
        echo "feild student";
    }
}
