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
    
    $db = new mysqli("localhost", "", "", "");
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
    $films = array();

    if (!$sql_films || $sql_films->num_rows == 0)
    {
        echo "No films found matching this criteria.";
    }
    else
    {
        while ($row = $sql_films->fetch_assoc())
        {
            array_push($films, $row);
        }

        echo json_encode($films);
    }

    $db->close();
?>
