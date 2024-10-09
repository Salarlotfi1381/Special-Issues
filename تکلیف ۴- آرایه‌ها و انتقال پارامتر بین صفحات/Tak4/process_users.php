<?php
session_start(); // شروع یا ادامه‌ی جلسه

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // خواندن تعداد کاربران از جلسه
    $userCount = $_SESSION["userCount"];
    
    // آرایه‌ای برای ذخیره اطلاعات کاربران
    $users = array();

    // آرایه‌ای برای ذخیره پیغام‌های خطا برای هر فیلد
    $errors = array();

    // اعتبارسنجی و ذخیره اطلاعات برای هر کاربر
    for ($i = 1; $i <= $userCount; $i++) {
        $firstName = $_POST["firstName$i"];
        $lastName = $_POST["lastName$i"];
        $age = $_POST["age$i"];
        $gender = $_POST["gender$i"];
        $email = $_POST["email$i"];
        $password = $_POST["password$i"];

        // اعتبارسنجی اطلاعات
        if (
            ctype_upper(substr($firstName, 0, 1)) && ctype_upper(substr($lastName, 0, 1)) &&
            strlen($firstName) >= 3 && strlen($lastName) >= 3 &&
            preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)
        ) {
            // اگر اعتبارسنجی موفق بود، اطلاعات را به آرایه اضافه کنید
            $users[$email] = array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'age' => $age,
                'gender' => $gender,
                'email' => $email,
                'password' => $password
            );
        } else {
            // اگر اعتبارسنجی ناموفق بود، پیغام خطا را به آرایه اضافه کنید
            if (!ctype_upper(substr($firstName, 0, 1)) || strlen($firstName) < 3) {
                $errors[$i]['firstName'] = "First name for user $i must start with an uppercase letter and have at least 3 characters";
            }
            if (!ctype_upper(substr($lastName, 0, 1)) || strlen($lastName) < 3) {
                $errors[$i]['lastName'] = "Last name for user $i must start with an uppercase letter and have at least 3 characters";
            }
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
                $errors[$i]['password'] = "Password for user $i must contain at least one lowercase letter, one uppercase letter, one digit, and be at least 8 characters long";
            }
        }
    }

    // چاپ پیغام‌های خطا
    foreach ($errors as $index => $error) {
        if (isset($error['firstName'])) {
            echo $error['firstName'] . "<br>";
        }
        if (isset($error['lastName'])) {
            echo $error['lastName'] . "<br>";
        }
        if (isset($error['password'])) {
            echo $error['password'] . "<br>";
        }
    }

    // اگر آرایه خطاها خالی نبود، از ادامه‌ی فرآیند جلوگیری کنید
    if (!empty($errors)) {
        exit;
    }

    // ذخیره آرایه کاربران در جلسه
    $_SESSION["users"] = $users;
    
    // هدایت به صفحه بعدی یا انجام دیگر عملیات مربوطه
    header("Location: page_4.php");
    exit;
}
?>
