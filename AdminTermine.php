<?php 
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['username']) && $_SESSION['type'] != 'Dirigent'){header("location: index.php"); return;}
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
                    <div class="text-secondary" style="width: 100%;height: 100%;overflow: hidden;background-color: #ffffff;border-width: 0;border-bottom: 0;border-color: lightgrey;border-style: solid;">
                        <div style="width: 30%;background: grey;float: left;height: 100%;background-color: rgba(255,255,255,0);"><i class="icon ion-ios-contact" style="color: #478cf4;font-size: 64px;margin: -18px;margin-left: -28px;"></i></div>
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;">Martin</label><label style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;">Dirigent</label></div>
                    </div>
                </li>
                <li> <a class="activeTab" href="AdminTermine.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Termine</a><a href="AdminProbenplan.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Probenplan</a><a href="AdminAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Rückmeldungen</a><a href="assets/php/logoutProcess.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Logout</a></li>
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
                                if(!isset($realDate)){
                                    $realDate = $d;
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
                                if(!isset($realTime)){
                                    $realTime = $t;
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


                    for($i = 0; $i < count($rows); ++$i){
                        $groups = str_replace("_", " ", implode("<br>", array_keys(json_decode($rows[$i]["groups"], true))));
                    
                        //if date not in past
                        $date = strtotime($rows[$i]["realDate"]) + 86400;
                        $now = time();
                        $actual = true;
                        if($date < $now &! isset($_GET["showOld"])) {
                            continue;
                        }
                    
                    ?>


                    <div style="display: block;border-radius: 10px;height: 111px;margin-right: 20px;margin-left: 20px;box-shadow: 0px 0px 30px rgba(128,128,128,0.4);margin-top: 30px;text-align: left;min-width: 300px;zoom: 0.8;border-width: 4px;border-style: solid;border-color: rgb(179,179,179); background-color: <?php if (isset($rows[$i]['color'])) { print $rows[$i]['color'];}else{print 'white';}?>;">
                        <div class="row" style="width: 100%;">
                            <div class="col col-8" style="margin-top: -7px;">
                                <div class="row">
                                    <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["date"]);?><br></label></div>
                                    <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;margin-top: 15px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($groups);?>&nbsp;<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col col-6"><label class="col-form-label text-break" style="margin-bottom: 0;margin-left: 20px;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["time"]);?><br></label></div>
                                    <div class="col"><label class="col-form-label text-break" style="margin-bottom: 0;font-size: 20px;font-weight: 600;width: 100%;overflow: auto;max-height: 40px;"><?php print($rows[$i]["location"]);?><br></label></div>
                                </div>
                            </div>
                            <div style="height: 50%;width: 24%;display: inline-block;white-space: nowrap; float: right; padding-top: 15px;transform: scale(1.4);transform-origin: 0 0;"><img id="<?php print($rows[$i]['id']); ?>" class= "edit" src="assets/img/icons8_edit_file_48px.png" style="cursor: pointer; transform: scale(0.9);transform-origin: 0 -210px;"><img id="<?php print($rows[$i]['id']); ?>" class= "delete" src="assets/img/icons8_delete_bin_96px.png" style="transform: scale(0.5);transform-origin: 0 0; cursor: pointer;"></div>
                        </div>
                    </div>


                    <?php
                    }


                    ?>

                    </div><br><br><br><br><br></div><a href="TerminHinzufügen.php"><img src="assets/img/icons8_add_96px.png" style="position: fixed;bottom: 10px;right: 10px;z-index: 9999;-webkit-filter: drop-shadow(5px 5px 5px #222);filter: drop-shadow(5px 5px 5px #222);" /> </a></div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>


        $(".delete").click(function (event) {
            $.ajax({
                url: 'assets/php/deleteRehearsalProcess.php',
                type:'POST',
                data:
                {
                    id: event.target.id
                }
            });
            location.reload();
        });

        
        $(".edit").click(function (event) {
            window.location = "TerminBearbeiten.php?id=".concat(event.target.id);
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
                    window.location = "AdminTermine.php?showOld=true";
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
                    window.location = "AdminTermine.php";
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