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
                width: 95%;
                background-color: #e8eeef;
                color: #01090f;
                box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
                margin-bottom: 30px;
            }
            .error {color: #FF0000;}
            </style>
    </head>
    <body>
        <?php include 'side_nav.php'; ?>
        <?php
            $nameErr=$emailErr=$userNameErr="";
            $name =$email=$phoneNo=$address=$DOB=$mother=$father=$userName="";

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
                if (empty($_POST["username"])) 
                {
                    $userNameErr = "User name is required";
                }
                elseif($_POST["username"]!=$_SESSION["username"] && $conn->query("select username from users where username='".$_POST["username"]."';")->num_rows>0)
                {
                    $userNameErr = "User name is already taken";
                }
                else 
                {
                    $userName = test_input($_POST["username"]);
                }
                if($nameErr=="" && $userNameErr=="")
                {
                    //echo($userName);
                    $email=test_input($_POST["email"]);
                    $phoneNo=test_input($_POST["phoneNo"]);
                    $address=test_input($_POST["address"]);
                    $mother=test_input($_POST["mother"]);
                    $father=test_input($_POST["father"]);
                    $DOB=$_POST["DOB"];
                    //echo("<br>".$DOB."<br>");
                    $sql = "UPDATE users SET name='".$name."',username='".$userName."' where user_id='".$_SESSION["user_id"]."';";
                    $_SESSION["username"]=$userName;
                    //echo($sql);
                    if ($conn->query($sql) === TRUE)
                    {
                        echo "Details updated successfully";
                    }
                    else
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $sql = "UPDATE students SET DOB='".$DOB."',phoneNo='".$phoneNo."',email='".$email."',address='".$address."',mother='".$mother."',father='".$father."' where user_id='".$_SESSION["user_id"]."';";
                    //echo($sql);
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

            //echo($_SESSION["user_id"]);
            $sql = "select * from (select user_id,name,username,password from users where user_id=".$_SESSION["user_id"].") as u natural join (select user_id,DOB,gender,phoneNo,email,address,mother,father from students where user_id=".$_SESSION["user_id"].") as s;";
            //echo($sql);
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h1>Edit Student Details</h1>
            <fieldset>
                <legend>Your Profile</legend>
                <a href="student_password_change.php">Change password</a>
                <label for="name">Name :</label>
                <input type="text" name="name" value="<?php echo $row["name"]?>"><span class="error">* <?php echo $nameErr;?></span>
                <br>
                <label for="username">Username :</label>
                <input type="text" name="username" value="<?php echo $row["username"]?>"><span class="error">* <?php echo $userNameErr;?></span>
                <br>
                <label for="phoneNo">Mobile Number :</label>
                <input type="text" name="phoneNo" value="<?php echo $row["phoneNo"]?>">
                <br>
                <label for="email">Email ID :</label>
                <input type="email" name="email" value="<?php echo $row["email"]?>">
                <br>
                <label for="address">Address :</label>
                <input type="text" name="address" value="<?php echo $row["address"]?>">
                <br>
                <label for="mother">Mother's Name :</label>
                <input type="text" name="mother" value="<?php echo $row["mother"]?>">
                <br>
                <label for="father">Father's Name :</label>
                <input type="text" name="father" value="<?php echo $row["father"]?>">
                <br>
                <label for="DOB">Date of Birth :</label>
                <input type="date" name="DOB" value="<?php echo $row["DOB"]?>">
            </fieldset>
            <button type="Submit">Submit Details</button>
        </form>
    </body>
</html>