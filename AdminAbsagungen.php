<?php
if(!isset($_SESSION)){
    session_start();
}
if($_SESSION['type'] != 'Dirigent'){header("location: index.php"); return;}
?>
<html style="width: 100%;height: 100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>JSO-Planer</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titan+One">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="shortcut icon" href="assets/img/tabIcon.png" type="image/x-icon">
</head>

<body style="width: 100%;height: 100%;">
    <div id="wrapper">
        <div class="shadow-lg topBar" id="sidebar-wrapper" style="background-color: #ffffff;">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" style="background-color: #478cf4;height: 67px;">
                    <div class="text-secondary" style="width: 100%;height: 100%;overflow: hidden;background-color: #ffffff;border-width: 0;border-bottom: ;border-color: lightgrey;border-style: solid;">
                        <div style="width: 30%;background: grey;float: left;height: 100%;background-color: rgba(255,255,255,0);"><i class="icon ion-ios-contact" style="color: #478cf4;font-size: 64px;margin: -18px;margin-left: -28px;"></i></div>
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;">Martin</label><label style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;">Dirigent</label></div>
                    </div>
                </li>
                <li> <a href="AdminTermine.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Termine</a><a href="AdminProbenplan.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Probenplan</a><a class="activeTab" href="AdminAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">R??ckmeldungen</a><a href="assets/php/logoutProcess.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Logout</a></li>
            </ul>
        </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;">
            <div class="col topBar"><a class="btn btn-link float-left" role="button" id="menu-toggle" href="#menu-toggle" style="font-size: 37px; margin-top: 9px;"><i class="fa fa-bars"></i></a>
                <div class="float-none text-center">
                    <div style="white-space: pre;display: block;padding: 9.5px;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;word-break: break-all;word-wrap: break-word;overflow: hidden;"> <a class="navbar-brand float-none" href="#" style="color: #478cf4 !important;
    font-size: 31px !important;
    padding-top: 0 !important;
    font-weight: 1000 !important;
    margin-top: 4px !important;
    padding-bottom: 0px !important;
    font-family: 'Fugaz One', cursive !important; margin-right: 50px;">JSO-Planer</a><i onclick="openOld();" class="fas fa-history" style="transform: scale(1.5); transform-origin: 0; position: fixed; top: 26px; right: 50px;"></i></div>
                </div>
            </div>
        </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;box-shadow: none !important;">
            <div id="contentPage" class="col" style="padding: 0;"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
