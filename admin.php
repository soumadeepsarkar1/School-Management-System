<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='admin'))
    {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>School Management System</title>
        <link rel="stylesheet" href="style1.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div><div>Hello, <?php echo($_SESSION["username"]);?></div><a href ='logout.php'>Log out</a></div>
        <div><a href ='admin_teachers.php'>Teachers</a></div>
        <div><a href ='admin_students.php'>Students</a></div>
        <div><a href ='admin_class_routine.php'>Class routine</a></div>
        <div><a href ='admin_edit.php'>Edit admin details</a></div>
        <div><a href ='admin_create.php'>Add a new admin</a></div>
    </body>
</html>