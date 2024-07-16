<?php
    session_start();
?>
<html>
<head>
    <title>Minor Updates</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="minor.css">
</head>
<body>
    <br><br>
    <form method="POST">
        <br><br>
        <div class="divheading1">
            <h1>Manual Update</h1>
        </div>

        <input type="text" name="yes" autofocus required placeholder="Type 'yes'">
        <br><br>

        <input type="submit" value="Click here to update Due Dates, Fines, Ages, etc." style="cursor: pointer">
        <br><br><br><br><br>
    <?php
        function find_difference($due) {

            $now = time();
            $due = strtotime($due);
            $diff = $now - $due;

            
            $d = (int)($diff / (60 * 60 * 24));
            if ($d < 0)
                $d--;

            return $d;
        }
        function calculate_age($dob) {
            $currentyear = date("Y");
            $currentmonth = date("m");
            $currentdate = date("d");

            $dobyear = (int)substr($dob, 0, 4);
            $dobmonth = (int)substr($dob, 5, 2);
            $dobdate = (int)substr($dob, 8, 2);

            if (($dobmonth > $currentmonth) || ($dobmonth == $currentmonth && $dobdate > $currentdate))
                $age = $currentyear - $dobyear - 1;
            else
                $age = $currentyear - $dobyear;

            return $age;
        }
        if (isset($_SESSION["no"])) { 
            if (isset($_POST["yes"]) and $_POST["yes"] == "yes") {

                $yes = $_POST["yes"];

                $v1 = $v2 = $v3 = $v4 = $v5 = $v6 = 0;

                $date = date("Y-m-d");

                $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                $s1 = "select * from student";

                if ($r1 = mysqli_query($link, $s1)) {
                    while ($row1 = mysqli_fetch_array($r1)) {
                        $age = calculate_age($row1['dob']);
                        $u1 = "update student set age = '$age' where reg_no = '$row1[reg_no]'";
                        mysqli_query($link, $u1);

                        $t1 = "s".$row1['reg_no'];
                        $s4 = "select * from $t1";
                        if ($r4 = mysqli_query($link, $s4)) {
                            while ($row4 = mysqli_fetch_array($r4)) {
                                $d = find_difference($row4['due_date']);
                                if ($d > 0) {
                                    $u4 = "update $t1 set past_due_days = '$d' where sno = '$row4[sno]'";
                                    mysqli_query($link, $u4);
                                    $u7 = "update borrow_log set fine= '$d' where regid = '$row1[reg_no]' && title = '$row4[book]'";
                                    mysqli_query($link, $u7);
                                }
                            }
                        } else {
                            echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                        }
                    }
                    $v1 = 1;
                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                }

                $s2 = "select * from faculty";

                if ($r2 = mysqli_query($link, $s2)) {
                    while ($row2 = mysqli_fetch_array($r2)) {
                        $age = calculate_age($row2['dob']);
                        $u2 = "update student set age = '$age' where faculty_id = $row2[faculty_id]";
                        mysqli_query($link, $u2);

                        $t2 = "f".$row2['faculty_id'];
                        $s5 = "select * from $t2";
                        if ($r5 = mysqli_query($link, $s5)) {
                            while ($row5 = mysqli_fetch_array($r5)) {
                                $d = find_difference($row5['due_date']);
                                if ($d > 0) {
                                    $u5 = "update $t2 set past_due_days = '$d' where sno = '$row5[sno]'";
                                    mysqli_query($link, $u5);
                                    $u8 = "update borrow_log set fine= '$d' where regid = '$row2[faculty_id]' && title = '$row5[book]'";
                                    mysqli_query($link, $u8);
                                }
                            }
                        } else {
                            echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                        }
                    }
                    $v2 = 1;
                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                }

                $s3 = "select * from library_staff";

                if ($r3 = mysqli_query($link, $s3)) {
                    while ($row3 = mysqli_fetch_array($r3)) {
                        $age = calculate_age($row3['dob']);
                        $u3 = "update student set age = '$age' where staff_id = $row3[staff_id]";
                        mysqli_query($link, $u3);

                        $t3 = "ls".$row3['staff_id'];
                        $s6 = "select * from $t3";
                        if ($r6 = mysqli_query($link, $s6)) {
                            while ($row6 = mysqli_fetch_array($r6)) {
                                $d = find_difference($row6['due_date']);
                                if ($d > 0) {
                                    $u6 = "update $t3 set past_due_days = '$d' where sno = '$row6[sno]'";
                                    mysqli_query($link, $u6);
                                    $u9 = "update borrow_log set fine= '$d' where regid = '$row3[staff_id]' && title = '$row6[book]'";
                                    mysqli_query($link, $u9);
                                }
                            }
                        } else {
                            echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                        }
                    }
                    
                    $v3 = 1;
                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                }

                if ($v1 == 1 && $v2 == 1 && $v3 == 1) {
                    echo "<p>All Updates Successful</p><br>";
                    echo "<a href='Staff_Functions.php'>Go Back</a>";
                    echo "&emsp;&emsp;<a href='Logout.php'>Logout</a><br><br><br><br>";

                } else {
                    echo "<p>Process Failed</p><br><br>";
                }

            } elseif (isset($_POST["yes"])) {
                echo "<p>Type 'yes'</p><br><br><br><br><br>";
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