<!---- Must Add above thing or you can use alternative icons or CSS Entities---->



    <?php

    include "assets/php/database.php";

    //Lade Proben
    $result = $database -> query("select * from rehearsals")
    or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));

    $rows = array();
    while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
    }


    //split date and time from abbreviation
    for($i = 0; $i < count($rows); ++$i){
        $d = $rows[$i]["date"];
        $t = $rows[$i]["time"];
        if(strpos($d, " ") !== FALSE || strpos($d, "-") !== FALSE ){
            $splitted = preg_split("/[\s,\-]+/", $d);
            for($i2 = 0; $i2 < count($splitted); ++$i2){
                if(strpos($splitted[$i2], ".") > 0){
                    $realDate = $splitted[$i2];
                    $rows[$i]["realDate"] = $realDate;
                    break;
                }
            }
        } else{
            $rows[$i]["realDate"] = $d;
        }

        if(strpos($t, " ") !== FALSE || strpos($t, "-") !== FALSE ){
            $splittedT = preg_split("/[\s,\-]+/", $t);
            for($i3 = 0; $i3 < count($splittedT); ++$i3){
                if(strpos($splittedT[$i3], ":") > 0){
                    $realTime = $splittedT[$i3];
                    $rows[$i]["realTime"] = $realTime;
                    break;
                }
            }
        } else{
            $rows[$i]["realTime"] = $t;
        }
    }


    function date_compare($a, $b)
    {
        $input = $a["realDate"]." ".$a["realTime"];
        $date = strtotime($input);
        $input2 = $b["realDate"]." ".$b["realTime"];
        $date2 = strtotime($input2);

        return $date - $date2;
    }
    usort($rows, 'date_compare');
    include "assets/php/getPromises.php";

    function arrValContains($search, $arr){
        foreach ($arr as $entry) {
            if(strpos($entry, $search) !== FALSE){
                return true;
            }
        }
    }

    for($i = 0; $i < count($rows); ++$i){


        //if date not in past
        $date = strtotime($rows[$i]["realDate"]) + 86400;
        $now = time();
        $actual = true;
        if($date < $now &! isset($_GET["showOld"])) {
            continue;
        }


        $probenTyp = "";
        $groups = json_decode($rows[$i]["groups"], true);

        $g = array_keys($groups);
        if(in_array("Stimmprobe", $g) || in_array("Konzert", $g) || in_array("Generalprobe", $g) || in_array("Konzertreise", $g)){
            $probenTyp = $g[0];
        }
        if(arrValContains("*", $g)){
            $probenTyp = "Kleingruppenprobe";
            if(in_array("Konzert*", $g)){
                $probenTyp = "Kleingruppenkonzert";
            }
            if(in_array("Konzertreise*", $g)) {
                $probenTyp = "Kleingruppenkonzertreise";
            }
            if(in_array("Generalprobe*", $g)) {
                $probenTyp = "Kleingruppengeneralprobe";
            }
        }

        
    ?>

    
    

    <div class="tree">
      <ul style="padding-left: 5px;">

      <li><span><a style="color:#000; text-decoration:none; background-color: <?php if (isset($rows[$i]['color'])) { print $rows[$i]['color'];}else{print 'white';}?>;" data-toggle="collapse" href="#Orchester<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="Orchester<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
      <i class="expanded"><i class="far fa-folder-open"></i></i> <?php print($rows[$i]['date']); if($probenTyp != ""){print(" - ".$probenTyp);}?></a> <a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Tutti"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Tutti"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Tutti"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
      <div id="Orchester<?php print($rows[$i]['id']);?>" class="collapse">
      <ul>
          <?php if(isInGroup("Streicher*", $groups) || isInGroup("Violine_1*", $groups) || isInGroup("Violine_2*", $groups) || isInGroup("Bratsche*", $groups) || isInGroup("Cello*", $groups) || isInGroup("Kontrabass*", $groups)){ ?>
       <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Streicher<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="Streicher<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
      <i class="expanded"><i class="far fa-folder-open"></i></i> Streicher</a> <a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Streicher"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Streicher"=>0), $rows[$i])));?></a><i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Streicher"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
         <ul><div id="Streicher<?php print($rows[$i]['id']);?>" class="collapse">
            <?php if(isInGroup("Violine_1*", $groups)){?>
            <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#vio1<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="vio1<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="far fa-folder-open"></i></i> Violine 1</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Violine_1"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Violine_1"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Violine_1"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                       <ul><div id="vio1<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Violine_1"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Violine_1"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Violine_1"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Violine_1*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Violine_1*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Violine_1*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                       </ul>
            </li>
            <?php } if(isInGroup("Violine_2*", $groups)){?>
            <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#vio2<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="vio2<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="far fa-folder-open"></i></i> Violine 2</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Violine_2"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Violine_2"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Violine_2"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                       <ul><div id="vio2<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Violine_2"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Violine_2"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Violine_2"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Violine_2*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Violine_2*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Violine_2*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                       </ul>
            </li>
            <?php } if(isInGroup("Bratsche*", $groups)){?>
            <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#br<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="br<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="far fa-folder-open"></i></i> Bratschen</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Bratsche"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Bratsche"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Bratsche"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                       <ul><div id="br<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Bratsche"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Bratsche"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Bratsche"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Bratsche*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Bratsche*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Bratsche*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                       </ul>
            </li>

            <?php } if(isInGroup("Cello*", $groups)){?>

            <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#clo<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="clo<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="far fa-folder-open"></i></i> Celli</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Cello"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Cello"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Cello"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                       <ul><div id="clo<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Cello"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Cello"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Cello"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Cello*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Cello*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Cello*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                       </ul>
            </li>
            <?php } if(isInGroup("Kontrabass*", $groups)){?>
            <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#ba<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="ba<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="far fa-folder-open"></i></i> B??sse</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Kontrabass"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Kontrabass"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Kontrabass"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                       <ul><div id="ba<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Kontrabass"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Kontrabass"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Kontrabass"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Kontrabass*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Kontrabass*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Kontrabass*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                       </ul>
            </li>
            <?php } ?>
         </ul>
       </li>
       <?php } if(isInGroup(isInGroup("Bl??ser*", $groups) || "Holzbl??ser*", $groups) || isInGroup("Blechbl??ser*", $groups) || isInGroup("Fl??te*", $groups) || isInGroup("Klarinette*", $groups) || isInGroup("Oboe*", $groups) || isInGroup("Fagott*", $groups) || isInGroup("Trompete*", $groups) || isInGroup("Posaune*", $groups)  || isInGroup("Tuba*", $groups) || isInGroup("Horn*", $groups)){ ?>

      <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Bl??ser<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="Bl??ser<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
      <i class="expanded"><i class="far fa-folder-open"></i></i> Bl??ser</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Bl??ser"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Bl??ser"=>0), $rows[$i])));?></a></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Bl??ser"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
        <ul><div id="Bl??ser<?php print($rows[$i]['id']);?>" class="collapse">
            <?php if(isInGroup("Holzbl??ser*", $groups) || isInGroup("Fl??te*", $groups) || isInGroup("Klarinette*", $groups) || isInGroup("Oboe*", $groups) || isInGroup("Fagott*", $groups)){ ?>
          <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#hb<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="hb<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
              <i class="expanded"><i class="far fa-folder-open"></i></i> Holzbl??ser </a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Holzbl??ser"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Holzbl??ser"=>0), $rows[$i])));?></a></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Holzbl??ser"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
             <ul><div id="hb<?php print($rows[$i]['id']);?>" class="collapse">
                <?php if(isInGroup("Fl??te*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#fl<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="fl<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Fl??ten</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Fl??te"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Fl??te"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Fl??te"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="fl<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Fl??te"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Fl??te"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Fl??te"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Fl??te*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Fl??te*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Fl??te*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                    </ul>
                </li>
                <?php } if(isInGroup("Klarinette*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#kl<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="kl<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Klarinetten</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Klarinette"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Klarinette"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Klarinette"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="kl<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Klarinette"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Klarinette"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Klarinette"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Klarinette*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Klarinette*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Klarinette*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                    </ul>
                </li>
                <?php } if(isInGroup("Oboe*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#ob<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="ob<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Oboen</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Oboe"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Oboe"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Oboe"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="ob<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Oboe"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Oboe"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Oboe"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Oboe*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Oboe*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Oboe*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                        </ul>
                </li>
                <?php } if(isInGroup("Fagott*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#fa<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="fa<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Fagotte</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Fagott"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Fagott"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Fagott"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="fa<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Fagott"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Fagott"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Fagott"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Fagott*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Fagott*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Fagott*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                        </ul>
                </li>
                <?php } ?>
               </div>
             </ul>
            </li>
            <?php } if(isInGroup("Blechbl??ser*", $groups) || isInGroup("Trompete", $groups) || isInGroup("Posaune", $groups)  || isInGroup("Tuba", $groups) || isInGroup("Horn", $groups)){?>
            <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#bb<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="bb<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
            <i class="expanded"><i class="far fa-folder-open"></i></i> Blechbl??ser</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Blechbl??ser"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Blechbl??ser"=>0), $rows[$i])));?></a></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Blechbl??ser"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
             <ul><div id="bb<?php print($rows[$i]['id']);?>" class="collapse">

                <?php if(isInGroup("Trompete", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#tr<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="tr<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Trompeten</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Trompete"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Trompete"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Trompete"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="tr<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Trompete"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Trompete"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Trompete"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Trompete*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Trompete*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Trompete*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                    </ul>
                </li>
                <?php } if(isInGroup("Posaune*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#po<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="po<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Posaunen</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Posaune"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Posaune"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Posaune"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="po<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Posaune"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Posaune"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Posaune"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Posaune*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Posaune*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Posaune*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                    </ul>
                </li>
                <?php } if(isInGroup("Tuba*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#tu<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="tu<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> Tuben</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Tuba"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Tuba"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Tuba"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="tu<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Tuba"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Tuba"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Tuba"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Tuba*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Tuba*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Tuba*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                    </ul>
                </li>
                <?php } if(isInGroup("Horn*", $groups)){?>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#ho<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="ho<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> H??rner</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Horn"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getPromises(array("Horn"=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Horn"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
                           <ul><div id="ho<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Horn"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Horn"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Horn"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{ 
                                foreach(getWithoutPromises(array("Horn*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Horn*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Horn*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
                        </div>
                    </ul>
                </li>
                <?php } ?>
               </div>
             </ul>
            </li>


           </div>
        </ul>
      </li>
      <?php }?>
      <?php } if(isInGroup("Schlagwerk*", $groups)){ ?>

       <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Schlagwerk<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="Schlagwerk<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
      <i class="expanded"><i class="far fa-folder-open"></i></i>Schlagwerk</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Schlagwerk"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Schlagwerk"=>0), $rows[$i])));?></a></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Schlagwerk"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
         <ul><div id="Schlagwerk<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Schlagwerk"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Schlagwerk"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Schlagwerk"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{
                            foreach(getWithoutPromises(array("Schlagwerk*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Schlagwerk*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Schlagwerk*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
         </ul>
       </li>
       <?php } if(isInGroup("Andere*", $groups)){ ?>
       <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Andere<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="Andere<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
      <i class="expanded"><i class="far fa-folder-open"></i></i> Andere</a><a class="rightfloatet"><?php print_r(count(getWithoutPromises(array("Andere"=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array("Andere"=>0), $rows[$i])));?></a></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array("Andere"=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
         <ul><div id="Andere<?php print($rows[$i]['id']);?>" class="collapse">
                            <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array("Andere"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Andere"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Andere"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } }else{
                            foreach(getWithoutPromises(array("Andere*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getPromises(array("Andere*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php } ?>
                            <?php foreach(getWithNoPromises(array("Andere*"=>0), $rows[$i]) as $userid => $user){?>
                                <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                            <?php }}?>
         </ul>
       </li>
       <?php } ?>
      </ul>
      </div>
      </li>
      </ul>

      </div>
    <?php
    }
?>



<br></div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
    <?php
    if(!isset($_GET["showOld"])) {
    ?>
        function openOld() {
            swal({
                title:"Zur vollst??ndigen Ansicht wechseln?",
                text: "In der vollst??ndigen Ansicht werden auch bereits vergangene Proben angezeigt.",
                buttons: {
                        cancel: "Abbrechen",
                        confirm: "Vollst??ndige Ansicht"
                }
            }).then( function(isConfirm) { 
                if (isConfirm) {
                    window.location = "AdminAbsagungen.php?showOld=true";
                }
            });
        }
    <?php
    } else {
    ?>
        function openOld() {
            swal({
                title:"Zur relevanten Ansicht wechseln?",
                text: "In der relevanten Ansicht werden nur zuk??nftige Proben angezeigt.",
                buttons: {
                        cancel: "Abbrechen",
                        confirm: "Relevante Ansicht"
                }
            }).then( function(isConfirm) { 
                if (isConfirm) {
                    window.location = "AdminAbsagungen.php";
                }
            });
        }



    <?php
    }
    ?>

    $(document).on("click", "span", function (event) {
        if($(this).children("a").length > 0)
            $(this).children("a")[0].click();
    });


    $(document).on('click','.userSpan', function(){

        var user = this.innerText.trim();
        var username = this.innerText.split(" - ")[0].replace("???", "").trim();

        //load user info
        $.ajax({
            url: 'assets/php/accModifier.php?getLastLogin=true&name=' + user,
            success: function(data) {

                swal({
                title: username,
                text: "Letzer login: " + data,
                dangerMode: true,
                buttons: {
                    confirm: `Account l??schen`,
                    deny: `Passwort zur??cksetzen`,
                    cancel: 'Abbrechen',
                }
                }).then( function(value) {
                    switch (value) {
                        case true: deleteAcc(user); break;
                        case "deny": resetPW(user); break;
                    }
                });

            }
        });

    });

    function deleteAcc(username) {
        swal({
            title:"Account L??schen",
            html: true,
            text: "Willst du den Account von " + username + " wirklich l??schen?\n Wir k??nnen keine Daten wiederherstellen!",
            buttons: {
                    cancel: "Abbrechen",
                    confirm: "L??schen"
            },
            dangerMode: true,
        }).then( function(isConfirm) { 
                if (isConfirm) {
                    $.ajax({
                    url: 'assets/php/accModifier.php?delete=true&name=' + username,
                    success: function(data) {
                        swal({
                                icon: "success",
                                text: data,
                            });
                    }
                    });
                }
        });
    }

    function resetPW(username) {
        swal({
            title:"Passwort zur??cksetzen",
            text: "Willst du das Passwort von " + username + " wirklich zur??cksetzen?\n Wir k??nnen keine Daten wiederherstellen!",
            buttons: {
                    cancel: "Abbrechen",
                    confirm: "Zur??cksetzen"
            },
        }).then( function(isConfirm) { 
                if (isConfirm) {
                        $.ajax({
                        url: 'assets/php/accModifier.php?resetPW=true&name=' + username,
                        success: function(data) {
                            swal({
                                icon: "success",
                                text: data,
                            });
                        }
                        });
                }
        });
    }

    </script>
    
<?php include "assets/php/checkForAlerts.php";?>
</body>

</html>