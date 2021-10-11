<!-- Nathan Chay   -->
<!-- 200403221     -->
<!-- CS 215        -->
<!-- Oct. 6, 2020  -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

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

    if (isset($_GET["mid"]) && $_GET["mid"])
    {
        $db = new mysqli("localhost", "", "", "");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

        $mid = $_GET["mid"];

        $sql_film_info = $db->query("SELECT * FROM Movies WHERE mid = $mid")->fetch_assoc();

        if ($sql_film_info)
        {
            $title = $sql_film_info["title"];
            $year = $sql_film_info["year"];
            $origin = $sql_film_info["origin"];
            $genre = $sql_film_info["genre"];
            $poster = $sql_film_info["poster"];
            $director = $sql_film_info["director"];
            $wiki_link = $sql_film_info["wikiLink"];
            $cast = $sql_film_info["cast"];
        }

        $uid = $_SESSION["uid"];
        $time_viewed = date('Y-m-d H:i:s');

        $sql_check_viewed = $db->query("SELECT * FROM Views WHERE uid = $uid AND mid = $mid")->fetch_assoc();
        
        if ($sql_check_viewed)
        {
            $sql_save_view = $db->query("UPDATE Views SET timeViewed = '$time_viewed' WHERE uid = $uid AND mid = $mid");
        }
        else
        {
            $sql_save_view = $db->query("INSERT INTO Views (uid, mid, timeViewed) VALUES ($uid, $mid, '$time_viewed')");
        }

        $sql_check_rating = $db->query("SELECT * FROM Ratings WHERE uid = $uid AND mid = $mid")->fetch_assoc();

        if (isset($_POST["rating"]) && $_POST["rating"])
        {
            $rating = $_POST["rating"];

            if ($rating == -1)
            {
                $sql_delete_rating = $db->query("DELETE FROM Ratings WHERE uid = $uid AND mid = $mid");
            }
            else if ($sql_check_rating)
            {
                $sql_update_rating = $db->query("UPDATE Ratings SET rating = $rating, dateRated = '$time_viewed' WHERE uid = $uid AND mid = $mid");
            }
            else
            {
                $sql_add_rating = $db->query("INSERT INTO Ratings (uid, mid, rating, dateRated) VALUES ($uid, $mid, $rating, '$time_viewed')");
            }
        }
        else
        {
            if ($sql_check_rating)
            {
                $rating = $sql_check_rating["rating"];
            }
            else
            {
                $rating = -1;
            }
        }

        $db->close();
    }
    else
    {
        header("Location: home.php");
    }
?>

<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <title>nate's movie database</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="./css/main.css"/>
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
                <a href="<?=$navbar_button1_link?>"><?=$navbar_button1_text?></a>
            </li>

            <li>
                <a href="<?=$navbar_button2_link?>"><?=$navbar_button2_text?></a>
            </li>
        </ul>

        <div class="info-outer">
            <div class="info-title">
                <?=$title?>

                <div class="info-year">
                    (<?=$year?>)
                </div>
            </div>

            <div class="info-director">
                dir. <?=$director?>
            </div>

            <img class="info-poster" src="<?=$poster?>.jpg"></img>

            <div class="info-info">
                <b>origin:</b> <?=$origin?> <br/>
                <b>genres:</b> <?=$genre?> <br/>
                <br/>
                <b>cast:</b> <br/>
                <i><?=$cast?></i>
                <br/>
                <br/>

                <b>your rating:</b>
                <br/>
                <br/>
                <form name="rate" id="rate" action="film-info.php?mid=<?=$mid?>" method="post">
                    <select class="info-select" id="rating" name="rating">
                        <option value="-1" <?=$rating == -1 ? 'selected="selected"' : '';?>>none</option>
                        <option value="1" <?=$rating == 1 ? 'selected="selected"' : '';?>>1</option>
                        <option value="2" <?=$rating == 2 ? 'selected="selected"' : '';?>>2</option>
                        <option value="3" <?=$rating == 3 ? 'selected="selected"' : '';?>>3</option>
                        <option value="4" <?=$rating == 4 ? 'selected="selected"' : '';?>>4</option>
                        <option value="5" <?=$rating == 5 ? 'selected="selected"' : '';?>>5</option>
                        <option value="6" <?=$rating == 6 ? 'selected="selected"' : '';?>>6</option>
                        <option value="7" <?=$rating == 7 ? 'selected="selected"' : '';?>>7</option>
                        <option value="8" <?=$rating == 8 ? 'selected="selected"' : '';?>>8</option>
                        <option value="9" <?=$rating == 9 ? 'selected="selected"' : '';?>>9</option>
                        <option value="10" <?=$rating == 10 ? 'selected="selected"' : '';?>>10</option>
                    </select>
                    /10         
                    
                    <input class="info-rate" type="submit" value="rate"></input>
                    <br/>
                    <br/>
                    
                    <input type="hidden" name="mid" value="<?=$mid?>"/>
                </form>

                <div class="info-watchlist">
                    <b>watchlist:</b>
                    <br/>
                    <br/>
    
                    <form name="watchlist-add" id="watchlist-add" action="watchlists.php" method="post">
                        <select class="info-select" id="watchlist" name="watchlist" style="width: 170px;">
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
                                    echo "<option value='' disabled selected>none</option>";
                                }
                                else
                                {
                                    while ($row = $sql_watchlists->fetch_assoc())
                                    {
                                        $name = $row["name"];
                                        $wid = $row["wid"];

                                        echo "<option value='$wid'>$name</option>";
                                    }
                                }

                                $db->close();
                            ?>
                        </select>

                        <input class="info-add" type="submit" value="add"></input>
                        <br/>
                        <br/>
                    
                        <input type="hidden" name="mid" value="<?=$mid?>"/>
                    </form>
                </div> </br>
                </br>
                </br>
                </br>
                </br>

                <a class="info-wiki" href="<?=$wiki_link?>">wikipedia</a>
            </div>
        </div>
    </body>
</html>
