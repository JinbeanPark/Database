<!DOCTYPE html>
<html>
<head>
<style>
.note {
    font-size: 120%;
    text-align: center;
    color: dodgerblue;
}
.uclaColor {
    background-color: dodgerblue;
    color: goldenrod;
    text-align: center;
    padding: 20px;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
</head>

<body>
<h1>
    <span class = "note"><a href="./index.php" 
    style="text-decoration:none">CS143 Movie Cinema</a></span>
</h1>


<div class="uclaColor">
    
    <h2> Movie Information Page: </h2>
    <hr>

    <p>
    <form action="./search.php" method="get">
    Search Actor/Moive: <input type="text" name="name"><br>
    <input type="submit" value = "Search!">
    </form></p>
    <hr>

    <p>
    <h4> Movie Information is: </h4>
    <?php
    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db -> connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $movieID = $_GET['movieID'];
    $movieTitle;
    $query = 
    "SELECT DISTINCT M.title, M.company, M.rating, G.genre
    FROM Movie M, MovieGenre G
    WHERE M.id = $movieID AND
          M.id = G.mid";
    $searchedMovie = $db->query($query);
    if (!$searchedMovie) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    ?>

    <?php
        while ($row = $searchedMovie->fetch_assoc()) {
            $movieTitle = $row['title'];
            echo "<p>Title: " . $row['title'] . "</p>";
            echo "<p>Company: " . $row['company'] . "</p>";
            echo "<p>MPAA Rating: " . $row['rating'] . "</p>";
            echo "<p>Genre: " . $row['genre'] . " ";
            
            $numGenre = $searchedMovie->num_rows;
            if ($numGenre > 1) {
                while ($rowGenre = $searchedMovie->fetch_assoc()) {
                    echo $rowGenre['genre'] . " ";
                }
                echo "</p>";
                break;
            }
            else {
                "</p>";
            }
        }
    ?>
    </p>
    <hr>

    <p>
    <h4> Actors in this Movie: </h4>
    <?php
    $queryActRol =
    "SELECT A.id, A.last, A.first, MA.role
     FROM Actor A, MovieActor MA
     WHERE MA.mid = $movieID AND
           A.id = MA.aid";
    
    $queryActRol = $queryActRol . " ORDER BY first";
    $searchedActRol = $db->query($queryActRol);
    if (!$searchedActRol) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    ?>

    <table style="width:100%">
        <tr>
            <th>Name</th>
            <th>Role</th>
        </tr>
    
    <?php
    while ($row = $searchedActRol->fetch_assoc()) {
        $columnActID[] = $row['id'];
        $columnActName[] = $row['first'] . $row['last'];
        $columnRole[] = $row['role'];
    }
    for ($i = 0; $i < count($columnActID); $i++) {
        echo "<tr><td><a href=\"./actor.php?actorID=" . $columnActID[$i] . "\">" . $columnActName[$i] . "</a></td>";
        echo '<td>' . $columnRole[$i] . '</td></tr>';
    }
    $searchedMovie->free();
    $searchedActRol->free();
    ?>
    </table>
    </p>
    <hr>

    <p>
    <h4> User Review: </h4>
    <?php
    $queryAVG =
    "SELECT AVG(rating), COUNT(*)
     FROM Review
     WHERE mid = $movieID";
    $searchedAVG = $db->query($queryAVG);
    if (!$searchedAVG) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    
    while ($row = $searchedAVG->fetch_assoc()) {
        echo "<p>Average score for this Movie is " . $row['AVG(rating)'] . " based on " . $row['COUNT(*)'] . 
        " people's reviews.</p>";
    }
    echo "<a href=\"./comment.php?movieID=" . $movieID . "&movieTitle=" . $movieTitle .
             "\">Leave my review</a>";
    
    $searchedAVG->free();
    ?>
    </p>
    <hr>

    <p>
    <h4> Every Comment for this movie: </h4>
    <?php
    $queryComment =
    "SELECT name, time, rating, comment
     FROM Review
     WHERE mid = $movieID";
    
    $queryComment = $queryComment . " ORDER BY time";
    $searchedComment = $db->query($queryComment);
    if (!$searchedComment) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    
    while ($row = $searchedComment->fetch_assoc()) {
        echo "<p>" . $row['name'] . " rates the this movie with score " . $row['rating'] . 
        " and left a review at " . $row['time'] . "<br>comment:<br>" . $row['comment'] . "</p>";
    }
    $searchedComment->free();
    $db->close();
    ?>
    </p>
</div>
</body>
</html>