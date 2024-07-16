<?php
    session_start();
?>
<html>
<html>
<head>
    <title>Student</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="functions.css">
</head>
<body>
    <?php
        if (isset($_SESSION["name"])) {
            echo "<br><br>
            <div class='divbody'>
                <br>
                <h1>Welcome, $_SESSION[name]</h1>
                What would you like to do today?
                <br><br><br><br>
                <a href='Profile.php'><button>View Profile</button></a> &emsp;&emsp;&emsp;
                <a href='Search.php'><button>Search</button></a>&emsp;&emsp;&emsp;
                <a href='Borrow.php'><button>Borrow Book(s)</button></a>
                <br><br><br>
                <a href='Renew.php'><button>Renew</button></a> &emsp;&emsp;&emsp;
                <a href='Suggest.php'><button>Suggest</button></a> &emsp;&emsp;&emsp;
                <a href='Status.php'><button>Check Status</button></a>
                <br><br><br>
                <a href='Logout.php'><button id='logout'>Logout</button></a>
                <br><br><br>
                </div>
            ";
        } else {
            echo "<br><br><br><br><br><br><br><br><br>
            <div class='divbody'>
                <br><br>
                <h1>Please Login to Access the Features</h1>
                <br><br>
            ";
        }
    ?>
</body>
</html>