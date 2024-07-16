<?php
    session_start();
?>
<html>
<head>
    <title>Suggest</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="suggest.css">
</head>
<body>
    <br><br>
    <form method="POST">
        <br>
        <h1 style='font-size: 50px;'>Suggestions</h1>

        <label for="suggestion">What do you think can be improved in this website?</label>
        <br><br>
        <textarea name="suggestion" rows="7" cols="40" minlength="10" maxlength="200" required placeholder="Maximum of 200 characters"></textarea>
        <br><br><br>

        <input type="submit" value="Submit Suggestion" style="cursor:pointer;">
        <br><br><br>
    <?php
        if (isset($_SESSION["no"])) {
            if (isset($_POST["suggestion"])) {

                $no = $_SESSION["no"];
                $type = $_SESSION["type"];

                $suggestion = $_POST["suggestion"];

                $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                $insert = "insert into suggestions values ('$no', '$type', '$suggestion')";

                if (mysqli_query($link, $insert)) {
                    echo "Your suggestion has been noted. Thank you.<br><br>";
                    echo "<a href='Suggest.php' style='text-decoration: none;'>Make Another Suggestion</a>&emsp;";
                    echo "<a href='Logout.php' style='text-decoration: none;'>Logout and Go to Home Page</a>";
                    echo "<br><br>";

                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
                }
            } 
        } else {
            echo "
            <div class='divbody'>
                <h1>Please Login to Access the Features</h1>
                <br><br>
            </div>
            <br><br><br>
            ";
        }
    ?>
</body>
</html>