<?php
// اتصال به دیتابیس و اجرای کوئری‌ها برای ثبت نام
// ابتدا مقادیر ارسالی از فرم را دریافت کرده و بررسی می‌کنیم
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];

// اصلاح: استفاده از تابع password_hash برای رمزنگاری رمز عبور
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

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

// بررسی آیا کاربر با این ایمیل قبلاً ثبت نام کرده یا نه
$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    // اگر ایمیل در دیتابیس وجود نداشته باشد، یک رکورد جدید برای کاربر ایجاد کنید
    $stmt->close();

    // استفاده از prepared statement برای جلوگیری از injection
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    // اجرای prepared statement
    if ($stmt->execute() === TRUE) {
        // ثبت نام با موفقیت انجام شد، اطلاعات کاربر را در session ذخیره کنید
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name; // اضافه کردن نام کاربر به SESSION
         $_SESSION['last_name'] = $last_name; // اضافه کردن نام خانوادگی کاربر به SESSION
        $_SESSION['user_id']= $user_id;
        echo "ثبت نام با موفقیت انجام شد";
        // هدایت کاربر به کنترل پنل
        
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // اگر ایمیل در دیتابیس وجود داشته باشد، پیام خطا نمایش داده و کاربر را به فرم ثبت نام هدایت کنید
    echo "این ایمیل قبلاً ثبت شده است.";
}

$stmt->close();
$conn->close();
?>
