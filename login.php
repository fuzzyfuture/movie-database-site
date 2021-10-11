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
        $pass = trim($_POST["pass"]);

        $db = new mysqli("localhost", "", "", "");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }
        
        $sql_get_user = $db->query("SELECT * FROM Users WHERE email = '$email' AND password = '$pass'")->fetch_assoc();

        if ($email != $sql_get_user["email"] && $pass != $sql_get_user["password"])
        {
            $valid = false;
            $error = "Email/password combination does not exist.";
        }

        if ($sql_get_user["isLoggedIn"] == 1)
        {
            $valid = false;
            $error = "You are already logged in!";
        }

        if ($valid)
        {
            session_start();

            $_SESSION["uid"] = $sql_get_user["uid"];
            $_SESSION["user"] = $sql_get_user["username"];
            $_SESSION["avi"] = $sql_get_user["avatar"];
            $_SESSION["loggedin"] = $sql_get_user["isLoggedIn"];    

            $sql_store_login = $db->query("UPDATE Users SET isLoggedIn = 1 WHERE email = '$email'");

            if ($sql_store_login)
            {
                header("Location: home.php");
            }
            else
            {
                $error = "Login error, please try again.";
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
            <form name="login" id="login" action="login.php" method="post">
                <label for="email">e-mail</label> <br/>
                <input class="index-text-input" type="text" id="email" name="email"/>
                <label class="index-err" id="email-err"></label> <br/>

                <label for="pass">password</label> <br/>
                <input class="index-text-input" type="password" id="pass" name="pass"/>
                <label class="index-err" id="pass-err"></label> <br/>
                <br/>

                <input class="index-submit" type="submit" value="login">
                <input class="index-submit" type="reset" value="clear">

                <input type="hidden" name="submitted" value="1"/>
            </form>

            <?=$error?>

            <script type="text/javascript" src="./scripts/login-events.js"></script>
        </div>
    </body>
</html>
