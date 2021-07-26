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
        $user = "guest";
        $avi = "avatars/default-avatar.png";

        $navbar_button1_text = "login";
        $navbar_button1_link = "./login.php";
        
        $navbar_button2_text = "signup";
        $navbar_button2_link = "./signup.php";
    }

    if ($_GET["s"])
    {
        $search_term = $_GET["s"];
    }
    else
    {
        $search_term = "";
    }

    if ($_GET["origin"])
    {
        $origin = $_GET["origin"];
    }
    else
    {
        $origin = "";
    }

    if ($_GET["genre"])
    {
        $genre = $_GET["genre"];
    }
    else
    {
        $genre = "";
    }

    if ($_GET["sort"])
    {
        $sort = $_GET["sort"];
    }
    else
    {
        $sort = "rating";
    }

    if ($_GET["sort-type"])
    {
        $sort_type = $_GET["sort-type"];
    }
    else
    {
        $sort_type = "desc";
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml" id="html">
    <head>
        <title>nate's movie database</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="./css/main.css"/>

        <script type="text/javascript" src="./scripts/form-validate.js"></script>
        <script type="text/javascript" src="./scripts/home-ajax.js"></script>
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
                <a class="active" href="./home.php">home</a>
            </li> 

            <li>
                <a href="<?=$navbar_button1_link?>"><?=$navbar_button1_text?></a>
            </li>

            <li>
                <a href="<?=$navbar_button2_link?>"><?=$navbar_button2_text?></a>
            </li>
        </ul>

        <div class="outer">
            <form name="search" id="search" action="home.php" method="get">
                <input class="home-search-bar" type="text" id="term" name="s" placeholder="enter a search term..." value="<?=$search_term?>"></input>

                <select class="home-select" id="origin" name="origin">
                    <option value="" disabled <?=$origin == '' ? 'selected="selected"' : '';?>>origin</option>
                    <option value="any" <?=$origin == 'any' ? 'selected="selected"' : '';?>>any</option>
                    <option value="american" <?=$origin == 'american' ? 'selected="selected"' : '';?>>american</option>
                    <option value="australian" <?=$origin == 'australian' ? 'selected="selected"' : '';?>>australian</option>
                    <option value="bollywood" <?=$origin == 'bollywood' ? 'selected="selected"' : '';?>>bollywood</option>
                    <option value="british" <?=$origin == 'british' ? 'selected="selected"' : '';?>>british</option>
                    <option value="canadian" <?=$origin == 'canadian' ? 'selected="selected"' : '';?>>canadian</option>
                    <option value="chinese" <?=$origin == 'chinese' ? 'selected="selected"' : '';?>>chinese</option>
                    <option value="japanese" <?=$origin == 'japanese' ? 'selected="selected"' : '';?>>japanese</option>
                    <option value="punjabi" <?=$origin == 'punjabi' ? 'selected="selected"' : '';?>>punjabi</option>
                    <option value="russian" <?=$origin == 'russian' ? 'selected="selected"' : '';?>>russian</option>
                </select>

                <select class="home-select" id="genre" name="genre">
                    <option value="" disabled <?=$genre == '' ? 'selected="selected"' : '';?>>genre</option>
                    <option value="any" <?=$genre == 'any' ? 'selected="selected"' : '';?>>any</option>
                    <option value="action" <?=$genre == 'action' ? 'selected="selected"' : '';?>>action</option>
                    <option value="adventure" <?=$genre == 'adventure' ? 'selected="selected"' : '';?>>adventure</option>
                    <option value="biography" <?=$genre == 'biography' ? 'selected="selected"' : '';?>>biography</option>
                    <option value="comedy" <?=$genre == 'comedy' ? 'selected="selected"' : '';?>>comedy</option>
                    <option value="crime" <?=$genre == 'crime' ? 'selected="selected"' : '';?>>crime</option>
                    <option value="drama" <?=$genre == 'drama' ? 'selected="selected"' : '';?>>drama</option>
                    <option value="family" <?=$genre == 'family' ? 'selected="selected"' : '';?>>family</option>
                    <option value="fantasy" <?=$genre == 'fantasy' ? 'selected="selected"' : '';?>>fantasy</option>
                    <option value="horror" <?=$genre == 'horror' ? 'selected="selected"' : '';?>>horror</option>
                    <option value="musical" <?=$genre == 'musical' ? 'selected="selected"' : '';?>>musical</option>
                    <option value="mystery" <?=$genre == 'mystery' ? 'selected="selected"' : '';?>>mystery</option>
                    <option value="patriotic" <?=$genre == 'patriotic' ? 'selected="selected"' : '';?>>patriotic</option>
                    <option value="romance" <?=$genre == 'romance' ? 'selected="selected"' : '';?>>romance</option>
                    <option value="sci-fi" <?=$genre == 'sci-fi' ? 'selected="selected"' : '';?>>sci-fi</option>
                    <option value="social" <?=$genre == 'social' ? 'selected="selected"' : '';?>>social</option>
                    <option value="sports" <?=$genre == 'sports' ? 'selected="selected"' : '';?>>sports</option>
                    <option value="spy" <?=$genre == 'spy' ? 'selected="selected"' : '';?>>spy</option>
                    <option value="suspense" <?=$genre == 'suspense' ? 'selected="selected"' : '';?>>suspense</option>
                    <option value="thriller" <?=$genre == 'thriller' ? 'selected="selected"' : '';?>>thriller</option>
                    <option value="war" <?=$genre == 'war' ? 'selected="selected"' : '';?>>war</option>
                    <option value="western" <?=$genre == 'western' ? 'selected="selected"' : '';?>>western</option>
                    <option value="wuxia" <?=$genre == 'wuxia' ? 'selected="selected"' : '';?>>wuxia</option>
                    <option value="zombie" <?=$genre == 'zombie' ? 'selected="selected"' : '';?>>zombie</option>
                </select>

                <br/>
                <br/>

                sort by

                <select class="home-select" id="sort" name="sort" style="width: 10%">
                    <option value="rating" <?=$sort == 'rating' ? 'selected="selected"' : '';?>>rating</option>
                    <option value="title" <?=$sort == 'title' ? 'selected="selected"' : '';?>>title</option>
                    <option value="year" <?=$sort == 'year' ? 'selected="selected"' : '';?>>year</option>
                </select>

                <select class="home-select" id="sort-type" name="sort-type" style="width: 10%">
                    <option value="asc" <?=$sort_type == 'asc' ? 'selected="selected"' : '';?>>asc.</option>
                    <option value="desc" <?=$sort_type == 'desc' ? 'selected="selected"' : '';?>>desc.</option>
                </select>

                <input class="home-search-button" type="submit" value="search"></input>
                <br/>
                <br/>
            </form>

            <script type="text/javascript" src="./scripts/home-events.js"></script>

            <div class="inner">
                <ul class="movielist" id="movielist">
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

                    if (isset($_GET["s"]) && $_GET["s"] && $_GET["s"] != null && $_GET["s"] != "")
                    {
                        $search_term = $_GET["s"];
                        $search_query = "WHERE Movies.title LIKE '%$search_term%'";

                        $origin_cond = "AND";
                        $genre_cond = "AND";
                    }
                    else
                    {
                        $search_query = "";
                        
                        $origin_cond = "WHERE";
                    }

                    if (isset($_GET["origin"]) && $_GET["origin"] && $_GET["origin"] != "any")
                    {
                        $origin = $_GET["origin"];
                        $origin_query = "$origin_cond Movies.origin LIKE '%$origin%'";

                        $genre_cond = "AND";
                    }
                    else
                    {
                        $origin_query = "";

                        $genre_cond = "WHERE";
                    }

                    if (isset($_GET["genre"]) && $_GET["genre"] && $_GET["genre"] != "any")
                    {
                        $genre = $_GET["genre"];
                        $genre_query = "$genre_cond Movies.genre LIKE '%$genre%'";
                    }
                    else
                    {
                        $genre_query = "";
                    }
                    
                    if (isset($_GET["sort"]) && $_GET["sort"])
                    {
                        $sort_by = $_GET["sort"];
                    }
                    else
                    {
                        $sort_by = "rating";
                    }

                    if (isset($_GET["sort-type"]) && $_GET["sort-type"] && $_GET["sort-type"] == "asc")
                    {
                        $sort_type = "ASC";
                    }
                    else
                    {
                        $sort_type = "DESC";
                    }

                    $sql_films = $db->query("SELECT Movies.title, Movies.year, Movies.origin, Movies.genre, Movies.poster, Movies.director, Movies.mid, Ratings.rating FROM Movies LEFT JOIN Ratings ON Movies.mid = Ratings.mid AND Ratings.uid = $uid $search_query $origin_query $genre_query ORDER BY $sort_by $sort_type LIMIT 15");

                    if (!$sql_films || $sql_films->num_rows == 0)
                    {
                        echo "No films found matching this criteria.";
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

                                    <form name="watchlist-add" id="watchlist-add" action="watchlists.php" method="post">
                                        <div class="home-watchlist-add">
                                            <input type="submit" value="add"></input>
                                        </div>
                
                                        <div class="home-watchlist-select-div">
                                            watchlist: </br>
                                            </br>
                
                                            <select class="home-select" id="watchlist" name="watchlist" style="width: 100%;">
EOT;
                                                $sql_watchlists = $db->query("SELECT wid, name FROM Watchlists WHERE uid = $uid");

                                                if (!$sql_watchlists || $sql_watchlists->num_rows == 0)
                                                {
                                                    echo "<option value='' disabled selected>none</option>";
                                                }
                                                else
                                                {
                                                    while ($row_wl = $sql_watchlists->fetch_assoc())
                                                    {
                                                        $name = $row_wl["name"];
                                                        $wid = $row_wl["wid"];

                                                        echo "<option value='$wid'>$name</option>";
                                                    }
                                                }

                                                $mid = $GLOBALS["mid"];
                                            
                                                echo <<<EOT
                                            </select> </br>
                                        </div>

                                        <input type="hidden" name="mid" value="$mid"/>
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