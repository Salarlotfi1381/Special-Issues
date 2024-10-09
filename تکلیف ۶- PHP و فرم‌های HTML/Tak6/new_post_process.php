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

// اگر فرم ارسال شده است
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت داده‌های فرم
    $title = $_POST['title'];
    $content = $_POST['content'];
    $categories = $_POST['categories'];
   
    // کوئری درج در جدول پست‌ها
    // دریافت user_id از جلسه
    session_start();
    $user_email = $_SESSION['email'];

   // var_dump($user_email);






// استفاده از جمله‌ی SELECT برای استخراج user_id بر اساس مقادیر جلسه

$select_user_id_query = "SELECT user_id FROM users WHERE email = '$user_email'";

// اجرای کوئری
$select_user_id_result = $conn->query($select_user_id_query);

// بررسی نتیجه و استفاده از user_id اگر موجود است
if ($select_user_id_result->num_rows > 0) {
    // دریافت user_id از نتیجه کوئری
    $row = $select_user_id_result->fetch_assoc();
    $user_id = $row["user_id"];
 //var_dump($user_id);
    // استفاده از user_id در کوئری اصلی
    $insert_query = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', '$user_id')";

    // ادامه‌ی کارهای لازم ...
} else {
    // اگر user_id موجود نبود
    echo "کاربر مورد نظر یافت نشد.";
}


    
    $insert_query = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', '$user_id')";

    if ($conn->query($insert_query) === TRUE) {
        // آخرین post_id را دریافت می‌کنیم
        $last_id = $conn->insert_id;

        // استخراج مقادیر category_id از جدول categories
        $category_ids = implode(',', array_map('intval', $categories));
        $category_query = "SELECT category_id FROM categories WHERE category_id IN ($category_ids)";
        $category_result = $conn->query($category_query);
        //var_dump($category_result);
        if ($category_result->num_rows > 0) {
            // درج دسته‌بندی‌ها به عنوان رکوردهای مجزا در جدول میانی
            while ($row = $category_result->fetch_assoc()) {
                $category_id = $row['category_id'];
                $insert_category_query = "INSERT INTO post_category (post_id, category_id) VALUES ('$last_id', '$category_id')";
                $conn->query($insert_category_query);
            }
        
            echo "پست با موفقیت اضافه شد.";
        } else {
            echo "هیچ دسته‌بندی با این شناسه‌ها یافت نشد.";
        }
    } else {
        echo "خطا در اضافه کردن پست: " . $conn->error;
    }
}

// بستن اتصال به دیتابیس
$conn->close();
?>
