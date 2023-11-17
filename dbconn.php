<?php

$dbsearver ="localhost";
$username ="root";
$passsword ="";
$database ="reg__login";


$conn =mysqli_connect($dbsearver,$username,$passsword,$database);
if($conn){
    echo "sus";
}



?>