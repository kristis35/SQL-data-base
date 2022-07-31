<?php

// sukuriame modelių klasės objektą
include 'libraries/models.class.php';
$modelsObj = new models();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $modelsObj->getModelListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $modelsObj->getDalinimoList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/dalinimo_list.tpl.php';
	
?>