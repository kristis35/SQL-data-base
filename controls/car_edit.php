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
		'dydis' => 'alfanum',
		'aukstoji_mokykla' => 'alfanum',
		'galvos_dydis' => 'alfanum'
		);

	// sukuriame laukų validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $_POST;

		

		// atnaujiname duomenis
		$carsObj->updateCar($data);

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
	// išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $carsObj->getCar($id);
}

$data['editing'] = 1;
// įtraukiame šabloną
include 'templates/mantija_form.tpl.php';

?>