<?php


$action = empty($_POST['action']) ? '' : $_POST['action'];

if($action == 'createUserCharacter'){
    handle_createUserCharacter();
}
else {
    header("Loaction: index.php");
    exit();
}
//creates the users character within the database
function handle_createUserCharacter(){

    if(!session_start()) {
        // If the session couldn't start, show error
        header("Location: error.php");
        exit;
    }

    // get current user
    $currentUser = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

    // get form data
    $class = empty($_POST['classSelection']) ? '' : $_POST['classSelection'];
    $name = empty($_POST['characterName']) ? '' : $_POST['characterName'];

    // set up class skills starting values
    $s_athletics = 0;
    $s_mechanics = 0;
    $s_stealth = 0;
    $s_speech = 0;

    //setup correct values by class and adjust skills
    if($class == 'Fighter'){
        $p_def = 3;
        $p_attack = 2;
        $s_athletics = 2;
    }
    elseif ($class == 'Sorcerer'){
        $p_def = 1;
        $p_attack = 4;
        $s_mechanics = 1;
        $s_speech = 1;
    }
    elseif ($class == 'Rogue'){
        $p_def = 2;
        $p_attack = 3;
        $s_mechanics = 1;
        $s_stealth = 1;
    }

    require_once 'db.conf';

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        require "error.php";
        exit;
    }

    $name = $mysqli->real_escape_string($name);

    $query = "INSERT INTO userCharacters VALUES ('$currentUser', '$name', '$class', '$p_def', '$p_attack', '$s_athletics', '$s_mechanics', '$s_stealth', '$s_speech')";

    //if successful
    if($mysqli->query($query) === TRUE) {
        header("Location: deep-down.php");
        $mysqli->close();
        exit;
    // if unsuccessful in creating user display error
    } else {
        //header("Location: index.php");
        echo mysqli_errno($mysqli) . ": ". mysqli_error($mysqli);
        $mysqli->close();
        exit;
    }
}

?>