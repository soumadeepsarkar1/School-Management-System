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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="side_nav.css">
<link rel="stylesheet" href="style1.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: right;
  width: 30%;
  margin-bottom: 20px;
  padding: 0 8px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
  width: 80%;
  float: center;
}

.about-section {
  padding: 50px;
  text-align: center;
  background-color: #474e5d;
  color: white;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

@media screen and (max-width: 650px) {
  .column {
    width: 50%;
    display: block;
  }
}
</style>
</head>
<body>
<?php include 'side_nav.php'; ?>
<div class="about-section">
  <h1>About Us Page</h1>
  <p>We are the students from University of Engineering and Management, Kolkata developed this school management system website.</p>
  <p>For any querries contact us from below given credentials.</p>
  <p>Thank You.</p>
</div>
<h2 style="text-align:center">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="sohini1.jpeg" alt="John" style="width:100%">
      <div class="container">
        <h2>Sohini Dutta</h2>
        <p class="title">3rd Year Student</p>
        <p>Computer Science and Enginnering, B.Tech</p>
        <p>john@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
  <div class="column">
    <div class="card">
      <img src="soumya1.jpg" alt="Mike" style="width:100%">
      <div class="container">
        <h2>Soumya Bhattacharjee</h2>
        <p class="title">3rd Year Student</p>
        <p>Computer Science and Engineering, B.tech</p>
        <p>Roll - 63</p>
        <p>bhattacharjee.soumya018@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
  <div class="column">
    <div class="card">
      <img src="soumadeep.png" alt="Jane" style="width: 100%">
      <div class="container">
        <h2>Soumadeep Sarkar</h2>
        <p class="title">3rd Year Student</p>
        <p>Computer Science and Engineering, B.Tech</p>
        <p>Roll - 62</p>
        <p>jane@example.com</p>
        <p><button class="button" >Contact</button></p>
      </div>
    </div>
  </div>
  
</div>

</body>
</html>