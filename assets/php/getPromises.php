<?php

include "database.php";
include "globals.php";

//Lade Proben
$result = $database -> query("select * from rehearsals")
or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));

$rehearsals = array();
while($r = mysqli_fetch_assoc($result)) {
    $rehearsals[] = $r;
}

//Lade Nutzer
$result = $database -> query("select * from users")
or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));

$users = array();
while($r = mysqli_fetch_assoc($result)) {
    $users[] = $r;
}

function getRehearsalByID($id){
    global $rehearsals;
    for($i = 0; $i < count($rehearsals); ++$i){
        if($rehearsals[$i]["id"] == $id){
            return $rehearsals[$i];
        }
    }
}

function findKey($key, $array) {
    if (array_key_exists($key, $array)) return true;
    foreach ($array as $k=>$v) {
        if (!is_array($v)) continue;
        if (array_key_exists($key, $v)) return true;
    }
    return false;
}

function isInGroup($type, $groups){
    $type = str_replace (" ", "_", $type);
    global $typeStructure;
    $groups = (array)$groups;
    
    if(!empty($groups)){
        if(strpos(array_keys($groups)[0], "*")){        //Falls *-Probe:
            if(!strpos($type, "*")){                    //Überprüfe ob Nutzer ist *
                return false;                           //Wenn nicht: return false;
            } else {                                    //Sonst
                foreach(array_keys($groups) as $key){   //Entferne alle "*" bei den Probengruppen
                    $groups[str_replace("*", "", $key)] = $groups[$key];
                    unset($groups[$key]);
                }
            }
        }
    } else{
        return true;
    }
    $type = str_replace("*", "", $type); 

    if(findKey($type, $groups)){
        return true;
    }
    if(findKey("Tutti", $groups)){
        return true;
    }
    if(findKey("Streicher", $groups)){
        if(in_array($type, $typeStructure["Tutti"]["Streicher"]) || $type == "Streicher"){
            return true;
        }
    }
    if(findKey("Holzbläser", $groups)){
        if(in_array($type, $typeStructure["Tutti"]["Bläser"]["Holzbläser"]) || $type == "Holzbläser" || $type == "Bläser"){
            return true;
        }
    }
    if(findKey("Blechbläser", $groups)){
        if(in_array($type, $typeStructure["Tutti"]["Bläser"]["Blechbläser"]) || $type == "Blechbläser" || $type == "Bläser"){
            return true;
        }
    }
    if(findKey("Bläser", $groups)){
        if(in_array($type, $typeStructure["Tutti"]["Bläser"]["Holzbläser"]) || $type == "Holzbläser"){
            return true;
        }
        if(in_array($type, $typeStructure["Tutti"]["Bläser"]["Blechbläser"]) || $type == "Blechbläser"){
            return true;
        }
        if($type == "Bläser"){
            return true;
        }
    }
    return false;
}

function getUserInfo($username, $rehearsal){
    global $users;
    $id = $rehearsal["id"];

    $info = "";
    for($i = 0; $i < count($users); ++$i){
        if($users[$i]["username"] == $username){

            $promArr = explode("|", $users[$i]["promises"]);
            $search = "";
            foreach($promArr as $key=>$value){
                if(strpos($value, "!".$id) !== false){
                    $search = "|".$value;
                }
            }
            preg_match('!\(([^\)]+)\)!', $search, $match);
            if(!empty($match)){
                $info = $match[0];
                $info = str_replace("(", "", $info);
                $info = str_replace(")", "", $info);
            }
        }
    }
    return $info;
}

function getPromises($group, $rehearsal){
    global $users;
    $count = [];
    $id = $rehearsal["id"];
    $rehearsalGroups = json_decode($rehearsal["groups"]);

    for($i = 0; $i < count($users); ++$i){
        if(isInGroup($users[$i]["type"], $rehearsalGroups)){ //Nur wenn überhaupt für die Probe gewollt
            if(isInGroup($users[$i]["type"], $group)){
                if(!empty($users[$i]['promises'])){
                    $promises = preg_replace("#\((.*?)\)#","",$users[$i]['promises']);
                    if(strpos($users[$i]['promises'], "|".$id) !== false){
                        array_push($count, $users[$i]);
                    }
                }
            }
        }
    }
    return $count;
}

function getWithoutPromises($groups, $rehearsal){
    global $users;
    $count = [];
    $id = $rehearsal["id"];
    $rehearsalGroups = json_decode($rehearsal["groups"]);

    for($i = 0; $i < count($users); ++$i){
        if(isInGroup($users[$i]["type"], $rehearsalGroups)){ //Nur wenn überhaupt für die Probe gewollt
            if(isInGroup($users[$i]["type"], $groups)){
                if(!empty($users[$i]['promises'])){
                    $promises = preg_replace("#\((.*?)\)#","",$users[$i]['promises']);
                    if(strpos($users[$i]['promises'], "!".$id) !== false){
                        array_push($count, $users[$i]);
                    }
                }
            }
        }
    }
    return $count;
}

function getWithNoPromises($groups, $rehearsal){
    global $users;
    $count = [];
    $id = $rehearsal["id"];
    $rehearsalGroups = json_decode($rehearsal["groups"]);

    for($i = 0; $i < count($users); ++$i){
        if(isInGroup($users[$i]["type"], $rehearsalGroups)){ //Nur wenn überhaupt für die Probe gewollt
            if(isInGroup($users[$i]["type"], $groups)){
                if(!empty($users[$i]['promises'])){
                    $promises = preg_replace("#\((.*?)\)#","",$users[$i]['promises']);
                    if(!strpos($users[$i]['promises'], $id)){
                        array_push($count, $users[$i]);
                    }
                } else{
                    array_push($count, $users[$i]);
                }
            }
        }
    }
    return $count;
}


?>