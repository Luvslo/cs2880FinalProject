<?php

// HTTPS redirect
if ($_SERVER['HTTPS'] !== 'on') {
    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectURL");
    exit;
}
if(!session_start()) {
    // If the session couldn't start, show error
    header("Location: error.php");
    exit;
}

// Check to see if the user has already logged in
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

if ($loggedIn) {
    header("Location: index.php");
    exit;
}


$action = empty($_POST['action']) ? '' : $_POST['action'];

if ($action == 'do_login') {
    handle_login();
} else {
    login_form();
}

function handle_login() {
    $username = empty($_POST['username']) ? '' : $_POST['username'];
    $password = empty($_POST['password']) ? '' : $_POST['password'];


    // Require the credentials
    require_once 'db.conf';

    // Connect to the database
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        require "loginPage.php";
        exit;
    }

    $username = $mysqli->real_escape_string($username);
    $password = $mysqli->real_escape_string($password);


    // Build query
    $query = "SELECT id FROM users WHERE userName = '$username' AND password = '$password'";


    // Run the query
    $mysqliResult = $mysqli->query($query);

    // If there was a result, log in
    if ($mysqliResult) {
        // How many records were returned?
        $match = $mysqliResult->num_rows;

        // Close the results
        $mysqliResult->close();
        // Close the DB connection
        $mysqli->close();


        // If there was a match, login
        if ($match == 1) {
            //start session, set = username for use throughout site
            $_SESSION['loggedin'] = $username;
            header("Location: index.php");
            exit;
        }
        else {
            $error = 'Error: Incorrect username or password';
            require "loginPage.php";
            exit;
        }
    }
    // Else, there was no result
    else {
        $error = 'Login Error: Please contact the system administrator.';
        require "loginPage.php";
        exit;
    }
}

function login_form() {
    $username = "";
    $error = "";
    require "loginPage.php";
    exit;
}
?>