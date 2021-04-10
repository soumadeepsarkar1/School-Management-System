<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!isset($_SESSION["username"]) && $_SESSION["usertype"]!='admin')
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
        <form action="" method="post">

            <h1>Edit Student Details</h1>

            <fieldset>
                <legend><span class="number">1</span>Your Profile</legend>

                <label for="name">Name :</label>
                <input type="text" name="user_name">
                <br>
                <br>
                <label for="class">Class :</label>
                <input type="number" name="user_class" min="1" max="10">
                <br>
                <br>
                <label for="rollnumber">Roll Number :</label>
                <input type="number" name="user_rollno">
                <br>
                <br>
                <label>Gender :</label>
                <input type="radio" name="gender" value="male"><label for="male" class="light">Boy</label><br>
                <input type="radio" name="gender" value="female"><label for="female" class="light">Girl</label><br>
                <input type="radio" name="gender" value="other"><label for="other" class="light">Other</label>
                <br>
                <br>
                <label>Mobile Number :</label>
                <input type="number" name="user_no">
                <br>
                <br>
                <label>Email ID :</label>
                <input type="email" name="user_email">
                <br>
                <br>
                <br>
                <label>Address :</label>
                <input type="text" name="user_addr">
                <br>
                <br>
                <label>Mother's Name :</label>
                <input type="text" name="user_mom">
                <br>
                <br>
                <label>Father's Name :</label>
                <input type="text" name="user_papa">
                <br>
                <br>
                <label>Date of Birth :</label>
                <input type="date" name="user_birth">
                <br>
                <br>
                <br>
                <label>Admission Date :</label>
                <input type="date" name="user_adms">
                <br>
                <br>
                <label>Admission Number :</label>
                <input type="number" name="adms_no">


            </fieldset>
            
            <button type="Submit">Submit Details</button>

        </form>
        
        <script src="" async defer></script>
    </body>
</html>