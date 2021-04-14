<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='student'))
    {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Announcements</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="ann.css">
        <link rel="stylesheet" href="side_nav.css">
    </head>
    <body>
        <?php include 'side_nav.php'; ?>
        <div class="main_container">
            <header>
            
                <h1>ANNOUNCEMENTS</h1>
            </header>
        </div>
    </body>
</html>