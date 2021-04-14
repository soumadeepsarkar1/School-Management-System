<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='student'))
    {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Student Details</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="side_nav.css">
    </head>
    <body>
        <?php include 'side_nav.php'; ?>
        <div class="main_container">
            <h2>Class Schedule</h2>
            <div>
                <?php
                    //first retrieve the class of the student
                    $sql="select class from students where user_id=".$_SESSION["user_id"];
                    $result=$conn->query($sql);
                    $row=$result->fetch_assoc();
                    $sql="select routine from class_routines where class=".$row["class"];
                    $result=$conn->query($sql);
                    $row=$result->fetch_assoc();
                    if(!empty($row["routine"]))
                    {
                        echo("<embed src=\"routines/".$row["routine"]."\" width=\"1000px\" height=\"700px\" />");
                    }
                    else
                    {
                        echo("Routine not uploaded");
                    }
                ?>
            </div>
        </div>
    </body>
</html>

