<?php 
    session_start();
    include 'connection.php';
    if(!isset($_SESSION["username"]))
    {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>School Management System</title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            $firstNameErr = $lastNameErr =$passwordErr=$password1Err=$password2Err="";
            $firstName = $lastName = $password1=$password2= "";

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (empty($_POST["fname"])) 
                {
                    $firstNameErr = "First name is required";
                } 
                else 
                {
                    $firstName = test_input($_POST["fname"]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName)) 
                    {
                        $fistNameErr = "Only letters and white space allowed";
                    }
                }
                if (empty($_POST["lname"])) 
                {
                    $lastNameErr = "Last name is required";
                } 
                else 
                {
                    $lastName = test_input($_POST["lname"]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastName)) 
                    {
                        $lastNameErr = "Only letters and white space allowed";
                    }
                }
                /* if (empty($_POST["uname"])) 
                {
                    $userNameErr = "User name is required";
                }
                elseif($conn->query("select username from users where username='".$_POST["uname"]."';")->num_rows>0)
                {
                    $userNameErr = "User name is already taken";
                }
                else 
                {
                    $userName = test_input($_POST["uname"]);
                } */
                if (empty($_POST["password1"])) 
                {
                    $password1Err = "Password is required";
                } 
                else
                {
                    $password1 = $_POST["password1"];
                }
                if (empty($_POST["password2"])) 
                {
                    $password2Err = "Password is required";
                } 
                else 
                {
                    $password2 = $_POST["password2"];
                }
                if($password1!="" && $password2!="" && $password1!=$password2)
                {
                    $passwordErr="Passwords must match";
                }
                if($firstNameErr=="" && $lastNameErr =="" && $password1Err=="" && $password2Err=="" && $passwordErr=="")
                {
                    $sql = "UPDATE users SET first_name='".$firstName."',last_name='".$lastName."',password='".$password1."' where user_id='".$_POST["user_id"]."';";
                    if ($conn->query($sql) === TRUE)
                    {
                        echo "Details updated successfully";
                    }
                    else
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $sql = "select * from users where username='".$_SESSION["username"]."' and usertype='".$_SESSION["usertype"]."';";
            #echo($sql);
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>
        <h2>Edit Admin details</h2><br>
        <div><h4>User id = <?php echo($row["user_id"]);?><h4></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="fname">First name:</label><br>
            <input type="text" id="fname" name="fname" value="<?php echo($row["first_name"]);?>" required><span class="error">* <?php echo $firstNameErr;?></span><br>
            <label for="lname">Last name:</label><br>
            <input type="text" id="lname" name="lname" value="<?php echo($row["last_name"]);?>" required><span class="error">* <?php echo $lastNameErr;?></span><br>
            <div>Username: <?php echo($row["username"]);?> (cannot be changed)</div>
            <label for="password1">Password:</label><br>
            <input type="password" id="password1" name="password1" required><span class="error">* <?php echo $password1Err;?></span><br>
            <label for="password2">Confirm password:</label><br>
            <input type="password" id="password2" name="password2" required><span class="error">* <?php echo $password2Err;?></span><br>
            <span class="error"><?php echo $passwordErr;?><br>
            <input type="hidden" name="user_id" value="<?php echo($row["user_id"]);?>">
            <input type="submit"><br>
            <a href="admin.php"><< Back to admin panel</a>
        </form>