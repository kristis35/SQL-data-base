<?php
/**
 * Sutarčių redagavimo klasė
 *
 * @author ISK
 */

class contracts {

	private $sutartys_lentele = '';
	private $darbuotojai_lentele = '';
	private $klientai_lentele = '';
	private $uzsakytos_paslaugos_lentele = '';
	private $dalinimo_lentele = '';
	private $paslaugu_kainos_lentele = '';
	
	public function __construct() {
		$this->sutartys_lentele = 'sutartys' ;
		$this->klientai_lentele = 'klientai' ;
		$this->uzsakytos_paslaugos_lentele = 'uzsakytos_paslaugos';
		$this->dalinimo_lentele = 'dalinimo_vietos';
		$this->paslaugu_kainos_lentele = 'paslaugos_kainos';
	}
	
	/**
	 * Sutarčių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getContractList($limit, $offset) {
		$limit = mysql::escapeFieldForSQL($limit);
		$offset = mysql::escapeFieldForSQL($offset);

		$query = "  SELECT `{$this->sutartys_lentele}`.`nr`,
						   `{$this->sutartys_lentele}`.`sutarties_data`,
						   `{$this->sutartys_lentele}`.`kaina`,
						   `{$this->klientai_lentele}`.`vardas` AS `kliento_vardas`,
						   `{$this->klientai_lentele}`.`pavarde` AS `kliento_pavarde`,
						   `{$this->klientai_lentele}`.`fakultetas` AS `kliento_fakultetas`
					FROM `{$this->sutartys_lentele}`
						LEFT JOIN `{$this->klientai_lentele}`
							ON `{$this->sutartys_lentele}`.`fk_Klientasnr`=`{$this->klientai_lentele}`.`nr`";
		$data = mysql::select($query);
		
		
		return $data;
	}


	public function getContractList1() {
		$query = "  SELECT *
					FROM `{$this->sutartys_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Sutarčių kiekio radimas
	 * @return type
	 */
	public function getContractListCount() {
		$query = "  SELECT COUNT(`nr`) as `kiekis`
					FROM {$this->sutartys_lentele}";
		$data = mysql::select($query);
		
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Sutarties išrinkimas
	 * @param type $nr
	 * @return type
	 */
	public function getContract($nr) {
		$nr = mysql::escapeFieldForSQL($nr);

		$query = "  SELECT `{$this->sutartys_lentele}`.`nr`,
						   `{$this->sutartys_lentele}`.`sutarties_data`,
						   `{$this->sutartys_lentele}`.`nuomos_data_laikas`,
						   `{$this->sutartys_lentele}`.`planuojama_grazinimo_data`,
						   `{$this->sutartys_lentele}`.`faktine_grazinimo_data`,
						   `{$this->sutartys_lentele}`.`kaina`,
						   `{$this->sutartys_lentele}`.`fk_Klientasnr`,
						   `{$this->sutartys_lentele}`.`fk_Dalinimo_vietaid`,
						   `{$this->sutartys_lentele}`.`fk_Mantijanr`,
						   (IFNULL(SUM(`{$this->uzsakytos_paslaugos_lentele}`.`kaina` * `{$this->uzsakytos_paslaugos_lentele}`.`kiekis`), 0) + `{$this->sutartys_lentele}`.`kaina`) AS `bendra_kaina`
					FROM `{$this->sutartys_lentele}`
						LEFT JOIN `{$this->uzsakytos_paslaugos_lentele}`
							ON `{$this->sutartys_lentele}`.`nr`=`{$this->uzsakytos_paslaugos_lentele}`.`fk_Sutartisnr`
					WHERE `{$this->sutartys_lentele}`.`nr`='{$nr}' GROUP BY `{$this->sutartys_lentele}`.`nr`";
		$data = mysql::select($query);

		//
		return $data[0];
	}
	
	/**
	 * Patikrinama, ar sutartis su nurodytu numeriu egzistuoja
	 * @param type $nr
	 * @return type
	 */
	public function checkIfContractNrExists($nr) {
		$nr = mysql::escapeFieldForSQL($nr);

		$query = "  SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->sutartys_lentele}`
					WHERE `{$this->sutartys_lentele}`.`nr`='{$nr}'";
		$data = mysql::select($query);

		//
		return $data[0]['kiekis'];
	}

	/**
	 * Užsakytų papildomų paslaugų sąrašo išrinkimas
	 * @param type $orderId
	 * @return type
	 */
	public function getOrderedServices($orderId) {
		$orderId = mysql::escapeFieldForSQL($orderId);

		$query = "  SELECT *
					FROM `{$this->uzsakytos_paslaugos_lentele}`
					WHERE `fk_Sutartisnr`='{$orderId}'";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Sutarties atnaujinimas
	 * @param type $data
	 */
	public function updateContract($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE `{$this->sutartys_lentele}`
					SET    `sutarties_data`='{$data['sutarties_data']}',
						   `nuomos_data_laikas`='{$data['nuomos_data_laikas']}',
						   `planuojama_grazinimo_data`='{$data['planuojama_grazinimo_data']}',
						   `faktine_grazinimo_data`='{$data['faktine_grazinimo_data']}',
						   `kaina`='{$data['kaina']}',
						   `fk_Klientasnr`='{$data['fk_Klientasnr']}',
						   `fk_Dalinimo_vietaid`='{$data['fk_Dalinimo_vietaid']}',
						   `fk_Mantijanr`='{$data['fk_Mantijanr']}',
					WHERE `nr`='{$data['nr']}'";
		mysql::query($query);
	}
	public function lastID()
	{
		$query = "SELECT nr FROM {$this->sutartys_lentele} ORDER BY nr DESC LIMIT 1";
		mysql::query($query);
		$data = mysql::select($query);
		if(!empty($data))
		{
			return $data[0]['nr'];
		}
		return 0;

	}
	/**
	 * Sutarties įrašymas
	 * @param type $data
	 */
	public function insertContract($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		$id = $this->lastID()+1;
		$query = "  INSERT INTO `{$this->sutartys_lentele}`
								(
									`nr`,
									`sutarties_data`,
									`nuomos_data_laikas`,
									`planuojama_grazinimo_data`,
									`faktine_grazinimo_data`,
									`kaina`,
									`busena`,
									`fk_Klientasnr`,
									`fk_Dalinimo_vietaid`,
									`fk_Mantijanr`
								)
								VALUES
								(
									'{$id}',
									'{$data['sutarties_data']}',
									'{$data['nuomos_data_laikas']}',
									'{$data['planuojama_grazinimo_data']}',
									'{$data['faktine_grazinimo_data']}',
									'{$data['kaina']}',
									'{$data['fk_Klientasnr']}',
									'{$data['fk_Dalinimo_vietaid']}',
									'{$data['fk_Mantijanr']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Sutarties šalinimas
	 * @param type $id
	 */
	public function deleteContract($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->sutartys_lentele}`
					WHERE `nr`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Visų sutarties užsakytų papildomų paslaugų šalinimas
	 * @param type $contractId
	 */
	public function deleteOrderedServices($contractId) {
		$contractId = mysql::escapeFieldForSQL($contractId);

		$query = "  DELETE FROM `{$this->uzsakytos_paslaugos_lentele}`
					WHERE `fk_Sutartisnr`='{$contractId}'";
		mysql::query($query);
	}
	
	/**
	 * Sutarties užsakytos papildomos paslaugos šalinimas
	 * @param type $contractId
	 */
	public function deleteOrderedService($contractId, $serviceId, $priceFrom, $price) {
		$contractId = mysql::escapeFieldForSQL($contractId);
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		$priceFrom = mysql::escapeFieldForSQL($priceFrom);
		$price = mysql::escapeFieldForSQL($price);

		$query = "  DELETE FROM `{$this->uzsakytos_paslaugos_lentele}`
					WHERE `fk_Sutartisnr`='{$contractId}' AND `fk_Paslaugos_kaina`='{$serviceId}' AND `fk_Paslaugos_kainagalioja_nuo`='{$priceFrom}' AND `kaina`='{$price}'";
		mysql::query($query);
	}

	/**
	 * Užsakytų papildomų paslaugų atnaujinimas
	 * @param type $data
	 */
	public function updateOrderedServices($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$this->deleteOrderedServices($data['nr']);
		
		if(isset($data['paslaugos_kainos']) && sizeof($data['paslaugos_kainos']) > 0) {
			foreach($data['paslaugos_kainos'] as $key=>$val) {
				
				// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}#{$price['galioja_nuo']}#{$price['kaina']}
				$tmp = explode("#", $val);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];
				
				$query = "  INSERT INTO `{$this->uzsakytos_paslaugos_lentele}`
										(
											`kiekis`,
											`kaina`
											`fk_Sutartisnr`,
											`fk_Paslaugos_kaina`
											`fk_Paslaugos_kainagalioja_nuo`
										)
										VALUES
										(
											'{$data['nr']}',
											'{$priceFrom}',
											'{$serviceId}',
											'{$data['kiekiai'][$key]}',
											'{$price}'
										)";
					mysql::query($query);
			}
		}
	}
	
	/**
	 * Užsakytos papildomos paslaugos įrašymas
	 * @param type $data
	 */
	public function insertOrderedService($contractId, $serviceId, $priceFrom, $price, $amount) {
		$contractId = mysql::escapeFieldForSQL($contractId);
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		$priceFrom = mysql::escapeFieldForSQL($priceFrom);
		$price = mysql::escapeFieldForSQL($price);
		$amount = mysql::escapeFieldForSQL($amount);

		if(isset($data['paslaugos_kainos']) && sizeof($data['paslaugos_kainos']) > 0) {
			foreach($data['paslaugos_kainos'] as $key=>$val) {
				$tmp = explode(":", $val);
				$serviceId = $tmp[0];
				$price = $tmp[1];
				$date_from = $tmp[2];
				$query = "  INSERT INTO `{$this->uzsakytos_paslaugos_lentele}`
										(
											`kiekis`,
											`kaina`
											`fk_Sutartisnr`,
											`fk_Paslaugos_kaina`
											`fk_Paslaugos_kainagalioja_nuo`
										)
										VALUES
										(
											'{$contractId}',
											'{$priceFrom}',
											'{$serviceId}',
											'{$amount}',
											'{$price}'
										)";
				mysql::query($query);
			}
		}
	}


	/**
	 * Sutarties būsenų sąrašo išrinkimas
	 * @return type
	 */
	public function getContractStates() {
		$query = "  SELECT *
					FROM `{$this->sutarties_busenos_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Aikštelių sąrašo išrinkimas
	 * @return type
	 */
	public function getParkingLots() {
		$query = "  SELECT *
					FROM `{$this->aiksteles_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Paslaugos kainų įtraukimo į užsakymus kiekio radimas
	 * @param type $serviceId
	 * @param type $validFrom
	 * @return type
	 */
	public function getPricesCountOfOrderedServices($serviceId, $validFrom) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		$validFrom = mysql::escapeFieldForSQL($validFrom);
		
		$query = "  SELECT COUNT(`{$this->uzsakytos_paslaugos_lentele}`.`fk_Paslaugos_kaina`) AS `kiekis`
					FROM `{$this->paslaugu_kainos_lentele}`
						INNER JOIN `{$this->uzsakytos_paslaugos_lentele}`
							ON `{$this->paslaugu_kainos_lentele}`.`fk_Paslaugaid`=`{$this->uzsakytos_paslaugos_lentele}`.`fk_Paslaugos_kaina` AND `{$this->paslaugu_kainos_lentele}`.`galioja_nuo`=`{$this->uzsakytos_paslaugos_lentele}`.`fk_Paslaugos_kainagalioja_nuo`
					WHERE `{$this->paslaugu_kainos_lentele}`.`fk_Paslaugaid`='{$serviceId}' AND `{$this->paslaugu_kainos_lentele}`.`galioja_nuo`='{$validFrom}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}

	public function getCustomerContracts($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`kaina`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`kaina`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`kaina`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT  `{$this->sutartys_lentele}`.`nr`,
							`{$this->sutartys_lentele}`.`sutarties_data`,
							`{$this->klientai_lentele}`.`nr`,
							`{$this->klientai_lentele}`.`vardas`,
						    `{$this->klientai_lentele}`.`pavarde`,
						    `{$this->sutartys_lentele}`.`kaina` as `sutarties_kaina`,
						    IFNULL(sum(`{$this->uzsakytos_paslaugos_lentele}`.`kiekis` * `{$this->uzsakytos_paslaugos_lentele}`.`kaina`), 0) as `sutarties_paslaugu_kaina`,
						    `t`.`bendra_kliento_sutarciu_kaina`,
						    `s`.`bendra_kliento_paslaugu_kaina`
					FROM `{$this->sutartys_lentele}`
						INNER JOIN `{$this->klientai_lentele}`
							ON `{$this->sutartys_lentele}`.`fk_Klientasnr`=`{$this->klientai_lentele}`.`nr`
						LEFT JOIN `{$this->uzsakytos_paslaugos_lentele}`
							ON `{$this->sutartys_lentele}`.`nr`=`{$this->uzsakytos_paslaugos_lentele}`.`fk_Sutartisnr`
						INNER JOIN (
							SELECT `{$this->sutartys_lentele}`.`nr`,
									sum(`{$this->sutartys_lentele}`.`kaina`) AS `bendra_kliento_sutarciu_kaina`
							FROM `{$this->sutartys_lentele}`
								INNER JOIN `{$this->klientai_lentele}`
									ON `{$this->sutartys_lentele}`.`fk_Klientasnr`=`{$this->klientai_lentele}`.`nr`
							{$whereClauseString}
							GROUP BY `nr`
						) `t` ON `t`.`nr`=`{$this->klientai_lentele}`.`nr`
						INNER JOIN (
							SELECT `{$this->sutartys_lentele}`.`nr`,
									IFNULL(sum(`{$this->uzsakytos_paslaugos_lentele}`.`kiekis` * `{$this->uzsakytos_paslaugos_lentele}`.`kaina`), 0) as `bendra_kliento_paslaugu_kaina`
							FROM `{$this->sutartys_lentele}`
								INNER JOIN `{$this->klientai_lentele}`
									ON `{$this->sutartys_lentele}`.`fk_Klientasnr`=`{$this->klientai_lentele}`.`nr`
								LEFT JOIN `{$this->uzsakytos_paslaugos_lentele}`
									ON `{$this->sutartys_lentele}`.`nr`=`{$this->uzsakytos_paslaugos_lentele}`.`fk_Sutartisnr`
								{$whereClauseString}							
								GROUP BY `nr`
						) `s` ON `s`.`nr`=`{$this->klientai_lentele}`.`nr`
					{$whereClauseString}
					GROUP BY `{$this->sutartys_lentele}`.`nr` ORDER BY `{$this->klientai_lentele}`.`pavarde` ASC";
		$data = mysql::select($query);

		//
		return $data;
	}
	
	public function getSumPriceOfContracts($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`kaina`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`kaina`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`kaina`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT sum(`{$this->sutartys_lentele}`.`kaina`) AS `nuomos_suma`
					FROM `{$this->sutartys_lentele}`
					{$whereClauseString}";
		$data = mysql::select($query);

		//
		return $data;
	}

	public function getSumPriceOfOrderedServices($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`kaina`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`kaina`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->sutartys_lentele}`.`kaina`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT sum(`{$this->uzsakytos_paslaugos_lentele}`.`kiekis` * `{$this->uzsakytos_paslaugos_lentele}`.`kaina`) AS `paslaugu_suma`
					FROM `{$this->sutartys_lentele}`
						INNER JOIN `{$this->uzsakytos_paslaugos_lentele}`
							ON `{$this->sutartys_lentele}`.`nr`=`{$this->uzsakytos_paslaugos_lentele}`.`fk_Sutartisnr`
					{$whereClauseString}";
		$data = mysql::select($query);

		//
		return $data;
	}
	
	public function getDelayedCars($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);

		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " AND `{$this->sutartys_lentele}`.`sutarties_data`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`sutarties_data`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->sutartys_lentele}`.`sutarties_data`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT `nr`,
						   `sutarties_data`,
						   `planuojama_grazinimo_data`,
						   IF(`faktine_grazinimo_data`='0000-00-00 00:00:00', 'negrąžinta', `faktine_grazinimo_data`) AS `grazinta`,
						   `{$this->klientai_lentele}`.`vardas`,
						   `{$this->klientai_lentele}`.`pavarde`
					FROM `{$this->sutartys_lentele}`
						INNER JOIN `{$this->klientai_lentele}`
							ON `{$this->sutartys_lentele}`.`fk_Klientasnr`=`{$this->klientai_lentele}`.`nr`
					WHERE (DATEDIFF(`faktine_grazinimo_data`, `planuojama_grazinimo_data`) >= 1 OR
						(`faktine_grazinimo_data` = '0000-00-00 00:00:00' AND DATEDIFF(NOW(), `planuojama_grazinimo_data`) >= 1))
					{$whereClauseString}";
		$data = mysql::select($query);

		//
		return $data;
	}
	
}