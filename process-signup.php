<?php

    if(empty($_POST["username"])) {
        die("Name is required");
    }

    if( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Email is not valid");
    }

    if(strlen($_POST["password"]) < 6) {
        die("Password must be at least 6 characters");
    }   

    if(!preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }  

    if(!preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }  

    if ($_POST["password"] !== $_POST["confirm_password"]) {
        die("Password does not match");
    }  
    
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "../config/database.php";

    $sql = "INSERT INTO tbl_customer (username, email, password) VALUES (?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if (! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }   

    $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $password);
   
    if ($stmt->execute()) {
        header("Location: signup-success.html");
    }
    else {
        if($mysqli->errno == 1062) {
            die("Username or email already exists");
        }
        else {
            die($mysqli->error."".$mysqli->errno);
        }
        
    }
    

