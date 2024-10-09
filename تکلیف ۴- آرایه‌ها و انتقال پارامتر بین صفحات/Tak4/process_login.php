<?php
session_start(); // شروع یا ادامه‌ی جلسه

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // اطلاعات لاگین از فرم بخش ۴
    $loginEmail = $_POST["email"];
    $loginPassword = $_POST["password"];
    $keepLoggedIn = $_POST["keepLoggedIn"];

    // خواندن اطلاعات کاربران از جلسه
    $users = $_SESSION["users"];

    // بررسی مطابقت اطلاعات لاگین با اطلاعات ذخیره شده
    foreach ($users as $user) {
        if ($user['email'] == $loginEmail && $user['password'] == $loginPassword) {
            // اگر اطلاعات مطابقت داشت، اطلاعات کاربر را در کوکی‌ها ذخیره کنید
            setcookie('firstName', $user['firstName'], time() + ($keepLoggedIn * 60), "/");
            setcookie('lastName', $user['lastName'], time() + ($keepLoggedIn * 60), "/");
            setcookie('gender', $user['gender'], time() + ($keepLoggedIn * 60), "/");
            setcookie('age', $user['age'], time() + ($keepLoggedIn * 60), "/");
            setcookie('authenticated', true, time() + ($keepLoggedIn * 60), "/");
            setcookie('expiration', $keepLoggedIn, time() + ($keepLoggedIn * 60), "/"); // ذخیره طول عمر خواسته شده در کوکی
            // هدایت به صفحه بعدی یا انجام دیگر عملیات مربوطه
            header("Location: page_6.php");
            exit;
        }
    }
    // اگر اطلاعات لاگین نامعتبر بود، پیام خطا را چاپ کنید
    echo "Error: Invalid email or password";
    exit;
}
?>
