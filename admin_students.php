<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='admin'))
    {
        header("Location: index.php");
        exit();
    }
    $nameErr=$userNameErr= $admissionNoErr=$passwordErr=$password1Err=$password2Err= $classErr="";
    $name =$userName=$admissionNo=$password1=$password2="";
    $class=$noError=0;
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
        if (empty($_POST["class"])) 
        {
            $classErr = "Class is required";
        }
        elseif(is_numeric($_POST["class"]) && $_POST["class"]<1 && $_POST["class"]>10)
        {
            $classErr = "Invalid class input";
        }
        else
        { 
            $class=$_POST["class"];
        }
        //echo("select admissionNo from students where admissionNo='".$_POST["admissionNo"]."';");
        if (empty($_POST["admissionNo"])) 
        {
            $admissionNoErr = "admission no. is required";
        }
        elseif($conn->query("select admissionNo from students where admissionNo='".$_POST["admissionNo"]."';")->num_rows>0)
        {
            $admissionNoErr = "Admission no. is already taken";
        }
        else 
        {
            $admissionNo = test_input($_POST["admissionNo"]);
        }
        if (empty($_POST["uname"])) 
        {
            $userNameErr = "User name is required";
        }
        elseif($conn->query("select username from users where username='".$_POST["uname"]."' and usertype='student';")->num_rows>0)
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
            //echo("password check");
            $password2 = $_POST["password2"];
        }
        if($password1!="" && $password2!="" && $password1!=$password2)
        {
            $passwordErr="Passwords must match";
        }
        //echo($nameErr==""&& $classErr="" && $userNameErr =="" && $admissionNoErr=="" && $password1Err=="" && $password2Err=="" && $passwordErr=="");
        if($nameErr==""&& $classErr=="" && $userNameErr =="" && $admissionNoErr=="" && $password1Err=="" && $password2Err=="" && $passwordErr=="")
        {
            $noError=1;
            $sql = "INSERT INTO users (name,username,usertype,password) VALUES ('".$name."','".$userName."','student', '".$password1."');";
            //echo ($sql);
            if ($conn->query($sql) === TRUE)
            {
                //echo "New record created successfully";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $sql="select user_id from users where username='".$userName."';";
            //echo ($sql);
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $userId=$row["user_id"];
            $sql="select count(*) as cnt from students where class=".$_POST["class"].";";
            //echo ($sql);
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $classStudentCount=$row["cnt"];
            if($classStudentCount==0)
                $rollNo=1;
            else
            {
                $sql="select max(rollNo) from students where class=".$_POST["class"].";";
                // echo ($sql);
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $rollNo = $row["max(rollNo)"]+1;
            }
            $sql="insert into students (user_id,class,rollNo,admissionNo,admissionDate,gender) values (".$userId.",".$class.",".$rollNo.",'".$admissionNo."',curdate(),'".$_POST["gender"]."');";
            // echo ($sql);
            if ($conn->query($sql) === TRUE)
            {
                //echo "New record created successfully";
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
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
        <a href="admin.php"><< Back to admin panel</a><br>
        <button id="addStudentButton">Add new student</button>
        <div class="addStudentModal" id="addStudentModal" <?php if($_SERVER["REQUEST_METHOD"] == "POST" && $noError==0){echo "style=\"display:block;\"";}?>>
			<div class="addStudentModalContent">
				<div class="modalHeader">
					<div class="modalHeaderText">
						New Student
					</div>
					<span class="closebutton" id="addStudentCloseButton">&times;</span>
				</div>
				<form class="addStudentForm" name="addStudentForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input class="addStudentFormInput" type="text" name="name"  placeholder="Name" value = "<?php if($_SERVER["REQUEST_METHOD"] == "POST" && $noError==0){ echo($_POST["name"]); }?>" required><span class="error">* <?php echo $nameErr;?></span>
                    <input type="text" class="addStudentFormInput" name="uname" placeholder="Username." value = "<?php if($_SERVER["REQUEST_METHOD"] == "POST" && $noError==0){ echo($_POST["uname"]); }?>" required><span class="error">* <?php echo $userNameErr;?></span>
                    <input class="addStudentFormInput" type="text" name="admissionNo"  placeholder="Admission No." value = "<?php if($_SERVER["REQUEST_METHOD"] == "POST" && $noError==0){ echo($_POST["admissionNo"]); }?>" required><span class="error">* <?php echo $admissionNoErr;?></span>
                    <input class="addStudentFormInput" type="number" name="class" placeholder="Class (1 - 12)"  value = "<?php if($_SERVER["REQUEST_METHOD"] == "POST" && $noError==0){ echo($_POST["class"]); }?>" min="1" max="12" required><span class="error">* <?php echo $classErr;?></span>
                    <input class="addStudentFormInput" type="password" name="password1" placeholder="Password" required><span class="error">* <?php echo $password1Err;?></span><br>
                    <input type="password" class="addStudentFormInput" name="password2" placeholder="Confirm password" required><span class="error">* <?php echo $password2Err;?></span><br>
                    <div class="error"><?php echo $passwordErr;?></div>
                    <input type="radio" class="addStudentFormRadioInput" name="gender" value="male" checked>
                    <label for="male" class="addStudentFormRadioInputLabel">Male</label>
                    <input type="radio" class="addStudentFormRadioInput" name="gender" value="female">
                    <label for="female" class="addStudentFormRadioInputLabel">Female</label>
                    <input type="radio" class="addStudentFormRadioInput" name="gender" value="other">
                    <label for="other" class="addStudentFormRadioInputLabel">Other</label><br>
					<button type="submit" id="addButton" name="Submit" value="addStudent">Add Student</button>
                    <!-- admission date will be the date when the admin creates the student record -->
                    <!-- roll no will be max(roll no. of that class) + 1 -->
				</form>
			</div>
		</div>
        <div id="admin_student_content" class=flex-container>
            <table>
                <th class="id">User_id</th><th>Name</th><th>Class</th><th>Roll No.</th><th>Email</th><th>Actions</th>
                <?php
                $sql="select * from (select user_id, name from users) as u natural join (select user_id,class, rollNo,email from students) as s order by class,name;";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        echo "
                        <tr class=\"data\">
                            <td class=\"id\">".$row["user_id"]."</td><td>".$row["name"]."</td><td>".$row["class"]."</td><td>".$row["rollNo"]."</td><td>".$row["email"]."</td>                            </td>
                            <td>
                                <a href=\"admin_student_details.php?user_id=".$row["user_id"]."\">Details</a>
                                <a href=\"admin_student_update.php?user_id=".$row["user_id"]."\">Update</a>
                                <a href=\"admin_student_delete.php?user_id=".$row["user_id"]."\">Delete</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </table>
        </div>
        <script>
            var addStudentButton=document.getElementById("addStudentButton");
            var addStudentModal=document.getElementById("addStudentModal");
            var addStudentCloseButton=document.getElementById("addStudentCloseButton");
            addStudentButton.onclick=function(){addStudentModal.style.display="block"}
            addStudentCloseButton.onclick=function(){addStudentModal.style.display="none";}
            window.onclick = function(event) 
            {
                if (event.target == addStudentModal) 
                {
                addStudentModal.style.display = "none";
                }
            }
        </script>
        <div id="studentList">
            
        </div>
    </body>
</head>