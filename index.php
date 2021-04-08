<?php include 'connection.php';?>
<!DOCTYPE html>
<html>
    <head>
        <title>School Management System</title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <form action="" method="post">
            Username: <input type="text" name="name"><br>
            Password: <input type="text" name="email"><br>
            <form>
                <input type="radio" id="userType" name="userType" value="admin">
                <label for="other">Admin</label>
                <input type="radio" id="userType" name="userType" value="male">
                <label for="male">Male</label>
                <input type="radio" id="userType" name="userType" value="female">
                <label for="female">Female</label>
                <input type="submit">
            </form>
        </form>
    </body>
</html>