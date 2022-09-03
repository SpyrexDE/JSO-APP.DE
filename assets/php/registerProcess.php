<?php session_start();
    if(empty( $_POST['username']) ||  empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['token']) || empty($_POST['type'])){ array_push($_SESSION["alerts"], array("Fehler!", "Ein oder mehrere erforderliche Felder wurden nicht ausgefüllt.", "error")); header('location: ../../Register.php'); return;}



    //Lade Werte des form-elemtes in die Variablen
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $token = $_POST['token'];
    $type = $_POST['type'];

    include('database.php');
    include('globals.php');

    //Anti Mysql injection
    $username = strip_tags($username);
    $password = strip_tags($password);
    $password2 = strip_tags($password2);
    $token = strip_tags($token);
    $username = mysqli_real_escape_string($database, $username);
    $password = mysqli_real_escape_string($database, $password);
    $password2 = mysqli_real_escape_string($database, $password2);
    $token = mysqli_real_escape_string($database, $token);

    $_SESSION["alerts"] = array();
    if(strcmp($password, $password2) > 0){array_push($_SESSION["alerts"], array("Fehler!", "Beide Passworteingaben müssen exakt übereinstimmen.", "error"));header('location: ../../Register.php'); return;}
    if(strlen( $username) < 2 && strlen( $username) > 20 ){ array_push($_SESSION["alerts"], array("Fehler!", "Der Nutzername muss mindestens 2 und darf maximal 20 Zeichen haben.", "error"));header('location: ../../Register.php'); return;}
    if(strlen( $password) < 4 || strlen( $password) > 20){array_push($_SESSION["alerts"], array("Fehler!", "Das Passwort muss mindestens 4 und darf maximal 20 Zeichen haben.", "error"));header('location: ../../Register.php'); return;}
    if($username == $global_AdminName){array_push($_SESSION["alerts"], array("Fehler!", "Der Nutzername darf nicht mit dem des Dirigenten übereinstimmen.", "error"));header('location: ../../Register.php'); return;}
    if($token != $global_token){array_push($_SESSION["alerts"], array("Fehler!", "Es wurde ein falscher Token eingegeben.", "error"));header('location: ../../Register.php'); return;}

    //Suche nach Nutzer in der Datenbank
    $result = $database -> query("select * from users where username = '$username'")
                         or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));

    if (mysqli_num_rows($result) <= 0){  //Falls name noch nicht existiert:
        //Registriere Nutzer
        $password = password_hash($password, PASSWORD_DEFAULT);//encrypt pw
        $database -> query("INSERT INTO users (username, password, type) VALUES ('$username', '$password', '$type')") or die ("Fehler beim erstellen des Accounts: ".mysqli_error($database));



        //Suche nach Nutzer in der Datenbank
        $result = $database -> query("select * from users where username = '$username' and password = '$password'")
        or die('Fehler beim durchsuchen der Datenbank: '.mysqli_error($database));
        $row = $result->fetch_array();

        //Login
        $_SESSION['username'] = $username;
        $_SESSION['type'] = $row['type'];
        $_SESSION['promises'] = $row['promises'];


        array_push($_SESSION["alerts"], array("Willkommen!", "Dein Account wurde erfolgreich registriert.", "success"));
        header("location: ../../Abmeldungen.php");
    } else{
        array_push($_SESSION["alerts"], array("Fehler!", "Dieser Name ist leider schon vergeben.", "error"));
        header('location: ../../Register.php');
    }

?>