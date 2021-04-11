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
        <title>Student Details</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="side_nav.css">
        <style>
            .error {color: #FF0000;}
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
                width: 95%;
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
            $originalPasswordErr=$passwordErr=$password1Err=$password2Err="";
            $password1=$password2= "";

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $sql = "select password from users where username='".$_SESSION["username"]."' and usertype='".$_SESSION["usertype"]."';";
                #echo($sql);
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if(empty($_POST["originalPassword"]))
                {
                    $originalPasswordErr="Original password is required";
                }
                elseif($row["password"]!=$_POST["originalPassword"])
                {
                    $originalPasswordErr="Incorrect password";
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
                if($password1Err=="" && $password2Err=="" && $passwordErr=="")
                {
                    $sql = "UPDATE users SET password='".$password1."' where user_id='".$_SESSION["user_id"]."';";
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
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h1>Change password</h1>
            <fieldset>
                <label for="password">Original password :</label>
                <input type="password" name="originalPassword" required><span class="error">* <?php echo $originalPasswordErr;?></span>
                <br>
                <label for="password">New password :</label>
                <input type="password" name="password1" required><span class="error">* <?php echo $password1Err;?></span>
                <br>
                <label for="password">Confirm password :</label>
                <input type="password" name="password2" required><span class="error">* <?php echo $password2Err;?></span>
                <div class="error"><?php echo $passwordErr;?></div>
            </fieldset>
            <button type="Submit">Submit</button>
        </form>
    </body>
</html>