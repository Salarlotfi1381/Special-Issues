<?php
try{
    $pdoObj=new PDO("mysql:host=localhost;charset=utf8",'root','');
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbName = "gallery";
    $dbQuery= "CREATE DATABASE IF NOT EXISTS ".$dbName.
    " DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci;";
    $pdoObj->query($dbQuery);
    $pdoObj->query("use `$dbName`;");

    // create images table
    $tableQ = "CREATE TABLE IF NOT EXISTS images (
    image_id INT(11) NOT NULL AUTO_INCREMENT,
    image_title VARCHAR(255) NOT NULL,
    image_description VARCHAR(255) NOT NULL,
    image_views INT(10) DEFAULT 0,
    image_date DATETIME NOT NULL,
    image_main_url VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_persian_ci,
    image_avatar_url VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_persian_ci,
    PRIMARY KEY (image_id)
    )";
    $pdoObj->query($tableQ);
    echo "gallery Database and images table successfully created.";
} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
} 
?>