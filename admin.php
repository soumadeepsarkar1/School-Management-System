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
        <?php include('admin_header.php');?>
        <div class="flex-container pill_button_group">
            <div class="pill_button_row">
                <a class="pill_button" href ='admin_teachers.php'>Teachers</a>
                <a class="pill_button" href ='admin_students.php'>Students</a>
            </div>
            <div class="pill_button_row">
                <a class="pill_button" href ='admin_class_routine.php'>Class routine</a>
                <a class="pill_button" href ='admin_edit.php'>Edit admin details</a>
            </div>
            <div class="pill_button_row">
                <a class="pill_button" href ='admin_create.php'>Add a new admin</a>
                <a class="pill_button" href ="admin_fees.php">Fees details</a>
            </div>
        </div>
        <footer>
            <div>
                Created by Soumadeep Sarkar, Soumya Bhattacharjee and Sohini Dutta
            </div>
        </footer>
    </body>
</html>