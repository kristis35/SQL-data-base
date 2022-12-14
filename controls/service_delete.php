<?php

include 'libraries/services.class.php';
$servicesObj = new services();

if(!empty($id)) {
	// patikriname, ar šalinama paslauga nenaudojama jokioje sutartyje
	$contractCount = $servicesObj->getContractCountOfService($id);

	$removeErrorParameter = '';
	if($contractCount == 0) {
		// pašaliname paslaugos kainas
		$servicesObj->deleteAllServicePrices($id);

		// pašaliname paslaugą
		$servicesObj->deleteService($id);

		echo 'Paslauga pasalinta'
	} else {
		// nepašalinome, nes modelis priskirtas bent vienam automobiliui, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į paslaugų puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}
	
?>