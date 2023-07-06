<!-- You have the right to use this code as you see fit. But don't forget to check out my github and have your say: 
// https://github.com/mGuillermoSanchez/ -->


<?php

// Retrieves the department parameter sent via the GET request
$region = $_GET['region'];

// Connection to the PhpMyAdmin database
$host = "localhost";
$username = "root";
$pass = "";
$dbname = "database_example";

$connexion = new mysqli($host, $username, $pass, $dbname);
// Check if the connection was successful
if ($connexion->connect_error){
    die("The connection to the database (database_example) has failed: " . $connexion->connect_error);
}

// Executes an SQL command to retrieve data for the selected region 
$sql = "SELECT * FROM namibia WHERE region = '$region'"; # Query (command) sql
$result = $connexion->query($sql);

// Checks whether results have been obtained and sends the result
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <style>
            a {
                color: black;
            }

            .container {
                position: relative;
                max-width: 500px;
                margin: 0 auto;
                padding: 2px;
                border: 2px solid black;
                border-radius: 5px;
                float: right;
                right: 10%;
                top: 5%;

                font-family: Arial, Helvetica, sans-serif;
                color: black;
                text-align: justify;
            }

            h1 {
                color: black;
                font-size: 14px;
            }

            p {
                color: black;
                font-size: 12px;
            }
        </style>
        <div class="container">
            <h1><?=$row['region']?></h1>
            <p><?=$row['infos']?></p>
            <?php
            $links = $row['link'];
            $titles = $row['link_title'];

            $linkArray = explode(", ", $links);
            $titleArray = explode(", ", $titles);

            $count = min(count($linkArray), count($titleArray));

            for($i = 0; $i < $count; $i++) {
                $link = $linkArray[$i];
                $title = $titleArray[$i];
                ?>
                <a href="<?=$link?>"><?=$title?></a><br>
                <?php
            }
            ?>
        </div><br>
        <?php
    }
}

?>