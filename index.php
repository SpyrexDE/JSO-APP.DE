<html style="width: 100%;height: 100%;">

<?php
session_start();
if(isset($_SESSION["type"])){
	if($_SESSION["type"] == "Dirigent"){
		header("location: AdminAbsagungen.php");
		exit;
	} else{
		header("location: Abmeldungen.php");
		exit;
	}
}
?>
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
    <div class="login-clean" style="width: 100%;padding-bottom: 20vh;padding-top: 5vh;height: 100%;min-height: 440px;">
        <form accept-charset="UTF-8" method="post" action="assets/php/loginProcess.php">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><img src="assets/img/Logo.png" style="transform: scale(0.85);transform-origin: 0 0;"/></div>
            <div class="form-group"><input class="form-control" type="text" id="username" name="username" placeholder="Nutzername" style="font-family: Roboto, sans-serif;" required="" minlength="2" maxlength="20"></div>
            <div class="form-group"><input class="form-control" type="password" id="password" name="password" placeholder="Passwort" style="font-family: Roboto, sans-serif;" required="" minlength="4" maxlength="20"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(71,140,244);font-family: Roboto, sans-serif;">Einloggen</button></div><a href="Register.php" style="display: block;text-align: center;font-size: 12px;color: gray;">Noch keinen Account? Hier <font color="#5772b4">registrieren</font>!</a></form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>


<script>

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

window.addEventListener('load', (event) => {
  if(getCookie("username") != null && getCookie("password") != null)
  {
    document.getElementById("username").value = getCookie("username");
    document.getElementById("password").value = getCookie("password");
    document.getElementById("loginBtn").click();
  }
});

</script>

<?php include "assets/php/checkForAlerts.php";?>
</body>

</html>
