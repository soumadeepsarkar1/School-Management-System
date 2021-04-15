<?php
    session_start();
    include 'connection.php';
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='admin'))
    {
        header("Location: index.php");
        exit();
    }
    //echo("hello, this is ajax");
?>
<table>
    <tr><th>User Id.</th><th>Admission No.</th><th>Name</th><th>Phone No.</th><th>Fees paid upto</th></tr>
    <?php
        $months=array("No fees paid","January","February","March","April","May","June","July","August","September","October","November","December");
        //echo("criteria=".$_POST['criteria']);
        if($_POST["criteria"]=="overdue")
        {
            $sql="select * from (select user_id,phoneNo,admissionNo,ifnull(fees_paid_upto_month,0) as FPUM from students where class=".$_POST["class"]." and ifnull(fees_paid_upto_month,0)<month(curdate())) as s natural join (select user_id, name from users) as u order by name;";
            //echo($sql);
        }
        else
        {
            $sql="select * from (select user_id,phoneNo,admissionNo,ifnull(fees_paid_upto_month,0) as FPUM from students where class=".$_POST["class"].") as s natural join (select user_id, name from users) as u order by name;";
            //echo($sql);
        }
        $result=$conn->query($sql);
        //echo "Error: " . $sql . "<br>" . $conn->error;
        while($row=$result->fetch_assoc())
        {
            echo("<tr><td>".$row["user_id"]."</td><td>".$row["admissionNo"]."</td><td>".$row["phoneNo"]."</td><td>".$row["name"]."</td><td>".$months[$row["FPUM"]]."</td></tr>");//FPUM is alias for ifnull(fees_paid_upto_month,0)
        }
    ?>
</table>
