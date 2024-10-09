<?php
    //make variables available
    $image_title = $_POST['image_title'];
    $image_description = $_POST['image_description'];

    if((isset($_FILES['userAvatarImage']) and $_FILES['userAvatarImage']['size']>0) and (isset($_FILES['userMainImage']) and $_FILES['userMainImage']['size']>0)){
        list($width_Avatar, $height_Avatar, $type_Avatar, $attr_Avatar) = getimagesize($_FILES['userAvatarImage']['tmp_name']);
        list($width_Main, $height_Main, $type_Main, $attr_Main) = getimagesize($_FILES['userMainImage']['tmp_name']);

        if(($width_Main < 500 || $width_Main > 1500) || ($height_Main < 300 || $height_Main > 900)){
            echo "Sorry, Your main image size must be at least 500x300!<br>";
            echo "<a href=\"imageForm.php\">Try Again</a>";
            exit();
        }

        $validMimeTypes_Avatar = array('image/jpg', 'image/jpeg');
        $validFileExt_Avatar = array('.jpg', '.jpg');
        $validMimeTypes_Main = array('image/jpg', 'image/jpeg', 'image/png');
        $validFileExt_Main = array('.jpg', '.jpg', '.png');
        //Instantiate a finfo Object for checking MIME type
        $file_info = new finfo(FILEINFO_MIME_TYPE);
        //Reading entire file into a string
        $binaryFileStr_Avatar = file_get_contents($_FILES['userAvatarImage']['tmp_name']);
        $binaryFileStr_Main = file_get_contents($_FILES['userMainImage']['tmp_name']);
        //Get Information about a string buffer
        $mime_type_Avatar = $file_info->buffer($binaryFileStr_Avatar);
        $mime_type_Main = $file_info->buffer($binaryFileStr_Main);
        //Serach file MIME type in our valid types
        $fileExtIndex_Avatar = array_search(strtolower($mime_type_Avatar), $validMimeTypes_Avatar);
        $fileExtIndex_Main = array_search(strtolower($mime_type_Main), $validMimeTypes_Main);
        //Check if file has a valid type or not
        if($fileExtIndex_Avatar != false){
            $ext_Avatar = $validFileExt_Avatar[$fileExtIndex_Avatar];
        }else{
            echo "<br>Sorry, Your avatar image file was not JPG file!<br>";
            echo "<a href=\"imageForm.php\">Try Again</a>";
            exit();
        }

        if($fileExtIndex_Main != false){
            $ext_Main = $validFileExt_Main[$fileExtIndex_Main];
        }else{
            echo "Sorry, Your main image was not JPG or PNG file!<br>";
            echo "<a href=\"imageForm.php\">Try Again</a>";
            exit();
        }

        // Avatar image
        $ImageDir_Avatar = "temp_avatarImages/";
        $imageName_Avatar = $_FILES['userAvatarImage']['name'];
        $tmpImageUrl_Avatar = $ImageDir_Avatar . $imageName_Avatar;
        $moveOperation_Avatar = move_uploaded_file($_FILES['userAvatarImage']['tmp_name'], $tmpImageUrl_Avatar);

        // Main image
        $ImageDir_Main = "temp_mainImages/";
        $imageName_Main = $_FILES['userMainImage']['name'];
        $tmpImageUrl_Main = $ImageDir_Main . $imageName_Main;
        $moveOperation_Main = move_uploaded_file($_FILES['userMainImage']['tmp_name'], $tmpImageUrl_Main);

        if($moveOperation_Avatar != true or $moveOperation_Main != true){
            echo "<br>File Submission Error!<br>";
            echo "<a href=\"imageForm.php\">Try Again</a>";
            exit();
        }

        try{
            $pdoObj = new PDO("mysql:host=localhost;dbname=gallery;charset=utf8", 'root', '');
            $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $insert = "INSERT INTO images
            (image_title, image_description, image_date)
            VALUES (?, ?, ?)";
            $insertStmnt = $pdoObj->prepare($insert);
            $insertStmnt->execute([$image_title, $image_description, date("Y-m-d H:i:s")]); // Corrected the date format

            $picId = $pdoObj->lastInsertId();
            $uniqueFileName_Avatar = bin2hex(random_bytes(10)).$picId.$ext_Avatar;
            $uniqueFileName_Main = bin2hex(random_bytes(10)).$picId.$ext_Main;
            $imageUrl_Avatar = "avatarImages/" . $uniqueFileName_Avatar;
            $imageUrl_Main = "mainImages/" . $uniqueFileName_Main;
            $renameOp_Avatar = rename($tmpImageUrl_Avatar, $imageUrl_Avatar);
            $renameOp_Main = rename($tmpImageUrl_Main, $imageUrl_Main);

            // Modify main image
            $src_avatarImage = imagecreatefromjpeg($imageUrl_Avatar);
            list($srcW, $srcH) = getimagesize($imageUrl_Avatar);
            $dstW = 70; $dstH = 100;
            $dst_avatarImage = imagecreatetruecolor($dstW, $dstH);
            Imagecopyresampled($dst_avatarImage, $src_avatarImage, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
    
            imagefilter($dst_avatarImage, IMG_FILTER_GRAYSCALE);

            if($ext_Main == '.png'){ $src_mainImage = imagecreatefrompng($imageUrl_Main); } else { $src_mainImage = imagecreatefromjpeg($imageUrl_Main); }
            list($src_w, $src_h) = getimagesize($imageUrl_Main);
            $dst_w = 1000; $dst_h = 600; // New dimensions for main image
            $dst_mainImage = imagecreatetruecolor($dst_w, $dst_h);
            Imagecopyresampled($dst_mainImage, $src_mainImage, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h); // Resize main image

            $src_x = $src_y = 0;
            $dst_x = $dst_w - $dstW; $dst_y = $dst_h - $dstH;
            $pct = 100;
            imagecopymerge($dst_mainImage, $dst_avatarImage, $dst_x, $dst_y, $src_x, $src_y, $dstW, $dstH, $pct);
            
            $imagePath = "Images/".$picId."_IMG".$ext_Main;
            if($ext_Main == '.png'){ imagepng($dst_mainImage, $imagePath); } else { imagejpeg($dst_mainImage, $imagePath); }

            if($renameOp_Main == true and $renameOp_Avatar == true){
                $update = "UPDATE images SET image_main_url = '$imagePath', image_avatar_url = '$imageUrl_Avatar'
                WHERE image_id = $picId";
                $pdoObj->query($update);
            } else{
                echo "<br>File RENAME Error!<br>";
                echo "<a href=\"imageForm.php\">Try Again</a>";
                exit();
            }

        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            echo "<a href=\"imageForm.php\">Try Again</a>";
            exit();
        }

    } else{
        echo "<br>Submission Error!<br>";
        echo "<a href=\"imageForm.php\">Try Again</a>";
        exit();
    }
    echo "<br>Your image file uploaded!";
    echo "<br><a href=\"album.php\">مشاهده آلبوم</a><br>";
?>

<html>
<head>
    <title>وضعیت آپلود</title>
</head>
<body>
</body>
</html>
