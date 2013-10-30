<?php

include("Fxbtc.class.php");

$fxbtc = new Fxbtc("username", "password");
$ticker = $fxbtc->ticker(); 
var_dump($ticker);
?>
