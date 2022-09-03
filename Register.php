<?php 
if(!isset($_SESSION)){
    session_start();
}
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

<body style="width: 100%;height: 100%; margin-top: 0!important;">
    <div class="login-clean" style="width: 100%;/*padding-bottom: 20vh;*/padding-top: 5vh;height: 100%;min-height: 440px;">
        <form accept-charset="UTF-8" method="post" action="assets/php/registerProcess.php">
            <input type="hidden" id="type" name="type" value="">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-contact" style="color: rgb(71,140,244);"></i></div>
            <div class="form-group"><input class="form-control" type="text" id="username" name="username" placeholder="Nutzername" style="font-family: Roboto, sans-serif;" required="" minlength="3" maxlength="20"></div>
            <div class="form-group"><input class="form-control" type="password" id="password" name="password" placeholder="Passwort" style="font-family: Roboto, sans-serif;" required="" minlength="4" maxlength="20"></div>
            <div class="form-group"><input class="form-control" type="password" id="password" name="password2" placeholder="Passwort wiederholen" style="font-family: Roboto, sans-serif;" required="" minlength="4" maxlength="20"></div>
            <div class="form-group"><input class="form-control" type="text" id="token" name="token" placeholder="JSO-Token" style="font-family: Roboto, sans-serif;" required=""></div><div class="dropdown"><button id="dropD" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="visibility: visible;margin-top: 0;width: 100%;background-color: Orange;">Stimmgruppe</button>
                <div role="menu" class="dropdown-menu pre-scrollable"><a role="presentation" class="dropdown-item" href="#">Flöte</a><a role="presentation" class="dropdown-item" href="#">Oboe</a><a role="presentation" class="dropdown-item" href="#">Klarinette</a><a role="presentation" class="dropdown-item" href="#">Fagott</a>
                    <a
                        role="presentation" class="dropdown-item" href="#">Horn</a><a role="presentation" class="dropdown-item" href="#">Trompete</a><a role="presentation" class="dropdown-item" href="#">Tuba</a><a role="presentation" class="dropdown-item" href="#">Posaune</a><a role="presentation" class="dropdown-item"
                            href="#">Schlagwerk</a><a role="presentation" class="dropdown-item" href="#">Violine 1</a><a role="presentation" class="dropdown-item" href="#">Violine 2</a><a role="presentation" class="dropdown-item" href="#">Bratsche</a><a role="presentation"
                            class="dropdown-item" href="#">Cello</a><a role="presentation" class="dropdown-item" href="#">Kontrabass</a><a role="presentation" class="dropdown-item" href="#">Andere</a></div>
                </div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(71,140,244);font-family: Roboto, sans-serif;">Registrieren</button></div>
            <a href="index.php" style="display: block;text-align: center;font-size: 12px;color: gray;">Bereits registriert? Hier <font color="#5772b4">einloggen</font>!</a>
        </form>
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
    </script>

<?php include "assets/php/checkForAlerts.php";?>
</body>

</html>