<?php
    session_start();
    include 'connection.php';
    #echo($_SERVER["REQUEST_METHOD"]);
    $loginerror=0;
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sql = "select * from users where username='".$_POST["uname"]."' and password='".$_POST["password"]."' and usertype='".$_POST["userType"]."';";
        #echo($sql);
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0)
        {
            //echo('Hello'.$_POST["uname"]);
            $_SESSION["user_id"]=$row["user_id"];
            $_SESSION["username"]=$_POST["uname"];
            $_SESSION["usertype"]=$_POST["userType"];
            echo($row["user_id"]);
            if($_SESSION["usertype"]=='admin')
            {
                header("Location: admin.php");//redirecting to admin
                exit();
            }
            elseif($_SESSION["usertype"]=='student')
            {
                header("Location: student_dashboard.php");//redirecting to student_dashboard
                exit();
            }
        }
        else
        {
            $loginerror=1;
        }
    }
    //if user is already logged in, then redirect. Don't show index page.
    elseif(isset($_SESSION["username"]) && $_SESSION["usertype"]=="admin")
    {
        header("Location: ".$_SESSION["usertype"].".php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>School Management System</title>
        <!-- <link rel="stylesheet" href="style1.css"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        body 
        {
            font-family: Arial, Helvetica, sans-serif;
            background-image:url("images/background.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100vh;
            background-blend-mode: lighten;
        }
        * {box-sizing: border-box;}
        .input-container {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        width: 100%;
        margin-bottom: 15px;
        }

        .icon {
        padding: 10px;
        background: dodgerblue;
        color: white;
        min-width: 50px;
        text-align: center;
        }

        .input-field {
        width: 100%;
        padding: 10px;
        outline: none;
        }

        .input-field:focus {
        border: 2px solid dodgerblue;
        }

        /* Set a style for the submit button */
        .btn {
        background-color: dodgerblue;
        color: white;
        padding: 15px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        }

        .btn:hover {
        opacity: 1;
        }
        #user_login_header {
            text-align: center; 
            background: rgb(17 143 158);
            /*greenish background */
            color:white;
            height:10vh;
            margin-bottom:2vh;
            margin-top:2vh;
            padding-top:2px;
        }
        input[type=radio]
        {
            width:1.5em;
            height:1.5em;
        }
        label
        {
            font-size:1.5em;
            color: #001fc5;
        }
        header
        {
            width:100%;
            background-color:blue;
            font-size:1.5em;
            text-align:center;
            height:10vh;
            color:white;
            padding:14px;
        }
        </style>
    </head>
    <body>
        <header>
            School Management System
        </header>
        <div class="error">
            <?php
                if($loginerror==1)
                {
                    echo("Invalid login credentials!");
                }
            ?>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="max-width:500px;margin:auto">
            <div id="user_login_header">
                <h2>User Login</h2>
            </div>
            <div class="input-container">
                <i class="fa fa-user icon"></i>
                <input type="text" class="input-field" placeholder="Username" name="uname" required><br>
            </div>
            <div class="input-container">
                <i class="fa fa-key icon"></i>
                <input type="password" placeholder="Password" class="input-field" name="password" required><br>
            </div>
            <input type="radio" name="userType" value="admin" checked>
            <label for="admin">Admin</label>
            <input type="radio" name="userType" value="staff">
            <label for="staff">Staff</label>
            <input type="radio" name="userType" value="student">
            <label for="student">Student</label><br>
            <input type="submit" value = "Login" class="btn">
        </form>
    </body>
</html>