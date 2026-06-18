<?php
require "../../classes/Dbsql.php";

session_start();


if (!isset($_SESSION['login'])) {
    header("location: ../../login.php");
    exit();
}
$admin = ($_SESSION['login']['role'] == 'admin');

// $connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');
// $sql = "SELECT * FROM `users`;";
// $reslt =  mysqli_query($connection, $sql);

// $all_users = mysqli_fetch_all($reslt, 1);

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
    <?php if ($admin) : ?>
        <a href="form.php">Add student</a>
    <?php endif; ?>
    <a href="../../logout.php">log out</a>

    <table>
        <tr>
            <th>University no</th>
            <th>Name</th>
            <th>Email</th>
            <th>level</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php foreach ($students as $key => $value) : ?>

            <tr>
                <td><?php echo $value['university_no']; ?></td>
                <td><?= $value['full_name']; ?></td>
                <td><?= $value['email']; ?></td>
                <td><?= $value['level']; ?></td>
                <!-- <td>
                    <?php
                    // تحويل النص المخزن في القاعدة إلى مصفوفة باستخدام الفاصلة
                    $images = explode(",", $value['image_name']);
                    foreach ($images as $img): if (!empty($img)): ?>
                        <img src="uploads/<?= $img; ?>" width="50" height="50" style="object-fit: cover; border-radius: 4px; margin-right: 2px;">
                    <?php endif;
                    endforeach; ?>
                </td> -->

                <td><a href="delete.php?id=<?= $value['student_id'] ?>">delete</a></td>
                <td><a href="edit.php?id=<?= $value['student_id'] ?>">edit</a></td>
            </tr>
        <?php endforeach; ?>

    </table>


</body>

</html>