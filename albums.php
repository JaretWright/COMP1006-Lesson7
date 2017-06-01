<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Albums</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

</head>

<body>
    <h1>Albums</h1>

    <?php
        //start a session
        session_start();

        //validate if the user is active
        if (!empty($_SESSION['email']))
            echo '<a href="AlbumDetails.php">Add a new Album</a>';
    ?>


    <?php

        //step 1 - connect to the database
        $conn = new PDO('mysql:host=localhost;dbname=php', 'root', 'admin');

        //step 2 - create a SQL command
        $sql = "SELECT * FROM albums";

        //step 3 - prepare the SQL command
        $cmd = $conn->prepare($sql);

        //step 4 - execute and store the results
        $cmd->execute();
        $albums = $cmd->fetchAll();

        //step 5 - disconnect from the DB
        $conn = null;

        //create a table and display the results
        echo '<table class="table table-striped table-hover">
            <tr><th>Title</th>
                <th>Year</th>
                <th>Artist</th>
                <th>Genre</th>';

        if (!empty($_SESSION['email'])){
            echo '<th>Edit</th>
                  <th>Delete</th>';
        }

        echo '</tr>';

        foreach($albums as $album)
        {
            echo '<tr><td>'.$album['title'].'</td>
                      <td>'.$album['year'].'</td>
                      <td>'.$album['artist'].'</td>
                      <td>'.$album['genre'].'</td>';

            //only show the edit and delete links if these are valid, logged in users
            if (!empty($_SESSION['email'])){
                echo '<td><a href="AlbumDetails.php?albumID='.$album['albumID'].'"
                                class="btn btn-primary">Edit</a></td>
                      <td><a href="deleteAlbum.php?albumID='.$album['albumID'].'" 
                                class="btn btn-danger confirmation">Delete</a></td>';
            }
            echo '</tr>';
        }

        echo '</table>';

    ?>

</body>

<!-- Latest jQuery -->
<script src="js/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.min.js" ></script>

<!-- custom js -->
<script src="js/app.js"></script>
</html>
