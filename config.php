<?php
	
	require_once $_SERVER["DOCUMENT_ROOT"]. '/vendor/autoload.php';

	$token = "5234372700:AAFOhTGi2G5vSiM8IROc-W4Px7NU7Ut5bLw";
	$bot_name = "@ShepherdKozyBot";
	$gm_id = 316156004;//Morok
	$squadIds = [
		'Луна' 				=> 2144434684,
		'a Nostra' 			=> 1814894885, 
		'Братец Огурец' 	=> 2135985069,
		'Северный ветер'	=> 1560858775, 
		'Капитан Капуста' 	=> 1428613143,
		'Куго' 				=> 433337230,
		'Benihime' 			=> 231806103,
		'Erizo' 			=> 1644383981 ,
		'Antirinka'			=> 793512208,
		'Morok' 			=> 316156004,
	];
	$admins = [
		316156004
	];
/*	$playersIds = [
		'Палыча' => 1180155700,
		'Войса' => 316156004,
	];*/
	$ali_admins = [
		$gm_id, 
		316156004 //Morok
	];
	/*$resources_admins = [
		$gm_id, 
		1180155700, //Palych
		318688492 //lady_eboshi
	];*/
	$quest_admins = [
		$gm_id, 
		793512208, //Antirinka
		231806103 //Бени
	];
	$url = 'https://kozy-bot.herokuapp.com/';
