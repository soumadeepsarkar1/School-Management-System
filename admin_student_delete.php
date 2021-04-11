<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='admin'))
    {
        header("Location: index.php");
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sql="delete from users where user_id=".$_POST["user_id"];
        $result = $conn->query($sql);
        $sql="delete from students where user_id=".$_POST["user_id"];
        $result = $conn->query($sql);
        header("Location: admin_students.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Confirm delete student</title>
        <style>
            body {font-family: Arial, Helvetica, sans-serif;}
            * {box-sizing: border-box;}

            /* Set a style for all buttons */
            
            .cancelbtn:hover, .deletebtn:hover {
            opacity:1;
            }

            /* Float cancel and delete buttons and add an equal width */
            .cancelbtn, .deletebtn {
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                opacity: 0.9;
                float: left;
                width: 50%;
            }

            /* Add a color to the cancel button */
            .cancelbtn {
            background-color: #ccc;
            color: black;
            }

            /* Add a color to the delete button */
            .deletebtn {
            background-color: #f44336;
            }

            /* Add padding and center-align text to the container */
            .container {
            padding: 16px;
            text-align: center;
            }

            /* The Modal (background) */
            .modal {
            position: fixed; /* Stay in place */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: #474e5d;
            padding-top: 50px;
            }

            /* Modal Content/Box */
            .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 75%; /* Could be more or less, depending on screen size */
            }

            /* Style the horizontal ruler */
            hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
            }
            
            /* Clear floats */
            .clearfix::after {
            content: "";
            clear: both;
            display: table;
            }

            /* Change styles for cancel button and delete button on extra small screens */
            @media screen and (max-width: 300px) {
                .cancelbtn, .deletebtn {
                    width: 100%;
                }
            }
</style>
    </head>
    <body>
<body>
    <div id="id01" class="modal">
        <form class="modal-content" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="container">
                <h1>Delete Account</h1>
                <p>Are you sure you want to delete student record with user id = <?php echo($_GET["user_id"]);?>?</p>            
                <div class="clearfix">
                    <a href="admin_students.php"><button type="button" class="cancelbtn">Cancel</button></a>
                    <input type="hidden" name="user_id" value="<?php echo $_GET["user_id"];?>">
                    <input type="submit" class="deletebtn" value="Delete">
                </div>
            </div>
        </form>
    </div>
    </body>
</html>