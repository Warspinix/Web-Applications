<?php
    session_start();
?>
<html>
<head>
    <title>Renew Books</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="renew.css">
</head>
<body>
    <br>
    <form method="POST">
        <br><br>
        <h1 style="font-size: 60px;">Renewal</h1>
        <br><br>
        <input type="text" name="renew" autofocus required placeholder="Type 'renew'" id="type"><br><br>
        <input type="submit" value="Renew All Books" id="renew">
        <br><br>
    </form>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_POST["renew"])) {
                echo "<div style='text-align:center;'>";
                if ($_SESSION["type"] == "student")
                        echo "<a href='Student_Functions.php'><button id='button'>Go to Functions Page</button></a> &emsp;";
                else
                        echo "<a href='Student_Functions.php'><button id='button'>Go to Functions Page</button></a>";
                echo "<a href='Logout.php'><button id='logout'>Logout</button></a>
                    </div>";
                $no = $_SESSION["no"];
                $type = $_SESSION["type"];
                $renew = $_POST["renew"];

                $v = 0;

                $months_30 = array("04","06","09","11");
                $months_31 = array("01","03","05","07","08","10","12");

                if ($type == "student")
                    $table = "s".$no;
                else
                    $table = "f".$no;

                $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE)
                    die("Error connecting to database. Please try again later.");

                $today = date('Y-m-d');

                $s1 = "select * from $table";
                if ($r1 = mysqli_query($link, $s1)) {
                    if (mysqli_num_rows($r1) > 0) {
                        while ($row1=mysqli_fetch_array($r1)) {
                            $book = $row1['book'];
                            $s2 = "select title, type from books";
                            if ($r2 = mysqli_query($link, $s2)) {
                                while ($row2 = mysqli_fetch_array($r2)) {
                                    if ($row2['title'] == $book && $row2['type'] == "Normal") {
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

                                        $u1 = "update $table set borrow_date = '$today'";
                                        $u2 = "update $table set due_date = '$return_date'";
                                        $u3 = "update borrow_log set return_status=Yes where regid='$no' and title='$book' and return_status=No";

                                        mysqli_query($link, $u1);
                                        mysqli_query($link, $u2);
                                        mysqli_query($link, $u3);

                                        $s3 = "select * from borrow_log";

                                        if ($r3 = mysqli_query($link, $s3)) {
                                            $latest_borrow_id = 1;
                                            if (mysqli_num_rows($r3) > 0) {
                                                while ($row3= mysqli_fetch_array($r3)) {
                                                    $latest_borrow_id = $row3['borrow_id'];
                                                }
                                                $latest_borrow_id = $latest_borrow_id + 1;
                                            }
                                            
                                            $s4 = "select book_id from books where title='$book'";
                                            $r4 = mysqli_query($link, $s4);
                                            $row4 = mysqli_fetch_array($r4);
                                            $book_id = $row4['book_id'];
                                            

                                            $i5 = "insert into borrow_log values ('$latest_borrow_id','$no','$book_id','$book','$today','$return_date','No', 0)";
                                            if (mysqli_query($link, $i5))
                                                $v = 1;
                                            else
                                            echo "<br><br><div class='divbody'>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</div><br>";
                                        }
                                        
                                    }
                                }
                            }
                        }
                        if ($v == 1 && $renew == "renew") {
                            echo "<br><div style='text-align: center; font-size: 40px;'><br>Renewal Successful for all Books</div>";
                            $select = "select * from $table";
                            $result = mysqli_query($link,$select);
                            echo "<br><br>
                                <table>
                                    <tr>
                                        <th>Title of the Book</th>
                                        <th>Borrow Date</th>
                                        <th>Due Date</th>
                                    </tr>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>
                                        <td>$row[book]</td>
                                        <td>$row[borrow_date]</td>
                                        <td>$row[due_date]
                                    </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<br><br><div class='divbody'>Type 'renew'!</div><br>";
                        }
                    } else {
                        echo "<br><br><br>
                        <div class='divbody'>
                            <br><br>
                            <h1>You don't have any books borrowed normally to renew.</h1>
                            <br><br>
                        </div>
                        <br><br><br>";
                    }
                } else {
                    echo "<div class='divbody'>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</div><br><br>";
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
</body>
</html>