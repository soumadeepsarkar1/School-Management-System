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
    </head>
    <body>
        <?php include('admin_header.php');?>
        <section>
            <?php
                $nameErr = $userNameErr=$passwordErr=$password1Err=$password2Err="";
                $name = $userName = $password1=$password2= "";

                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    if (empty($_POST["name"])) 
                    {
                        $nameErr = "Name is required";
                    } 
                    else 
                    {
                        $name = test_input($_POST["name"]);
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) 
                        {
                            $nameErr = "Only letters and white space allowed";
                        }
                    }
                    if (empty($_POST["uname"])) 
                    {
                        $userNameErr = "User name is required";
                    }
                    elseif($conn->query("select username from users where username='".$_POST["uname"]."' and usertype='admin';")->num_rows>0)
                    {
                        $userNameErr = "User name is already taken";
                    }
                    else 
                    {
                        $userName = test_input($_POST["uname"]);
                    }
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
                    if($nameErr=="" && $userNameErr=="" && $password1Err=="" && $password2Err=="" && $passwordErr=="")
                    {
                        $sql = "INSERT INTO users (name,username,usertype,password) VALUES ('".$name."', '".$userName."','admin', '".$password1."');";
                        if ($conn->query($sql) === TRUE)
                        {
                            echo "New record created successfully";
                        }
                        else
                        {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    /* if (empty($_POST["email"])) 
                    {
                        $emailErr = "Email is required";
                    }
                    else
                    {
                        $email = test_input($_POST["email"]);
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailErr = "Invalid email format";
                        }
                    } 
                    if (empty($_POST["comment"])) {
                    $comment = "";
                    } else {
                    $comment = test_input($_POST["comment"]);
                    }

                    if (empty($_POST["gender"])) {
                    $genderErr = "Gender is required";
                    } else {
                    $gender = test_input($_POST["gender"]);
                    }*/       
                }
                function test_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
            ?>
            <a href="admin.php"><< Back to admin panel</a>
            <h2>Admin Creation</h2><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><span class="error">* <?php echo $nameErr;?></span><br>
                <label for="uname">Username:</label><br>
                <input type="text" id="uname" name="uname" required><span class="error">* <?php echo $userNameErr;?></span><br>
                <label for="password1">Password:</label><br>
                <input type="password" id="password1" name="password1" required><span class="error">* <?php echo $password1Err;?></span><br>
                <label for="password2">Confirm password:</label><br>
                <input type="password" id="password2" name="password2" required><span class="error">* <?php echo $password2Err;?></span><br>
                <span class="error"><?php echo $passwordErr;?><br>
                <input type="submit"><br>
            </form>
        </section>
        <footer>
            <div>
                Created by Soumadeep Sarkar, Soumya Bhattacharjee and Sohini Dutta
            </div>
        </footer>
    </body>
</html>