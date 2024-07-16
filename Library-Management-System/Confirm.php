<?php
    session_start();
?>
<html>
<head>
    <title>Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="confirm.css">
</head>
<body>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_SESSION["title"])) {
                $no = $_SESSION["no"];
                $book_id = $_SESSION["book_id"];
                $title = $_SESSION["title"];
                $type = $_SESSION["type"];
                $book_type = $_SESSION["book_type"];

                $v1 = $v2 = $v3 = $v4 = 0;

                $date = date("Y-m-d");

                $months_30 = array("04","06","09","11");
                $months_31 = array("01","03","05","07","08","10","12");

                if ($book_type == "Normal") {
                    $c = "no_of_books_borrowed";
                    $y = date("Y");
                    $m = date("m");
                    if (in_array($m,$months_30)) {
                    	$d = strval(date("d")+14);
                        if ($d > 30) {
                        $m += 1;
                        $d = strval($d%30);
                        }
                    }
                    else if (in_array($m,$months_31)) {
                    	$d = strval(date("d")+14);
                        if ($d > 31) {
                        $m += 1;
                        $d = strval($d%31);
                        }
                    }
                    else {
                    	$d = strval(date("d")+14);
                        if ($d > 28) {
                        $m += 1;
                        $d = strval($d%28);
                        }
                    }
                        
                    if (strlen($d) == 1)
                    	$d = "0$d";
                    $m = strval($m);
                    if (strlen($m) == 1)
                    	$m = "0$m";
                    
                    $return_date = "$y-$m-$d";
                } else {
                    $c = "book_bank_borrowed";
                    $y = date("Y");
                    $m = strval((date("m")+3)%12);
                    if (strlen($m) == 1)
                    	$m = "0$m";
                    $d = date("d");
                    $return_date = "$y-$m-$d";
                }
                
                if ($type == "student") {
                    $regid = "reg_no";
                    $table = "s".$no;
                } else {
                    $regid = "faculty_id";
                    $table = "f".$no;
                }

                $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE)
                    die("Error connecting to database. Please try again later.");

                $s1 = "select * from $type where $regid = '$no'";

                if ($r1 = mysqli_query($link,$s1)) {
                    if (mysqli_num_rows($r1) == 1) {
                        $row1 = mysqli_fetch_array($r1);
                        $name = $row1['fname'] . " " . $row1['lname'];
                        $no_borrowed = $row1[$c]+1;
                        $no_can_borrow = 4 - $no_borrowed;
                        if ($no_borrowed < 5) {
                            $s2 = "select available_copies from books where title='$title'";
                            if ($r2 = mysqli_query($link, $s2)) {
                                if (mysqli_num_rows($r2) == 1) {
                                    $row2 = mysqli_fetch_array($r2);
                                    $a = $row2['available_copies'] - 1;
                                    $u2 = "update books set available_copies = '$a' where title = '$title'";
                                    if (mysqli_query($link, $u2))
                                        $v1 = 1;
                                    else    
                                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br>";
                                }
                            } else {
                                echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br>";
                            }
                            $u3 = "update $type set $c='$no_borrowed' where $regid = '$no'";
                            if (mysqli_query($link, $u3))
                                $v2 = 1;
                            else
                                echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br>";

                            $s4 = "select * from $table";
                            if ($r4 = mysqli_query($link, $s4)) {
                                $latest_sno = 1;
                                if (mysqli_num_rows($r4) > 0) {
                                    while ($row4 = mysqli_fetch_array($r4)) {
                                        $latest_sno = $row4['sno'];
                                    }
                                    $latest_sno = $latest_sno + 1;
                                }
                                $i4 = "insert into $table values ('$latest_sno', '$title', '$date', '$return_date', 0)";
                                if (mysqli_query($link, $i4))
                                    $v3 = 1;
                                else
                                echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br>";
                            }
                            $s5 = "select * from borrow_log";
                            if ($r5 = mysqli_query($link, $s5)) {
                                $latest_borrow_id = 1;
                                if (mysqli_num_rows($r5) > 0) {
                                    while ($row4 = mysqli_fetch_array($r5)) {
                                        $latest_borrow_id = $row4['borrow_id'];
                                    }
                                    $latest_borrow_id = $latest_borrow_id + 1;
                                }
                                $i5 = "insert into borrow_log values ('$latest_borrow_id','$no','$book_id','$title','$date','$return_date','No', 0)";
                                if (mysqli_query($link, $i5))
                                    $v4 = 1;
                                else
                                echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br>";
                            }
                            if ($v1 == 1 && $v2 == 1 && $v3 == 1 && $v4 == 1) {
                                echo "<br><br><div class='divbody'>
                                <br><br>
                                <h1>Book Borrow Successful</h1>
                                <br><br>
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <td>$name</td>
                                    </tr>
                                    <tr>
                                        <th>Book Borrowed</th>
                                        <td>$title</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>$book_type</td>
                                    </tr>
                                    <tr>
                                        <th>No. of $book_type Slots Available</th>
                                        <td>$no_can_borrow</td>
                                    </tr>
                                </table>
                                <br><br>
                            </div>";
                            echo "<br><br><br><div class='divbody'><br><br>";
                            if ($type == "student")
                                echo "<a href='Student_Functions.php'><button id='button'>Functions Page</button></a> &emsp;";
                            else
                                echo "<a href='Faculty_Functions.php'><button id='button'>Functions Page</button></a> &emsp;";
                            echo "<a href='Logout.php'><button id='logout'>Logout</button></a><br><br><br>
                            </div>
                             <br><br><br><br>";
                            }
                        } else {
                            echo "<br><br><br><div class='divbody'><br><br><br>
                            <p style='text-align: center; font-size: 20px;'>Sorry, you have borrowed the maximum amount of books. You have to return a book now to borrow another.</p><br><br>";
                            if ($type == "student")
                                echo "<a href='Student_Functions.php'><button id='button'>Functions Page</button></a> &emsp;";
                            else
                                echo "<a href='Faculty_Functions.php'><button id='button'>Functions Page</button></a> &emsp;";
                            echo "<a href='Logout.php'><button id='logout'>Logout</button></a><br><br><br>
                            </div>
                             <br><br><br>";
                        }

                    }
                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                }
            } else {
                echo "<br><br><br><br><br><br><br><br><br>
                <div class='divbody'>
                    <br><br>
                    <h1><No Books Borrowed/h1>
                    <br><br>
                </div>
                <br><br><br>
                ";
                echo "<div class='divbody'><br><br><br>";
                if ($type == "student")
                    echo "<a href='Student_Functions.php'><button id='button'>Functions Page</button></a> &emsp;";
                else
                    echo "<a href='Faculty_Functions.php'><button id='button'>Functions Page</button></a> &emsp;";
                echo "<a href='Logout.php'><button id='logout'>Logout</button></a><br><br><br><br>
            </div>
        <br><br><br>";
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
</body>
</html>