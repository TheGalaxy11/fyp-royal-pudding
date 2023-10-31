<?php

    //Start Session
    session_start();

    //Create constants to store non repeating values
    define('SITEURL', 'http://localhost/royal-pudding/'); //Update the home URL of the project if you have changed port number or it's live on server
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'royal-pudding');

    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error()); //Database Connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //Selecting Database

?>