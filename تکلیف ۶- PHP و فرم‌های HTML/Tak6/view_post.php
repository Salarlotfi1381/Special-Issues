

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نمایش پست</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .post-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .back-btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="post-container">

<?php
// اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Webds";
$conn = new mysqli($servername, $username, $password, $dbname);

// چک کردن اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// دریافت post_id از URL
$post_id = $_GET['post_id'];

// کوئری برای بازیابی اطلاعات پست
$sql = "SELECT posts.post_id, posts.title, posts.content, posts.image_url, posts.post_date, posts.user_id, post_category.category_id
        FROM posts
        INNER JOIN post_category ON posts.post_id = post_category.post_id
        WHERE posts.post_id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $post_id = $row["post_id"];
        $title = $row["title"];
        $content = $row["content"];
        $image_url = $row["image_url"];
        $post_date = $row["post_date"];
        $user_id = $row["user_id"];
        $category_id = $row["category_id"];

        // اطلاعات دسته بندی
        $sql_category = "SELECT title FROM categories WHERE category_id = $category_id";
        $result_category = $conn->query($sql_category);
        $category_title = ($result_category->num_rows > 0) ? $result_category->fetch_assoc()["title"] : "بدون دسته بندی";

        // نمایش اطلاعات پست و دسته بندی
        echo "<h1>$title</h1>";
        echo "<p>محتوا: $content</p>";
        echo "<p>تصویر: <img src='$image_url' alt='تصویر پست'></p>";
        echo "<p>تاریخ انتشار: $post_date</p>";
        echo "<p>نام دسته بندی: $category_title</p>";

        // اطلاعات کاربر
        $sql_user = "SELECT first_name, last_name FROM users WHERE user_id = $user_id";
        $result_user = $conn->query($sql_user);
        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_name = $user["first_name"] . " " . $user["last_name"];
        } else {
            $user_name = "ناشناس";
        }

        echo "<p>نویسنده: $user_name</p>";
    }
} else {
    echo "<p>پست مورد نظر یافت نشد.</p>";
}

// بستن اتصال به دیتابیس
$conn->close();
?>
 </div>
    <a href="index.php" class="back-btn">بازگشت به صفحه اصلی</a>
</body>
</html>