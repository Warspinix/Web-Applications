<?php
    session_start();
?>
<html>
<head>
    <title>Add</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add.css">
</head>
<body>
    <br><br>
    <form method="POST">
        <br>
        <h1 style="text-align:center; font-size:50px;">Add New Book(s)</h1>
        <br><br><br>

        &emsp;&emsp;&emsp;
        <label for="book_id">Book ID</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label for="publication_year">Year of Publication</label>
        <br><br>

        &emsp;&emsp;&emsp;
        <input type="text" name="book_id" minlength="5" maxlength="5" size="10" autofocus required placeholder="Book ID">
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="number" name="publication_year" min="1950" max="2023" required placeholder="Year">
        <br><br><br>

        &emsp;&emsp;&emsp;
        <label for="title">Title of the Book</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label for="type">Type</label>
        <br><br>

        &emsp;&emsp;&emsp;
        <input type="text" name="title" size="25" required placeholder="Book Title">
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <select name="type" required>
            <option value="" disable selected>Type</option>
            <option value="Normal">Normal</option>
            <option value="Bookbank">Book Bank</option>
        </select>
        <br><br><br>

        &emsp;&emsp;&emsp;
        <label for="author">Author(s)</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&emsp;
        <label for="total">How Many Copies?</label>
        <br><br>

        &emsp;&emsp;&emsp;
        <input type="text" name="author" size="25" required placeholder="Authors">
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="number" name="total" min="1" max="10" size="15" required>
        <br><br><br>

        &emsp;&emsp;&emsp;
        <label for="subject">Subject</label>
        <br><br>

        &emsp;&emsp;&emsp;
        <select name="subject" required>
            <option value="" disable selected>Choose Subject</option>
            <option value="DBMS">DBMS</option>
            <option value="EEE">EEE</option>
            <option value="Maths">Mathematics</option>
            <option value="Medicine">Medicine</option>
            <option value="Physics">Physics</option>
            <option value="Chemistry">Chemistry</option>
            <option value="Robotics">Robotics</option>
            <option value="Programming">Programming</option>
            <option value="Computer Science">Computer Science</option>
            <option value="Biology">Biology</option>
            <option value="Language">Language</option>
        </select>

        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="submit" value="Add Book" style="background-color:black; color:white; cursor: pointer;">
        <br><br><br><br>
    </form>
    <?php
        if (isset($_SESSION["type"])) {
            if ($_SESSION["type"] == "library_staff") {
                if (isset($_POST["subject"])) {

                    $book_id = $_POST["book_id"];
                    $title = $_POST["title"];
                    $author = $_POST["author"];
                    $subject = $_POST["subject"];
                    $year = $_POST["publication_year"];
                    $type = $_POST["type"];
                    $copies = $_POST["total"];

                    $link = mysqli_connect("localhost","root","","library");
                    if ($link == FALSE)
                        die("Error connecting to database. Please try again later.");

                    if (is_numeric($book_id)) {
                        $s1 = "select * from books where book_id='$book_id'";
                        if ($r1 = mysqli_query($link,$s1)) {
                            if (mysqli_num_rows($r1) == 1) {
                                $row = mysqli_fetch_array($r1);
                                if ($row['title'] == $title) {
                                    $no_of_copies = $row['no_of_copies'] + $copies;
                                    $available_copies = $row['available_copies'] + $copies;
                                    
                                    $u1 = "update books set no_of_copies='$no_of_copies' where book_id='$book_id'";
                                    mysqli_query($link,$u1);
                                    $u2 = "update books set available_copies='$available_copies' where book_id='$book_id'";
                                    mysqli_query($link,$u2);

                                    echo "<p>Update Successful.</p>";
                                } else {
                                    echo "<p>A book with this ID is already present. Please make use of another ID.";
                                }
                            } else {
                                $insert = "insert into books values ('$book_id','$title','$author','$subject','$year','$type','$copies','$copies')";
                                if (mysqli_query($link, $insert)) {
                                    echo "<p>Book Successfully Added</p>";
                                } else {
                                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p>";
                                }
                            }
                        } else {
                            echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p>";
                        }
                    } else {
                        echo "<p>Invalid Book ID.</p>";
                    }
                } 
            } else {
                echo "<p>Sorry, only library staff can add books.</p>";
            }
        } else {
            echo "<p>Please Login to Access the Features</p>";
        }
    ?>
</body>
</html>