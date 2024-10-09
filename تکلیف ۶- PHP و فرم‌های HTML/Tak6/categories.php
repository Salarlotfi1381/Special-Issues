<?php



// اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Webds";
$conn = new mysqli($servername, $username, $password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// کوئری برای دریافت تمام category_id های موجود
$query = "SELECT category_id FROM categories";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // نمایش تمام category_id های موجود
    while($row = $result->fetch_assoc()) {
        echo "category_id: " . $row["category_id"] . "<br>";
    }
} else {
    echo "هیچ دسته‌بندی وجود ندارد.";
}

// بستن اتصال به دیتابیس
$conn->close();

?>