<?php
    session_start();
?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href=".css">
</head>
<body>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_SESSION[""])) {

                $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                if (2 > 1) {

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
</body>
</html>