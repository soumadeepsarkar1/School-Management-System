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
            <a href="admin.php"><< Back to admin panel</a>
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
                document.getElementById('class').value=<?php if(isset($_POST["class"])){echo($_POST["class"]);}else{echo(0);} ?>;
            </script>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    if(!empty($_POST["fees_input"]))
                    {
                        $sql="update current_fees set fees=".$_POST["fees_input"]." where class=".$_POST["class"].";";
                        if($conn->query($sql)==TRUE)
                        {
                            echo("Fees updated successfully");
                        }
                        else
                        {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    $sql="select fees from current_fees where class=".$_POST["class"].";";
                    $result=$conn->query($sql);
                    $row=$result->fetch_assoc();
                    echo("<div>");
                    if(empty($row["fees"]))
                    {
                        echo ("Fees for class ".$_POST["class"]." is not set
                        <button class=\"setOrChange\" onclick=\"showFeeSetter()\">Set fees</button>");
                    }
                    else
                    {
                        echo("Current monthly fees for class ".$_POST["class"]." is set to ₹ ".$row["fees"].".
                        <button class=\"setOrChange\" onclick=\"showFeeSetter()\">Change fees</button>");
                    }
                    echo("</div>"); 
                }
            ?>
            <form id="fees_setter" method="POST" style="display:none;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="number" min=0 name="fees_input">
                <input type="hidden" name="class" value="<?php echo($_POST["class"]);?>">
                <input type="submit">
            </form>
            <form id="display_student_criteria" method="POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:
            <?php
                if(empty($row["fees"]))
                {
                    echo("none");
                }
                else
                {
                    echo("block");
                }
            ?>;">
                <input type="radio" id="all" name="criteria" value="all" onclick="showStudents(this.value,<?php echo($_POST["class"]);?>)">
                <label for="all">Display fees details of all students of class <?php echo($_POST["class"]);?>.</label><br>
                <input type="radio" id="overdue" name="criteria" value="overdue" onclick="showStudents(this.value,<?php echo($_POST["class"]);?>)">
                <label for="overdue">Display fees details of students who have fees overdue.</label><br>
            </form>
            <div id="studentFeesDetails">Students fees details displayed here<br></div>
            <script>
                function showStudents(str,cls) {
                    var xhttp;
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function()
                    {
                        if (this.readyState == 4 && this.status == 200)
                        {
                            document.getElementById("studentFeesDetails").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("POST", "adminGetStudentFeesDetails.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("criteria="+str+"&class="+cls);
                }
                function showFeeSetter()
                {
                    document.getElementById("fees_setter").style.display="block";
                }
            </script>
        </section>
        <footer>
            <div>
                Created by Soumadeep Sarkar, Soumya Bhattacharjee and Sohini Dutta
            </div>
        </footer>
    </body>
</html>
