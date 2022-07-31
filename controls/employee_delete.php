<?php

include 'libraries/employees.class.php';
$employeeObj = new employees();

if(!empty($id)) {
	// patikriname, ar šalinamas modelis nenaudojamas, t.y. nepriskirtas jokiam automobiliui
	$count = $employeeObj->getCarCountOfModel($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// pašaliname modelį
		$employeeObj->deleteModel($id);
	} else {
		// nepašalinome, nes modelis priskirtas bent vienam automobiliui, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į modelių puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>