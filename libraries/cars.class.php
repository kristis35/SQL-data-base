<?php
/**
 * Automobilių redagavimo klasė
 *
 * @author ISK
 */

class cars {

	private $mantijos_lentele = '';
	private $sutartys_lentele = '';
	private $dydis_tipai_lentele = '';
	private $galvos_dydis_tipai_lentele = '';
	
	public function __construct() {
		$this->mantijos_lentele = 'mantijos';
		$this->sutartys_lentele = 'sutartys';
		$this->dydis_tipai_lentele = 'mantiju_dydziai';
		$this->galvos_dydis_tipai_lentele = 'kepures_dydziai';		
	}
	
	/**
	 * Automobilio išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT `{$this->mantijos_lentele}`.`nr`,
						   `{$this->mantijos_lentele}`.`aukstoji_mokykla`,
						   `{$this->dydis_tipai_lentele}`.`name` AS `dydis`,
						   `{$this->mantijos_lentele}`.`galvos_dydis`
					FROM `{$this->mantijos_lentele}`
						LEFT JOIN `{$this->dydis_tipai_lentele}`
							ON `{$this->mantijos_lentele}`.`dydis`=`{$this->dydis_tipai_lentele}`.`id`";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Automobilio atnaujinimas
	 * @param type $data
	 */
	public function updateCar($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE `{$this->mantijos_lentele}`
					SET    `aukstoji_mokykla`='{$data['aukstoji_mokykla']}',
						   `dydis`='{$data['dydis']}',
						   `galvos_dydis`='{$data['galvos_dydis']}'
					WHERE `nr`='{$data['nr']}'";
		mysql::query($query);
	}

	public function lastID()
	{
		$query = "SELECT nr FROM {$this->mantijos_lentele} ORDER BY nr DESC LIMIT 1";
		mysql::query($query);
		$data = mysql::select($query);
		if(!empty($data))
		{
			return $data[0]['nr'];
		}
		return 0;

	}
	/**
	 * Automobilio įrašymas
	 * @param type $data
	 */
	public function insertCar($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		$id = $this->lastID()+1;
		$query = "  INSERT INTO `{$this->mantijos_lentele}` 
								(
									`nr`,
									`aukstoji_mokykla`,
									`dydis`,
									`galvos_dydis`
								) 
								VALUES
								(
									'{$id}',
									'{$data['aukstoji_mokykla']}',
									'{$data['dydis']}',
									'{$data['galvos_dydis']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Automobilių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCarList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}
		
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		
		$query = "  SELECT `{$this->mantijos_lentele}`.`nr`,
						   `{$this->mantijos_lentele}`.`aukstoji_mokykla`,
						   `{$this->dydis_tipai_lentele}`.`name` AS `dydis`,
						   `{$this->mantijos_lentele}`.`galvos_dydis`
					FROM `{$this->mantijos_lentele}`
						LEFT JOIN `{$this->dydis_tipai_lentele}`
							ON `{$this->mantijos_lentele}`.`dydis`=`{$this->dydis_tipai_lentele}`.`id`{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Automobilių kiekio radimas
	 * @return type
	 */
	public function getCarListCount() {
		$query = "  SELECT COUNT(`nr`) as `kiekis`
					FROM {$this->mantijos_lentele}";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Automobilio šalinimas
	 * @param type $id
	 */
	public function deleteCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->mantijos_lentele}`
					WHERE `nr`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Sutačių, į kurias įtrauktas automobilis, kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->mantijos_lentele}`
						INNER JOIN `{$this->sutartys_lentele}`
							ON `{$this->mantijos_lentele}`.`nr`=`{$this->sutartys_lentele}`.`fk_Mantijanr`
					WHERE `{$this->mantijos_lentele}`.`nr`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Pavarų dėžių sąrašo išrinkimas
	 * @return type
	 */
	public function getGearboxList() {
		$query = "  SELECT *
					FROM `{$this->dydis_tipai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Degalų tipo sąrašo išrinkimas
	 * @return type
	 */
	public function getFuelTypeList() {
		$query = "  SELECT *
					FROM `{$this->galvos_dydis_tipai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}


	
}