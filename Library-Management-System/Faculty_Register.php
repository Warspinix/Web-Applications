<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <br><br><br>
    <form method="POST">
        <br>
        <div class="divheading1">
            <h1 id="center">Faculty Registration</h1>
        </div>
        
        &emsp;&emsp;&emsp;&emsp;
        <label for="fn">First Name</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label for="ln">Last Name</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label for="email">E-Mail ID</label>
        
        <br><br>

        &emsp;&emsp;&emsp;&emsp;
        <input type="text" name="fn" size="15" placeholder="First Name" autofocus required>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="text" name="ln" size="15" placeholder="Last Name" required>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="email" name="email" size="15" placeholder="E-Mail" required>
        
        <br><br><br>

        &emsp;&emsp;&emsp;&emsp;
        <label for="id">Faculty ID</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;
        <label for="pw1">Password</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;
        <label for="pw2">Confirm Password</label>
        
        <br><br>

        &emsp;&emsp;&emsp;&emsp;
        <input type="text" name="id" size="15" minlength="10" maxlength="10" placeholder="Faculty ID" required>       
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="password" name="pw1" minlength="8" maxlength="15" size="15" placeholder="Password" required>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="password" name="pw2" minlength="8" maxlength="15" size="15" placeholder="Confirm Password" required>

        <br><br><br>

        &emsp;&emsp;&emsp;&emsp;
        <label for="gender">Gender:</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label for="dob">Date of Birth:</label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label for="mno">Mobile No:</label>

        <br><br>
        
        &emsp;&emsp;&emsp;&emsp;
        <select name="gender" placeholder="Gender" required>
            <option value="" disable selected>Choose Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;
        <input type="date" name="dob" required>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;
        <input type="text" name="mno" minlength="10" maxlength="10" size="15" placeholder="00000 00000" required>

        <br><br><br><br>

        <div id="center">
            <input type="submit" value="Register" style="cursor: pointer; height: 50px; width: 30%;">
        </div>
        <br><br>

    </form>
    <?php
        function id_valid($id) {
            $depts = array( "501"=>"Automobile Engineering",
                            "502"=>"Aerospace Engineering",
                            "503"=>"Electronics Engineering",
                            "504"=>"Instrumentation Engineering",
                            "505"=>"Production Technology",
                            "506"=>"Information Technology",
                            "507"=>"Rubber and Plastics Technology",
                            "508"=>"Robotics and Automation",
                            "509"=>"Computer Technology");
            $y = (int)substr($id, 0, 5);
            $d = substr($id, 5, 3);
            $n = (int)substr($id, 8, 2);
            if (is_numeric($id) && $y == 11111 && array_key_exists($d, $depts) && $n >= 1 && $n <= 30)
                return TRUE;
            else
                return FALSE;
        }
        function password_valid($p1) {
            $arr = str_split($p1);
            $upper = $lower = $no = $spl = 0;
            $len = strlen($p1);
            foreach ($arr as $i) {
                if (ctype_upper($i)) 
                    $upper = 1;
                else if (ctype_lower($i))
                    $lower = 1;
                else if (is_numeric($i)) 
                    $no = 1;
                else
                    $spl = 1;
            }
            if ($upper == 1 && $lower == 1 && $no == 1 && $spl == 1)
                return TRUE;
            else 
                return FALSE;    
        }
        function password_match($p1, $p2) {
            return $p1 == $p2;
        }
        function calculate_age($dob) {
            $currentyear = date("Y");
            $currentmonth = date("m");
            $currentdate = date("d");

            $dobyear = (int)substr($dob, 0, 4);
            $dobmonth = (int)substr($dob, 5, 2);
            $dobdate = (int)substr($dob, 8, 2);

            if (($dobmonth > $currentmonth) || ($dobmonth == $currentmonth && $dobdate > $currentdate))
                $age = $currentyear - $dobyear - 1;
            else
                $age = $currentyear - $dobyear;

            return $age;
        }
        function dob_valid($dob) {
            $age = calculate_age($dob);
            if ($age > 0)
                return TRUE;
            else 
                return FALSE;
        }
        function age_valid($age) {
            if ($age >= 30)
                return TRUE;
            else
                return FALSE;
        }
        function mno_valid($mobile) {
            if (is_numeric($mobile))
                return TRUE;
            else
                return FALSE;
        }
        function find_dept($id) {
            $depts = array( "501"=>"Automobile Engineering",
                            "502"=>"Aerospace Engineering",
                            "503"=>"Electronics Engineering",
                            "504"=>"Instrumentation Engineering",
                            "505"=>"Production Technology",
                            "506"=>"Information Technology",
                            "507"=>"Rubber and Plastics Technology",
                            "508"=>"Robotics and Automation",
                            "509"=>"Computer Technology");
            return $depts[(int)substr($id,5,3)];
        }
        if (isset($_POST["mno"])) {
            $fn = $_POST["fn"];
            $ln = $_POST["ln"];
            $email = $_POST["email"];
            $id = $_POST["id"];
            $pw1 = $_POST["pw1"];
            $pw2 = $_POST["pw2"];
            $gender = $_POST["gender"];
            $dob = $_POST["dob"];
            $mno = $_POST["mno"];

            $age = calculate_age($dob);

            $table = "f".$id;

            if (id_valid($id)) {
                $dept = find_dept($id);
                if (password_valid($pw1)) {
                    if (password_match($pw1, $pw2)) {
                        if (dob_valid($dob)) {
                            if (age_valid($age)) {
                                if (mno_valid($mno)) {
                                    $link = mysqli_connect("localhost", "root", "", "library");
                                    if ($link == FALSE) {
                                        echo "<p>";
                                        die("Error connecting to database. Please try again later.");
                                    }
                                    $create = "create table $table (
                                                    sno int unique not null,
                                                    book varchar(100),
                                                    borrow_date date,
                                                    due_date date,
                                                    past_due_days int
                                                )"; 

                                    if (mysqli_query($link,$create)) {
                                        $insert = "insert into faculty values ('$id', '$pw1', '$fn', '$ln',
                                                                                '$dept', '$gender', '$dob',
                                                                                '$age', '$email', '$mno', 0, 0)";
                                        if (mysqli_query($link, $insert)) {
                                            echo "<p>Registration Successful. &nbsp;
                                            <a href='Faculty_Login.php'><button style='cursor: pointer;'>Go to Login</button></a></p>";
                                        } else {
                                            echo "<p>There is some error from our side. Please try again later. 
                                            Error Message: ".mysqli_error($link)."</p>";
                                            $drop = "drop table $table";
                                            mysqli_query($link, $drop);
                                        }
                                    } else {
                                        echo "<p>You are already registered. &nbsp;        
                                        <a href='Faculty_Login.php'><button style='cursor: pointer;'>
                                        Proceed to login.
                                        </button></a></p>";
                                    }
                                } else {
                                    echo "<p>Invalid Mobile Number.</p>";
                                }
                            } else {
                                echo "<p>Sorry, you are not old enough to register.</p>";
                            }
                        } else {
                            echo "<p>Invalid Date of Birth.</p>";
                        }
                    } else {
                        echo "<p>Passwords do not match.</p>";
                    }
                } else {
                    echo "<p>Password should contain at least 1 lowercase letter, 1 uppercase letter, 1 number, and 1 special character.</p>";
                }
            } else {
                echo "<p>Invalid Faculty ID.</p>";
            }
        }
    ?>
</body>
</html>