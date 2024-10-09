<?php
session_start(); // شروع یا ادامه‌ی جلسه

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // اطلاعات ورودی از فرم بخش ۱
    $userCount = $_POST["userCount"];

    // ذخیره‌ی تعداد کاربران در جلسه
    $_SESSION["userCount"] = $userCount;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form - Part 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <form action="process_users.php" method="POST">
            <?php
            // نمایش فرم بخش ۲ بر اساس تعداد کاربران
            for ($i = 1; $i <= $userCount; $i++) {
                echo "<h2>User $i</h2>";
                echo "<label for='firstName$i'>First Name:</label>";
                echo "<input type='text' id='firstName$i' name='firstName$i' placeholder='FirstName$i' required><br>";
                echo "<label for='lastName$i'>Last Name:</label>";
                echo "<input type='text' id='lastName$i' name='lastName$i' placeholder='LastName$i' required><br>";
                echo "<label for='age$i'>Age:</label>";
                echo "<input type='number' id='age$i' name='age$i' placeholder='age$i' required><br>";

                echo "<div class='gender'>";
                echo "<label >Gender:</label>";
                echo "<br>";
                echo "<label ><input type='radio' name='gender$i' value='male'> Male</label>";
                echo "<label ><input type='radio' name='gender$i' value='female'> Female</label><br>";
                echo "</div>";
                echo "<br>";
                echo "<label for='email$i'>Email:</label>";
                echo "<input type='email' id='email$i' name='email$i' placeholder='Email$i' required><br>";
                echo "<label for='password$i'>Password:</label>";
                echo "<input type='password' id='password$i' name='password$i' placeholder='Password$i' required><br><br>";
            }
            ?>
            <button type="submit">Submit</button>
        </form>

    </div>

</body>
</html>




