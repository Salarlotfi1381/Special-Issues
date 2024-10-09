<?php
// new_post.php

// شروع session
session_start();

// بررسی آیا کاربر لاگین کرده است یا نه
if(!isset($_SESSION['email'])) {
    // اگر کاربر لاگین نکرده بود، به صفحه ورود هدایت کنید
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ایجاد دسته‌بندی جدید</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>ایجاد دسته‌بندی جدید</h2>
    <form action="new_category_process.php" method="post">
        <label for="category_title">عنوان دسته‌بندی:</label><br>
        <input type="text" id="category_title" name="category_title"><br><br>
        <input type="submit" value="ایجاد دسته‌بندی">
    </form>
</body>
</html>
