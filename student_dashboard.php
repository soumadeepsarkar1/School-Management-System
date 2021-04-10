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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="side_nav.css">
</head>
<body>
  <?php include 'side_nav.php'; ?>
  <div><div>Hello, <?php echo($_SESSION["username"]);?></div><a href ='logout.php'>Log out</a></div>
  <div class="content">
    <h1>YOUR DASHBOARD</h1>
  </div>
</div>

</body>
</html>
