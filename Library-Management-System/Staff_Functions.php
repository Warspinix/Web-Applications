<?php
    session_start();
?>
<html>
<html>
<head>
    <title>Staff</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="functions.css">
    <style>
        button {
            width: 16%;
        }
    </style>
</head>
<body>
    <?php
        if (isset($_SESSION["name"])) {
            echo "<br><br>
                    <div class='divbody' style='width:90%;'>
                    <br>
                        <h1>Welcome, $_SESSION[name]</h1>
                        What would you like to do today?
                        <br><br><br><br>
                        <a href='Profile.php'><button>View Profile</button></a> &emsp;&emsp;&emsp;
                        <a href='Search.php'><button>Search</button></a> &emsp;&emsp;&emsp;
                        <a href='Details.php'><button>User Details</button></a> &emsp;&emsp;&emsp;
                        <a href='Check_Suggestions.php'><button>View Suggestions</button></a> 
                        <br><br><br>
                        <a href='Remove.php'><button>Remove User</button></a> &emsp;&emsp;&emsp;
                        <a href='Add.php'><button>Add Book</button></a> &emsp;&emsp;&emsp;
                        <a href='Update.php'><button>Update Copies</button></a> &emsp;&emsp;&emsp;
                        <a href='Minor.php'><button>Minor Tasks</button></a> 
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