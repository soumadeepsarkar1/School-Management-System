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
        if ($result->num_rows > 0)
        {
            echo('Hello'.$_POST["uname"]);
            $_SESSION["username"]=$_POST["uname"];
            $_SESSION["usertype"]=$_POST["userType"];
            header("Location: admin.php");
            exit();
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
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="error">
            <?php
                if($loginerror==1)
                {
                    echo("Invalid login credentials!");
                }
            ?>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            Username: <input type="text" name="uname" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="radio" name="userType" value="admin" checked>
            <label for="admin">Admin</label>
            <input type="radio" name="userType" value="staff">
            <label for="staff">Staff</label>
            <input type="radio" name="userType" value="student">
            <label for="student">Student</label><br>
            <input type="submit" value = "Login">
        </form>
    </body>
</html>