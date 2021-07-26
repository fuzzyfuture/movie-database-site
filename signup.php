<!-- Nathan Chay   -->
<!-- 200403221     -->
<!-- CS 215        -->
<!-- Oct. 6, 2020  -->

<?php
    $valid = true;
    $error = "";

    if (isset($_POST["submitted"]) && $_POST["submitted"])
    {
        $email = trim($_POST["email"]);
        $user = trim($_POST["user"]);
        $fname = trim($_POST["fname"]);
        $lname = trim($_POST["lname"]);
        $pass = trim($_POST["pass"]);

        $avi_dir = "avatars/";
        $avi = $_FILES['avi']['name'];
        $avi_tmp = $_FILES['avi']['tmp_name'];
        $avi_file_type = strtolower(pathinfo(basename($avi), PATHINFO_EXTENSION));

        $db = new mysqli("localhost", "ngc582", "Sponge7!", "ngc582");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

        $sql_email_check = $db->query("SELECT * FROM Users WHERE email = '$email'");

        if ($sql_email_check->num_rows > 0)
        {
            $valid = false;
            $error = "This e-mail is already in use.";
        }

        $sql_user_check = $db->query("SELECT * FROM Users WHERE username = '$user'");

        if ($sql_user_check->num_rows > 0)
        {
            $valid = false;
            $error = "This username is already in use.";
        }

        if ($avi_tmp > 500000)
        {
            $valid = false;
            $error = "Avatar is too large.";
        }

        if ($avi_file_type != "jpg" && $avi_file_type != "jpeg" && $avi_file_type != "png" && $avi_file_type != "gif")
        {
            $valid = false;
            $error = "Unsupported file type. Only .jpg, .jpeg, .png, and .gif avatars are allowed.";
        }

        if ($valid)
        {
            $avi_file_name = $avi_dir.$user.'.'.$avi_file_type;
            $sql_upload_avi = move_uploaded_file($avi_tmp, $avi_file_name);
            $sql_insert_data = $db->query("INSERT INTO Users (username, fname, email, password, avatar, isLoggedIn, lname) VALUES ('$user', '$fname', '$email', '$pass', '$avi_file_name', False, '$lname')");
                                            
            if ($sql_insert_data && $sql_upload_avi)
            {
               header("Location: login.php");
            }
            else
            {
                $error = "Registration error, please try again.";
            }
        }
        
        $db->close();
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <title>nate's movie database</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="./css/main.css"/>

        <script type="text/javascript" src="./scripts/form-validate.js"></script>
    </head>

    <body>
        <div class="index-div" style="line-height: 30px;">
            <form name="signup" id="signup" action="signup.php" method="post" enctype="multipart/form-data">
                <label for="email">e-mail</label> <br/>
                <input class="index-text-input" type="text" id="email" name="email"/>
                <label class="index-err" id="email-err"></label> <br/>

                <label for="user">username</label> <br/>
                <input class="index-text-input" type="text" id="user" name="user"/>
                <label class="index-err" id="user-err"></label> <br/>
                <br/>

                <label for="avi">avatar</label> <br/>
                <input class="index-file-input" type="file" id="avi" name="avi">
                <label class="index-err" id="avi-err"></label> <br/>
                <br/>

                <label for="fname">first name</label> <br/>
                <input class="index-text-input" type="text" id="fname" name="fname"/>
                <label class="index-err" id="fname-err"></label> <br/>

                <label for="lname">last name</label> <br/>
                <input class="index-text-input" type="text" id="lname" name="lname"/>
                <label class="index-err" id="lname-err"></label> <br/>
                <br/>

                <label for="pass">password</label> <br/>
                <input class="index-text-input" type="password" id="pass" name="pass"/>
                <label class="index-err" id="pass-err"></label> <br/>

                <label for="cpass">confirm password</label> <br/>
                <input class="index-text-input" type="password" id="cpass" name="cpass"/>
                <label class="index-err" id="cpass-err"></label> <br/>
                <br/>

                <input class="index-submit" type="submit" value="signup">
                <input class="index-submit" type="reset" value="clear">

                <input type="hidden" name="submitted" value="1"/>
            </form>

            <?=$error?>

            <script type="text/javascript" src="./scripts/signup-events.js"></script>
        </div>
    </body>
</html>