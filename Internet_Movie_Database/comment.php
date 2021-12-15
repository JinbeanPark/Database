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
    
    <h2> Leave your Comment here: </h2>
    
    <p>
    <?php
    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db -> connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $movieID = $_GET['movieID'];
    $movieTitle = $_GET['movieTitle'];
    

    echo "<p>Movie Title: " . $movieTitle . "</p>";

    echo "<form action=\"./postedComment.php\">" . 
    "<label for=\"username\">Name:</label><br>" . 
    "<input type=\"text\" id=\"username\" name=\"username\" value=\"Anoymous\"><br>" . 
    "<label for=\"rating\">Rating:</label>" .
    "<select id=\"rating\" name=\"rating\">
    <option value=\"1\">1</option>
    <option value=\"2\">2</option>
    <option value=\"3\">3</option>
    <option value=\"4\">4</option>
    <option value=\"5\">5</option>
    </select><br>" . 
    "<textarea name=\"comment\" rows=\"30\" cols=\"50\">
    Enter the comment.</textarea><br><br>" . 
    "<input type = \"hidden\" name=\"movieID\" value=\"" . $movieID . "\">" .
    "<input type = \"hidden\" name=\"movieTitle\" value=\"". $movieTitle . "\">" .
    "<input type=\"submit\" value = \"Post Comment\"></form>";
    $db->close();
    ?>
</div>
</body>
</html>