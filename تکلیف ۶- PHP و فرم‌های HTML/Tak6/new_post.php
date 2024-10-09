<?php
// new_post.php

// شروع session
session_start();

// بررسی آیا کاربر لاگین کرده است یا نه
if(!isset($_SESSION['email'])) {
    // اگر کاربر لاگین نکرده بود، به صفحه ورود هدایت کنید
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درج پست جدید</title>
</head>
<body dir="rtl">
    <h2>درج پست جدید</h2>
    <form action="new_post_process.php" method="post">
        <label for="title">عنوان:</label><br>
        <input type="text" id="title" name="title"><br><br>

        <label for="content">متن:</label><br>
        <textarea id="content" name="content"></textarea><br><br>

        <label for="categories">دسته‌بندی:</label><br>
        <select id="categories" name="categories[]" multiple>
            <?php
            // اتصال به دیتابیس
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Webds";
            $conn = new mysqli($servername, $username, $password, $dbname);

            // بررسی اتصال
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // بازیابی دسته‌بندی‌های موجود از دیتابیس
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);

            // نمایش دسته‌بندی‌ها به عنوان آیتم‌های فیلد جعبه کشویی
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='". $row['category_id'] ."'>". $row['title'] ."</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="ارسال">
    </form>
</body>
</html>
