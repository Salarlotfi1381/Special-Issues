<?php
// اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Webds";
// اتصال به دیتابیس
$conn = new mysqli($servername, $username, $password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// اگر فرم ارسال شده است
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت عنوان دسته بندی ارسالی از فرم
    $category_name = $_POST['category_title'];

    // بررسی تکراری نبودن عنوان دسته بندی
    $check_query = "SELECT * FROM categories WHERE title = '$category_name'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // اگر عنوان دسته بندی تکراری است، پیام خطا نمایش داده شود
        echo "این دسته بندی قبلاً اضافه شده است.";
        echo '<a href="dashboard.php">بازگشت به صفحه داشبورد</a>';
    } else {
        // اگر عنوان دسته بندی تکراری نیست، دسته بندی جدید به دیتابیس اضافه شود
        $insert_query = "INSERT INTO categories (title) VALUES ('$category_name')";
        if ($conn->query($insert_query) === TRUE) {
            echo "دسته بندی با موفقیت اضافه شد.";
            echo '<a href="dashboard.php">بازگشت به صفحه داشبورد</a>';
        } else {
            echo "خطا در اضافه کردن دسته بندی: " . $conn->error;
        }
    }
}

// بستن اتصال به دیتابیس
$conn->close();
?>