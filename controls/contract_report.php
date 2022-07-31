<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

$formErrors = null;
$fields = array();

$data = array();
if(empty($_POST['submit'])) {
	// rodome ataskaitos parametrų įvedimo formą
	include 'templates/contract_report_form.tpl.php';
} else {
	// nustatome laukų validatorių tipus
	$validations = array (
		'kainaNuo' => 'int',
		'kainaIki' => 'int'
	);

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations);

	if($validator->validate($_POST)) {
		// išrenkame ataskaitos duomenis
		$contractData = $contractsObj->getCustomerContracts($_POST['kainaNuo'], $_POST['kainaIki']);
		$totalPrice = $contractsObj->getSumPriceOfContracts($_POST['kainaNuo'], $_POST['kainaIki']);
		$totalServicePrice = $contractsObj->getSumPriceOfOrderedServices($_POST['kainaNuo'], $_POST['kainaIki']);
		
		// perduodame datos filtro reikšmes į šabloną
		$data['kainaNuo'] = $_POST['kainaNuo'];
		$data['kainaIki'] = $_POST['kainaIki'];
		
		// rodome ataskaitą
		include 'templates/contract_report_show.tpl.php';
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;

		// rodome ataskaitos parametrų įvedimo formą su klaidomis
		include 'templates/contract_report_form.tpl.php';
	}
}