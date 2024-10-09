<?php
// اتصال به دیتابیس و بازیابی پست‌های مرتبط با دسته‌بندی مورد نظر
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Webds";
$conn = new mysqli($servername, $username, $password, $dbname);

// چک کردن اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// دریافت category_id از URL
$category_id = $_GET['category_id'];

// کوئری برای بازیابی پست‌های مرتبط با دسته‌بندی مورد نظر
$sql = "SELECT posts.* FROM posts
        INNER JOIN post_category ON posts.post_id = post_category.post_id
        WHERE post_category.category_id = $category_id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاهده پست‌ها</title>
    <style>
        /* استایل‌ها اینجا قرار می‌گیرند */
    </style>
</head>
<body>
    <h1>پست‌های دسته‌بندی</h1>

    <!-- نمایش پست‌های مرتبط با دسته‌بندی مورد نظر -->
    <?php
    if ($result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><a href='view_post.php?post_id=" . $row['post_id'] . "'>" . $row["title"] . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>هیچ پستی در این دسته‌بندی یافت نشد.</p>";
    }
    ?>

</body>
</html>

<?php
// بستن اتصال به دیتابیس
$conn->close();
?>
