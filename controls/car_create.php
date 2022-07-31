<?php

include 'libraries/cars.class.php';
$carsObj = new cars();


$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('aukstoji_mokykla', 'dydis', 'galvos_dydis');


// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'dydis' => 'anything',
		'aukstoji_mokykla' => 'anything',
		'galvos_dydis' => 'anything'
		);

	// sukuriame laukų validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		$data = $_POST;

		// įrašome naują įrašą
		$carsObj->insertCar($data);

		// nukreipiame vartotoją į automobilių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	if(!empty($id)) {
		// išrenkame automobilį
		$data = $carsObj->getCar($id);
	}
}

// įtraukiame šabloną
include 'templates/mantija_form.tpl.php';

?>