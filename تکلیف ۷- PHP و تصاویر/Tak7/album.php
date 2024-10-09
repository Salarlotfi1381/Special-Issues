<?php
try {
    $pdoObj = new PDO("mysql:host=localhost;dbname=gallery;charset=utf8", 'root', '');
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // بررسی وجود کلید 'orderby' و تنظیم مقدار پیش‌فرض در صورت عدم وجود
    $orderby = isset($_GET["orderby"]) ? $_GET["orderby"] : "image_date";
    // مجاز بودن مقادیر برای 'orderby' جهت جلوگیری از تزریق SQL
    $validOrderBy = ["image_date", "image_views"];
    if (!in_array($orderby, $validOrderBy)) {
        $orderby = "image_date";
    }

    $select = "SELECT * FROM images ORDER BY $orderby DESC";
    $album = $pdoObj->query($select);
    $row = $album->fetchAll();
    $cl = 3;
    $c = 0;

    echo "<table border=\"1px\">";
    echo "<tr>
            <th>مرتب بر اساس:</th>
            <th><a href=\"album.php?orderby=image_date\">تاریخ درج</a></th>
            <th><a href=\"album.php?orderby=image_views\">تعداد بازدید</a></th>
          </tr>";

    for ($j = 1; $j <= ceil($album->rowCount() / $cl); $j++) {
        echo "<tr>";
        if ($album->rowCount() % $cl > 0 && $j == ceil($album->rowCount() / $cl)) {
            for ($i = 1; $i <= $album->rowCount() % $cl; $i++) {
                echo "<td><center>" . htmlspecialchars($row[$c]["image_title"]) . "</center>
                      <a href=\"imageDetails.php?image_id=" . htmlspecialchars($row[$c]["image_id"]) . "\">
                      <img width=\"250\" height=\"150\" src=\"" . htmlspecialchars($row[$c]["image_main_url"]) . "\"/></a></td>";
                $c += 1;
            }
        } else {
            for ($i = 1; $i <= $cl; $i++) {
                echo "<td><center>" . htmlspecialchars($row[$c]["image_title"]) . "</center>
                      <a href=\"imageDetails.php?image_id=" . htmlspecialchars($row[$c]["image_id"]) . "\">
                      <img width=\"250\" height=\"150\" src=\"" . htmlspecialchars($row[$c]["image_main_url"]) . "\"/></a></td>";
                $c += 1;
            }
        }
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<a href=\"album.php\">Reload</a>";
    exit();
}
?>

<html>
<head>
    <title>آلبوم شما</title>
</head>
<body dir="rtl">
<a href="imageForm.php">برگشت به صفحه آپلود</a>
<br>
</body>
</html>
