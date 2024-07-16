<?php
    session_start();
?>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="functions.css">
    <link rel="stylesheet" href="table.css">
</head>
<body>
    <?php
        if (isset($_SESSION["no"])) {
            echo "<br><br><br>
            <div class='divbody'>
                <br>
                <h1>User Profile</h1>";
        
            $no = $_SESSION["no"];
            $type = $_SESSION["type"];
            if ($type == "student") {
                $n1 = "reg_no";
                $n2 = "Register Number";
            } else if ($type == "faculty") {
                $n1 = "faculty_id";
                $n2 = "Faculty ID";
            } else if ($type == "library_staff") {
                $n1 = "staff_id";
                $n2 = "Staff ID";
            }
            $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE) 
                    die("Error connecting to database. Please try again later.");
            $select = "select * from $type where $n1 = '$no'";
            if ($result = mysqli_query($link, $select)) {
                $row = mysqli_fetch_array($result);
                $name = $row['fname'] . " " . $row['lname'];
                $gender = $row['gender'];
                $mno = $row['mobile_no'];
                $email = $row['email_id'];
                $dob = $row['dob'];
                $age = $row['age'];

                if ($type == "student") {
                    $year = $row['year'];
                    $dept = $row['department'];
                    $bb = $row['no_of_books_borrowed'];
                    $bbb = $row['book_bank_borrowed'];
                    echo "<br>
                    <table>
                        <tr>
                            <th>Name</th>
                            <td>$name</td>
                        </tr>
                        <tr>
                            <th>Register Number</th>
                            <td>$no</td>
                        </tr>
                        <tr>
                            <th>Email ID</th>
                            <td>$email</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>$dob</td>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <td>$age</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>$gender</td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>$mno</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>$dept</td>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <td>$year</td>
                        </tr>
                        <tr>
                            <th>No. of Books Currently Borrowed</th>
                            <td>$bb</td>
                        </tr>
                        <tr>
                            <th>Books Borrowed through the Book Bank Scheme</th>
                            <td>$bbb</td>
                        </tr>
                    </table><br>
                    ";
                } else if ($type == "faculty") {
                    $dept = $row['department'];
                    $bb = $row['no_of_books_borrowed'];
                    $bbb = $row['book_bank_borrowed'];
                    echo "<br>
                    <table>
                        <tr>
                            <th>Name</th>
                            <td>$name</td>
                        </tr>
                        <tr>
                            <th>Faculty ID</th>
                            <td>$no</td>
                        </tr>
                        <tr>
                            <th>Email ID</th>
                            <td>$email</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>$dob</td>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <td>$age</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>$gender</td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>$mno</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>$dept</td>
                        </tr>
                        <tr>
                            <th>No. of Books Currently Borrowed</th>
                            <td>$bb</td>
                        </tr>
                        <tr>
                            <th>Books Borrowed through the Book Bank Scheme</th>
                            <td>$bbb</td>
                        </tr>
                    </table><br>
                    ";
                } else if ($type == "library_staff") {
                    echo "<br>
                    <table>
                        <tr>
                            <th>Name</th>
                            <td>$name</td>
                        </tr>
                        <tr>
                            <th>Staff ID</th>
                            <td>$no</td>
                        </tr>
                        <tr>
                            <th>Email ID</th>
                            <td>$email</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>$dob</td>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <td>$age</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>$gender</td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>$mno</td>
                        </tr>
                    </table><br><br>
                    ";
                }
            } else {
                echo "We are facing some issues. Please try again later. Error: ".mysqli_error($link);
            }
            echo "<a href='Logout.php'><button id='logout' style='height: 50px; width: 10%;'>Logout</button></a>
                <br><br></div>";
        } else {
            echo "<br><br><br><br><br><br><br><br><br>
            <div class='divbody'>
                <br><br>
                <h1>Please Login to Access the Features</h1>
                <br><br>
            </div>
            ";
        }
    ?>
</body>
</html>