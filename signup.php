<?php

// HTTPS redirect
if ($_SERVER['HTTPS'] !== 'on') {
    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectURL");
    exit;
}
if(!session_start()) {
    // If the session couldn't start, present an error
    header("Location: error.php");
    exit;
}

// Check to see if the user has already logged in, shouldn't be possible, but just in case - redirect to home page if they are
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

if ($loggedIn) {
    header("Location: index.php");
    exit;
}


$action = empty($_POST['action']) ? '' : $_POST['action'];

if ($action == 'do_signup') {
    handle_signup();
} else {
    signup_form();
}

function handle_signup() {
    $username = empty($_POST['username']) ? '' : $_POST['username'];
    $password = empty($_POST['password']) ? '' : $_POST['password'];
    $confirmPass = empty($_POST['confirmPass']) ? '' : $_POST['confirmPass'];


    //double check that the passwords match
    if(strcmp($password,$confirmPass)){
        $error = 'Error: Passwords do not match';
        require "signUpPage.php";
        exit;
    }

    // Require the credentials
    require_once 'db.conf';

    // Connect to the database
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        require "signUpPage.php";
        exit;
    }

    $username = $mysqli->real_escape_string($username);
    $password = $mysqli->real_escape_string($password);

    //check that username doesn't already exist to print unique error message
    $query = "SELECT username FROM users WHERE username='$username'";
    $result = $mysqli->query($query);

    if($result) {
        $match = $result->num_rows;
        $result->close();

        if ($match > 0) {
            $error = "Username already in use";
            require "signUpPage.php";
            $mysqli->close();
            exit;
        }
    }
    // Build query to insert username, once everything has been checked
    $query = "INSERT INTO users (username, password, addDate) VALUES ('$username', '$password', now())";

    // if successful log user in and send to home page, index.php
    if($mysqli->query($query) === TRUE) {
        $_SESSION['loggedin'] = $username;
        header("Location: index.php");
        $mysqli->close();
        exit;
    // if unsuccessful in creating user display error
    } else {
        $error = "Could not create account";
        require "signUpPage.php";
        $mysqli->close();
        exit;
    }
}

function signup_form() {
    $username = "";
    $error = "";
    require "signUpPage.php";
    exit;
}
?>