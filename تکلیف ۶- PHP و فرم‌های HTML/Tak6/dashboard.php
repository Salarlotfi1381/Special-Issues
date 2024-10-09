<?php
// control_panel.php

// شروع session
session_start();

// بررسی آیا کاربر لاگین کرده است یا نه
if(isset($_SESSION['email'])) {
    // اگر لاگین کرده بود، اجازه دسترسی به صفحه را بدهید
    // در اینجا محتویات صفحه کنترل پنل کاربر را قرار دهید
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>کنترل پنل کاربر</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                padding: 20px;
            }

            h2 {
                color: #333;
            }

            ul {
                list-style-type: none;
                padding: 0;
            }

            li {
                margin-bottom: 10px;
                background-color: #fff;
                border-radius: 5px;
                padding: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            li a {
                color: #007bff;
                text-decoration: none;
            }

            li a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <h2>پنل کاربر</h2>
        <ul>
            <li><a href="new_category.php">ایجاد دسته‌بندی جدید</a></li>
            <li><a href="new_post.php">ایجاد پست جدید</a></li>
            <li><a href="logout.php">خروج</a></li>
        </ul>
    </body>
    </html>
    <?php
} else {
    // اگر کاربر لاگین نکرده بود، به صفحه ورود هدایت کنید
    header("Location: login.php");
    exit();
}
?>
