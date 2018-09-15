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
    <title>Sword&Board- Home </title>
    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="pageStyle.css">

    <script>
        $(function(){
            //check if logged in, to change login/logout buttons
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
            <div class="contentBox">
                <h2>Adventures</h2>
            </div>
            <!-- adventure listing -->
            <div class="contentBox">
                <div class="adventurePreviewBox">
                    <a href="deep-down.php"><img src="images/caveImage.jpg" alt="Cave"></a>
                    <div class="previewBoxTitle"><h4>Deep Down</h4></div>
                </div>
                <div class="adventurePreviewBox">
                    <img src="images/dungeon.jpg" alt="Forest">
                    <div class="previewBoxTitle"><h4>Coming Soon...</h4></div>
                </div>
            </div>
            <hr>
            <!-- video -->
            <iframe width="854" height="480" src="https://www.youtube.com/embed/wacGpSE3qEA" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
    <div class="footer">
        <p>Created by Kyle Stevenson.</p>
    </div>
</body>
</html>