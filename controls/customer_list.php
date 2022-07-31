<?php

// sukuriame klientų klasės objektą
include 'libraries/customers.class.php';
$customersObj = new customers();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $customersObj->getCustomersListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio klientus
$data = $customersObj->getCustomersList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/customer_list.tpl.php';

?>