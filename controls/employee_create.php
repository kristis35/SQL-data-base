<?php

include 'libraries/brands.class.php';
$brandsObj = new brands();

include 'libraries/employees.class.php';
$employeeObj = new employees();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('data','suma','fk_Sutartisnr');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'suma' => 20,
	'fk_Sutartisnr' => 10
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'suma' => 'positivenumber',
		'data' => 'date',
		'fk_Sutartisnr' => 'positivenumber');

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// atnaujiname duomenis
		$employeeObj->insertModel($_POST);

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
	if(!empty($id)) {
		$data = $employeeObj->getDalinimo($id);
	}
}

// įtraukiame šabloną
include 'templates/employee_form.tpl.php';

?>