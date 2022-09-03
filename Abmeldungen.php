<?php 
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['username'])){header("location: index.php"); return;}
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
        <link rel="manifest" href="manifest.json"><script type="module" src="https://cdn.jsdelivr.net/npm/easy-pwa-js@1.0/dist/front.js"></script>
</head>

<body style="width: 100%;height: 100%;">
    <div id="wrapper">
        <div class="shadow-lg topBar" id="sidebar-wrapper" style="background-color: #ffffff;">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" style="background-color: #478cf4;height: 67px;">
                    <div class="text-secondary" style="width: 100%;height: 100%;overflow: hidden;background-color: #ffffff;border-width: 0;border-bottom: 0;border-color: lightgrey;border-style: solid;">
                        <div style="width: 30%;background: grey;float: left;height: 100%;background-color: rgba(255,255,255,0);"><i class="icon ion-ios-contact" style="color: #478cf4;font-size: 64px;margin: -18px;margin-left: -28px;"></i></div>
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;"><?php echo $_SESSION['username'] ?></label><label style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;"><?php echo $_SESSION['type'];?></label></div>
                    </div>
                </li>
<li> <a class="activeTab" href="Abmeldungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Meine Meldungen</a><?php if(strpos($_SESSION['username'], '♚') !== false){?><a href="LeaderAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Rückmeldungen</a><?php }?> <a href="Probenplan.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Probenplan</a>  <a href="EditProfile.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Profil bearbeiten</a>
                    <a
                        href="assets/php/logoutProcess.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Logout</a>
                </li>
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
    font-family: 'Fugaz One', cursive !important; margin-right: 100px;">JSO-Planer</a><i onclick="openOld();" class="fas fa-history" style="transform: scale(1.5); transform-origin: 0; position: fixed; top: 26px; right: 82px;"></i><i id="toolTip1"class="fa fa-question-circle" style="transform: scale(3); transform-origin: 0; position: fixed; top: 30px; right: 50px;"></i></div></div>
                </div>
            </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;box-shadow: none !important;">
            <div id="contentPage" class="col" style="padding: 0;">
                <div class="float-none text-center">

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

                    function sortTypes($a,$b){
                        if($b == "Konzertreise"){
                            return 1;
                        } elseif($b == "Konzert" && $a != "Konzertreise"){
                            return 1;
                        } elseif($b == "Generalprobe" && $a != "Konzert"){
                            return 1;
                        } elseif ($b == "Stimmprobe" && $a != "Generalprobe" && $a != "Konzert") {
                            return 1;
                        } elseif($b == $_SESSION['type'] && $a != "Stimmprobe" && $a != "Generalprobe" && $a != "Konzert"){
                            return 1;
                        } elseif(isInGroup($_SESSION['type'], array($b=>0)) && $a != "Stimmprobe" && $a != "Generalprobe" && $a != "Konzert"){
                            return 1;
                        } else{
                            return -1;
                        }
                     }


                    for($i = 0; $i < count($rows); ++$i){
                        //if relevant
                        include_once 'assets/php/getPromises.php';
                        $groups = json_decode($rows[$i]["groups"]);


                        //and date not in past
                        $date = strtotime($rows[$i]["realDate"]) + 86400;
                        $now = time();
                        $actual = true;
                        if($date < $now &! isset($_GET["showOld"])) {
                            $actual = false;
                        }

                        if(isInGroup($_SESSION['type'], $groups) && $actual){

                            //Sortierung der $groups
                            $groupArray = array_keys(json_decode($rows[$i]["groups"], true));

                            usort($groupArray, "sortTypes");


                            $groups = str_replace("_", " ", implode("<br>", $groupArray));



                            $promArr = explode("|", $_SESSION['promises']);
                            $search = "";
                            foreach($promArr as $key=>$value){
                                if(strpos($value, "!".$rows[$i]["id"]) !== false){
                                    $search = "|".$value;
                                }
                            }
                            preg_match('!\(([^\)]+)\)!', $search, $match);
                            if(!empty($match)){
                                $info = $match[0];
                                $info = str_replace("(", "", $info);
                                $info = str_replace(")", "", $info);
                            }else{
                                $info = "";
                            }

                            $promises = preg_replace("#\((.*?)\)#","",$_SESSION['promises']);
                            
                            //if promised
                            if(in_array($rows[$i]["id"], explode("|", $promises))){
                    ?>
                    <div class="greenOut" style="position: relative; display: block;border-radius: 10px;height: 111px;margin-right: 20px;margin-left: 20px;box-shadow: 0px 0px 30px rgba(128,128,128,0.4);margin-top: 30px;text-align: left;min-width: 300px;zoom: 0.8;border-width: 4px;border-style: solid; background-color: <?php if (isset($rows[$i]['color'])) { print $rows[$i]['color'];}else{print 'white';}?>;">
                        <div class="row" style="width: 100%;">
                            <div class="col col-8" style="margin-top: -7px;">
                                <div class="row">
                                    <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["date"]);?><br></label></div>
                                    <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($groups);?>&nbsp;<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["time"]);?><br></label></div>
                                    <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["location"]);?><br></label></div>                                </div>
                                </div>
                            <div style="height: 50%;width: 24%;display: inline-block;white-space: nowrap;float: right;padding-top: 13px;transform: scale(1.4);transform-origin: 0 0;"><img id= "<?php print($rows[$i]['id']);?>" class="checkBtn" src="assets/img/icons8_checked_checkbox_48px_2.png"><img id= "<?php print($rows[$i]['id']);?>" class="crossBtn deselected" src="assets/img/icons8_close_window_48px_1.png"></div>
                        </div>
                        <i id="icon<?php print($rows[$i]['id']);?>"class="hideIcon fa <?php if($info == ""){print("fa-plus-square");}else{print("fa-pen-square");}?> addNoteBtn" style="transform: scale(2); transform-origin: 0; top: 12px; right: 18px;position:absolute; <?php if($info == ""){print("color: lightgrey;");}?>visibility: hidden;"></i>
                    </div>

                    <?php 
                    //if unpromised
                        }elseif(in_array("!".$rows[$i]["id"], explode("|", $promises))){ ?>

                        <div class="redOut" style="position: relative; display: block;border-radius: 10px;height: 111px;margin-right: 20px;margin-left: 20px;box-shadow: 0px 0px 30px rgba(128,128,128,0.4);margin-top: 30px;text-align: left;min-width: 300px;zoom: 0.8;border-width: 4px;border-style: solid; background-color: <?php if (isset($rows[$i]['color'])) { print $rows[$i]['color'];}else{print 'white';}?>;">
                            <div class="row" style="width: 100%;">
                                <div class="col col-8" style="margin-top: -7px;">
                                    <div class="row">
                                        <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["date"]);?><br></label></div>
                                        <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($groups);?>&nbsp;<br></label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["time"]);?><br></label></div>
                                        <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["location"]);?><br></label></div>                                </div>
                                    </div>
                                <div style="height: 50%;width: 24%;display: inline-block;white-space: nowrap;float: right;padding-top: 13px;transform: scale(1.4);transform-origin: 0 0;"><img id= "<?php print($rows[$i]['id']);?>" class="checkBtn deselected" src="assets/img/icons8_checked_checkbox_48px_2.png"><img id= "<?php print($rows[$i]['id']);?>" class="crossBtn" src="assets/img/icons8_close_window_48px_1.png"></div>
                            </div>
                            <i id="icon<?php print($rows[$i]['id']);?>"class="showIcon fa <?php if($info == ""){print("fa-plus-square");}else{print("fa-pen-square");}?> addNoteBtn" style="transform: scale(2); transform-origin: 0; top: 12px; right: 18px;position:absolute; <?php if($info == ""){print("color: lightgrey;");}?>"></i>
                        </div>
                    
                    <?php
                            //if not decided yet
                            } else { ?>

                                <div class="grayOut" style="position: relative; display: block;border-radius: 10px;height: 111px;margin-right: 20px;margin-left: 20px;box-shadow: 0px 0px 30px rgba(128,128,128,0.4);margin-top: 30px;text-align: left;min-width: 300px;zoom: 0.8;border-width: 4px;border-style: solid; background-color: <?php if (isset($rows[$i]['color'])) { print $rows[$i]['color'];}else{print 'white';}?>;">
                                    <div class="row" style="width: 100%;">
                                        <div class="col col-8" style="margin-top: -7px;">
                                            <div class="row">
                                                <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["date"]);?><br></label></div>
                                                <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($groups);?>&nbsp;<br></label></div>
                                            </div>
                                            <div class="row">
                                                <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["time"]);?><br></label></div>
                                                <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["location"]);?><br></label></div>                                </div>
                                            </div>
                                        <div style="height: 50%;width: 24%;display: inline-block;white-space: nowrap;float: right;padding-top: 13px;transform: scale(1.4);transform-origin: 0 0;"><img id= "<?php print($rows[$i]['id']);?>" class="checkBtn deselected" src="assets/img/icons8_checked_checkbox_48px_2.png"><img id= "<?php print($rows[$i]['id']);?>" class="crossBtn deselected" src="assets/img/icons8_close_window_48px_1.png"></div>
                                    </div>
                                    <i id="icon<?php print($rows[$i]['id']);?>"class="hideIcon fa <?php if($info == ""){print("fa-plus-square");}else{print("fa-pen-square");}?> addNoteBtn" style="transform: scale(2); transform-origin: 0; top: 12px; right: 18px;position:absolute; <?php if($info == ""){print("color: lightgrey;");}?>visibility: hidden;"></i>
                                </div>
                            <?php
                            }
                            ?>
                            <input type="hidden" id="info<?php print($rows[$i]['id']);?>" value="<?php print $info;?>">
                            <?php
                        }
                    }
                    ?>


                    <br>

                    </div>
