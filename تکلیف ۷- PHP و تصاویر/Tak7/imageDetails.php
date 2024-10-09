<?php
try {
    $pdoObj = new PDO("mysql:host=localhost;dbname=gallery;charset=utf8", 'root', '');
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // بررسی وجود کلید 'image_id'
    if (!isset($_GET["image_id"])) {
        echo "Invalid image ID.";
        echo "<a href=\"album.php\">Go to the album page</a>";
        exit();
    }

    $img_id = $_GET["image_id"];

    // استفاده از prepared statement برای جلوگیری از SQL injection
    $select = $pdoObj->prepare("SELECT * FROM images WHERE image_id = :img_id");
    $select->bindParam(':img_id', $img_id, PDO::PARAM_INT);
    $select->execute();
    $image = $select->fetchAll();

    // بررسی وجود تصویر
    if (empty($image)) {
        echo "Image not found.";
        echo "<a href=\"album.php\">Go to the album page</a>";
        exit();
    }

    // بروزرسانی تعداد بازدید
    $update = $pdoObj->prepare("UPDATE images SET image_views = image_views + 1 WHERE image_id = :img_id");
    $update->bindParam(':img_id', $img_id, PDO::PARAM_INT);
    $update->execute();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<a href=\"album.php\">Go to the album page</a>";
    exit();
}
?>
<html>
<head>
    <title><?php echo htmlspecialchars($image[0]["image_title"]); ?></title>
</head>
<body dir="rtl">
<a href="album.php">برگشت به آلبوم</a>
<br>
<strong>عنوان تصویر: <?php echo htmlspecialchars($image[0]["image_title"]); ?></strong>
<br>
<strong>توضیحات تصویر: <?php echo htmlspecialchars($image[0]["image_description"]); ?></strong>
<br>
<strong>تاریخ درج: <?php echo htmlspecialchars($image[0]["image_date"]); ?></strong>
<br>
<strong>تعداد بازدید: <?php echo htmlspecialchars($image[0]["image_views"]); ?></strong>
<br>
<br>
<br>
<strong>تصویر کاربر : </strong>
<img src="<?php echo htmlspecialchars($image[0]["image_avatar_url"]); ?>" />
<br>
<br>
<br>
<strong>تصویر اصلی : </strong>
<br>
<img src="<?php echo htmlspecialchars($image[0]["image_main_url"]); ?>" />
</body>
</html>
