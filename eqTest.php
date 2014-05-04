<?php

require_once "eos.class.php";
    require_once("db_connection.php");
    require_once("functions.php");
    require_once("session.php");

$test = 3400;

$equation = "(100*x)-50";

$equation = str_replace("x",$test,$equation);

$eq = new eqEOS();
$result = $eq->solveIF($equation);

//echo($result);

$test = getActiveChannels();





    date_default_timezone_set('America/New_York');
    
    $time = time() - 1800;
    
    $now = date("Y-m-d H:i:s",$time);


echo($now);

?>