<?php session_start();
    $_SESSION["alerts"] = array();

    //Lade Werte des form-elemtes in die Variablen
    $oldUsername = $_SESSION['username'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $type = $_POST['type'];
    $smallGroup = $_POST['smallGroup'];
    $groupLeader = $_POST['groupLeader'];
    $groupLeaderPW = $_POST['groupLeaderPW'];

    include('database.php');
    include('globals.php');

    //Anti Mysql injection
    $username = strip_tags($username);
    $password = strip_tags($password);
    $username = mysqli_real_escape_string($database, $username);
    $password = mysqli_real_escape_string($database, $password);


    if(!empty($username)){
        if(strlen( $username) < 2 && strlen( $username) > 20){array_push($_SESSION["alerts"], array("Fehler!", "Dein Nutzername muss zwischen 2 und 20 Zeichen haben.", "error")); header('location: ../../EditProfile.php'); return;}
        if($username == $global_AdminName){array_push($_SESSION["alerts"], array("Fehler!", "Dein Nutzername darf nicht der des Dirigenten sein.", "error")); header('location: ../../EditProfile.php'); return;}

        //Suche nach Nutzer in der Datenbank
        $result = $database -> query("select * from users where username = '$username'")
        or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));
        
        //Überprüfe, ob Nutzername schon existiert
        if (mysqli_num_rows($result) > 0 && $username != $oldUsername){         array_push($_SESSION["alerts"], array("Fehler!", "Dieser Nutzername ist bereits vergeben", "error")); header("location: ../../EditProfile.php");}

        //Setze neuen Nutzernamen
        $database -> query("UPDATE users SET username='$username' WHERE username='$oldUsername'") or die ("Fehler beim bearbeiten des Accounts: ".mysqli_error($database));
    } else {
        $username = $oldUsername;
    }

    if(!empty($password)){
        if($password != $password2){array_push($_SESSION["alerts"], array("Fehler!", "Der Inhalt des ersten Passwortfeldes muss mit dem des Zweiten übereinstimmen.", "error")); header('location: ../../EditProfile.php'); return;}
        if(strlen( $password) < 2 || strlen( $password) > 20){array_push($_SESSION["alerts"], array("Fehler!", "Dein Passwort muss zwischen 2 und 20 Zeichen haben.", "error")); header('location: ../../EditProfile.php'); return;}

        $password = password_hash($password, PASSWORD_DEFAULT);//encrypt pw

        //Setze neues Passwort
        $database -> query("UPDATE users SET password='$password' WHERE username='$username'") or die ("Fehler beim bearbeiten des Accounts: ".mysqli_error($database));
    }

    if(!empty($type)){
        //Setze neue Stimmgruppe
        $database -> query("UPDATE users SET type='$type' WHERE username='$username'") or die ("Fehler beim bearbeiten des Accounts: ".mysqli_error($database));
    } else{
        $type = $_SESSION['type'];
    }

    ////Check for smallGroup

    if(!empty($smallGroup)){
        if(strpos($type, "*") === false){
            $type = $type."*";
        }
    } else{
        if(strpos($type, "*") !== false){
            $type = str_replace("*", "", $type);
        }
    }
    //Setze neue smallGroup
    $database -> query("UPDATE users SET type='$type' WHERE username='$username'") or die ("Fehler beim bearbeiten des Accounts: ".mysqli_error($database));
    
    ////


    ////Check for groupLeader
    $newUsername = $username;
    if(!empty($groupLeader) && $groupLeaderPW == $global_leaderPW || !empty($groupLeader) && strpos($username, "♚") !== false){
        if(strpos($username, "♚") === false){
            $newUsername = $newUsername."♚";
        }
    } else{
        if(strpos($username, "♚") !== false){
            $newUsername = str_replace("♚", "", $newUsername);
        }
    }
    //Setze neuen groupLeader
    $database -> query("UPDATE users SET username='$newUsername' WHERE username='$username'") or die ("Fehler beim bearbeiten des Accounts: ".mysqli_error($database));
    
    ////

    include "logoutProcess.php";

    $_SESSION["alerts"] = array();
    array_push($_SESSION["alerts"], array("Erfolg!", "Deine Änderungen wurden übernommen! Bitte logge dich erneut ein.", "success"));
?>