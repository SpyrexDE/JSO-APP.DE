<?php session_start();
    if(empty( $_POST['username']) ||  empty($_POST['password'])){header('location: ../../index.php'); return;}



    //Lade Werte des form-elemtes in die Variablen
    $username = $_POST['username'];
    $password = $_POST['password'];

    include('database.php');
    include('globals.php');

    $_SESSION["alerts"] = array();

    if($username == $global_AdminName && $password == $global_AdminPW){$_SESSION['username'] = 'Martin'; $_SESSION['type'] = 'Dirigent'; header("location: ../../AdminAbsagungen.php"); return;}

    //Anti Mysql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($database, $username);
    $password = mysqli_real_escape_string($database, $password);




    //Suche nach Nutzer in der Datenbank
    $result = $database -> query("select * from users where username = '$username'")
                  or die('Fehler beim durchsuchen der Datenbank: '.mysqli_error($database));
    $row = $result->fetch_array();

    if(empty($row)){
        $username = $username."♚";

        //Suche nach Nutzer in der Datenbank
        $result = $database -> query("select * from users where username = '$username'")
                    or die('Fehler beim durchsuchen der Datenbank: '.mysqli_error($database));
        $row = $result->fetch_array();
	    
        if(empty($row))
        {
            array_push($_SESSION["alerts"], array("Fehler!", "Benutzername oder Passwort ist falsch.", "error")); header("location: ../../index.php");  return;	
        }

    }



    


    if ($row['username'] != $username || !password_verify($password, $row['password'])){array_push($_SESSION["alerts"], array("Fehler!", "Benutzername oder Passwort ist falsch.", "error")); header("location: ../../index.php");  return;}


    //Add activityPoints
    $ap = $row['ap'];
    $date = $row["last_login"];
    $now = date("d.m.Y");
    if($date != $now) {
        $ap += 1;
        $database -> query("UPDATE users SET ap='$ap', last_login='$now' WHERE username='$username'") or die ("Fehler beim einloggen: ".mysqli_error($database));
    }


    $_SESSION['username'] = $username;
    $_SESSION['type'] = $row['type'];
    $_SESSION['promises'] = $row['promises'];
    
    setcookie ("username",$_POST["username"],time()+ 604800) or die("Fehler beim erstellen von Cookies");
    setcookie ("password",$_POST["password"],time()+ 604800) or die("Fehler beim erstellen von Cookies");


    header("location: ../../Abmeldungen.php");
    


?>
