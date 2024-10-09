<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <?php
            // بازیابی اطلاعات از کوکی‌ها
            $firstName = $_COOKIE['firstName'];
            $lastName = $_COOKIE['lastName'];
            $gender = $_COOKIE['gender'];
            $age = $_COOKIE['age'];
            $authenticated = $_COOKIE['authenticated'];
            $expiration = $_COOKIE['expiration']; // بازیابی طول عمر خواسته شده

            // نمایش اطلاعات کاربر
            echo "<p><strong>First Name:</strong> $firstName</p>";
            echo "<p><strong>Last Name:</strong> $lastName</p>";
            echo "<p><strong>Gender:</strong> $gender</p>";
            echo "<p><strong>Age:</strong> $age</p>";
            echo "<p><strong>Authenticated:</strong> " . ($authenticated ? 'Yes' : 'No') . "</p>";
            echo "<p><strong>Expiration:</strong> $expiration minutes</p>"; // نمایش طول عمر خواسته شده
            ?>
        </div>
    </div>
</body>
</html>
