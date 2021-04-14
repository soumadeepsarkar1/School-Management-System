<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='admin'))
    {
        header("Location: index.php");
        exit();
    }
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        //echo(!(is_uploaded_file($_FILES['routine']['tmp_name'])));
        if(isset($_FILES['routine']) && is_uploaded_file($_FILES['routine']['tmp_name']))//check if any file has been uploaded
        {
            //managing file
            //$target_file = $target_dir . basename($_FILES["routine"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($_FILES["routine"]["name"],PATHINFO_EXTENSION));
            //echo $fileType."<br>";
            $target_dir = "routines/";
            //assigning a random name to the file
            $ran=md5(time().rand());
            $target_file = $ran.".".$fileType;
            // Check file size
            if ($_FILES["routine"]["size"] > 5000000)
            {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            elseif($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType!="pdf") 
            {
                echo "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0)
            {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            }
            else 
            {
                //check if there is already a routine available for that class,
                //if available then delete the previous routine and insert the new routine
                $sql="select routine from class_routines where class=".$_POST["class"].";";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if(!empty($row["routine"]))
                {
                    unlink("routines/".$row["routine"]);
                }
                $sql="update class_routines set routine='".$target_file."' where class=".$_POST["class"].";";
                if ($conn->query($sql) === FALSE)
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                if (move_uploaded_file($_FILES["routine"]["tmp_name"],$target_dir.$target_file))
                {
                    echo "The file ". htmlspecialchars( basename( $_FILES["routine"]["name"])). " has been uploaded.";
                }
                else 
                {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
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
        <a href="admin.php"><< Back to admin panel</a>
        <div>
            <form id="class_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="class">Choose a class:</label>
                <select name="class" id="class" form="class_form" onchange='if(this.value != 0) { this.form.submit(); }'>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </form>
            <script>
                document.getElementById('class').value=<?php if(isset($_POST["class"])){echo($_POST["class"]);} else {echo(1);} ?>;
            </script>
        </div>
        <div>
            <?php
                if($_SERVER["REQUEST_METHOD"]=="POST")
                {
                     echo("<form action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"post\" enctype=\"multipart/form-data\">
                            <label for=\"routine\">Upload a new routine (pdf or image file): </label>
                            <input type=\"file\" name=\"routine\">
                            <input type=\"hidden\" name=\"class\" value=\"".$_POST["class"]."\">
                            <input type=\"submit\" value=\"Upload\">
                        </form>");
                }
                if(isset($_POST["class"]))
                {
                    echo("<h2>Routine for class ".$_POST["class"]."</h2>");
                    echo("<div>");
                    $sql="select routine from class_routines where class=".$_POST["class"].";";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    if(!empty($row["routine"]))
                    {
                        echo("<embed src=\"routines/".$row["routine"]."\" width=\"1000px\" height=\"700px\" />");
                    }
                    else
                    {
                        echo("Routine not uploaded");
                    }
                    echo("</div>");
                }
            ?>
            <!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                <label for="routine">Upload a new routine (pdf or image file): </label>
                <input type="file" name="routine">
                <input type="hidden" name="class" value="<?php echo($_POST["class"]);?>">
            </form> -->
        </div>
        <!-- <embed src="student_images/14aad77f7ede362ef41f0480e6efa133.jpg" width="1000px" height="700px" /> -->
    </body>
</html>
        