<?php
    session_start();
?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <br><br>
    <form method="POST">
        <div class="divheading1" style='height: 200px;'>
            <br>
            <h1>User Details</h1>
        </div>
        <input type="text" name="no" minlength="10" maxlength="10" autofocus required placeholder="User ID">
        <br><br>

        <select name="type">
            <option value="" disable selected>Select Member Type</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
        </select>
        <br><br>

        <input type="submit" value="View Details" style='height: 50px;'>
        <br><br><br><br><br><br>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_POST["type"])) {

                $no = $_POST["no"];
                $table = $_POST["type"];

                if ($table == "student") {
                    $id = "reg_no";
                    $title = "Register Number";
                }
                else {
                    $id = "faculty_id";
                    $title = "Faculty ID";
                }

                $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                $select = "select * from $table where $id = '$no'";

                if ($result=mysqli_query($link, $select)) {
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result);
                        echo "<table>
                                <tr>
                                    <th>$title</th>
                                    <td>$row[$id]</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>$row[fname] $row[lname]</td>
                                <tr>
                                    <th>Email ID</th>
                                    <td>$row[email_id]</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>$row[dob]</td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td>$row[age]</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>$row[gender]</td>
                                </tr>
                                <tr>
                                    <th>Mobile Number</th>
                                    <td>$row[mobile_no]</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>$row[department]</td>
                                </tr>
                                <tr>
                                    <th>Year</th>
                                    <td>$row[year]</td>
                                </tr>
                                <tr>
                                    <th>No. of Books Currently Borrowed</th>
                                    <td>$row[no_of_books_borrowed]</td>
                                </tr>
                                <tr>
                                    <th>Books Borrowed through the Book Bank Scheme</th>
                                    <td>$row[book_bank_borrowed]</td>
                                </tr>
                            </table><br>
                        ";
                    } else {
                        echo "<p style='text-align: center; font-size: 30px;'>Sorry, no such $table member found.</p><br><br><br>";
                    }
                } else {
                    echo "<p style='text-align: center;'>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
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