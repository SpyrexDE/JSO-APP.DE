<?php session_start();
    if(!isset($_SESSION["username"])){header('location: ../../index.php'); return;}



    $username = $_SESSION["username"];

    include('database.php');
    


        $database -> query("DELETE FROM users WHERE username='$username'") or die ("Fehler beim löschen des Accounts: ".mysqli_error($database));


        session_destroy();
        session_start();
        $_SESSION["alerts"]=array();
        array_push($_SESSION["alerts"], array("Erfolg!", "Dein Account wurde erfolgreich gelöscht.", "success"));

        header("location: ../../index.php");

?>