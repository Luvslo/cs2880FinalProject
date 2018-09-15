<?php

$action = empty($_POST['action']) ? '' : $_POST['action'];

if($action == 'characterExist'){
    characterExist();
}
elseif($action == 'setUpStatBox'){
    setUpStatBox();
}
else{
    header("Location: index.php");
    exit();
}
//checks if the user has a character by checking their username from users with userCharacters tables
function characterExist(){
    if(!session_start()) {
        // If the session couldn't start, present an error
        header("Location: error.php");
        exit;
    }

// get current user
    $currentUser = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

    require_once 'db.conf';

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        require "error.php";
        exit;
    }
// get all character data
    $query = "SELECT username FROM userCharacters WHERE username='$currentUser'";

// Run the query
    $mysqliResult = $mysqli->query($query);

// If there was a result, will return has character, otherwise return no character
    if ($mysqliResult) {

        $match = $mysqliResult->num_rows;

        // Close the results
        $mysqliResult->close();
        // Close the DB connection
        $mysqli->close();

        if ($match == 1) {
            print "hasCharacter";
        }
        else{
            print "noCharacter";
        }
    }
    else{
        print "noCharacter";
    }
}
//sends back data of users character to set up the stat box
function setUpStatBox(){
    if(!session_start()) {
        // If the session couldn't start, present an error
        header("Location: error.php");
        exit;
    }

// get current user
    $currentUser = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

    require_once 'db.conf';

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check for errors
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        require "error.php";
        exit;
    }
// get all character data
    $query = "SELECT * FROM userCharacters WHERE username='$currentUser'";

// Run the query
    $mysqliResult = $mysqli->query($query);

// If there was a result
    if ($mysqliResult->num_rows == 1) {

        $row = $mysqliResult->fetch_assoc();

        //get the correct image and print to right box
        if($row["class"] == 'Fighter'){
            $classImg = "<img src='images/Fighter.png' alt='Fighter'>";
        }
        elseif($row["class"] == 'Sorcerer'){
            $classImg = "<img src='images/Sorcerer.png' alt='Sorcerer'>";

        }
        elseif($row["class"] == 'Rogue'){
            $classImg = "<img src='images/Rogue.png' alt='Rogue'>";
        }
        //sends correct values from table
        print $classImg."<div><p>Name: ".$row['name']."</p></div><div><p>Class: ".$row['class']."</p></div>".
            "<div><p>Defense: ".$row['player_defense']."</p></div><div><p>Attack: ".$row['player_attack'].
            "</p></div><hr><h3>Skills</h3><div><p>Athletics: ".$row['s_athletics']."</p></div><div><p>Mechanics: ".
            $row['s_mechanics']."</p></div><div><p>Speech: ".$row['s_speech']."</p></div><div><p>Stealth: ".$row['s_stealth']."</p></div>";

        // Close the results
        $mysqliResult->close();
        // Close the DB connection
        $mysqli->close();
    }
    else{
        // Close the results
        $mysqliResult->close();
        // Close the DB connection
        $mysqli->close();
        print "error loading data";
    }
}
?>