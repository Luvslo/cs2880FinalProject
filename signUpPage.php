<?php
// HTTPS redirect
if ($_SERVER['HTTPS'] !== 'on') {
    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectURL");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sword&Board- SignUp</title>
    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">
    <link href="jquery-ui-1.12.1.custom/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="jquery-ui-1.12.1.custom/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="pageStyle.css">
    <script>
        $(function(){
            $("#signUpNav").css("visibility","visible");
            $("input[type=submit]").button();
            $("#confirmPass").keyup(passwordMatch);
        });
        //check that passwords match in realTime, changes font color to red until they match
        function passwordMatch() {
            var pass = $("#password").val();
            var confirmPass = $("#confirmPass").val();
            if(pass != confirmPass){
                $("#confirmPass").css("color","red");
            }
            else {
                $("#confirmPass").css("color","#EEE");
            }
        }
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
            <div id="loginWidget" class="ui-widget">
                <h1 class="ui-widget-header">Sign Up</h1>
                <?php
                if ($error) {
                    print "<div class=\"ui-state-error\">$error</div>\n";
                }
                ?>

                <form action="signup.php" method="POST">

                    <input type="hidden" name="action" value="do_signup">

                    <div class="stack">
                        <label for="username">Username: </label>
                        <input type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus value="" required>
                    </div>

                    <div class="stack">
                        <label for="password">Password: </label>
                        <input type="password" id="password" name="password" class="ui-widget-content ui-corner-all" required>
                    </div>
                    <div class="stack">
                        <label for="confirmPass">Confirm Password: </label>
                        <input type="password" id="confirmPass" name="confirmPass" class="ui-widget-content ui-corner-all" required>
                    </div>

                    <div class="stack">
                        <input type="submit" value="Submit" id="submitBtn">
                    </div>
                </form>
                <div id="formLink">Already have an account? <a href="login.php">Log In</a></div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Created by Kyle Stevenson.</p>
    </div>
</body>
</html>