<script src="assets/js/jquery.min.js"></script>

<script>
$(".checkBtn").click(function(e) {
        var id = e.target.id;
        id = id.replace("icon", "");

        e.target.nextSibling.classList.add("deselected");
        e.target.classList.remove("deselected");
        e.target.parentElement.parentElement.parentElement.classList.remove("redOut");
        e.target.parentElement.parentElement.parentElement.classList.remove("grayOut");
        e.target.parentElement.parentElement.parentElement.classList.add("greenOut");
        document.getElementById("icon".concat(e.target.id)).classList.remove("showIcon");
        document.getElementById("icon".concat(e.target.id)).classList.add("hideIcon");
        $("#icon".concat(e.target.id)).css('visibility', 'hidden');
        $.ajax({
                url: 'assets/php/promiseReceiver.php',
                type:'POST',
                data:
                {
                    promised: true,
                    id: id
                }
        });
});
    
$(".crossBtn").click(function(e) {
        var id = e.target.id;
        id = id.replace("icon", "");

        e.target.previousSibling.classList.add("deselected");
        e.target.classList.remove("deselected");
        e.target.parentElement.parentElement.parentElement.classList.remove("greenOut");
        e.target.parentElement.parentElement.parentElement.classList.remove("grayOut");
        e.target.parentElement.parentElement.parentElement.classList.add("redOut");
        document.getElementById("icon".concat(e.target.id)).classList.remove("hideIcon");
        document.getElementById("icon".concat(e.target.id)).classList.add("showIcon");
        document.getElementById("icon".concat(e.target.id)).classList.add("fa-plus-square");
        document.getElementById("icon".concat(e.target.id)).classList.remove("fa-pen-square");
        document.getElementById("icon".concat(e.target.id)).style.color = 'lightgrey';
        $("#icon".concat(e.target.id)).css('visibility', 'visible');

        $.ajax({
                url: 'assets/php/promiseReceiver.php',
                type:'POST',
                data:
                {
                    promised: false,
                    id: id
                }
        });
});
</script></div>
            </div>
        </div>
    </div>


