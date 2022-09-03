<?php
include "globals.php";

$input = $_POST["input"];

if ($input == $global_leaderPW){
    echo "true";
}else{
    echo "false";
}
?>