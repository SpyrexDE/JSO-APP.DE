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
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css"/>
</head>

<body style="width: 100%;height: 0;min-height: 600px;">
    <div id="wrapper">
        <div class="shadow-lg topBar" id="sidebar-wrapper" style="background-color: #ffffff;">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" style="background-color: #478cf4;height: 67px;">
                    <div class="text-secondary" style="width: 100%;height: 100%;overflow: hidden;background-color: #ffffff;border-width: 0;border-bottom: 0;border-color: lightgrey;border-style: solid;">
                        <div style="width: 30%;background: grey;float: left;height: 100%;background-color: rgba(255,255,255,0);"><i class="icon ion-ios-contact" style="color: #478cf4;font-size: 64px;margin: -18px;margin-left: -28px;"></i></div>
                        <div class="text-nowrap" style="width: 70%;background: green;overflow: hidden;height: 100%;background-color: rgba(255,255,255,0);"><label style="margin: 0;width: 100%;height: 50%;float: left;margin-left: -10px;margin-top: -7px;"><?php echo $_SESSION['username'] ?></label><label style="margin: 0;width: 100%;height: 50%;float: left;margin-top: -12px;margin-left: -10px;"><?php echo $_SESSION['type'];?></label></div>
                    </div>
                </li>
                <li> <a href="Abmeldungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Meine Meldungen</a><?php if(strpos($_SESSION['username'], '♚') !== false){?><a href="LeaderAbsagungen.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Rückmeldungen</a><?php }?><a href="Probenplan.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Probenplan</a><a class="activeTab" href="EditProfile.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Profil bearbeiten</a>
                    <a
                        href="assets/php/logoutProcess.php" style="color: rgb(0,0,0);font-family: Roboto, sans-serif;">Logout</a>
                </li>
            </ul>
        </div>
        <div class="shadow-sm page-content-wrapper" style="width: 100%;background-color: #ffffff;padding-bottom: 0px;">
            <div class="col topBar"><a class="btn btn-link float-left" role="button" id="menu-toggle" href="#menu-toggle" style="font-size: 37px; margin-top: 9px;"><i class="fa fa-bars"></i></a>
                <div class="float-none text-center">
                    <div style="padding: 4px; white-space: pre;display: block;padding: 9.5px;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;word-break: break-all;word-wrap: break-word;overflow: hidden;"> <a class="navbar-brand float-none" href="#" style="color: #478cf4 !important;
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
            <div id="contentPage" class="col" style="padding: 0;">
                <div class="float-none text-center">
                    <div style="white-space: pre;display: block;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;word-break: break-all;word-wrap: break-word;overflow: hidden;margin-left: 15%;margin-right: 15%;margin-bottom: 0;"><a class="float-none" href="#" style="color: #525861;font-size: 31px;padding-top: 0;font-family: Roboto, sans-serif;font-weight: 1000;padding-bottom: 0px;margin-right: 0;">Profil bearbeiten</a><i id="toolTip1"class="fa fa-exclamation-circle" style="transform: scale(2); transform-origin: 0; position: absolute;"></i>
                        <form accept-charset="UTF-8" method="post" action="assets/php/editProfileProcess.php"><input class="form-control" type="text" id="username" name="username" placeholder="Nutzername" style="font-family: Roboto, sans-serif;margin-bottom: 15px;"  minlength="3" maxlength="20"><input class="form-control" type="password"
                                id="password" name="password" placeholder="Passwort" style="font-family: Roboto, sans-serif;margin-bottom: 15px;"  minlength="4" maxlength="20"><input class="form-control" type="password" id="password" name="password2"
                                placeholder="Passwort wiederholen" style="font-family: Roboto, sans-serif;margin-bottom: 15px;"  minlength="4" maxlength="20"><div class="dropdown"><button id="dropD" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="visibility: visible;margin-top: 0;width: 100%;background-color: Orange;">Stimmgruppe</button>
                                    <div role="menu" class="dropdown-menu pre-scrollable"><a role="presentation" class="dropdown-item" href="#">Flöte</a><a role="presentation" class="dropdown-item" href="#">Oboe</a><a role="presentation" class="dropdown-item" href="#">Klarinette</a><a role="presentation" class="dropdown-item" href="#">Fagott</a><a
                                                role="presentation" class="dropdown-item" href="#">Horn</a><a role="presentation" class="dropdown-item" href="#">Trompete</a><a role="presentation" class="dropdown-item" href="#">Tuba</a><a role="presentation" class="dropdown-item" href="#">Posaune</a><a role="presentation" class="dropdown-item"
                                                href="#">Schlagwerk</a><a role="presentation" class="dropdown-item" href="#">Violine 1</a><a role="presentation" class="dropdown-item" href="#">Violine 2</a><a role="presentation" class="dropdown-item" href="#">Bratsche</a><a role="presentation"
                                                class="dropdown-item" href="#">Cello</a><a role="presentation" class="dropdown-item" href="#">Kontrabass</a><a role="presentation" class="dropdown-item" href="#">Andere</a></div><div class="form-check custom-control custom-checkbox mb-3 zoomed" style="    position: absolute; left: 50%; margin-left: -100px;"><input class="form-check-input custom-control-input" type="checkbox" id="Kleingruppe" name="smallGroup" <?php if(strpos($_SESSION['type'], "*")){ print"checked";}?>><label class="form-check-label custom-control-label" for="Kleingruppe">Kleingruppe</label><i id="toolTip2"class="fa fa-question-circle" style="margin: 4px;"></i></div>
                                                
                                                <input type="hidden" id="groupLeaderPW" name="groupLeaderPW">
                                                <div class="form-check custom-control custom-checkbox mb-3 zoomed" style="    position: absolute; left: 50%; margin-left: -100px;"><input class="form-check-input custom-control-input" type="checkbox" id="Stimmführer" name="groupLeader" <?php if(strpos($_SESSION['username'], "♚")){ print"checked";}?>><label class="form-check-label custom-control-label" for="Stimmführer">Stimmführer</label></div>
                                    </div>
                            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(71,140,244);font-family: Roboto, sans-serif;">Speichern</button></div><input type="hidden" id="type" name="type"></form>
                        <button onclick="deleteAcc()" class="btn btn-primary btn-block" style="background-color: rgb(226, 38, 38);font-family: Roboto, sans-serif;" value="Account Löschen">Account löschen</Button>
                        <form accept-charset="UTF-8" action="assets\php\deleteAcc.php" id="form" style="display: none;">
                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                            <script>
                            function deleteAcc(){
                                swal({
                                    title:"Account Löschen",
                                    text: "Willst du deinen Account wirklich löschen?\n Wir können keine Daten wiederherstellen!",
                                    buttons: {
                                            cancel: "Abbrechen",
                                            confirm: "Löschen"
                                    },
                                    dangerMode: true
                                }).then( function(isConfirm) { 
                                    if (isConfirm) {
                                        $("#form").submit();
                                    }
                                    });
                                }
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>

    <script>
        $(".dropdown-item").click(function () {
            var text = $(event.target).text();
            $("#dropD").html(text);
            $("#type").val(text);
        });
        $("#Stimmführer").click(function() {
            if($("#Stimmführer").is(":checked")){
                var password = prompt("Stimmführerpasswort angeben:", "");
                if (password === null) {
                    return false;
                }
                $("#groupLeaderPW").val(password);
                $.ajax({
                    type: "POST",
                    url: "assets/php/leaderPwCheck.php",
                    data:
                        {
                            input: password
                        },
                    success : function(text)
                    {
                        if(text=="true"){
                            $("#Stimmführer").prop("checked", true);
                        }else{
                            alert("Ungültiges passwort!");
                        }
                    }
                });
                return false;
            }
        });
    </script>

    <!-- Development -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    <!-- Production -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script>
    tippy('#toolTip1', {
        content: 'Es müssen nur die Felder ausgefüllt werden, die auch bearbeitet werden sollen.',
        arrow:'true',
    	trigger:'click'
    });
    tippy('#toolTip2', {
        content: 'Markiere diese Checkbox, wenn du zur Kleingruppe gehörst. Personen die zur Kleingruppe gehören, bekommen auch die Proben angezeigt, bei denen für Stücke mit geringer Besetzung geprobt wird.',
        arrow:'true',
    	trigger:'click'
    });
    </script>

<?php include "assets/php/checkForAlerts.php";?>
</body>

</html>
