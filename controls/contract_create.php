<?php
	
include 'libraries/contracts.class.php';
$contractsObj = new contracts();

include 'libraries/services.class.php';
$servicesObj = new services();

include 'libraries/cars.class.php';
$carsObj = new cars();

include 'libraries/employees.class.php';
$employeesObj = new employees();

include 'libraries/customers.class.php';
$customersObj = new customers();

$formErrors = null;
$data = array();
$data['uzsakytos_paslaugos'] = array();

// nustatome privalomus laukus
$required = array('nr', 'sutarties_data', 'nuomos_data_laikas', 'planuojama_grazinimo_data', 'faktine_grazinimo_data', 'kaina', 'faktine_grazinimo_data', 'fk_Klientasnr', 'fk_Dalinimo_vietaid', 'fk_Mantijanr');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'nr' => 'positivenumber',
		'sutarties_data' => 'date',
		'nuomos_data_laikas' => 'date',
		'planuojama_grazinimo_data' => 'date',
		'faktine_grazinimo_data' => 'date',
		'kaina' => 'int',
		'fk_Klientasnr' => 'positivenumber',
		'fk_Dalinimo_vietaid' => 'positivenumber',
		'fk_Mantijanr' => 'positivenumber',
	);
	
	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// patikriname, ar nėra sutarčių su tokiu pačiu numeriu
		$kiekis = $contractsObj->checkIfContractNrExists($_POST['nr']);

		if($kiekis > 0) {
			// sudarome klaidų pranešimą
			$formErrors = "Sutartis su įvestu numeriu jau egzistuoja.";
			// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
			$data = $_POST;
		} else {
			// įrašome naują sutartį
			$contractsObj->insertContract($_POST);

			// įrašome užsakytas paslaugas
			foreach($_POST['paslauga'] as $keyForm => $serviceForm) {

				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}#{$price['kaina']}
				$tmp = explode("#", $serviceForm);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];

				$contractsObj->insertOrderedService($_POST['nr'], $serviceId, $priceFrom, $price, $_POST['kiekis'][$keyForm]);
			}
		}

		// nukreipiame vartotoją į sutarčių puslapį
		if($formErrors == null) {
			common::redirect("index.php?module={$module}&action=list");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;

		$data['uzsakytos_paslaugos'] = array();
		if(isset($_POST['paslauga'])) {
			$i = 0;
			foreach($_POST['paslauga'] as $key => $val) {
				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}#{$price['kaina']}
				$tmp = explode("#", $val);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];
				
				$data['uzsakytos_paslaugos'][$i]['fk_paslauga'] = $serviceId;
				$data['uzsakytos_paslaugos'][$i]['fk_kaina_galioja_nuo'] = $priceFrom;
				$data['uzsakytos_paslaugos'][$i]['kaina'] = $price;
				$data['uzsakytos_paslaugos'][$i]['kiekis'] = $_POST['kiekis'][$key];

				$i++;
			}
		}
	}
}

// į užsakytų paslaugų masyvo pradžią įtraukiame tuščią reikšmę, kad užsakytų paslaugų formoje
// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
// kiekį paslaugų
array_unshift($data['uzsakytos_paslaugos'], array());

// įtraukiame šabloną
include 'templates/contract_form.tpl.php';

?>