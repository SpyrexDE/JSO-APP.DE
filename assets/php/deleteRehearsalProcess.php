<?php session_start();
    if(!isset($_POST["id"])){header('location: ../../AdminTermine.php'); return;}



    //Anti MySQL-Injection
    $id = intval($_POST["id"]);
    $id = strval($id);

    include('database.php');
    

        //Delete ehearsal
        $database -> query("DELETE FROM rehearsals WHERE `id`='$id' ") or die ("Fehler beim löschen der Probe: ".mysqli_error($database));


        //Delete Promises including their notes

        //Lade Nutzer
        $result = $database -> query("select * from users")
        or die("Fehler beim durchsuchen der Datenbank: ".mysqli_error($database));

        $users = array();
        while($r = mysqli_fetch_assoc($result)) {
            $users[] = $r;
        }
        
        

        for($i = 0; $i < count($users); ++$i){
            $username = $users[$i]["username"];

            $promises = $database -> query("select promises from users where username = '$username'") or die ("Fehler: ".mysqli_error($database));
            $promises = mysqli_fetch_array($promises)[0];
            $without = preg_replace("#\((.*?)\)#","",$promises);

            if(in_array("!".$id, explode("|", $without))){

                $search = "|!".$id;
                //Remove notes
                foreach(explode("|", $promises) as $key=>$value){
                    if(strpos($value, "!".$id) !== false){
                        $search = "|".$value;
                    }
                }
                
                $promises = str_replace($search, "|".$id, $promises);
                $database -> query("UPDATE users SET promises='$promises' WHERE username='$username'");
            }
        }





        $find = "|".$id;
        $database -> query("UPDATE users SET promises = REPLACE(promises,'$find','')") or die ("Fehler beim löschen der Probe: ".mysqli_error($database));



        $_SESSION["alerts"] = array();
        array_push($_SESSION["alerts"], array("Erfolg!", "Der Termin wurde erfolgreich gelöscht!", "success"));
        header("location: ../../AdminTermine.php");

?>