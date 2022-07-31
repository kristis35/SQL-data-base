<?php

// sukuriame automobilių klasės objektą
include 'libraries/cars.class.php';
$carsObj = new cars();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $carsObj->getCarListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio automobilius
$data = $carsObj->getCarList($paging->size, $paging->first);	

// įtraukiame šabloną
include 'templates/mantija_list.tpl.php';

?>