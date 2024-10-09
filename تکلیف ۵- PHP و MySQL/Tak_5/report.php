<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        p {
            margin-bottom: 10px;
        }
        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
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

        // بررسی آیا آیدی آگهی ارسال شده از طریق URL معتبر است یا نه
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $ad_id = $_GET['id'];

            // دریافت اطلاعات آگهی
            $sql = "SELECT * FROM ads WHERE id = $ad_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $ad = $result->fetch_assoc();
                $user_id = $ad['user_id'];

                // دریافت اطلاعات کاربر صاحب آگهی
                $sql_user = "SELECT * FROM users WHERE id = $user_id";
                $result_user = $conn->query($sql_user);
                $user = $result_user->fetch_assoc();

                // دریافت تعداد گزارش‌های کاربر
                $sql_report_count = "SELECT report_count FROM users WHERE id = $user_id";
                $result_report_count = $conn->query($sql_report_count);
                $report_count = $result_report_count->fetch_assoc()['report_count'];

                // نمایش اطلاعات آگهی و کاربر صاحب آن و تعداد گزارش‌های کاربر
                echo "<h2>Ad Information</h2>";
                echo "<p><strong>Title:</strong> " . $ad['title'] . "</p>";
                echo "<p><strong>Description:</strong> " . $ad['description'] . "</p>";
                echo "<p><strong>Price:</strong> " . $ad['price'] . "</p>";
                echo "<p><strong>City:</strong> " . $ad['city'] . "</p>";
                echo "<p><strong>Creation Time:</strong> " . $ad['creation_time'] . "</p>";
                echo "<p><strong>Report Count:</strong> " . $ad['report_count'] . "</p>";
                echo "<h2>User Information</h2>";
                echo "<p><strong>Name:</strong> " . $user['first_name'] . " " . $user['last_name'] . "</p>";
                echo "<p><strong>Email:</strong> " . $user['email'] . "</p>";
                echo "<p><strong>Phone Number:</strong> " . $user['phone_number'] . "</p>";
                

                // افزایش تعداد گزارش آگهی
                $sql_update = "UPDATE ads SET report_count = report_count + 1 WHERE id = $ad_id";
                $conn->query($sql_update);

            } else {
                echo "Ad not found";
            }
        } else {
            echo "Invalid ad ID";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
