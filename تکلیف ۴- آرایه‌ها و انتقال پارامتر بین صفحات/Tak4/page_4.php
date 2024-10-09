<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="process_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder='Email' required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"  placeholder='Password'required>
            <label for="keepLoggedIn">Keep me logged-in for:</label>
            <select id="keepLoggedIn" name="keepLoggedIn">
                <option value="1">1 minute</option>
                <option value="10">10 minutes</option>
                <option value="60">1 hour</option>
            </select>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
