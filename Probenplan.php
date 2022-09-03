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
</head>

<body style="width: 100%;">
    <div id="wrapper">
        <div class="shadow-lg topBar" id="sidebar-wrapper" style="background-color: #ffffff;">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" style="background-color: #478cf4;height: 67px;">
                    <div class="text-secondary" style="width: 100%;height: 100%;overflow: hidden;background-color: #ffffff;border-width: 0;border-bottom: 0;border-color: lightgrey;border-style: solid;">
                        <div style="width: 30%;background: grey;float: left;height: 100%;background-color: rgba(255,255,255,0);"><i class="icon ion-ios-contact" style="color: #478cf4;font-size: 64px;margin: -18px;margin-left: -28px;"></i></div>
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;"><?php echo $_SESSION['username'] ?></label><label id="groupLabel" style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;"><?php echo $_SESSION['type'];?></label></div>
                    </div>
                </li>
<li> <a href="Abmeldungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Meine Meldungen</a><?php if(strpos($_SESSION['username'], '♚') !== false){?><a href="LeaderAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Rückmeldungen</a><?php }?> <a href="Probenplan.php"  class="activeTab" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Probenplan</a>  <a href="EditProfile.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Profil bearbeiten</a>
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
    font-family: 'Fugaz One', cursive !important; margin-right: 50px;">JSO-Planer</a><i onclick="openIV();" class="fas fa-user" style="transform: scale(1.8);margin-right: 5px;position: fixed;top: 15px;right: 50px;" id="toolTip1" style="transform: scale(2); transform-origin: 0; position: fixed; top: 20px; right: 50px; cursor: pointer;"></i></div></div>
                </div>
            </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;box-shadow: none !important;">
            <div id="contentPage" class="col" style="padding: 0;">
                <iframe id="frame" src="plan-printer.php" width="100%" height="100%" style="border: none; margin-top: -30px;"></iframe>
            </div>
        </div>
    </div>





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
    iMode = false;
    function openIV(btn) {
        if(!iMode) {
            swal({
                title:'Zur personalisierten Ansicht wechseln?',
                text: 'In der personalisierten Ansicht werden dir nur für dich zukünftig relevante Proben aufgelistet.',
                buttons: {
                        cancel: 'Abbrechen',
                        confirm: 'Personalisierte Ansicht',
                }
            }).then( function(isConfirm) { 
                if (isConfirm) {
                    document.getElementById('frame').src = 'plan-printer.php?iv=true&type=' + document.getElementById("groupLabel").innerHTML;
                    iMode = true;
                }
            });
        }
        else
        {
            swal({
                title:'Zur vollständigen Ansicht wechseln?',
                text: 'In der vollständigen Ansicht wird der komplette Probenplan angezeigt.',
                buttons: {
                        cancel: 'Abbrechen',
                        confirm: 'Vollständige Ansicht'
                }
            }).then( function(isConfirm) { 
                if (isConfirm) {
                    document.getElementById('frame').src = 'plan-printer.php';
                    iMode = false;
                }
            });
        }
    }

    </script>

    <script>
    tippy('#toolTip1', {
        allowHTML: true,
        content: "Wechsle hier zur personalisierten Ansicht",
        arrow:'true'
    });
    </script>

    <?php include "assets/php/checkForAlerts.php";?>
</body>

</html>
