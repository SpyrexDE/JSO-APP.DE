<?php
session_start();

$promised = $_POST["promised"];
$id = $_POST["id"];
$info = $_POST["info"];
$username = $_SESSION["username"];

include "database.php";

$promises = $database -> query("select promises from users where username = '$username'") or die ("Fehler: ".mysqli_error($database));
$promises = mysqli_fetch_array($promises)[0];

$without = preg_replace("#\((.*?)\)#","",$promises);

if($promised == "true"){
    if(!in_array($id, explode("|", $without)) &! in_array("!".$id, explode("|", $without))){

        $promises .= "|".$id;
        $database -> query("UPDATE users SET promises='$promises' WHERE username='$username'");
        $_SESSION['promises'] = $promises;

    } elseif(in_array("!".$id, explode("|", $without))){

        $search = "|!".$id;
        //Remove notes
        foreach(explode("|", $promises) as $key=>$value){
            if(strpos($value, "!".$id) !== false){
                $search = "|".$value;
            }
        }
        
        $promises = str_replace($search, "|".$id, $promises);
        $database -> query("UPDATE users SET promises='$promises' WHERE username='$username'");
        $_SESSION['promises'] = $promises;

    }
} else{
    if(in_array($id, explode("|", $without))){
        
        $promises = str_replace("|".$id, "|!".$id."(".$info.")", $promises);
        $database -> query("UPDATE users SET promises='$promises' WHERE username='$username'");
        $_SESSION['promises'] = $promises;
        
    } elseif(!in_array("!".$id, explode("|", $without))){

        $promises .= "|!".$id."(".$info.")";
        $database -> query("UPDATE users SET promises='$promises' WHERE username='$username'");
        $_SESSION['promises'] = $promises;

    } elseif(in_array("!".$id, explode("|", $without))){

        $search = "|!".$id;
        //Remove notes
        foreach(explode("|", $promises) as $key=>$value){
            if(strpos($value, "!".$id) !== false){
                $search = "|".$value;
            }
        }
        
        $promises = str_replace($search, "|!".$id."(".$info.")", $promises);
        $database -> query("UPDATE users SET promises='$promises' WHERE username='$username'");
        $_SESSION['promises'] = $promises;

    }
}



?>