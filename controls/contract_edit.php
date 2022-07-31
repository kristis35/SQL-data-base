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

// nustatome privalomus laukus
$required = array('nr', 'sutarties_data', 'nuomos_data_laikas', 'planuojama_grazinimo_data_laikas', 'pradine_rida', 'kaina', 'degalu_kiekis_paimant', 'busena', 'fk_klientas', 'fk_darbuotojas', 'fk_automobilis', 'fk_grazinimo_vieta', 'fk_paemimo_vieta', 'kiekis');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'nr' => 'positivenumber',
		'sutarties_data' => 'date',
		'nuomos_data_laikas' => 'datetime',
		'planuojama_grazinimo_data_laikas' => 'datetime',
		'faktine_grazinimo_data_laikas' => 'datetime',
		'pradine_rida' => 'int',
		'galine_rida' => 'int',
		'kaina' => 'int',
		'degalu_kiekis_paimant' => 'int',
		'dagalu_kiekis_grazinus' => 'int',
		'busena' => 'positivenumber',
		'fk_klientas' => 'alfanum',
		'fk_darbuotojas' => 'alfanum',
		'fk_automobilis' => 'positivenumber',
		'fk_grazinimo_vieta' => 'positivenumber',
		'fk_paemimo_vieta' => 'positivenumber',
		'kiekis' => 'int');
		
	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// atnaujiname sutartį
		$contractsObj->updateContract($_POST);

		// pašaliname nebereikalingas paslaugas ir įrašome naujas
		// gauname esamas paslaugas
		$servicesFromDb = $contractsObj->getOrderedServices($id);

		// jeigu paslaugos kainos nerandame iš formos gautame masyve, šaliname
		foreach($servicesFromDb as $serviceDb) {
			$found = false;
			if(isset($_POST['paslauga'])) {
				foreach($_POST['paslauga'] as $keyForm => $serviceForm) {
					// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}:{$price['galioja_nuo']}:{$price['kaina']}
					$tmp = explode("#", $serviceForm);
					
					$serviceId = $tmp[0];
					$priceFrom = $tmp[1];
					$price = $tmp[2];
					
					if($serviceDb['fk_paslauga'] == $serviceId && $serviceDb['fk_kaina_galioja_nuo'] == $priceFrom && $serviceDb['kiekis'] == $_POST['kiekis'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// šalinama paslaugos kaina
				$contractsObj->deleteOrderedService($id, $serviceDb['fk_paslauga'], $serviceDb['fk_kaina_galioja_nuo'], $serviceDb['kaina']);
			}
		}
		
		if(isset($_POST['paslauga'])) {
			foreach($_POST['paslauga'] as $keyForm => $serviceForm) {
				// jeigu užsakytos paslaugos nerandame duomenų bazėje, tačiau ji yra formoje, įrašome

				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}:{$price['galioja_nuo']}:{$price['kaina']}
				$tmp = explode("#", $serviceForm);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];

				$found = false;
				foreach($servicesFromDb as $serviceDb) {
					if($serviceDb['fk_paslauga'] == $serviceId && $serviceDb['fk_kaina_galioja_nuo'] == $priceFrom && $serviceDb['kiekis'] == $_POST['kiekis'][$keyForm]) {
						$found = true;
					}
				}

				if(!$found) {
					// įrašoma paslaugos kaina
					$contractsObj->insertOrderedService($id, $serviceId, $priceFrom, $price, $_POST['kiekis'][$keyForm]);
				}
			}
		}

		// nukreipiame vartotoją į sutarčių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} 
} else {
	//  išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $contractsObj->getContract($id);
	$data['uzsakytos_paslaugos'] = $contractsObj->getOrderedServices($id);

	// į užsakytų paslaugų masyvo pradžią įtraukiame tuščią reikšmę, kad užsakytų paslaugų formoje
	// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
	// kiekį paslaugų
	array_unshift($data['uzsakytos_paslaugos'], array());
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include 'templates/contract_form.tpl.php';

?>