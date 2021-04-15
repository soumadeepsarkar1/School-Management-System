<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='student'))
    {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="side_nav.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="about_us.css">
  </head>
  <body>
    <?php include 'side_nav.php'; ?>
    <div class="main_container">
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
            <img src="images/soumya1.jpg" alt="Mike" style="width:100%">
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
            <img src="images/soumadeep.png" alt="Jane" style="width: 100%">
            <div class="container">
              <h2>Soumadeep Sarkar</h2>
              <p class="title">3rd Year Student</p>
              <p>Computer Science and Engineering, B.Tech</p>
              <p>Roll - 62</p>
              <p>soumadeepsarkar1@gmail.com</p>
              <p><button class="button" >Contact</button></p>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card">
            <img src="images/sohini1.jpeg" alt="John" style="width:100%">
            <div class="container">
              <h2>Sohini Dutta</h2>
              <p class="title">3rd Year Student</p>
              <p>Computer Science and Enginnering, B.Tech</p>
              <p>Roll - 61</p>
              <p>sohinidutta008@gmail.com</p>
              <p><button class="button">Contact</button></p>
            </div>
          </div>
        </div>
      </div>
    <div>
  </body>
</html>