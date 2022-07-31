<?php

// sukuriame sutarčių klasės objektą
include 'libraries/contracts.class.php';
$contractsObj = new contracts();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $contractsObj->getContractListCount();

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio sutartis
$data = $contractsObj->getContractList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/contract_list.tpl.php';

?>