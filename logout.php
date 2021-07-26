<?php
    session_start();

    $db = new mysqli("localhost", "ngc582", "Sponge7!", "ngc582");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

    $uid = $_SESSION["uid"];    
    $sql_store_logout = $db->query("UPDATE Users SET isLoggedIn = 0 WHERE uid = '$uid'");

    $_SESSION = array();
    session_destroy();

    header("Location: index.php");
    exit();
?>