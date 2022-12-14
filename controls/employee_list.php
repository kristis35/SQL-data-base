<?php

// sukuriame modelių klasės objektą
include 'libraries/employees.class.php';
$employeeObj = new employees();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $employeeObj->getModelListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio modelius
$data = $employeeObj->getDalinimoList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/employee_list.tpl.php';
	
?>