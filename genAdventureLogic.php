<?php
    // get stat/skill value from database and add to d20 roll
    function skillCheck($skill){
        $sVal = getStat($skill);

        return rand(1,20)+$sVal;
    }
//returns num from database
function getStat($stat) {
    if (!session_start()) {
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

    if ($mysqliResult->num_rows == 1) {

        $row = $mysqliResult->fetch_assoc();

        // Close the results
        $mysqliResult->close();
        // Close the DB connection
        $mysqli->close();

        //return stat/skill
        return $row[$stat];
    }
    return "error";

}

?>