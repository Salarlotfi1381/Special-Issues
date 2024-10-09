<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        
        h2 {
            color: #333;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>ثبت نام</h2>
    <form action="register_process.php" method="post">
        <label for="first_name">نام:</label><br>
        <input type="text" id="first_name" name="first_name"><br>
        <label for="last_name">نام خانوادگی:</label><br>
        <input type="text" id="last_name" name="last_name"><br>
        <label for="email">ایمیل:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="password">رمز عبور:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="ثبت نام">
    </form>
</body>
</html>
