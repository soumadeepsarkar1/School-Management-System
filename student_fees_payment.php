<?php
    session_start();
    include 'connection.php';
    //echo(isset($_SESSION["username"]));
    if(!(isset($_SESSION["username"]) && $_SESSION["usertype"]=='student'))
    {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Student Details</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="side_nav.css">
        <style>
        table
        {
            border-collapse: collapse;
            width: 70%;
            margin-left:auto;
            margin-right:auto;
            margin-top:7vh;
            font-size:1.2em;
        }

        th, td
        {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
        #monthly_fees
        {
            font-size:1.5em;
        }
        #overdue_message
        {
            color:red;
        }
        </style>
    </head>
    <body>
        <?php include 'side_nav.php';
            $paid_successfully=0;
            if($_SERVER["REQUEST_METHOD"]=="POST")
            {
                //fees payment
                $sql="update students set fees_paid_upto_month=(select ifnull(fees_paid_upto_month,0))+1 where user_id=".$_SESSION["user_id"];
                if ($conn->query($sql) === TRUE)
                {
                    $paid_successfully=1;
                }
                else
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            $sql="select class,ifnull(fees_paid_upto_month,0) as FPUM from students where user_id=".$_SESSION["user_id"].";";
            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
            $class=$row["class"];
            $FPUM=$row["FPUM"];//FPUM is alias for fees_paid_upto_month
            $months=array("January","February","March","April","May","June","July","August","September","October","November","December");
            $sql="select fees from current_fees where class=".$class.";";
            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
        ?>
        <div class="main_container">
            <div id="monthly_fees">
                Monthly Fees for class <?php echo($class);?> is ₹<?php echo($row["fees"]);?>.
            </div>
            <div style="display:<?php
            if($paid_successfully==1)
            {
                echo("block");
            }
            else
            {
                echo("none");
            }
            ?>;">
                Fees paid successfully.
            </div>
            <table>
                <tr><th>Month</th><th>Status</th><th>Action</th></tr>
                <?php
                    for($i=0;$i<12;$i++)
                    {
                        echo("<tr><td>".$months[$i]."</td><td>");
                        if($FPUM>=$i+1)
                        {
                            echo("Paid.</td><td>");
                        }
                        elseif($i+1<=date('m') && (($FPUM<date('m') && date('d')>1)|| $FPUM<date('m')+1))
                        {
                            echo("<div id=\"overdue_message\">Overdue! Kindly pay the fees as soon as possible.</div></td>
                            <td>
                                <form method=\"POST\" action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\">
                                    <input type=\"submit\" value=\"Pay\">
                                </form>");
                        }
                        else
                        {
                            echo("Due 1st ".$months[$i]."</td>
                            <td>
                                <form method=\"POST\" action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\">
                                    <input type=\"submit\" value=\"Pay\">
                                </form>");
                        }
                        echo("</td></tr>");
                    }
                ?>
            </table>
        </div>
    </body>
</html>