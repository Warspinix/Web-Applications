<?php
    session_start();
?>
<html>
<head>
    <title>Check Status</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="status.css">
</head>
<body>
    <?php
        if (isset($_SESSION["no"])) {

            $no = $_SESSION["no"];
            $type = $_SESSION["type"];

            $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE)
                    die("Error connecting to database. Please try again later.");

            if ($type == "student") 
                $table = "s".$no;
            else
                $table = "f".$no;

            $select = "select * from $table";

            if ($result = mysqli_query($link, $select)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<br><div class='divheading1'>
                                <h1 style='text-align:center;'>Your Book Details</h1>
                            </div><br>";
                    echo "<table>
                            <tr>
                                <th>Title</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Fine</th>
                            </tr>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>
                                <td>$row[book]</td>
                                <td>$row[borrow_date]</td>
                                <td>$row[due_date]</td>
                                <td>$row[past_due_days]</td>
                            </tr>";
                    }
                    echo "</table>";

                } else {
                    echo "<br><p style='text-align: center;'>You haven't borrowed any books</p>";

                }
                if ($type == "student") {
                    echo "<br><br><br><div class='divbody'>
                            <a href='Student_Functions.php' style='text-decoration: none;'>
                                <button>Go Back</button>
                            </a>&emsp;";
                } else {
                    echo "<div class='divbody'>
                            <a href='Faculty_Functions.php' style='text-decoration: none;'>
                                <button>Go Back</button>
                            </a>&emsp;";
                }
                echo "<a href='Logout.php' style='text-decoration: none;'><button id='logout'>Logout</button></a>";
                echo "<br><br>";
                echo "</div>";
            

            } else {
                echo "<br><p style='text-align:center;'>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
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