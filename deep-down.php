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
//check if logged in
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
if (!$loggedIn) {
    $error = "Please LogIn first";
    require "loginPage.php";
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sword&Board- Deep Down</title>
    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script>
        var start = false;
        $(document).ready(function() {
            //load character data if user has a character or display character creation modals if not
            $.post("loadCharacter.php", { action: 'characterExist' }, function(data){
               if(data === 'noCharacter'){
                   $("#selectCharacterModal").modal('show');
                   setupStats();
               }
               else if(data === 'hasCharacter'){
                   $(".right").css("visibility","visible");
                   loadCharacter();
               }
               else{
                   $(".contentBox").html("<h2>Error Loading Data.</h2>");
               }
            });
            //starting text
            $(".contentBox").html("<p>Your torch illuminates the cold walls and low ceilings of this seemingly" +
                " unending cave system.  You've been walking through these tunnels for what seems like hours now.</p>" +
                "<p>Hired by a local town to investigate the cause of a number of strange dissapearances, bandits or kidnappers perhaps, "+
                "you had thought.  You'd discovered a few tracks leading to this cave and figured you should check it out,"+
                " but never would you have suspected it to be this large...</p>"+
                "<a onclick=startAdventure('begin')>Continue</a>");
        });
        // TRIGGERS MUSIC AND STARTS PHP REQUESTS FOR ADVENTURE
        function startAdventure(){
            $("#atmosphereMusic").trigger('play');
            $("#atmosphereMusic").prop('volume',0.03);
            updatePage('cave0');
        }
        // UPDATE PAGE FOR ADVENTURE, SEND STORY SELECTION BY USER TO PHP LOGIC TO RUN ADVENTURE
        function updatePage(choice){
            $.post("deepDownLogic.php", { choice: choice }, function(data){
                $(".contentBox").html(data);
            });
        }
        //Load character data into stat box
        function loadCharacter(){
            $.post("loadCharacter.php", { action : 'setUpStatBox' }, function(data){
                $(".statBox").html(data);
            });
        }
        // sets up stats for first modal on load
        function setupStats(){

            var fighter_class = "Fighter";
            var fighter_defense = 3;
            var fighter_attack = 2;

            var sorc_class = "Sorcerer";
            var sorc_defense = 1;
            var sorc_attack = 4;

            var rogue_class = "Rogue";
            var rogue_defense = 2;
            var rogue_attack = 3;

            $("#fighterBox").append("<img src='images/Fighter.png' alt='Fighter'><br>" +
                "<div><p>Class: "+fighter_class+"</p></div>" +
                "<div><p>Defense: "+fighter_defense+"</p></div>"+
                "<div><p>Attack: "+fighter_attack+"</p></div><hr>"+
                "<div><h4>Skills:</h4></div>"+
                "<div><p>Athletics</p></div>");
            $("#sorcBox").append("<img src='images/Sorcerer.png' alt='Mage'><br>" +
                "<div><p>Class: "+sorc_class+"</p></div>" +
                "<div><p>Defense: "+sorc_defense+"</p></div>"+
                "<div><p>Attack: "+sorc_attack+"</p></div><hr>"+
                "<div><h4>Skills:</h4></div>"+
                "<div><p>Mechanics, Speech</p></div>");
            $("#rogueBox").append("<img src='images/Rogue.png' alt='Rogue'><br>" +
                "<div><p>Class: "+rogue_class+"</p></div>" +
                "<div><p>Defense: "+rogue_defense+"</p></div>"+
                "<div><p>Attack: "+rogue_attack+"</p></div><hr>"+
                "<div><h4>Skills:</h4></div>"+
                "<div><p>Mechanics, Stealth</p></div>");
        }
        //Handle show/hide the 2 modals, and sets values needed when submitting characterCreate form for correct class
        function classSelect(classSelection){
            $("#selectCharacterModal").modal('hide');
            $("#selectCharacterStatsModal").modal('show');
            if(classSelection === 'Fighter'){
                $("#characterStatsDisplayClassImg").html("<img src='images/Fighter.png' alt='Fighter'>");
                $("#characterStatsDisplayClassName").html("<h2>Fighter</h2>");
                $("#classSelectForForm").val("Fighter");
            }
            if(classSelection === 'Sorcerer'){
                $("#characterStatsDisplayClassImg").html("<img src='images/Sorcerer.png' alt='Sorcerer'>");
                $("#characterStatsDisplayClassName").html("<h2>Sorcerer</h2>");
                $("#classSelectForForm").val("Sorcerer");
            }
            if(classSelection === 'Rogue'){
                $("#characterStatsDisplayClassImg").html("<img src='images/Rogue.png' alt='Rogue'>");
                $("#characterStatsDisplayClassName").html("<h2>Rogue</h2>");
                $("#classSelectForForm").val("Rogue");
            }
        }

    </script>
    <link rel="stylesheet" type="text/css" href="pageStyle.css">

</head>
<body>
    <!-- Modal pop-up to select class -->
    <div class="modal fade" id="selectCharacterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Choose a Class:</h2>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="modalRow">
                            <div class="modalCol">
                                <h1>Fighter</h1>
                                <div class="modalStatBox" id="fighterBox"></div>
                            </div>
                            <div class="modalCol">
                                <h1>Sorcerer</h1>
                                <div class="modalStatBox" id="sorcBox"></div>
                            </div>
                            <div class="modalCol">
                                <h1>Rogue</h1>
                                <div class="modalStatBox" id="rogueBox"></div>
                            </div>
                        </div>
                        <div class="modalRow">
                            <div class="modalCol">
                                <button class="characterSelectBtn" id="fighterSelect" type="button" onclick="classSelect('Fighter')">Select</button>
                            </div>
                            <div class="modalCol">
                                <button class="characterSelectBtn" id="sorcSelect" type="button" onclick="classSelect('Sorcerer')">Select</button>
                            </div>
                            <div class="modalCol">
                                <button class="characterSelectBtn" id="rogueSelect" type="button" onclick="classSelect('Rogue')">Select</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 2nd modal, choose character name -->
    <div class="modal fade" id="selectCharacterStatsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Name Your Character:</h2>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="modalRow">
                            <div id="characterStatsDisplayClassImg"></div>
                            <div id="characterStatsDisplayClassName"></div>
                            <form action="createCharacter.php" method="post">
                                <input type="hidden" name="action" value="createUserCharacter">
                                <input type="hidden" name="classSelection" id="classSelectForForm" value="">
                                <!--  IMPLEMENT IF  ENOUGH TIME, ALLOW PLAYER TO CHOOSE THEIR SKILLS
                                <h1>Select Two Skills:</h1>
                                <div>
                                    <input type="checkbox" id="athletics" name="stats" value="athletics">
                                    <label for="athletics">Athletics<br>
                                        Runnning, climbing, jumping</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="mechanics" name="stats" value="mechanics">
                                    <label for="mechanics">Mechanics<br>
                                        Disarming traps, picking locks</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="speech" name="stats" value="speech">
                                    <label for="speech">Speech<br>
                                        Persuading, intimidating, bartering</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="stealth" name="stats" value="stealth">
                                    <label for="stealth">Stealth<br>
                                        Sneaking and hiding</label>
                                </div>
                                -->
                                <div>
                                    <label id="modalTitle" for="characterName">Character Name:</label><br>
                                    <input type="text" id="characterName" name="characterName" size="25"  maxlength="25">
                                </div>
                                <input class="characterSelectBtn" id="submitCharacter" type="submit" value="Submit">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page audio tracks-->
    <audio class="audioTrack" id="atmosphereMusic" preload="none" loop><source src="audio/caveAtmosphere.mp3" type="audio/mpeg"></audio>

    <!-- navigation bar -->
    <ul class="navigation">
        <div id="navAlign">
            <li><a href="index.php"><img src="images/S&BLogo.png" alt="Sword & Board" id="logo"></a></li>
            <div id="navItems">
                <li><a href="index.php">Play</a></li>
                <li><a href="about.php">About</a></li>
                <span id="rightNav">
                    <li><a href="logout.php" id="logInNav">Log Out</a></li>
                </span>
            </div>
        </div>
    </ul>
    <!-- main page content -->
    <div class="contentWrapper">

        <div class="box main">
            <h2>Deep Down</h2>
            <br>
            <div class="contentBox">
                <p>Error Loading Page</p>
            </div>
        </div>
        <div class="box right">
            <h2>Character Info</h2>
            <div class="statBox"></div>
        </div>
    </div>
    <div class="footer">
        <p>Created by Kyle Stevenson.</p>
        <p id="credits">Music: https://www.bensound.com</p>
    </div>
</body>
</html>