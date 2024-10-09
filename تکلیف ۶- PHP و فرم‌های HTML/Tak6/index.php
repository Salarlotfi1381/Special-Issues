<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه اصلی</title>
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
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 3px;
        }
        a:hover {
            background-color: #007bff;
            color: #fff;
        }
        p {
            color: #555;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        li a {
            color: #333;
            text-decoration: none;
        }
        li a:hover {
            text-decoration: underline;
        }
        .welcome {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .dashboard-link {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>به وبلاگ خوش آمدید!</h1>
    
    <!-- لینک به صفحه ورود -->
    <a href="login.php">ورود</a>
    
    <!-- لینک به صفحه ثبت نام -->
    <a href="register.php">ثبت نام</a>
    
    <!-- اگر کاربر لاگین کرده باشد، نمایش پیام خوش‌آمدگویی و لینک به کنترل پنل -->
    <?php
    session_start();
    if (isset($_SESSION['email'])) {
        // بررسی وجود مقادیر "first_name" و "last_name"
        $welcome_message = isset($_SESSION['first_name']) && isset($_SESSION['last_name']) ? "خوش آمدید، " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "!" : "خوش آمدید!";
        echo "<p class='welcome'>$welcome_message</p>";
        echo "<a href='dashboard.php' class='dashboard-link'>کنترل پنل کاربر</a>";
    }
    ?>

    <!-- نمایش دسته‌بندی‌های موضوعی -->
    <?php
    // اتصال به دیتابیس و دریافت دسته‌بندی‌ها
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Webds";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>دسته‌بندی‌ها:</h2>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><a href='view_category.php?category_id=" . $row['category_id'] . "'>" . $row["title"] . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>هیچ دسته‌بندی‌ای یافت نشد.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
