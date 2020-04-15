<?php
//(c) 2016 Building Bitcoin Websites, Kyle Honeycutt
//This is a direct exerpt from Chapter 7 of the book pages 71-72

$url = "https://www.bitstamp.net/api/ticker/";
$fgc = file_get_contents($url);
$json = json_decode($fgc, TRUE);
$lastPrice = $json["last"];
$highPrice = $json["high"];
$lowPrice = $json["low"];

//calc 24 hr change
$openPrice = $json["open"];
if($openPrice < $lastPrice)
{
	$operator = "+";
	$change = $lastPrice - $openPrice;
	$percent = $change / $openPrice;
	$percent = $percent * 100;
	$percentChange = $operator.number_format($percent, 1);
	$color = "green";
}
if($openPrice > $lastPrice)
{
	$operator = "-";
	$change = $openPrice - $lastPrice;
	$percent = $change / $openPrice;
	$percent = $percent * 100;
	$percentChange = $operator.number_format($percent, 1);
	$color = "red";
}
$date = date("m/d/Y - h:i:sa");

?>

<!DOCTYPE html>
<html>
<head>
<title>My BTC Widget</title>
<style>
body{
    font-family: "Arial", sans-serif;
}    
#container{
	width: 275px;
	height: 90px;
	overflow: hidden;
	background-color: #2f2f2f;
	border: 1px solid #000;
	border-radius: 5px;
	color: #fefdfb;
}
#lastPrice{
	font-size: 24px;
	font-weight: bold;
}
#dateTime{
	font-size: 9px;
	color: #999;
}
</style>
</head>
<body>
<div id="container">
<table width="100%">
<tr>
	<td rowspan="3" width="60%" id="lastPrice">
	$<?php echo number_format($lastPrice, 2); ?>
	</td>
	<td align="right" style="color: <?php echo $color; ?>;">
	<?php echo number_format($percentChange, 2); ?>%
	</td>
</tr>
	<td align="right" style="color: white">
	H: <?php echo number_format($highPrice, 2); ?>
	</td>
<tr>
	<td align="right">
	L: <?php echo number_format($lowPrice, 2); ?>
	</td>
</tr>
<tr>
	<td align="right" colspan="2" id="dateTime">
	<?php echo $date; ?>
	</td>
</tr>
</table>
</div>
</body>
</html>

$url_coindesk = "https://api.coindesk.com/v1/bpi/currentprice.json";
$fgc_coindesk = file_get_contents($url_coindesk);
 
//echo json_decode(file_get_contents($url_coindesk))->bpi->USD->rate;
//echo json_decode(file_get_contents($url))->bpi->USD->rate;
$price_USD = json_decode($fgc_coindesk)->bpi->USD->rate;
$symbol_USD = json_decode($fgc_coindesk)->bpi->USD->symbol;
//echo $symbol_USD."".$price_USD;
$price_GBP = json_decode($fgc_coindesk)->bpi->GBP->rate;
$symbol_GBP = json_decode($fgc_coindesk)->bpi->GBP->symbol;
//echo $symbol_GBP."".$price_GBP;
$price_EUR = json_decode($fgc_coindesk)->bpi->EUR->rate;
$symbol_EUR = json_decode($fgc_coindesk)->bpi->EUR->symbol;
//echo $symbol_EUR."".$price_EUR;

$url = "https://www.bitstamp.net/api/ticker/";
$fgc = file_get_contents($url);
$json = json_decode($fgc, TRUE);
$lastPrice = $json["last"];
$highPrice = $json["high"];
$lowPrice = $json["low"];

//calc 24 hr change
$openPrice = $json["open"];
if($openPrice < $lastPrice)
{
	$operator = "+";
	$change = $lastPrice - $openPrice;
	$percent = $change / $openPrice;
	$percent = $percent * 100;
	$percentChange = $operator.number_format($percent, 1);
	$color = "green";
}
if($openPrice > $lastPrice)
{
	$operator = "-";
	$change = $openPrice - $lastPrice;
	$percent = $change / $openPrice;
	$percent = $percent * 100;
	$percentChange = $operator.number_format($percent, 1);
	$color = "red";
}
$date = date("m/d/Y - h:i:sa");

 <div class="container">
   
	<div class="header">
		<h2>Bitcoin Wallet</h2>
	</div>

	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<!-- logged in user information -->
		<div class="profile_info">
			<img src="images/user_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>
					<!--<?php echo serialize($_SESSION['user']['user_type']);?> -->

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>
		<div id="container">
			<table width="100%">
				<tr>
					<td rowspan="3" width="60%" id="lastPrice" style="color: white;">
					$<?php echo number_format($lastPrice, 2); ?>
					</td>
					<td align="right" style="color: <?php echo $color; ?>;">
					<?php echo number_format($percentChange, 2); ?>%
					</td>
					</tr>
					<td align="right" style="color: white;">
					H: <?php echo number_format($highPrice, 2); ?>
					</td>
					<tr>
					<td align="right" style="color: white;">
					L: <?php echo number_format($lowPrice, 2); ?>
					</td>
					</tr>
					<tr>
					<td align="right" colspan="2" id="dateTime">
					<?php echo $date; ?>
					</td>
				</tr>
			</table>
		</div>
	<div class="col-lg-12">
		<div class="col-lg-4">
			<div class="card text-white bg-secondary mb-3" >
		  		<div class="card-body">
		    		<h5 class="card-title">Price in Dollars</h5>
		    		<p class="card-text"><?php echo $symbol_USD."".$price_USD; ?></p>
		  		</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card text-white bg-secondary mb-3" >
		  		<div class="card-body">
		    		<h5 class="card-title">Price in Pounds</h5>
		    		<p class="card-text"><?php echo $symbol_GBP."".$price_GBP; ?></p>
		  		</div>
			</div>
		</div>
		<div class="col-lg-4">
			<form method = "post" action = "index.php">
				<input type = "text" name = "email">
				<input type = "text" name = "password">
				<input type = "submit" name = "submit" value = "submit">
		
			</form> 
		</div>
	</div>
		<!--
			<div class="card text-white bg-secondary mb-3" >
		  		<div class="card-body">
		    		<h5 class="card-title">Price in Euros</h5>
		    		<p class="card-text"><?php echo $symbol_EUR."".$price_EUR; ?></p>
		  		</div>
			</div>
-->
		
	</div>
</div>