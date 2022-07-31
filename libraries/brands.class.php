<?php
/**
 * Automobilių markių redagavimo klasė
 *
 * @author ISK
 */

class brands {
	
	private $miestoID = '';
	private $pavadinimas = '';
	
	public function __construct() {
		$this->miestoID = 'miestai';
		$this->pavadinimas = 'pavadinimas';
		$this->dalinimo_vietos_lentele = 'dalinimo_vietos';
	}
	
	/**
	 * Markės išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getBrand($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM {$this->miestoID}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}

	public function getContractCountOfCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->miestoID}`.`id`) AS `kiekis`
					FROM `{$this->miestoID}`
						INNER JOIN `{$this->dalinimo_vietos_lentele}`
							ON `{$this->dalinimo_vietos_lentele}`.`id`=`{$this->sutartys_lentele}`.`fk_Miestasid`
					WHERE `{$this->miestoID}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Markių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getBrandList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}

		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT *
					FROM {$this->miestoID}{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Markių kiekio radimas
	 * @return type
	 */
	public function getBrandListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM {$this->miestoID}";
		$data = mysql::select($query);
		
		// 
		return $data[0]['kiekis'];
	}

	
	
	public function lastID()
	{
		$query = "SELECT id FROM {$this->miestoID} ORDER BY id DESC LIMIT 1";
		mysql::query($query);
		$data = mysql::select($query);
		if(!empty($data))
		{
			return $data[0]['id'];
		}
		return 0;

	}
	/**
	 * Markės įrašymas
	 * @param type $data
	 */
	public function insertBrand($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		$id = $this->lastID()+1;
		$query = "  INSERT INTO {$this->miestoID}
								(
									`id`,
									`pavadinimas`
								)
								VALUES
								(
									'{$id}',
									'{$data['pavadinimas']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Markės atnaujinimas
	 * @param type $data
	 */
	public function updateBrand($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE {$this->miestoID}
					SET    `pavadinimas`='{$data['pavadinimas']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Markės šalinimas
	 * @param type $id
	 */
	public function deleteBrand($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM {$this->miestoID}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	

	
}