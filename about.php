<?php
// HTTPS redirect
if ($_SERVER['HTTPS'] !== 'on') {
    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectURL");
    exit;
}
    if(!session_start()) {
        header("Location: error.php");
        exit;
    }

    $loggedIn = empty($_SESSION['loggedin']) ? false : true;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sword&Board- About</title>
    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="pageStyle.css">

    <script>
        $(document).ready(function () {
            //checks is logged in, to change login/logout button
            var checkSession = '<?php echo $loggedIn; ?>';
            if (checkSession){
                $("#logInNav").html("Log Out");
                $("#logInNav").attr("href","logout.php");
            }
            else{
                $("#signUpNav").css("visibility","visible");
            }
        });
    </script>


</head>
<body>
    <ul class="navigation">
        <div id="navAlign">
            <li><a href="index.php"><img src="images/S&BLogo.png" alt="Sword & Board" id="logo"></a></li>
            <div id="navItems">
                <li><a href="index.php">Play</a></li>
                <li><a href="about.php">About</a></li>
                <span id="rightNav">
                    <li><a href="signup.php" id="signUpNav">Sign Up</a></li>
                    <li><a href="login.php" id="logInNav">Log In</a></li>
                </span>
            </div>
        </div>
    </ul>

    <div class="contentWrapper">
        <div class="mainCenter">
            <h2>About the Site</h2>
            <p>This site was created by Kyle Stevenson, I'm a junior IT major.  This site is intended to provide a fun text based RPG experience.
                Players have the ability to create a character which is saved to their account, and play the adventure making choices and
                passing skill checks to succeed.</p>
            <p>The current adventure is quite short due to time, but I would like to develope it further and create more adventures in the future.
                As well as continuing to improve the overall gameplay and functionality of the site.  I hope you enjoy!</p>
        </div>
    </div>
    <div class="footer">
        <p>Created by Kyle Stevenson.</p>
    </div>
</body>
