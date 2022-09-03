<?php session_start();

    if(!isset($_SESSION["username"])){ header('location: ../../index.php'); return;}

    include('globals.php');

    if($_SESSION['type'] != 'Dirigent' && !strpos($_SESSION["username"], "♚"))
        die("No permission");

    if(!isset($_GET["name"]))
        die("No name given");
    
    $name = $_GET["name"];

    include('database.php');
    
    if(isset($_GET["delete"]))
    {
        $database -> query("DELETE FROM users WHERE username='$name'") or die ("Fehler beim löschen des Accounts: ".mysqli_error($database));
        die("Der Nutzer $name wurde erfolgreich gelöscht.");
    }
    else if(isset($_GET["resetPW"]))
    {
        $pw = password_hash("12345", PASSWORD_DEFAULT);

        $database -> query("UPDATE users SET password='$pw' WHERE username='$name'") or die ("Fehler beim Zurücksetzen des Passworts: ".mysqli_error($database));
        die("Das Passwort des Nutzers $name wurde auf 12345 zurückgesetzt.");
    }
    else if(isset($_GET["getLastLogin"]))
    {
        $data = $database -> query("SELECT * FROM users WHERE username='$name'") or die ("Fehler beim Laden der Daten: ".mysqli_error($database));
        $data = $data->fetch_array();
        if(isset($data["last_login"]))
            die($data["last_login"]);
        else
            die("N/A");
    }
?>