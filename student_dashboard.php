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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="side_nav.css">
<style>
        * {
            box-sizing: border-box;
            list-style: none;
        }
        table,th,td {
            border: 1px solid black;
        }
        .card {
            box-shadow :0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width : 60%;
            margin:auto;
            text-align :left;
            font-family :"Lucida Console";
            background :powderblue;
            padding-left :5%;
            color : Blue;
            box-shadow : 10px 10px 5px #aaaaaa;
        }
        h1 {
            padding : 50px;
            text-align: center; 
            background: rgb(0, 153, 51);
            /*greenish background */
            color:white;
            animation-name: example;
            animation-duration : 4s;
            animation-iteration-count : infinite;
            animation-delay: 2s; 
            
        }
        @keyframes example {
            0%   {background:rgb(0, 153, 51) ;}
            25%  {background: yellow;}
            50%  {background: blue;}
            100% {background: green;}
            }
        
        </style>
</head>
<body>
  <?php include 'side_nav.php'; ?>
  <div><div>Hello, <?php echo($_SESSION["username"]);?></div><a href ='logout.php'>Log out</a></div>
    <header>
        <h1>YOUR DASHBOARD</h1>
    </header>
  <?php
    $sql="select * from (select user_id, name from users where user_id=". $_SESSION["user_id"].") as u natural join (select user_id,class, rollNo,DOB,gender,email,address,mother,father,image from students where user_id=". $_SESSION["user_id"].") as s order by class,name;";
    $result=$conn->query($sql);

    //if($result->num_rows > 0) {
        //echo "NAME<br>CLASS<br>ROLL NO.<br>DATE OF BIRTH<br>GENDER<br>";
         //output data of each row

        
         $row = $result->fetch_assoc() 
         ?>
                     <div class="card">
                     <div id = "student_image" style="height:50%;width:35%;float:right;border :2px solid blue;padding : 10px;box-shadow :10px 10px 5px #aaaaaa;">
                     <?php
                         if(empty($row["image"]))
                         {
                             echo('Image not uploaded');
                         }
                         else
                         {
                             echo("<img src = \"student_images\\".$row["image"]."\" style=\"width:100%;\">");
                         }
                     ?>
                 </div>
                         
                     <br>
                     <h3>NAME : <?php echo $row["name"]; ?></h3><br>
                     <h3>CLASS : <?php echo $row["class"]; ?></h3><br>
                     <h3>ROLL NO. : <?php echo $row["rollNo"]; ?></h3><br>
                     <h3>DATE OF BIRTH : <?php echo $row["DOB"]; ?></h3><br>
                     <h3>GENDER : <?php echo $row["gender"]; ?></h3><br>
                     <h3>EMAIL ID : <?php echo $row["email"]; ?></h3><br>
                     <h3>PERMANENT ADDRESS : <?php echo $row["address"]; ?></h3><br>
                     <h3>MOTHER'S NAME : <?php echo $row["mother"]; ?></h3><br>
                     <h3>FATHER'S NAME : <?php echo $row["father"]; ?></h3><br>
         
                     
     </div>
    
         $conn->close();
         ?>


</body>
</html>
