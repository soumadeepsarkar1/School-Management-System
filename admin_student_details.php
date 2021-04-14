<?php 
    session_start();
    include 'connection.php';
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
        <style>
            .card
            {
                box-shadow :0 4px 8px 0 rgba(0, 0, 0, 0.2);
                max-width : 60%;
                margin:auto;
                text-align :left;
                font-family :"Lucida Console";
                background :#e6ffff;
                padding-left :5%;
                color : Blue;
                box-shadow : 10px 10px 5px #aaaaaa;
            }
        </style>
    </head>
    <body>
        <?php include('admin_header.php');?>
        <a href="admin_students.php"><< Back to students</a>
        <div class="main_container">
            <?php
                $sql="select * from (select user_id, name from users where user_id=". $_GET["user_id"].") as u natural join (select * from students where user_id=". $_GET["user_id"].") as s order by class,name;";
                $result=$conn->query($sql);

            //if($result->num_rows > 0) {
                //echo "NAME<br>CLASS<br>ROLL NO.<br>DATE OF BIRTH<br>GENDER<br>";
                //output data of each row

                
                $row = $result->fetch_assoc() 
            ?>
            <div class="card">
                <div id = "student_image" style="height:50%;width:35%;float:right;border :2px solid blue;padding : 10px;box-shadow :10px 10px 5px #aaaaaa;">
                <?php
                    if(empty($row["image"]))
                    {
                        echo('Image not uploaded');
                    }
                    else
                    {
                        echo("<img src = \"student_images\\".$row["image"]."\" style=\"width:100%;\">");
                    }
                ?>
                </div>      
                <br>
                <h3>User id : <?php echo $row["user_id"]; ?></h3>
                <h3>Name : <?php echo $row["name"]; ?></h3>
                <h3>Class : <?php echo $row["class"]; ?></h3>
                <h3>Roll No. : <?php echo $row["rollNo"]; ?></h3>
                <h3>Admission no. : <?php echo $row["admissionNo"]; ?></h3>
                <h3>Admission date : <?php echo $row["admissionDate"]; ?></h3>
                <h3>Date of Birth : <?php echo $row["DOB"]; ?></h3>
                <h3>Gender : <?php echo $row["gender"]; ?></h3>
                <h3>Email Id. : <?php echo $row["email"]; ?></h3>
                <h3>Permanent address : <?php echo $row["address"]; ?></h3>
                <h3>Mother's name : <?php echo $row["mother"]; ?></h3>
                <h3>Father's name : <?php echo $row["father"]; ?></h3><br>
            </div>
        </div>