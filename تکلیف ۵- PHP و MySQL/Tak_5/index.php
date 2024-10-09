<?php
// نام فایل برای ذخیره اطلاعات
$database_check_file = 'database_created.txt';

// بررسی آیا فایل برای نشان دادن اینکه دیتابیس قبلاً ساخته شده است وجود دارد یا نه
if (!file_exists($database_check_file)) {
    // اتصال به پایگاه داده
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "divardb";

    // اتصال به MySQL
    $conn = new mysqli($servername, $username, $password);

    // بررسی اتصال
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ایجاد دیتابیس
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        //echo "Database created successfully\n";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    // انتخاب دیتابیس
    $conn->select_db($dbname);

    // ایجاد جدول کاربران
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(30) NOT NULL,
        last_name VARCHAR(30) NOT NULL,
        email VARCHAR(50) UNIQUE,
        phone_number VARCHAR(15),
        report_count INT(6) DEFAULT 0
    )";
    $conn->query($sql);

    // ایجاد جدول آگهی‌ها
    $sql = "CREATE TABLE IF NOT EXISTS ads (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        description TEXT,
        price INT(10),
        city VARCHAR(50),
        creation_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id INT(6) UNSIGNED,
        report_count INT(6) DEFAULT 0,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->query($sql);

    // درج رکوردها در جدول کاربران
    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, report_count) VALUES
        ('Ali', 'Ahmadi', 'Ali@gmail.com','093523341234', 0),
        ('Leila', 'Roosta', 'Leila@gmail.com', '09391147683', 0),
        ('Elyas', 'Pooran', 'Elyas@gmail.com', '09172504462', 0),
        ('Bahare', 'Bahrami', 'Bahare@gmail.com', '09041201580', 0),
        ('Reza', 'Maleki', 'Reza@gmail.com', '09168002045', 0)";
    $conn->query($sql);

    // درج رکوردها در جدول آگهی‌ها
    $sql = "INSERT INTO ads (title, city, price, description, user_id, report_count) VALUES
        ('کلاس خصوصی', 'جم', 250000, 'کلاس خصوصی تدریس برنامه نویسی وب در محل دانشکده مهندسی جم بصورت هفته‌ای دو کلاس خصوصی', 1, 0),
        ('آموزش نقاشی', 'شیراز', 300000, 'کلاس آموزش نقاشی به کودکان بصورت جلسه‌ای در منزل شما.', 2, 0),
        ('فروش گوشی ', 'بوشهر', 65000000, 'فروش گوشی آیفون ۱۳ پرو مکس در حد با درصد باتری ۸۷ زیر قیمت بازار به دلیل مهاجرت', 3, 0),
        ('سرویس کولر', 'جم', 1111111, 'سرویس و تعمیر وسایل کولرهای اسپلیت با نازلترین قیمت و بهترین کیفیت ارائه میشود. سرویس کولر', 3, 0),
        ('انجام پروژه‌ برنامه نویسی', 'شیراز', 100000, 'وبسایت طراحی و انجام پروژه‌های برنامه نویسی دانشجویی با قیمت توافقی', 4, 0)";
    $conn->query($sql);

    // بستن اتصال به پایگاه داده
    $conn->close();

    // ایجاد یک فایل برای نشان دادن اینکه دیتابیس قبلاً ساخته شده است
    $fp = fopen($database_check_file, 'w');
    fwrite($fp, 'Database Created');
    fclose($fp);
} else {
   // echo 'Database already created.';
}
?>


<?php
// اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "divardb";

// اتصال به MySQL
$conn = new mysqli($servername, $username, $password);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// انتخاب دیتابیس
$conn->select_db($dbname);

// تابع برای جستجوی آگهی‌ها
function searchAds($keyword) {
    global $conn;
    $keyword = $conn->real_escape_string($keyword);
    $sql = "SELECT ads.id, ads.title, ads.creation_time, ads.price, users.first_name, users.last_name
            FROM ads
            INNER JOIN users ON ads.user_id = users.id
            WHERE ads.title LIKE '%$keyword%'
            OR ads.description LIKE '%$keyword%'
            OR users.first_name LIKE '%$keyword%'
            OR users.last_name LIKE '%$keyword%'
            ORDER BY ads.creation_time DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Title</th><th>Creation Time</th><th>Price</th><th>Owner</th><th>Action</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["title"]."</td><td>".$row["creation_time"]."</td><td>".$row["price"]."</td><td>".$row["first_name"]." ".$row["last_name"]."</td><td><a href='report.php?id=".$row["id"]."'>Report</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found";
    }
}

// اجرای تابع جستجو
if(isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    searchAds($keyword);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divar-like Website</title>
    <link rel="stylesheet" href="styles.css"> <!-- اینجا از فایل CSS استفاده می‌کنیم -->
</head>
<body>
    <h1>Divar-like Website</h1>

    <form action="" method="GET">
        <label for="keyword">Search:</label>
        <input type="text" id="keyword" name="keyword">
        <input type="submit" value="Search">
    </form>
</body>
</html>
