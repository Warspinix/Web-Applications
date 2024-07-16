<?php
session_start();
$_SESSION["type"] = "student";
?>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
</head>

<body> 
    <br><br><br>
    <div class="divheading1">
        <h1 id="center">Student Login</h1>
    </div>

    <form method="POST">
        <br><br>
        <div id="center">
            <input type="text" name="rno" minlength="10" maxlength="10" size="17" placeholder="Register Number" autofcous required>
            <br><br>

            <input type="password" name="pw" size="17" placeholder="Password" required>
            <br><br>
            <a href="Student_Functions.php">
            <input type="submit" value="Login" style="cursor: pointer; width: 68%; font-family: 'Trebuchet MS';">
            </a>
            <br><br>

            <div style="color:white; font-size: 16px;" >
                <a style="text-decoration: none; color:white;" href="Student_Register.php">Register</a>
                .&nbsp;<a style="text-decoration: none; color:white;" href="Forgot_Password.php">Forgot Password</a>
            </div>
        </div>
        <br><br>
    </form>

    <?php
        function rno_valid($reg) {
            $depts = array( "501"=>"Automobile Engineering",
                            "502"=>"Aerospace Engineering",
                            "503"=>"Electronics Engineering",
                            "504"=>"Instrumentation Engineering",
                            "505"=>"Production Technology",
                            "506"=>"Information Technology",
                            "507"=>"Rubber and Plastics Technology",
                            "508"=>"Robotics and Automation",
                            "509"=>"Computer Technology");
            $y = (int)substr($reg, 0, 4);
            $d = substr($reg, 4, 3);
            $n = (int)substr($reg, 7, 3);
            if (is_numeric($reg) && $y >= 2000 && $y <= (int)date("Y") && array_key_exists($d, $depts) && $n >= 1 && $n <= 120)
                return TRUE;
            else
                return FALSE;
        }
        if (isset($_POST["pw"])) {
            $rno = $_POST["rno"];
            $pw = $_POST["pw"];
            
            if (rno_valid($rno)) {
                $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE) {
                    die("Error connecting to database. Please try again later.");
                }
                $select = "select reg_no, password, fname, lname from student where reg_no='$rno'";
                if ($result=mysqli_query($link, $select)) {
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result);
                        if ($row['password'] == $pw) {
                            $_SESSION["name"] = $row['fname'];
                            $_SESSION["no"] = $row['reg_no'];
                            header("Location: Student_Functions.php");
                        } else {
                            echo "<p>Invalid Password</p>";
                        }
                    } else {
                        echo "<p>You have not registered yet. Please register and then login.</p>";
                    }
                } else {
                    echo "<p>There is some error from our side. Please try again later. 
                    Error Message: ".mysqli_error($link)."</p>";
                }
            } else {
                echo "<p>Invalid Register Number</p>";
            }
        }
    ?>
</body>
</html>