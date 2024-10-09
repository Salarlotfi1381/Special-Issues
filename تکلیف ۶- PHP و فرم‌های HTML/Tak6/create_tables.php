<?php
$servername = "localhost";
$username = "root";
$password = "";

// اتصال به MySQL بدون انتخاب پایگاه داده
$conn = new mysqli($servername, $username, $password);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// نام پایگاه داده
$dbname = "Webds";

// چک کردن وجود فایل نشانه‌گذاری
$markerFilePath = "database_created.marker";
$databaseCreated = file_exists($markerFilePath);

// اگر پایگاه داده ایجاد نشده است، پایگاه داده را ایجاد کنید
if (!$databaseCreated) {
    // دستور SQL برای ایجاد پایگاه داده
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    // اجرای دستور SQL
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully<br>";
        // ایجاد فایل نشانه‌گذاری
        fopen($markerFilePath, "w");
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }
}

// انتخاب پایگاه داده جدید
$conn->select_db($dbname);

// چک کردن وجود جداول
$tablesExist = false;
$result = $conn->query("SHOW TABLES");
if ($result->num_rows > 0) {
    $tablesExist = true;
}

// اگر جداول وجود ندارند، آن‌ها را ایجاد کنید
if (!$tablesExist) {
    // دستورات SQL برای ایجاد جداول
    $sql = "
    CREATE TABLE users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(100) NOT NULL
    );

    CREATE TABLE posts (
        post_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        image_url VARCHAR(255),
        post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    );

    CREATE TABLE categories (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL
    );

    CREATE TABLE post_category (
        post_id INT,
        category_id INT,
        PRIMARY KEY (post_id, category_id),
        FOREIGN KEY (post_id) REFERENCES posts(post_id),
        FOREIGN KEY (category_id) REFERENCES categories(category_id)
    );
    ";

    // اجرای دستورات SQL
    if ($conn->multi_query($sql) === TRUE) {
        echo "Tables created successfully";
    } else {
        echo "Error creating tables: " . $conn->error;
    }
} else {
    echo "Tables already exist";
}

// بستن اتصال
$conn->close();
?>
