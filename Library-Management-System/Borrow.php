<?php
    session_start();
?>
<html>
<head>
    <title>Borrow</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="borrow.css">
</head>
<body>
    <br>
    <form method="POST">
        <br>
        <h1 style="text-align: center; font-size: 50px;">Borrow Book(s)</h1>
        <br>

        <input type="text" name="book_id" minlength="5" maxlength="5" autofocus required placeholder="Enter the ID of the Book" id="search">
        <br><br>

        <input type="submit" value="Check for Availability" id="button">
        <br><br>
    </form>
    <?php
        if (isset($_SESSION["type"])) {
            echo "<div style='text-align: center;'>";
            if ($_SESSION["type"] == "student")
                echo "<a href='Student_Functions.php'><button>Functions Page</button></a> &emsp;";
            else
                echo "<a href='Faculty_Functions.php'><button>Functions Page</button></a> &emsp;";
            
            echo "<a href='Search.php'><button>Search Page</button></a> &emsp;
            <a href='Logout.php'><button id='logout'>Logout</button></a>
            </div>
            <br>";
            
            if (isset($_POST["book_id"])) {
                $book_id = $_POST["book_id"];

                $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE)
                    die("Error connecting to database. Please try again later.");

                $select = "select * from books where book_id = '$book_id'";

                if ($result = mysqli_query($link, $select)) {
                    if (mysqli_num_rows($result) == 1) {
                        echo "<table>
                                <tr>
                                    <th>Title</th>
                                    <th>No. of Copies Available</th>
                                    <th></th>";
                        $row = mysqli_fetch_array($result);
                        echo "<tr>
                                <td>$row[title] by $row[author]</td>
                                <td>$row[available_copies]</td>
                            ";
                        if ($row['available_copies'] > 0)  {
                            $_SESSION["book_id"] = $row['book_id'];
                            $_SESSION["title"] = $row['title'];
                            $_SESSION["book_type"] = $row['type'];
                            echo "<td><a href='Confirm.php' style='text-decoration: none;'>Borrow</a></td></tr>";
                        } else {
                             echo "<td></td></tr>";
                        }
                        echo "</table><br>";
                    } else {
                        echo "<p>Sorry, no books found.</p><br>";
                    }
                } else {
                    echo "<p>Sorry, we are facing some unknown error. Please try again later. Error: ".mysqli_error($link)."</p><br>";
                }
            }
        } else {
            echo "<p>Please Login to Access the Features</p><br>";
        }
    ?>
</body>
</html>