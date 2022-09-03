<?php
if(!isset($_SESSION)){
    session_start();
}
if(strpos($_SESSION['username'], '♚') === false){header("location: index.php"); return;}
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
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;"><?php echo $_SESSION['username'] ?></label><label style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;"><?php echo $_SESSION['type'];?></label></div>
                    </div>
                </li>
<li> <a href="Abmeldungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Meine Meldungen</a><?php if(strpos($_SESSION['username'], '♚') !== false){?><a class="activeTab" href="LeaderAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Rückmeldungen</a><?php }?> <a href="Probenplan.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Probenplan</a> <a href="EditProfile.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Profil bearbeiten</a>
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
    font-family: 'Fugaz One', cursive !important; margin-right: 50px;">JSO-Planer</a><i onclick="openAV();" class="far fa-list-alt" id="toolTip1" style="transform: scale(2); transform-origin: 0; position: fixed; top: 20px; right: 50px; cursor: pointer;"></i></div></div>
                </div>
            </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;box-shadow: none !important;">
            <div id="contentPage" class="col" style="padding: 0;">
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
        $probenTyp = "";
        $groups = json_decode($rows[$i]["groups"], true);

        $g = array_keys($groups);
        if(in_array("Stimmprobe", $g) || in_array("Konzert", $g) || in_array("Generalprobe", $g) || in_array("Konzertreise", $g)){
            $probenTyp = $g[0];
        }
        if(arrValContains("*", $g)){
            $probenTyp = "Kleingruppenprobe";
        }

        $usersGroup = str_replace("*", "", $_SESSION["type"]);
        $usersGroup = str_replace(" ", "_", $usersGroup);
        if(!isInGroup($usersGroup."*", $groups)){continue;}
    ?>

    
    

    <div class="tree">
      <ul style="padding-left: 5px;">

    <li><span><a style="color:#000; text-decoration:none; background-color: <?php if (isset($rows[$i]['color'])) { print $rows[$i]['color'];}else{print 'white';}?>;" data-toggle="collapse" href="#Orchester<?php print($rows[$i]['id']);?>" aria-expanded="false" aria-controls="Orchester<?php print($rows[$i]['id']);?>"><i class="collapsed"><i class="fas fa-folder"></i></i>
    <i class="expanded"><i class="far fa-folder-open"></i></i> <?php print($rows[$i]['date']); if($probenTyp != ""){print(" - ".$probenTyp);}?></a> <a class="rightfloatet"><?php print_r(count(getWithoutPromises(array($usersGroup=>0), $rows[$i])));?></a> <i class="fas fa-times-circle treeIcon rightfloatet"></i> <a class="rightfloatet"><?php print_r(count(getPromises(array($usersGroup=>0), $rows[$i])));?></a> <i class="fas fa-check-circle treeIcon rightfloatet"></i><a class="rightfloatet"><?php print_r(count(getWithNoPromises(array($usersGroup=>0), $rows[$i])));?></a></a> <i class="fas fa-question-circle treeIcon rightfloatet"></i></span>
    <div id="Orchester<?php print($rows[$i]['id']);?>" class="collapse">
    <ul>

                <?php if($probenTyp != "Kleingruppenprobe"){ foreach(getWithoutPromises(array($usersGroup=>0), $rows[$i]) as $userid => $user){?>
                    <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                <?php } ?>
                <?php foreach(getPromises(array($usersGroup=>0), $rows[$i]) as $userid => $user){?>
                    <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                <?php } ?>
                <?php foreach(getWithNoPromises(array($usersGroup=>0), $rows[$i]) as $userid => $user){?>
                    <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                <?php } }else{
                foreach(getWithoutPromises(array($usersGroup."*"=>0), $rows[$i]) as $userid => $user){?>
                    <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-times-circle smallTreeIcon rightfloatet"></i></span></li>
                <?php } ?>
                <?php foreach(getPromises(array($usersGroup."*"=>0), $rows[$i]) as $userid => $user){?>
                    <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-check-circle smallTreeIcon rightfloatet"></i></span></li>
                <?php } ?>
                <?php foreach(getWithNoPromises(array($usersGroup."*"=>0), $rows[$i]) as $userid => $user){?>
                    <li><span class="userSpan"><i class="fas fa-user" style="zoom: 0.8; margin-right: 5px;"></i> <?php print($user['username']); if(getUserInfo($user['username'], $rows[$i]) != ""){print(" - ".getUserInfo($user['username'], $rows[$i]));}?>  <i class="fas fa-question-circle smallTreeIcon rightfloatet"></i></span></li>
                <?php }}?>

      </div>
      </li>
      </ul>

      </div>
      <?php } ?>


<br></div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Development -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    <!-- Production -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

<script>
    function openAV(){
        swal({
            title:"Zur erweiterten Ansicht wechseln?",
            buttons: {
                    cancel: "Abbrechen",
                    confirm: "Erweiterte Ansicht"
            }
        }).then( function(isConfirm) { 
            if (isConfirm) {
                window.open("AdvancedView.php","_self");
            }
        });
    }
</script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    tippy('#toolTip1', {
        allowHTML: true,
        content: "Wechsle hier zu erweiterten Ansicht",
        arrow:'true',
    });

    
    $(document).on("click", "span", function (event) {
        if($(this).children("a").length > 0)
            $(this).children("a")[0].click();
    });


    $(document).on('click','.userSpan', function(){

        var user = this.innerText.trim();
        var username = this.innerText.split(" - ")[0].replace("♚", "").trim();

        //load user info
        $.ajax({
            url: 'assets/php/accModifier.php?getLastLogin=true&name=' + user,
            success: function(data) {

                swal({
                title: username,
                text: "Letzer login: " + data,
                dangerMode: true,
                buttons: {
                    confirm: `Account löschen`,
                    deny: `Passwort zurücksetzen`,
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
            title:"Account Löschen",
            html: true,
            text: "Willst du den Account von " + username + " wirklich löschen?\n Wir können keine Daten wiederherstellen!",
            buttons: {
                    cancel: "Abbrechen",
                    confirm: "Löschen"
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
            title:"Passwort zurücksetzen",
            text: "Willst du das Passwort von " + username + " wirklich zurücksetzen?\n Wir können keine Daten wiederherstellen!",
            buttons: {
                    cancel: "Abbrechen",
                    confirm: "Zurücksetzen"
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