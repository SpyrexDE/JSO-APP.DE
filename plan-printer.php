<center>
<h1>Probenplan</h1>
<h5>Stand: <?php echo date("Y.m.d");?></h5>
</center>
<?php

setlocale(LC_TIME, 'de_DE');


function table( $result , $days) {
    echo '<table>';
    tableHead( $result);
    tableBody( $result , $days);
    echo '</table>';
}

function tableHead( $result ) {
    echo '<thead>';
    echo '<tr>';
    echo '
    
    <th>Tag</th>
    <th>Datum</th>
    <th>Zeit</th>
    <th>Ort</th>
    <th>Stimmen</th>

    ';
    
    echo '</tr>';
    echo '</thead>';
}

function tableBody( $result, $days ) {
    echo '<tbody>';
    $i = 0;
    foreach ( $result as $x ) {
    echo '<tr style="background: ' . $x["color"] . ';">';
    foreach ( $x as $k => $y) {

            if ($k == "date")
            {
                echo '<td>' . $days[$i] . '</td>';
            }

            if ($k == "color" || $k == "id" || $k == "realDate" || $k == "realTime")
                continue;

            if(is_array(json_decode($y, true)))
                $y = implode(", ", array_keys(json_decode($y, true)));

            if(strpos($y, "_"))
                $y = str_replace("_", " ", $y);

            echo '<td>' . $y . '</td>';
        }
        echo '</tr>';
        $i += 1;
    }
    echo '</tbody>';
}

include('assets/php/database.php');

$result = $database -> query("select * from rehearsals")
or die('Fehler beim durchsuchen der Datenbank: '.mysqli_error($database));

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
            $splittedT = preg_split("/[\s,\-]+/", t);
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
        $userType = $_GET["type"];
        if($b == "Konzertreise"){
            return 1;
        } elseif($b == "Konzert" && $a != "Konzertreise"){
            return 1;
        } elseif($b == "Generalprobe" && $a != "Konzert"){
            return 1;
        } elseif ($b == "Stimmprobe" && $a != "Generalprobe" && $a != "Konzert") {
            return 1;
        } elseif($b == $userType && $a != "Stimmprobe" && $a != "Generalprobe" && $a != "Konzert"){
            return 1;
        } elseif(isInGroup($userType, array($b=>0)) && $a != "Stimmprobe" && $a != "Generalprobe" && $a != "Konzert"){
            return 1;
        } else{
            return -1;
        }
     }






     


    if(isset($_GET["iv"]) && isset($_GET["type"]))
    {
        $userType = $_GET["type"];
        
        for($i = 0; $i < count($rows); ++$i){   //Doesn't call all rows!? :(
            //if relevant
            include_once 'assets/php/getPromises.php';
            $groups = json_decode($rows[$i]["groups"]);

            //and date not in past
            $date = strtotime($rows[$i]["realDate"]) + 86400;
            $now = time();
            $actual = true;
            if($date < $now) {
                $actual = false;
            }
            
            if(!isInGroup($userType, $groups) || !$actual)
            {
                unset($rows[$i]);
            }
        }
    }

    


$days = [];

foreach($rows as $d) {
    foreach($d as $k => $y){
        if($k != "date")
            continue;
        array_push($days, strftime("%a", strtotime($y)));
    }
}

table($rows, $days);



print "

<link href='https://fonts.googleapis.com/icon?family=Material+Icons'
      rel='stylesheet'>

<button class='btn' onclick='print();'><i class='material-icons'>print</i></button>


<style>
@media all {
    h1, h5{
        display: none;
    }

    body {
        padding: 0;
        padding-top: 10px;
        -webkit-print-color-adjust:exact;
    }

    table {
        border-spacing: 0;
        margin: auto;
    }

    th {
        text-align: left;
        padding-left: 10px;
    }

    td {
        padding: 0.5em;
        padding-right: 0.8em;
        max-width: 200px;
    }

    button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        color: white;
        background-color: rgb(71,140,244);
        border: none;
        outline: none;
        border-radius: 50%;
        display: block;
        -webkit-box-shadow: 0 6px 10px 0 rgba(0,0,0,0.3);
        box-shadow: 0 6px 10px 0 rgba(0,0,0,0.3);
        height: 5em;
        width: 5em;
        text-align: center;
        cursor: pointer;
        transition: 0.2s
    }

    button:hover{
        transform: scale(1.10)
    }

    button:active{
        transform: scale(0.90)
    }
}
@media print
{
    body{
        zoom: 0.8;
    }
    table {page-break-inside: avoid;}
    button {
        display: none;
    }

    h1, h5{
        display: block;
        margin-bottom: 0.5em;
    }

    h5 {
        color: gray;
        margin-bottom: 5em;
    }
}

@media only screen and (max-width: 600px) {
    table {
        zoom: 0.6;
    }
}

</style>
";