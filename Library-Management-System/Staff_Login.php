<?php
session_start();
$_SESSION["type"] = "library_staff";
?>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
</head>

<body> 
    <br><br><br>
    <div class="divheading1">
        <h1 id="center">Staff Login</h1>
    </div>

    <form method="POST">
        <br><br>
        <div id="center">
            <input type="text" name="id" minlength="10" maxlength="10" size="17" placeholder="Staff ID" autofcous required>
            <br><br>

            <input type="password" name="pw" size="17" placeholder="Password" required>
            <br><br>

            <input type="submit" value="Login" style="cursor: pointer; width: 68%; font-family: 'Trebuchet MS';">
            <br><br>

            <div style="color:white; font-size: 16px;" >
                <a style="text-decoration: none; color:white;" href="Staff_Register.php">Register</a>
                .&nbsp;<a style="text-decoration: none; color:white;" href="Forgot_Password.php">Forgot Password</a>
            </div>
        </div>
        <br><br>
    </form>

    <?php
        function id_valid($reg) {
            $words = array("LIBRA","STAFF","BOOKS");
            $l = substr($reg, 0, 5);
            $n = substr($reg, 5, 5);
            if (in_array($l, $words) && is_numeric($n))
                return TRUE;
            else
                return FALSE;
        }
        if (isset($_POST["pw"])) {
            $id = $_POST["id"];
            $pw = $_POST["pw"];
            
            if (id_valid($id)) {
                $link = mysqli_connect("localhost","root","","library");
                if ($link == FALSE) {
                    die("Error connecting to database. Please try again later.");
                }
                $select = "select staff_id, password, fname, lname from library_staff where staff_id='$id'";
                if ($result=mysqli_query($link, $select)) {
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result);
                        if ($row['password'] == $pw) {
                            $_SESSION["name"] = $row['fname'];
                            $_SESSION["no"] = $row['staff_id'];
                            header("Location: Staff_Functions.php");
                        } else {
                            echo "<p>Invalid Password</p>";
                        }
                    } else {
                        echo "<p>You have not registered yet. Please register and then login.</p>";
                    }
                } else {
                    echo "<p>There is some error from our side. Please try again later. 
                    Error Message: ".mysqli_error($link)."</p>";
                }
            } else {
                echo "<p>Invalid Register Number</p>";
            }
        }
    ?>
</body>
</html>