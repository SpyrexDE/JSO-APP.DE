<?php session_start();
    if(count($_POST) < 4){header('location: ../../TerminHinzufügen.php'); return;}



    //Lade Werte des form-elemtes in die Variablen
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    if(isset($_POST['smallGroup'])){
        $smallGroup = $_POST['smallGroup'];
        $types = array_slice($_POST, 4);
    }else{
        $types = array_slice($_POST, 3);
    }
    unset($types['selectedColor']);
    $color = $_POST['selectedColor'];

    include('database.php');

    //Anti Mysql injection
    $date = strip_tags($date);
    $time = strip_tags($time);
    $location = strip_tags($location);
    $color = strip_tags($color);
    $date = mysqli_real_escape_string($database, $date);
    $time = mysqli_real_escape_string($database, $time);
    $location = mysqli_real_escape_string($database, $location);
    $color = mysqli_real_escape_string($database, $color);


    if(!empty($smallGroup)){
        foreach(array_keys($types) as $key){
            $types[$key."*"] = $types[$key];
            unset($types[$key]);
        }
    }



    $types = json_encode($types, JSON_UNESCAPED_UNICODE);

    $_SESSION["alerts"] = array();

    //Check for date mistake

    //split date and time from abbreviation
    $d = $date;
    $t = $time;
    if(strpos($d, " ") !== FALSE || strpos($d, "-") !== FALSE ){
        $splitted = preg_split("/[\s,\-]+/", $d);
        for($i2 = 0; $i2 < count($splitted); ++$i2){
            if(strpos($splitted[$i2], ".") !== FALSE){
                $realDate = $splitted[$i2];
                break;
            }
            if(!isset($realDate)){
                $realDate = $d;
            }
        }
    } else{
        $realDate = $d;
    }
    
    if(strpos($t, " ") !== FALSE || strpos($t, "-") !== FALSE ){
        $splittedT = preg_split("/[\s,\-]+/", $t);
        for($i3 = 0; $i3 < count($splittedT); ++$i3){
            if(strpos($splittedT[$i3], ":") !== FALSE){
                $realTime = $splittedT[$i3];
                break;
            }
            if(!isset($realTime)){
                $realTime = $t;
            }
        }
    } else{
        $realTime = $t;
    }
    
    $input = $realDate." ".$realTime;
    $dt = strtotime($input);
    if(!$dt){array_push($_SESSION["alerts"], array("Fehler!", "Die Datum- und Zeitangaben enthalten nicht die nötigen Informationen. Bitte achten sie darauf, sowohl bei dem Datum, als auch bei der Zeit zwischen anderen Zeichen ein Leerzeichen zu platzieren. Zudem sollten sie das Format des Datums (z.B. 30.06.2020) und das Format der Zeit (z.B. 18:05) beachten.", "error")); header('location: ../../TerminHinzufügen.php'); return;}


    if(strlen( $date) < 2 || strlen( $date) > 50 || strlen( $time) < 2 || strlen( $time) > 50 || strlen($location) < 2 || strlen($location) > 50){array_push($_SESSION["alerts"], array("Fehler!", "Das Datum und die Uhrzeit dürfen nur zwischen 2 und 50 Zeichen haben.", "error")); header('location: ../../TerminHinzufügen.php'); return;}

        if($color == null){
            $database -> query("INSERT INTO rehearsals (`date`, `time`, `location`, `groups`) VALUES ('$date', '$time','$location', '$types')") or die ("Fehler beim erstellen der Probe: ".mysqli_error($database));
        } else{
            $database -> query("INSERT INTO rehearsals (`date`, `time`, `location`, `groups`, `color`) VALUES ('$date', '$time','$location', '$types', '$color')") or die ("Fehler beim erstellen der Probe: ".mysqli_error($database));
        }
        
        
        array_push($_SESSION["alerts"], array("Erfolg!", "Der neue Termin wurde erfolgreich erstellt!", "success"));
        header("location: ../../AdminTermine.php");

?>