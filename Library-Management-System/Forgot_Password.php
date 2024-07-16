<?php
    session_start();
?>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="forgot_password.css">
</head>
<body>
    <br><br><br>
    <form method="POST">
        <br><br>
        <div class="divheading1">
            <h1>Reset Password</h1>
        </div>
        <input type="text" name="no" minlength="10" maxlength="10" placeholder="User ID" required>  
        <br><br>

        <input type="email" name="email" placeholder="E-Mail" required>
        <br><br>

        <input type="text" name="mno" minlength="10" maxlength="10" placeholder="Mobile Number" required>
        <br><br>

        <input type="password" name="pw1" minlength="8" maxlength="15" placeholder="New Password" required>
        <br><br>

        <input type="password" name="pw2" minlength="8" maxlength="15" placeholder="Confirm New Password" required>
        <br><br>

        <input type="submit" value="Update Password" style='height: 50px;'>
        <br><br><br><br>
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
        function faculty_id_valid($id) {
            $depts = array( "501"=>"Automobile Engineering",
                            "502"=>"Aerospace Engineering",
                            "503"=>"Electronics Engineering",
                            "504"=>"Instrumentation Engineering",
                            "505"=>"Production Technology",
                            "506"=>"Information Technology",
                            "507"=>"Rubber and Plastics Technology",
                            "508"=>"Robotics and Automation",
                            "509"=>"Computer Technology");
            $y = (int)substr($id, 0, 5);
            $d = substr($id, 5, 3);
            $n = (int)substr($id, 8, 2);
            if (is_numeric($id) && $y == 11111 && array_key_exists($d, $depts) && $n >= 1 && $n <= 30)
                return TRUE;
            else
                return FALSE;
        }
        function staff_id_valid($reg) {
            $words = array("LIBRA","STAFF","BOOKS");
            $l = substr($reg, 0, 5);
            $n = substr($reg, 5, 5);
            if (in_array($l, $words) && is_numeric($n))
                return TRUE;
            else
                return FALSE;
        }
        function password_valid($p1) {
            $arr = str_split($p1);
            $upper = $lower = $no = $spl = 0;
            foreach ($arr as $i) {
                if (ctype_upper($i)) 
                    $upper = 1;
                else if (ctype_lower($i))
                    $lower = 1;
                else if (is_numeric($i)) 
                    $no = 1;
                else
                    $spl = 1;
            }
            if ($upper == 1 && $lower == 1 && $no == 1 && $spl == 1)
                return TRUE;
            else 
                return FALSE;    
        }
        function password_match($p1, $p2) {
            return $p1 == $p2;
        }
        function mno_valid($mobile) {
            if (is_numeric($mobile))
                return TRUE;
            else
                return FALSE;
        }
        if (isset($_SESSION["type"])) {
            if (isset($_POST["pw2"])) {

                $no = $_POST["no"];
                $email = $_POST["email"];
                $mno = $_POST["mno"];
                $pw1 = $_POST["pw1"];
                $pw2 = $_POST["pw2"];

                $type = $_SESSION["type"];

                if ($type == "student") {
                    $regid_valid = rno_valid($no);
                    $id = "reg_no";
                    $page = "Student_Login.php";
                }
                else if ($type == "faculty") {
                    $regid_valid = faculty_id_valid($no);
                    $id = "faculty_id";
                    $page = "Faculty_Login.php";
                }
                else {
                    $regid_valid = staff_id_valid($no);
                    $id = "staff_id";
                    $page = "Staff_Login.php";
                }
                
                if ($regid_valid) {
                    if (password_valid($pw1)) {
                        if (password_match($pw1, $pw2)) {
                            if (mno_valid($mno)) {

                                $link = mysqli_connect("localhost","root","","library");
                                if ($link == FALSE)
                                    die("Error connecting to database. Please try again later.");

                                $select = "select * from $type where $id = '$no' && email_id = '$email' && mobile_no = '$mno'";

                                if ($result = mysqli_query($link, $select)) {
                                    if (mysqli_num_rows($result) == 1) {
                                        $update = "update $type set password = '$pw1' where $id = '$no'";
                                        mysqli_query($link, $update);
                                        echo "<p>Password Successfully Updated.</p><br><br>";
                                        echo "<a href=$page>Go to Login Page</a><br><br><br>";
                                    } else {
                                        echo "<p>Invalid Details Entered</p><br><br><br>";
                                    }

                                } else {
                                    echo "<p style='text-align: center;'>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                                }
                            } else {
                                echo "<p>Invalid Mobile Number.</p><br><br><br>";
                            }
                        } else {
                            echo "<p>Passwords do not match.</p><br><br><br>";
                        }
                    } else {
                        echo "<p>Password should contain at least 1 lowercase letter, 1 uppercase letter, 1 number, and 1 special character.</p><br><br><br>";
                    }
                } else {
                    echo "<p>Invalid ID.</p><br><br><br>";
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