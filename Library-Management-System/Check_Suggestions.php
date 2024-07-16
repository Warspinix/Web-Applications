<?php
    session_start();
?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="check_suggestions.css">
</head>
<body>
    <?php
        if (isset($_SESSION["no"])) {
            echo "<br>
                    <div class='divheading1'>
                        <h1 style='text-align: center'>All Suggestions</h1>
                    </div>
                <br>";
            $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE)
                    die("Error connecting to database. Please try again later.");

            $select = "select * from suggestions";

            if ($result = mysqli_query($link, $select)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>
                            <tr style='height: 60px;'>
                                <th>User ID</th>
                                <th>Member Type</th>
                                <th>Suggestion Provided</th>
                            </tr>";
                    while ($row = mysqli_fetch_array($result)) {
                        $member_type = strtoupper(substr($row['member_type'], 0, 1)).substr($row['member_type'],1);
                        echo "<tr>
                                <td>$row[regid]</td>
                                <td>$member_type</td>
                                <td>$row[suggestion]</td>
                                </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No suggestions found. Check again later.</p>";
                }

            } else {
                echo "<p'>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br><br>";
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
</htm