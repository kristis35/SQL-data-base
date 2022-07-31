<?php

include 'libraries/brands.class.php';
$brandsObj = new brands();

if(!empty($id)) {

	$count = $brandsObj->getContractCountOfCar($id);
	$removeErrorParameter = '';
	

	if($count == 0) {
		// šaliname automobilį
		$brandsObj->deleteBrand($id);
	} else {
		// nepašalinome, nes automobilis įtrauktas bent į vieną sutartį, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į markių puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>