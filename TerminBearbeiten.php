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

<body style="width: 100%;height: 0;min-height: 600px;">
    <div id="wrapper">
        <div class="shadow-lg topBar" id="sidebar-wrapper" style="background-color: #ffffff;">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" style="background-color: #478cf4;height: 67px;">
                    <div class="text-secondary" style="width: 100%;height: 100%;overflow: hidden;background-color: #ffffff;border-width: 0;border-bottom: 0;border-color: lightgrey;border-style: solid;">
                        <div style="width: 30%;background: grey;float: left;height: 100%;background-color: rgba(255,255,255,0);"><i class="icon ion-ios-contact" style="color: #478cf4;font-size: 64px;margin: -18px;margin-left: -28px;"></i></div>
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;">Martin</label><label style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;">Dirigent</label></div>
                    </div>
                </li>
                <li> <a class="activeTab" href="AdminTermine.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Termine</a><a href="AdminAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Rückmeldungen</a><a href="assets/php/logoutProcess.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Logout</a></li>
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
    font-family: 'Fugaz One', cursive !important; margin-right: 50px;">JSO-Planer</a></div>
                </div>
            </div>
        </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;box-shadow: none !important;">
            <div class="col" style="padding: 0;">
                <div class="float-none text-center">


                    <?php 
                    include "assets/php/database.php";

                    //Lade ProbenDaten
                    $id = $_GET['id'];
                    $result = $database -> query("select * from rehearsals where id='$id'")
                    or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));

                    $rows = array();
                    while($r = mysqli_fetch_assoc($result)) {
                    $rows[] = $r;
                    }

                    $data = $rows[0];
                    $groups = $data["groups"];

                    if(strpos($groups, "*")){
                        $smallGroup = true;
                        $groups = str_replace("*", "", $groups);
                    } else{
                        $smallGroup = false;
                    }


                    $groups = json_decode($groups, true);

                    ?>

                    <div id="contentPageSmall" style="white-space: pre;display: block;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;word-break: break-all;word-wrap: break-word;overflow: hidden;margin-left: 15%;margin-right: 15%;margin-bottom: 0;"><a class="float-none" href="#" style="color: #525861;font-size: 31px;padding-top: 0;font-family: Roboto, sans-serif;font-weight: 1000;padding-bottom: 0px;margin-right: 0;">Termin bearbeiten</a>
                        <form accept-charset="UTF-8" method="post" action="assets\php\editRehearsalProcess.php"><input value="<?php print_r($data['date']);?>"  class="form-control" type="text" id="username" name="date" placeholder="Datum" style="font-family: Roboto, sans-serif;" required="" minlength="3" maxlength="50"><input value="<?php print($data['time']);?>" class="form-control" type="text" id="time" name="time"
                                placeholder="Uhrzeit" style="font-family: Roboto, sans-serif;margin-top: 3%;" required="" minlength="3" maxlength="50"><input value="<?php print($data['location']);?>" class="form-control" type="text" id="location" name="location" placeholder="Ort" style="font-family: Roboto, sans-serif;margin-top: 3%;"
                                required="" minlength="3" maxlength="50"><p class="float-none" href="#" style="color: rgba(82,88,97,0.74);font-size: 27px;padding-top: 0;font-family: Roboto, sans-serif;font-weight: 1000;padding-bottom: 0;margin-right: 0;margin-top: 40px;">Stimmgruppen</p><div class="dropdown"><button id="dropD" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="visibility: visible;margin-top: 0;width: 100%;color: black; background-color: <?php if (isset($data['color'])) { print $data['color'];}else{print 'white';}?>;">Farbenauswahl</button><div role="menu" class="dropdown-menu pre-scrollable"><a role="presentation" class="dropdown-item" href="#" id="white"></a><a role="presentation" class="dropdown-item" href="#" id="red"></a><a role="presentation" class="dropdown-item" href="#" id="blue"></a><a role="presentation" class="dropdown-item" href="#" id="yellow"></a><a role="presentation" class="dropdown-item" href="#" id="green"></a></div>
                                <div class="form-check custom-control custom-checkbox mb-3 zoomed"><input class="form-check-input custom-control-input" type="checkbox" id="Kleingruppe" name="smallGroup" <?php if($smallGroup){ print"checked";}?>><label class="form-check-label custom-control-label" for="Kleingruppe">Kleingruppe</label></div> <br> <div class="form-check custom-control custom-checkbox mb-3 zoomed"><input class="form-check-input custom-control-input" type="checkbox" id="Konzertreise" name="Konzertreise"><label class="form-check-label custom-control-label <?php if (isset($groups['Konzertreise'])) { print 'checked'; }?>" for="Konzertreise">Konzertreise</label></div><div class="form-check custom-control custom-checkbox mb-3 zoomed"><input class="form-check-input custom-control-input" type="checkbox" id="Konzert" name="Konzert"><label class="form-check-label custom-control-label <?php if (isset($groups['Konzert'])) { print 'checked'; }?>" for="Konzert">Konzert</label></div><div class="form-check custom-control custom-checkbox mb-3 zoomed"><input class="form-check-input custom-control-input" type="checkbox" id="Generalprobe" name="Generalprobe"><label class="form-check-label custom-control-label <?php if (isset($groups['Generalprobe'])) { print 'checked'; }?>" for="Generalprobe">Generalprobe</label></div><div class="form-check custom-control custom-checkbox mb-3 zoomed"><input class="form-check-input custom-control-input" type="checkbox" id="Stimmprobe" name="Stimmprobe"><label class="form-check-label custom-control-label <?php if (isset($groups['Stimmprobe'])) { print 'checked'; }?>" for="Stimmprobe">Stimmprobe</label></div><br>
                                <div
                        class="form-check custom-control custom-checkbox mb-3 zoomed" style="margin-top: -35px;font-weight: 500;"><input name="Tutti" class="form-check-input custom-control-input" type="checkbox" id="Tutti"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Tutti'])) { print 'checked'; }?>" id="TuttiLabel" for="Tutti">Tutti</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" type="checkbox" id="Streicher" name="Streicher"  ><label id="StreicherLabel" class="form-check-label custom-control-label <?php if (isset($groups['Streicher'])) { print 'checked'; }?>" for="Streicher">Streicher</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckStr"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Vio1" name="Violine 1" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Violine_1'])) { print 'checked'; }?>" for="Vio1">Violine 1</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckStr"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Vio2" name="Violine 2" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Violine_2'])) { print 'checked'; }?>" for="Vio2">Violine 2</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckStr"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Br" name="Bratsche" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Bratsche'])) { print 'checked'; }?>" for="Br">Bratsche</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckStr"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Clo" name="Cello" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Cello'])) { print 'checked'; }?>" for="Clo">Cello</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckStr"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Kontrabass" name="Kontrabass" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Kontrabass'])) { print 'checked'; }?>" for="Kontrabass">Kontrabass</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" type="checkbox" id="Bläser" name="Bläser"   ><label class="form-check-label custom-control-label <?php if (isset($groups['Bläser'])) { print 'checked'; }?>" id ="BläserLabel" for="Bläser">Bläser</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input subCheckBl" type="checkbox"  name="Blechbläser" id="BBläser"   ><label class="form-check-label custom-control-label <?php if (isset($groups['Blechbläser'])) { print 'checked'; }?>" id= BBläserLabel for="BBläser">Blechbläser</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckBBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Tro" name="Trompete" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Trompete'])) { print 'checked'; }?>" for="Tro">Trompete</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckBBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Po" name="Posaune" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Posaune'])) { print 'checked'; }?>" for="Po">Posaune</label></div>
                <div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckBBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Ho" name="Horn" type="checkbox"     ><label class="form-check-label custom-control-label <?php if (isset($groups['Horn'])) { print 'checked'; }?>" for="Ho">Horn</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckBBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Tu" name="Tuba" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Tuba'])) { print 'checked'; }?>" for="Tu">Tuba</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck subCheck subCheckBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" type="checkbox" id="HBläser" name="Holzbläser"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Holzbläser'])) { print 'checked'; }?>" id = "HBläserLabel" for="HBläser">Holzbläser</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckHBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Fl" name="Flöte" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Flöte'])) { print 'checked'; }?>" for="Fl">Flöte</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckHBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Ob" name="Oboe" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Oboe'])) { print 'checked'; }?>" for="Ob">Oboe</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckHBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Kl" name="Klarinette" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Klarinette'])) { print 'checked'; }?>" for="Kl">Klarinette</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck doubleSubCheck subCheckBl subCheckHBl"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" id="Fa" name="Fagott" type="checkbox"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Fagott'])) { print 'checked'; }?>" for="Fa">Fagott</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck"
                    style="margin-top: -35px;"><input class="form-check-input custom-control-input" type="checkbox" id="Schlagwerk"   name="Schlagwerk"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Schlagwerk'])) { print 'checked'; }?>" id="Schlagwerk" for="Schlagwerk">Schlagwerk</label></div>
				<div class="form-check custom-control custom-checkbox mb-3 zoomed allCheck"
					style="margin-top: -35px;"><input class="form-check-input custom-control-input" type="checkbox" id="Andere" name="Andere"  ><label class="form-check-label custom-control-label <?php if (isset($groups['Andere'])) { print 'checked'; }?>" for="Andere">Andere</label></div>               
                <div
                    class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(71,140,244);font-family: Roboto, sans-serif;">Speichern</button></div>
            
                    <input type="hidden" name="id" value="<?php print($_GET['id']);?>">

                    <input type="hidden" name="selectedColor" id="selectedColor">
                </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    
    <script src="assets/js/jquery.min.js"></script>

    <script>



        $(".dropdown-item").click(function(e) {

        $("#selectedColor").val($(e.target).css("background-color"));

        $("#dropD").css("background-color", $(e.target).css("background-color"));

        }); 





        //LoadChecks
        $(document).ready(function() {
            $(".checked").click();
        });

        //DisabledCheck
        $(".custom-control-label, .custom-control-input").click(function (event) { //Funktioniert leider NICHT
        if(event.target.disabled){
            event.preventDefault();
            event.stopImmediatePropagation();
            event.stopPropagation();
        }
        });



        //Tutti
        $("#TuttiLabel").click(function () {
        $('.allCheck').find('input[type="checkbox"]').prop('checked', !$('#Tutti').prop('checked'));
        if($('#Tutti').prop('checked')){
            $('.allCheck').find('input[type="checkbox"]').prop('disabled', false);
        } else{
            $('.allCheck').find('input[type="checkbox"]').prop('disabled', true);
        }
        });
        //Streicher
        $("#StreicherLabel").click(function () {
        $('.subCheckStr').find('input[type="checkbox"]').prop('checked', !$('#Streicher').prop('checked'));
        if($('#Streicher').prop('checked')){
            $('.subCheckStr').find('input[type="checkbox"]').prop('disabled', false);
        } else{
            $('.subCheckStr').find('input[type="checkbox"]').prop('disabled', true);
        }
        });
        //Bläser
        $("#BläserLabel").click(function () {
        $('.subCheckBl').find('input[type="checkbox"]').prop('checked', !$('#Bläser').prop('checked'));
        if($('#Bläser').prop('checked')){
            $('.subCheckBl').find('input[type="checkbox"]').prop('disabled', false);
        } else{
            $('.subCheckBl').find('input[type="checkbox"]').prop('disabled', true);
        }
        });
        //Blechbläser
        $("#BBläserLabel").click(function () {
        $('.subCheckBBl').find('input[type="checkbox"]').prop('checked', !$('#BBläser').prop('checked'));
        if($('#BBläser').prop('checked')){
            $('.subCheckBBl').find('input[type="checkbox"]').prop('disabled', false);
        } else{
            $('.subCheckBBl').find('input[type="checkbox"]').prop('disabled', true);
        }
        });
        //Holzbläser
        $("#HBläserLabel").click(function () {
        $('.subCheckHBl').find('input[type="checkbox"]').prop('checked', !$('#HBläser').prop('checked'));
        if($('#HBläser').prop('checked')){
            $('.subCheckHBl').find('input[type="checkbox"]').prop('disabled', false);
        } else{
            $('.subCheckHBl').find('input[type="checkbox"]').prop('disabled', true);
        }
        });

    </script><br>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <?php include "assets/php/checkForAlerts.php";?>
</body>

</html>