<script>
    $(".addNoteBtn").click(function(e){
        var id = e.target.id;
        id = id.replace("icon", "");

        if($("#info".concat(id)).val() != ""){
            var info = prompt('Anmerkung hinzufügen:', $("#info".concat(id)).val());
        }else{
            var info = prompt('Anmerkung hinzufügen:','');
        }
        if(info != null){
            $.ajax({
                    url: 'assets/php/promiseReceiver.php',
                    type:'POST',
                    data:
                    {
                        promised: false,
                        id: id,
                        info: info
                    }
            });
            if(info === ""){
                this.classList.add("fa-plus-square");
                this.classList.remove("fa-pen-square");
                this.style.color = "lightgrey";
            }else{
            this.classList.remove("fa-plus-square");
            this.classList.add("fa-pen-square");
            this.style.color = null;
            $("#info".concat(id)).val(info);
            }
        }
    });
</script>



    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    
        <!-- Development -->
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    <!-- Production -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
    tippy('#toolTip1', {
        allowHTML: true,
        content: "Hier siehst du alle für dich relevanten Proben.<br>Durch das Klicken auf das Haken- oder Kreuzsymbol der jeweiligen Probe kannst du zu- oder absagen. Deine Auswahl kannst du jederzeit wieder ändern.<br><br>Tipp: Bei allen vier Textfeldern einer Probe kann man scrollen. Sollten mehr Information vorhanden sein (z.B. weitere Stimmgruppen die mit deiner Stimmgruppe zusammen Probe haben), werden sie so sichtbar. Dies sollte jedoch nie nötig sein, da der Algorithmus erkennt, welche Information für dich beim ersten Blick zu sehen sein muss. <?php if(strpos($_SESSION['type'], '*') !== false){echo '<br><br>Für die Kleingruppenmitglieder: Alle mit * markierten Stimmgruppen meinen nur die Kleingruppenmitglieder der jeweiligen Stimmgruppe.';}?>",
        arrow:'true',
    	trigger:'click'
    });

    <?php
    if(!isset($_GET["showOld"])) {
    ?>
        function openOld() {
            swal({
                title:"Zur vollständigen Ansicht wechseln?",
                text: "In der vollständigen Ansicht werden auch bereits vergangene Proben angezeigt.",
                buttons: {
                        cancel: "Abbrechen",
                        confirm: "Vollständige Ansicht"
                }
            }).then( function(isConfirm) { 
                if (isConfirm) {
                    window.location = "Abmeldungen.php?showOld=true";
                }
            });
        }
    <?php
    } else {
    ?>
        function openOld() {
            swal({
                title:"Zur relevanten Ansicht wechseln?",
                text: "In der relevanten Ansicht werden nur zukünftige Proben angezeigt.",
                buttons: {
                        cancel: "Abbrechen",
                        confirm: "Relevante Ansicht"
                }
            }).then( function(isConfirm) { 
                if (isConfirm) {
                    window.location = "Abmeldungen.php";
                }
            });
        }

    <?php
    }
    ?>
    </script>
    
    <?php include "assets/php/checkForAlerts.php";?>
</body>

</html>
