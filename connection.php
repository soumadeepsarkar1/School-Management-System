<?php
    $servername="localhost";
    $username="user2";
    $password="1234";
    $dbname="db1";
    $conn = new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error)
    {
        die("Connection failed: ".$conn->connect_error);
    }
?>