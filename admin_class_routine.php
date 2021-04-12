<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
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
        <a href="admin.php"><< Back to admin panel</a>
        <div>
            <form id="class_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
                document.getElementById('class').value=<?php if(isset($_GET["class"])){echo($_GET["class"]);} else {echo(1);} ?>;
            </script>
        </div>
        <?php
            if(isset($_GET["class"]))
            {
                echo("<h2>Routine for class ".$_GET["class"]."</h2>");
            }
        ?>