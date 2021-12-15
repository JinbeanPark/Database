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
    
    <h2> Searching Result: </h2>
    <hr>

    <p>
    <form action="./search.php" method="get">
    Search Actor/Moive: <input type="text" name="name"><br>
    <input type="submit" value = "Search!">
    </form></p>
    <hr>

    <p>
    <h4> Matching Actors are: </h4>
    <?php
    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db -> connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $searchedName = $_GET['name'];
    $numWords = str_word_count($searchedName);
    $splitedWords = explode(" ", $searchedName);

    $query = "SELECT * FROM Actor WHERE ";
    $firstQuery = "(first LIKE '%%%s%%' ";
    $lastQuery = "last LIKE '%%%s%%') ";
    $andCondition = "AND ";
    $orCondition = "OR ";
    $chkFirst = true;
    foreach ($splitedWords as $word) {
        $sanitizedName = $db->real_escape_string($word);
        if ($chkFirst) {
            $query = $query . sprintf($firstQuery, $sanitizedName) . $orCondition . sprintf($lastQuery, $sanitizedName);
            $chkFirst = false;
        }
        else
            $query = $query . $andCondition . sprintf($firstQuery, $sanitizedName) . $orCondition . sprintf($lastQuery, $sanitizedName);
    }

    $query = $query . "ORDER BY first";
    $searchedTuples = $db->query($query);
    if (!$searchedTuples) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    ?>
    
    <table style="width:100%">
        <tr>
            <th>Name</th>
            <th>Date of Birth</th>
        </tr>

    <?php
        $columnActID = Array();
        $columnName = Array();
        $columnDOB = Array();
        while ($row = $searchedTuples->fetch_assoc()) {
            $columnActID[] = $row['id'];
            $columnName[] = $row['first'] . " " . $row['last'];
            $columnDOB[] = $row['dob'];
        }
        for ($i = 0; $i < count($columnDOB); $i++) {
            echo "<tr><td><a href=\"./actor.php?actorID=" . $columnActID[$i] . "\">" . $columnName[$i] . "</a></td>";
            echo "<td><a href=\"./actor.php?actorID=" . $columnActID[$i] . "\">" . $columnDOB[$i] . "</a></td></tr>";
        }
        $searchedTuples->free();
    ?>
        </table>
    </p>
    <hr>

    <p>
    <h4> Matching Movies are: </h4>

    <?php
    $query = "SELECT * FROM Movie WHERE ";
    $titleQuery = "title LIKE '%%%s%%' ";
    $chkFirst = true;
    foreach ($splitedWords as $word) {
        $sanitizedName = $db->real_escape_string($word);
        if ($chkFirst) {
            $query = $query . sprintf($titleQuery, $sanitizedName);
            $chkFirst = false;
        }
        else
            $query = $query . $andCondition . sprintf($titleQuery, $sanitizedName);
    }

    $query = $query . "ORDER BY title";
    $searchedTuples = $db->query($query);
    if (!$searchedTuples) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
    ?>
    
    <table style="width:100%">
        <tr>
            <th>Title</th>
            <th>Year</th>
        </tr>

    <?php
    $columnMovID = Array();
    $columnTitle = Array();
    $columnYear = Array();
    while ($row = $searchedTuples->fetch_assoc()) {
        $columnMovID[] = $row['id'];
        $columnTitle[] = $row['title'];
        $columnYear[] = $row['year'];
    }
    for ($i = 0; $i < count($columnTitle); $i++) {
        echo "<tr><td><a href=\"./movie.php?movieID=" . $columnMovID[$i] . "\">" . $columnTitle[$i] . "</a></td>";
        echo "<td><a href=\"./movie.php?movieID=" . $columnMovID[$i] . "\">" . $columnYear[$i] . "</a></td></tr>";
    }
    $searchedTuples->free();
    $db->close;
    ?>
    </table>
    </p>
</div>
</body>
</html>