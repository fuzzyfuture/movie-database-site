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

    if (isset($_GET["wid"]) && $_GET["wid"])
    {
        $db = new mysqli("localhost", "ngc582", "Sponge7!", "ngc582");
        if ($db->connect_error)
        {
            die("Connection failed: ".$db->connect_error);
        }

        $wid = $_GET["wid"];

        $sql_film_info = $db->query("SELECT name FROM Watchlists WHERE wid = $wid")->fetch_assoc();

        if ($sql_film_info)
        {
            $name = $sql_film_info["name"];
        }

        if (isset($_POST["delete"]) && $_POST["delete"])
        {
            $mid = $_POST["delete"];

            $sql_delete_entry = $db->query("DELETE FROM Entries WHERE wid = '$wid' AND mid = '$mid'");

        }

        $db->close();
    }
    else
    {
        header("Location: home.php");
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

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

        <div class="outer">
            <div class="info-header">
                <?=$name?>
            </div>

            <div class="inner">
                <span class="info-subheader">movies in this watchlist:</span> </br>
                </br>

                <ul class="movielist">
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

                        $sql_films = $db->query("SELECT Movies.title, Movies.year, Movies.origin, Movies.genre, Movies.poster, Movies.director, Movies.mid, Ratings.rating FROM Movies JOIN Entries ON Movies.mid = Entries.mid AND Entries.wid = $wid LEFT JOIN Ratings ON Movies.mid = Ratings.mid AND Ratings.uid = $uid");

                        if (!$sql_films || $sql_films->num_rows == 0)
                        {
                            echo "No films in this watchlist.";
                        }
                        else
                        {
                            while ($row = $sql_films->fetch_assoc())
                            {
                                $title = $row["title"];
                                $year = $row["year"];
                                $origin = $row["origin"];
                                $genre = $row["genre"];
                                $poster = $row["poster"];
                                $director = $row["director"];
                                $mid = $row["mid"];

                                if ($row["rating"])
                                {
                                    $rating = $row["rating"];
                                }
                                else
                                {
                                    $rating = "none";
                                }

                                echo <<<EOT
                                    <li>
                                        <img class="poster" src="$poster.jpg"></img>
                                    
                                        <div class="title">
                                            <form name="info" id="info" action="film-info.php" method="get">
                                                <input class="title-button" type="submit" value="$title"></input>
                                                <div class="year">
                                                    ($year)
                                                </div>

                                                <input type="hidden" name="mid" value="$mid"></input>
                                            </form>
                                        </div>
                
                                        <div class="director">
                                            dir. $director
                                        </div>
                
                                        <div class="info">
                                            origin: $origin <br/>
                                            genres: $genre <br/>
                                            <br/>
                                            your rating: $rating / 10
                                        </div>

                                        <form name="watchlist-delete" id="watchlist-delete" action="watchlist-info.php?wid=$wid" method="post">
                                            <input class="delete" type="submit" value="delete from watchlist"></input>
                                            <input type="hidden" name="delete" value=$mid/>
                                        </form>
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