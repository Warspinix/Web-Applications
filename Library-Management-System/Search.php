<?php
    session_start();
?>
<html>
<head>
    <title>Search</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="table.css">
</head>
<body><br><br><br>
    <div class="divbody">
    <br><br><br>
    <form method="POST">
        <input type="text" name="search" required placeholder="Search by Name, Author, or Subject" id="search">
        <br><br><br><br>
        <select name="format" required>
            <option value="" disable selected>Choose the Search Parameter</option>
            <option value="title">Name of the Book</option>
            <option value="author">Author of the Book</option>
            <option value="book_subject">Subject</option>
        </select>   
        &emsp;&emsp;&emsp;&emsp;
        <input type="submit" value="Search" style="cursor: pointer;">
        <br><br><br><br>
    <?php
        if (isset($_SESSION['no'])) {
            if (isset($_POST["format"])) {

                $search = $_POST["search"];
                $format = $_POST["format"];
                
                $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE)
                    die("Error connecting to database. Please try again later.");
                
                $select = "select * from books where $format like '%$search%'";

                if ($result=mysqli_query($link, $select)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>
                                <tr>
                                    <th>Book ID</th>
                                    <th>Title</th>
                                    <th>Author(s)</th>
                                    <th>Subject</th>
                                    <th>Total No. of Copies</th>
                                    <th>No. of Available Copies</th>
                                </tr>    
                        ";
                        while ($row=mysqli_fetch_array($result)) {
                            echo "<tr>
                                    <td>$row[book_id]</td>
                                    <td>$row[title]</td>
                                    <td>$row[author]</td>
                                    <td>$row[book_subject]</td>
                                    <td>$row[no_of_copies]</td>
                                    <td>$row[available_copies]</td>
                                </tr>
                            ";
                        }
                        echo "</table><br><br></div>";
                    } else {
                    echo "<br><br><br><br>No Results Found";
                    }
                } else {
                    echo "<br><br><br><br>here is some error from our side. Please try again later. 
                    Error Message: ".mysqli_error($link);
                }
            } 
        } else {
            echo "<br><br><br>
            <div class='divbody'>
                <br><br>
                <h1>Please Login to Access the Features</h1>
                <br><br>
            </div>";
        }
    ?>
</body>
</html>