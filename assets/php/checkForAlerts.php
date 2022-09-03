<?php 

#Weil CUTTED.txt hier nicht funktioniert können die PopUps leider nicht aufgereiht werden :(

if (isset($_SESSION["alerts"][0])){
$alert = $_SESSION["alerts"][0];

print("

<script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>

<script>
swal.fire(               
{
    title:'$alert[0]',
    icon: '$alert[2]',
    text: '$alert[1]',
    showConfirmButton: true
}
);
</script>
");
###

$_SESSION["alerts"] = null;
$_SESSION["alerts"] = array();
}


print("
<script>
setInterval(function(){
    if (!navigator.onLine) {
        alert('Achtung: Du bist offline! Bitte stelle wieder eine stabile Internetverbindung her, um die App benutzen zu können.')
      }
}, 1000);
</script>

");

?>