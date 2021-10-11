<!-- Nathan Chay   -->
<!-- 200403221     -->
<!-- CS 215        -->
<!-- Oct. 6, 2020  -->

<?php
    session_start();
    
    if ($_SESSION)
    {
        $user = $_SESSION["user"];
        $avi = $_SESSION["avi"];

        $navbar_button1_text = "my watchlists";
        $navbar_button1_link = "./watchlists.php";
        
        $navbar_button2_text = "logout";
        $navbar_button2_link = "./logout.php";
    }
    else
    {
        header("Location: index.php"); 
    }

    if (isset($_POST["new-watchlist"]) && $_POST["new-watchlist"])
    {
        $db = new mysqli("localhost", "", "", "");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

        $uid = $_SESSION["uid"];
        $watchlist_name = $_POST["name"];
        $cur_datetime = date('Y-m-d H:i:s');

        $sql_new_watchlist = $db->query("INSERT INTO Watchlists (uid, name, dateCreated) VALUES ($uid, '$watchlist_name', '$cur_datetime')");

        $db->close();
    }

    if (isset($_POST["delete-watchlist"]) && $_POST["delete-watchlist"])
    {
        $db = new mysqli("localhost", "ngc582", "Sponge7!", "ngc582");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

        $wid = $_POST["delete-watchlist"];

        $sql_delete_watchlist = $db->query("DELETE FROM Watchlists WHERE wid = '$wid'");
        $sql_delete_entries = $db->query("DELETE FROM Entries WHERE wid = '$wid'");

        $db->close();
    }

    if (isset($_POST["mid"]) && $_POST["mid"] && isset($_POST["watchlist"]) && $_POST["watchlist"])
    {
        $db = new mysqli("localhost", "ngc582", "Sponge7!", "ngc582");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

        $mid = $_POST["mid"];
        $wid = $_POST["watchlist"];
        $cur_datetime = date('Y-m-d H:i:s');

        $sql_movie_in_watchlist_check = $db->query("SELECT wid FROM Entries WHERE mid = '$mid' AND wid = '$wid'");

        if ($sql_movie_in_watchlist_check->num_rows == 0)
        {
            $sql_add_to_watchlist = $db->query("INSERT INTO Entries (wid, mid, dateAdded) VALUES ('$wid', '$mid', '$cur_datetime')");
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
    <ul class="navbar">
            <li>
                <img class="avi" src="<?=$avi?>"></img>
            </li>

            <li>
                <span><?=$user?></span>
            </li>

            <li>
                <a href="./home.php">home</a>
            </li> 

            <li>
                <a class = "active" href="<?=$navbar_button1_link?>"><?=$navbar_button1_text?></a>
            </li>

            <li>
                <a href="<?=$navbar_button2_link?>"><?=$navbar_button2_text?></a>
            </li>
        </ul>

        <div class="outer">
            <form name="create-watchlist" id="create-watchlist" action="watchlists.php" method="post">
                <input class="watchlists-text-input" type="text" id="name" name="name" placeholder="enter a name for a new watchlist..."></input>

                <label class="watchlists-char-count" id="char-count">0/15</label>

                <input class="watchlists-submit" type="submit" value="create new watchlist"></input> <br/>
                <br/>
                <input type="hidden" name="new-watchlist" value=1></input>
            </form>

            <script type="text/javascript" src="./scripts/watchlists-events.js"></script>

            <div class="inner">
                <ul class="watchlists-list">
                    <?php
                        session_start();

                        if ($_SESSION)
                        {
                            $uid = $_SESSION["uid"];
                        }
                        else
                        {
                            $uid = 0;
                        }
    
                        $db = new mysqli("localhost", "ngc582", "Sponge7!", "ngc582");
                        if ($db->connect_error)
                        {
                            die("Connection failed: ".$db->connect_error);
                        }

                        $sql_watchlists = $db->query("SELECT wid, name FROM Watchlists WHERE uid = $uid");

                        if (!$sql_watchlists || $sql_watchlists->num_rows == 0)
                        {
                            echo "No watchlists found.";
                        }
                        else
                        {
                            while ($row = $sql_watchlists->fetch_assoc())
                            {
                                $name = $row["name"];
                                $wid = $row["wid"];

                                $sql_movies_in_watchlist = $db->query("SELECT eid FROM Entries WHERE wid = $wid");
                                $movie_count = $sql_movies_in_watchlist->num_rows;

                                echo <<<EOT
                                <li>
                                    <form name="watchlist-delete" id="watchlist-delete" action="watchlists.php" method="post">
                                        <input class="delete" type="submit" value="delete this watchlist"></input>
                                        <input type="hidden" name="delete-watchlist" value=$wid/>
                                    </form>
                                    
                                    <form name="info" id="info" action="watchlist-info.php" method="get">
                                        <input class="watchlist-info-button" type="submit" value="$name"></input>

                                        <input type="hidden" name="wid" value=$wid></input>
                                    </form>
                                    <br/>
                                    <span class=watchlists-moviecount>movies: $movie_count</span>
                                </li> <br/>
EOT;
                            }
                        }

                        $db->close();
                    ?>
                </ul>
            </div>
        </div>
    </body>
</html>
