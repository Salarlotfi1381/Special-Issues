<html>
<head><title>تصویر خود را آپلود نمایید</title></head>
<body>
<form name="form1" method="post" action="processImg.php" enctype="multipart/form-data">
    <table border="1" cellpadding="5">
    <tr>
    <td>Image Title:</td>
    <td><input name="image_title" type="text" size="55" maxlength="255"></td>
    </tr>
    <tr>
    <td>Image Description:</td>
    <td><input name="image_description" type="text" size="55" maxlength="255"></td>
    </tr>
    <tr>
    <td>Your Avatar Image:<br><font size="-1"><em>Acceptable image formats only is JPG.</em></font></td>
    <td><input type="file" name="userAvatarImage"><input type="hidden" name="MAX_FILE1_SIZE" value="300000"></td>
    </tr>
    <tr>
    <td>Your Main Image:<br><font size="-1"><em>Acceptable image formats include JPG and PNG.</em></font></td>
        <td><input type="file" name="userMainImage"><input type="hidden" name="MAX_FILE2_SIZE" value="300000"></td>
        </tr>
    </table>
    <input type="submit" name="Submit" value="Submit">
    <input type="reset" name="Clear" value="Clear Form">
</form>
</body>
</html>