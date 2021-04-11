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
        <style>
            input[type="text"],
            input[type="number"],
            input[type="date"],
            input[type="email"],
            input[type="password"],
            textarea,
            select {
                background: rgba(19, 2, 2, 0.1);
                border: none;
                font-size: 16px;
                height: auto;
                margin: 0;
                outline: 0;
                padding: 15px;
                width: 100%;
                background-color: #e8eeef;
                color: #01090f;
                box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
                margin-bottom: 30px;
            }
            </style>
    </head>
    <body>
        <?php include 'side_nav.php'; ?>
        <?php
            $nameErr=$passwordErr=$password1Err=$password2Err="";
            $name = $lastName = $password1=$password2= "";

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
                if($nameErr==""  && $password1Err=="" && $password2Err=="" && $passwordErr=="")
                {
                    $sql = "UPDATE users SET name='".$name."',password='".$password1."' where user_id='".$_POST["user_id"]."';";
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
        <form action="" method="post">

            <h1>Change password</h1>
            <fieldset>
                <label for="password">Original password :</label>
                <input type="password" name="Opassword">
                <br>
                <br>
                <label for="password">New password :</label>
                <input type="password" name="password1">
                <br>
                <br>
                <label for="password">Confirm password :</label>
                <input type="password" name="password2">
            </fieldset>
            <button type="Submit">Submit</button>
        </form>
    </body>
</html>