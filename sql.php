<?php
include 'database_connection.php';


$url_coindesk = "https://api.coindesk.com/v1/bpi/currentprice.json";
$fgc_coindesk = file_get_contents($url_coindesk);
 
//echo json_decode(file_get_contents($url_coindesk))->bpi->USD->rate;
//echo json_decode(file_get_contents($url))->bpi->USD->rate;
$price_USD = json_decode($fgc_coindesk)->bpi->USD->rate;
$symbol_USD = json_decode($fgc_coindesk)->bpi->USD->symbol;
echo $symbol_USD."".$price_USD;
$price_GBP = json_decode($fgc_coindesk)->bpi->GBP->rate;
$symbol_GBP = json_decode($fgc_coindesk)->bpi->GBP->symbol;
echo $symbol_GBP."".$price_GBP;
$price_EUR = json_decode($fgc_coindesk)->bpi->EUR->rate;
$symbol_EUR = json_decode($fgc_coindesk)->bpi->EUR->symbol;
echo $symbol_EUR."".$price_EUR;

?>