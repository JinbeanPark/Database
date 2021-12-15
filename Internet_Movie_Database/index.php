<!DOCTYPE html>
<html>
<head>
<style>
.note {
    font-size: 120%;
    text-align: center;
    color: dodgerblue;
}
.centerCropped {
    text-align: center;
}
.uclaColor {
    background-color: dodgerblue;
    color: goldenrod;
    padding: 20px;
}
</style>
</head>
<body>

<h1>
    <span class = "note"> <a href="./index.php"
    style="text-decoration:none">CS143 Movie Cinema</a></span>
</h1>

<div class = "centerCropped">
    <img src = "./cinema1.png" width=400px, height=300px>
</div>

<div class="uclaColor">
    <h2> Welcome to CS 143 Cinema </h2>
    <p> 1. You can search for an actor/actress/movie through below
        a keyword search interface!<br>
        Type the first/last name of actor/actress or the title of movie.
    </p>
    <p> 2. You can see every link to the movies that the actor was in.</p>
    <p> 3. You can also see every link to the actors/actresses that
        were in the movie.
    </p>
    <p> 4. You can see the average socre and comments of the movie.</p>
    <p> 5. You can leave your comments to movie by clicking "add Comment" button.</p>
</div>

<div class="uclaColor">
    <p>
    <form action="./search.php" method="get">
    Search Actor/Moive: <input type="text" name="name"><br>
    <input type="submit" value = "Search!"></p>
    </form>
</div>

</body>
</html>