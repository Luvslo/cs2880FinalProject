<?php

include 'genAdventureLogic.php';

$choice = empty($_POST['choice']) ? '' : $_POST['choice'];

//Deep Down Game Logic
    switch ($choice){
        case 'cave0':
            print "<p>You push forward, as the tunnel begins to grow narrow, you come to a split.  A tunnel ".
                    "winds left, and another to the right sloping noticeably downward</p>";
            print "<a onclick=updatePage('left1')>Choose the Left path</a><br>";
            print "<a onclick=updatePage('right1')>Choose the Right path</a><br>";
            break;
        case 'left1':
            print "<p>You start down the left tunel, it begins to get even narrower than the previous tunnel.".
                "  After some time, you notice a foul smell in the air, your torch soon alights the cause...  Some creature,".
                " of what manner you can not tell lies decaying on the rocky floor across your path.</p>".
                "<p>You move forward, and notice it has deep stab wounds going clean through its body...</p>";
            print "<a onclick=updatePage('right1')>Turn Back, take the right tunnel instead</a><br>";
            print "<a onclick=updatePage('left2a')>Carefully step over the creature and continue</a><br>";
            print "<a onclick=updatePage('left2b')>[Mechanics] Perhaps this is a trap, investigate</a><br>";
            break;
        case 'left2a':
            print "<p>You step over the creature, being careful not to touch it, when your foot snags on something.".
                "  Sharp spears made of sharpened rock thrust through holes in the walls impaling you.</p>";
            death();
            break;
        case 'left2b':
            print "<p>Investigating around the corpse you notice holes in the sides of the wall, and a small trip wire.".
                "  Someone must have reset this trap and left this poor creature as bait.</p>";
            if(skillCheck('s_mechanics') > 5){
                print "<p>[Success] You disarm the trap.</p>";
                print "<a onclick=updatePage('left3')>Continue down the tunnel</a><br>";
            }
            else{
                print "<p>[Failure] In your attempt to disarm the device you accidentally trigger the trap!".
                    "  Sharp spears made of sharpened rock thrust through the holes in the walls impaling you.</p>";
                death();
            }
            break;
        case 'left3':
                print "<p>Your path leads you to a dead end... or perhaps not.  You look over this end in the path, and ".
                    "begin to notice a few strange markings on the wall in front of you.  Could this be some sort of door,".
                    " how could it possibly be opened?</p>";
                print "<p>You notice a small wheel on the door, with various animal shapes carved onto it, and it turns.".
                    "  This appears to be a sort of puzzle, the animal shapes resemble: a bat, a raven, and a fish</p>";
                print "<a onclick=updatePage('left4a')>Turn the wheel to the Bat</a><br>";
                print "<a onclick=updatePage('left4b')>Turn the wheel to the Raven</a><br>";
                print "<a onclick=updatePage('left4c')>Turn the wheel to the Fish</a><br>";
                print "<a onclick=updatePage('left4d')>[Speech] I think the answer might be...</a><br>";
                break;
        case ('left4a'):
                print "<p>You turn the wheel to the Bat and press on the door, it doesn't budge.</p>";
                print "<a onclick=updatePage('left3alt')>Try a different option</a><br>";
            break;
        case ('left4b'):
                print "<p>You turn the wheel to the Raven and press on the door, it doesn't budge.</p>";
                print "<a onclick=updatePage('left3alt')>Try a different option</a><br>";
                break;
        case ('left4c'):
                print "<p>You turn the wheel to the Fish and press on the door, The heavy stone grinds open,".
                    " a new path opens.</p>";
                print "<a onclick=updatePage('cave5')>Enter and continue</a><br>";
                break;
        case ('left4d'):
                if(skillCheck('s_speech')> 10){
                    print "<p>[Success] You notice a pattern here, a fish is the only creature that can't fly.  It's".
                        " worth a try, you turn the wheel to the fish and press on the door... The heavy stone grinds open,".
                        " a new path opens.</p>";
                    print "<a onclick=updatePage('cave5')>Enter and continue</a><br>";
                }
                print "<p>[Fail] You have no idea what the correct choice would be, guessing is your best chance.</p>";
                print "<a onclick=updatePage('left3alt')>Continue</a><br>";
                break;
        case 'left3alt':
                 print "<p>Your path leads you to a dead end... or perhaps not.  You look over this end in the path, and ".
                    "begin to notice a few strange markings on the wall in front of you.  Could this be some sort of door,".
                    " how could it possibly be opened?</p>";
                print "<p>You notice a small wheel on the door, with various animal shapes carved onto it, and it turns.".
                    "  This appears to be a sort of puzzle, the animal shapes resemble: a bat, a raven, and a fish.</p>";
                print "<a onclick=updatePage('left4a')>Turn the wheel to the Bat</a><br>";
                print "<a onclick=updatePage('left4b')>Turn the wheel to the Raven</a><br>";
                print "<a onclick=updatePage('left4c')>Turn the wheel to the Fish</a><br>";
                break;
        case 'right1':
                print "<p>You make your way down the right path, it becomes steeper as you venture further.  You".
                    " soon find youself is a large open cavern, a sizable lake in front of you, and you think you can see".
                    " the path continue on the other side.  The water is dark, and smells stale, but it may be shallow ".
                    "enough to wade through to the other side.</p>";
                print "<a onclick=updatePage('left1')>Turn back, take the left tunnel instead</a><br>";
                print "<a onclick=updatePage('right2')>Attempt to cross to the other side</a><br>";
                break;
        case 'right2':
                print "<p>You start into the water, it seems to only be a few feet deep, and warmer than you'd thought.".
                    "  Yet, as you make it near halfway across you sense the water tremble and begin to shake.  About".
                    " a dozen feet from you a creature lurches out of the water, slimy and horrific its numerous tentacles ready".
                    " to strangle you!</p>";
                print "<a onclick=updatePage('right3a')>[Athletics] Run! You can still make it to the other side!</a><br>";
                print "<a onclick=updatePage('right3b')>[Fight] Stand your ground and Fight!</a><br>";
                break;
        case 'right3a':
                if(skillCheck('s_athletics')>10){
                    print "<p>[Success] Narrowly evading this monstrosity you reach the other side and rush into the narrow tunnel.".
                        " The creature gurgles and howls but is too large to pursue you any further, you are safe, for now..</p>";
                    print "<a onclick=updatePage('cave5')>Continue down the tunnel</a><br>";
                }
                else{
                    print "<p>[Failure] The other side is within sight, you rush through the water when you feel the creature grab".
                        " hold of you legs.  You drop your torch and the cavern falls into complete darkness as it drags".
                        " you through the water.</p>";
                    death();
                }
            break;
        case 'right3b':
                if(skillCheck('player_attack')>5){
                    print "<p>[Success] Your attack drives the creature back!  It slinks back into the water badly wounded, you".
                        " make it to the other side, and enter into the tunnels once more.</p>";
                    print "<a onclick=updatePage('cave5')>Continue</a><br>";
                }
                else{
                    print "<p>[Failure] You attempt to fight off the beast, but you are no match for this creature. ".
                        "It grabs you and tosses you across the cavern, your head hits against a rock and your torch goes out".
                        " as it drops into the water.  Struggling to stand you are grabbed again and pulled to your death.</p>";
                    death();
                }
            break;
        case 'cave5':
                print "<p>You continue through the tunnel, until you begin to hear voices...human voices.  Perhaps you".
                    " have found the captives!  You inch closer and peer into the room, a few men in strange hooded black cloaks".
                    " patrol about the room.  Then you see them, their helpless victims, tied to posts in the back of the chamber.</p>";
                print "<a onclick=updatePage('cave5a')>[Stealth] Try to sneak around them and get to the victims</a><br>";
                print "<a onclick=updatePage('boss1')>[Fight] They will pay for what they're done!</a><br>";
                break;
        case 'cave5a':
            if(skillCheck('s_stealth')>12){
                print "<p>[Success] You manage to sneak around the perimeter of the cavern, and make it to the captives.".
                    "  They look to be in bad shape as you begin to untie their bonds.  You spot another tunnel leading out".
                    " of this wretched place, you lead the captives quietly away and escape!</p>";
                print "<a onclick=updatePage('end')>Continue</a><br>";
            }
            else{
                print "<p>[Failure] You're noticed by the men, they draw daggers and rush towards you!</p>";
                print "<a onclick=updatePage('boss1')>Attack!</a><br>";
            }
            break;
        case 'boss1':
            if(skillCheck('player_attack')>5){
                print "<p>[Success] You strike down one of the men, but are still surrounded by the others.</p>";
                print "<a onclick=updatePage('boss2')>Attack!</a><br>";
            }
            else{
                print "<p>[Failure] There are too many for you to fight, one lands a deep strike into your side and you ".
                    "drop to the floor, quickly surrounded by the others.</p>";
                death();
            }
            break;
        case 'boss2':
            if(skillCheck('player_defense')>8){
                print "<p>[Success] You withstand the blows of the others and continue to fight back!</p>";
                print "<a onclick=updatePage('boss3')>Attack!</a><br>";
            }
            else{
                print "<p>[Failure] After you kill one of their own the others respond in fury, you're unable to withstand their".
                    " assault, they pummel you to the ground in a bloody heap.</p>";
                death();
            }
            break;
        case 'boss3':
            if(skillCheck('player_attack')>10){
                print "<p>[Success] You triumph over your foes! You rush to the captives and untie their bonds.".
                    "  They are is bad shape, but thank you with what strength they have, you lead them into the tunnels to ".
                    "make your escape.</p>";
                print "<a onclick=updatePage('end')>Continue</a><br>";
            }
            else{
                print "<p>[Failure] Only one foe remains, the lives of these innocent people at stake.  You miss your attack...".
                    " and your enemy capitalizes, he thrusts his blade straight into your chest, piercing your heart.  You collapse,".
                    " the last thing you see.. the tied up victims tears as their only hope dies in front of them.</p>";
                death();
            }
            break;
        case 'end':
            print "<p>After hours you find your way back out of the cave with the captives, it was a struggle but you've done it!".
                "  The town is overjoyed, yet startled by the details of their captors.  Nonetheless you are paid handsomly and a feast".
                " is thrown in your honor that night!</p>";
            print "<p> Congratulations!</p>";
            print "<a href='deep-down.php'>Play Again</a>";
            break;
        default:
            print "Selection Error";
            break;
    }
    //death function, resets page
    function death(){
        print "<p>You have died!</p>";
        print "<a href='deep-down.php'>Try Again</a>";
    }
?>