<?php
	
include 'libraries/customers.class.php';
$customersObj = new customers();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('nr', 'vardas', 'pavarde', 'fakultetas', 'tel_nr');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'vardas' => 10,
	'pavarde' => 10,
	'fakultetas' => 3,
	'tel_nr' => 10
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'nr' => 'positivenumber',
		'vardas' => 'anything',
		'pavarde' => 'anything',
		'fakultetas' => 'anything',
		'tel_nr' => 'anything'
	);

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// redaguojame klientą
		$customersObj->insertCustomer($_POST);

		// nukreipiame vartotoją į klientų puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	}
	else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
}

// įtraukiame šabloną
include 'templates/customer_form.tpl.php';

?>