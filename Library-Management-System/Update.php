<?php
    session_start();
?>
<html>
<head>
    <title>Update Copies</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <br>
    <form method="POST">
        <br>
        <div class="divheading1">
            <h1>Update Book Count</h1>
        </div>
        <br>

        <input type="text" name="id" minlength="5" maxlength="5" autofocus required placeholder="Book ID">
        <br><br><br>

        <input type="number" name="number"  min="1" max="10" required placeholder="No. of Copies">
        <br><br><br>

        <input type="submit" value="Update" style='height: 60px; cursor: pointer;'>
        <br><br><br>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_POST["number"])) {

                $id = $_POST["id"];
                $number = (int)$_POST["number"];

                $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                $select = "select no_of_copies, available_copies from books where book_id = '$id'";

                if ($result = mysqli_query($link, $select)) {
                    $row = mysqli_fetch_array($result);
                    $total = $row['no_of_copies'] + $number;
                    $available = $row['available_copies'] + $number;

                    $u1 = "update books set no_of_copies='$total' where book_id = '$id'";
                    $u2 = "update books set available_copies='$available' where book_id = '$id'";

                    if (mysqli_query($link, $u1) && mysqli_query($link, $u2)) {
                        echo "<p>Update Successful</p><br>";
                        echo "<div>
                        <a href='Staff_Functions.php'>Go to Functions Page</button></a> &emsp;
                        <a href='Logout.php'>Logout</button></a><br><br>
                    </div>";

                    } else {
                        echo "<br><br><p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                    }


                } else {
                    echo "<br><br><p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
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