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
    
    <h2> Actor Information Page: </h2>
    <hr>

    <p>
    <form action="./search.php" method="get">
    Search Actor/Moive: <input type="text" name="name"><br>
    <input type="submit" value = "Search!">
    </form></p>
    <hr>

    <p>
    <h4> Actor Information is: </h4>
    <?php
    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db -> connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $actorID = $_GET['actorID'];

    $query = "SELECT * FROM Actor WHERE id = $actorID";
    $searchedActor = $db->query($query);
    if (!$searchedActor) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    ?>

    <table style="width:100%">
    <tr>
        <th>Name</th>
        <th>Sex</th>
        <th>Date of Birth</th>
        <th>Date of Death</th>
    </tr>

    <?php
    while ($row = $searchedActor->fetch_assoc()) {
        echo '<tr><td>' . $row['first'] . " " . $row['last'] . "</td>";
        echo '<td>' . $row['sex'] . "</td>";
        echo '<td>' . $row['dob'] . "</td>";
        if (is_null($row['dod'])) {
            echo '<td>' . "Still Alive" . "</td></tr>";
        }
        else {
            echo '<td>' . $row['dod'] . "</td></tr>";
        }
    }
    $searchedActor->free();
    ?>
    </table></p>
    <hr>

    <p>
    <h4> Actor's Movies and Role: </h4>
    <?php
    $query = "SELECT M.id, M.title, MA.role
              FROM Actor A, Movie M, MovieActor MA 
              WHERE A.id = $actorID AND
              A.id = MA.aid AND 
              M.id = MA.mid";

    $query = $query . " ORDER BY title";
    $searchedRoleMov = $db->query($query);
    if (!$searchedRoleMov) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    ?>

    <table style="width:100%">
    <tr>
        <th>Role</th>
        <th>Movie Title</th>
    </tr>

    <?php
    while ($row = $searchedRoleMov->fetch_assoc()) {
        $columnMovID[] = $row['id'];
        $columnTitle[] = $row['title'];
        $columnRole[] = $row['role'];
    }
    for ($i = 0; $i < count($columnTitle); $i++) {
        echo "<tr><td>" . $columnRole[$i] . "</td>";
        echo "<td><a href=\"./movie.php?movieID=" . $columnMovID[$i] . "\">" . $columnTitle[$i] . "</a></td></tr>";
    }
    $searchedRoleMov->free();
    $db->close();
    ?>
    </table>
</p>
</div>
</body>
</html>