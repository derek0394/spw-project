<?php

 $sentences = array(
        array('human', 'coastline', 'many', 'parts', 'of', 'asian', 'lying','on','the','sofa'), 
        array('die', 'run', 'awesome', 'mind', 'blowing', 'keep','on','going', 'rap','music'), 
        array('the' ,'other' ,'guy', 'fast', 'and', 'furious', 'run' ,'for', 'your' ,'life', 'lying','on','the','bed'),
        array('john','comes','to','class', 'huge','black','bird', 'korea','is','a','country', 'movies','and','films'),
        array('the' ,'other' ,'guy', 'fast', 'and', 'furious', 'run' ,'for', 'your' ,'life', 'lying','on','the','bed'),
    );
$number =  rand(1, 600);
$number1 =  rand(1, 600);
$number2 =  rand(1, 600);
$number3 =  rand(1, 600);
    $secret_key =  $sentences[0][rand(0, 9)].$number." ".$sentences[1][rand(0, 9)].$number1." ".$sentences[2][rand(0, 13)].$number2." ".$sentences[3][rand(0, 13)].$number3." ".$sentences[4][rand(0, 13)];
echo $secret_key;


		$options = [
		'cost' =>12
		];
		$password = password_hash($secret_key, PASSWORD_BCRYPT, $options);
    echo $password;
    
?>