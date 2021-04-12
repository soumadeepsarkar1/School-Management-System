

<div class="sidebar">
    <br>
    <br>
    <div class="logout"><div>Hello, <?php echo($_SESSION["username"]);?></div>
    <a id="student_dashboard" href="student_dashboard.php">DashBoard</a>
    <br>
    <a id="student_edit" href="student_edit.php">Edit Profile</a>
    <br>
    <a id="announce" href="announce.php">Announcements</a>
    <br>
    <a id="student_class_schedule" href="student_class_schedule.php">Class Schedule</a>
    <br>
    <a id="student_fees_payment" href="student_fees_payment.php">Fees payment</a>
    <br>
    <a id="about_us" href="about_us.php">About Us</a>
    <br>
    <a id="logout" href ="logout.php">Log out</a></div>
</div>
<script>
    var path = window.location.pathname;
    var page = path.split("/").pop();
    var name=page.substring(0, page.length - 4);
    //console.log(name);
    document.getElementById(name).style="background-color: #4CAF50;color: white;";
</script>