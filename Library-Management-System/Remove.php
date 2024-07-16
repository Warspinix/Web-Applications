<?php
    session_start();
?>
<html>
<head>
    <title>Remove Users</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="remove.css">
</head>
<body>
    <br><br>
    <form method="POST">
        <br>
        <div class="divheading1">
            <h1>Remove User</h1>
        </div>
        <input type="text" name="no" minlength="10" maxlength="10" autofocus required placeholder="User ID">
        <br><br>

        <select name="type">
            <option value="" disable selected>Select Member Type</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
        </select>
        <br><br>

        <textarea name="reason" rows="7" cols="31" minlength="10" maxlength="200" required placeholder="Reason for Removal. Maximum of 200 characters"></textarea>
        <br><br><br>

        <input type="submit" value="Remove User" style="height: 50px; cursor: pointer;" id="logout">
        <br><br><br><br>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_POST["reason"])) {

                $no = $_POST["no"];
                $table1 = $_POST["type"];
                $reason = $_POST["reason"];
                $date = date("Y-m-d");

                $staff = $_SESSION["no"];

                if ($table1 == "student") {
                    $id = "reg_no";
                    $title = "Register Number";
                    $table2 = "s".$no;
                }
                else {
                    $id = "faculty_id";
                    $title = "Faculty ID";
                    $table2 = "f".$no;
                }
                
                $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                $delete1 = "delete from $table1 where $id = '$no'";
                $delete2 = "drop table $table2";
                $delete3 = "delete from all_members where regid='$no'";
                $insert = "insert into removed_users values ('$no','$table1','$reason','$date','$staff')";

                if (mysqli_query($link, $delete1) 
                    && mysqli_query($link, $delete2) 
                        && mysqli_query($link, $delete3)
                            && mysqli_query($link, $insert)) {
                    echo "<p>User successfully removed.</p>";
                    echo "<div>
                    <a href='Staff_Functions.php'>Go to Functions Page</button></a> &emsp;
                    <a href='Logout.php'>Logout</button></a><br><br>
                </div>";

                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                }
            } 
        } else {
            echo "<br><br><br><br><br><br><br><br><br>
            <div class='divbody'>
                <br><br>
                <h1>Please Login to Access the Features</h1>
                <br><br>
            </div>
            <br><br><br>
            ";
        }
    ?>
    </form>
</body>
</html>