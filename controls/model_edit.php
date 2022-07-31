<?php

include 'libraries/brands.class.php';
$brandsObj = new brands();

include 'libraries/models.class.php';
$modelsObj = new models();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('kabineto_nr','adresas','fk_Miestasid');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'kabineto_nr' => 3,
	'pavadinimas' => 20,
	'fk_Miestasid' => 10
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'kabineto_nr' => 'positivenumber',
		'adresas' => 'anything',
		'fk_Miestasid' => 'positivenumber',);

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// atnaujiname duomenis
		$modelsObj->updateModel($_POST);

		// nukreipiame į modelių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $modelsObj->getDalinimo($id);
}

// įtraukiame šabloną
include 'templates/dalinimo_form.tpl.php';

?>