<?php
// اتصال به دیتابیس و اجرای کوئری‌ها برای ورود
// ابتدا مقادیر ارسالی از فرم را دریافت کرده و بررسی می‌کنیم
$email = $_POST['email'];
$passwordd = $_POST['password'];

// اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$db_password = ""; // تغییر نام متغیر تا از تداخل با متغیر قبلی جلوگیری شود
$dbname = "Webds";

$conn = new mysqli($servername, $username, $db_password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استفاده از prepared statement برای جلوگیری از injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

// اجرای prepared statement
$stmt->execute();
$result = $stmt->get_result();

// بررسی وجود رکورد با ایمیل مورد نظر
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // بررسی صحت رمزعبور
    if (password_verify($passwordd, $row['password'])) {
        session_start();
        $_SESSION['email'] = $email;
        // انتقال به صفحه‌ی کنترل پنل
        header("Location: dashboard.php");
        exit();
    } else {
        echo "رمز عبور اشتباه است";
    }
} else {
    echo "ایمیل یافت نشد";
}

$stmt->close();
$conn->close();
?>
