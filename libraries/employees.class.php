<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */

class employees {
	
	private $sutartys_lentele = '';
	private $dalinimo_vietos_lentele = '';
	
	public function __construct() {
		$this->sutartys_lentele = 'sutartys';
		$this->dalinimo_vietos_lentele = 'saskaitos';
	}
	
	/**
	 * Modelio išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getDalinimo($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM `{$this->dalinimo_vietos_lentele}`
					WHERE `nr`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Modelių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getDalinimoList($limit = null, $offset = null) {
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
		
		$query = "  SELECT `{$this->dalinimo_vietos_lentele}`.`nr`,
						   `{$this->dalinimo_vietos_lentele}`.`data`,
						   `{$this->dalinimo_vietos_lentele}`.`suma`,
						   `{$this->sutartys_lentele}`.`nr` AS `fk_Sutartisnr`
					FROM `{$this->dalinimo_vietos_lentele}`
						LEFT JOIN `{$this->sutartys_lentele}`
							ON `{$this->dalinimo_vietos_lentele}`.`fk_Sutartisnr`=`{$this->sutartys_lentele}`.`nr`{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}


	public function getContractList1() {
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
		
		
		$query = "  SELECT `{$this->dalinimo_vietos_lentele}`.`nr`,
						   `{$this->dalinimo_vietos_lentele}`.`data`,
						   `{$this->dalinimo_vietos_lentele}`.`suma`,
						   `{$this->dalinimo_vietos_lentele}`.`fk_Sutartisnr`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Modelių kiekio radimas
	 * @return type
	 */
	public function getModelListCount() {
		$query = "  SELECT COUNT(`{$this->dalinimo_vietos_lentele}`.`nr`) as `kiekis`
					FROM `{$this->dalinimo_vietos_lentele}`
						LEFT JOIN `{$this->sutartys_lentele}`
							ON `{$this->dalinimo_vietos_lentele}`.`fk_Sutartisnr`=`{$this->sutartys_lentele}`.`nr`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Modelių išrinkimas pagal markę
	 * @param type $brandId
	 * @return type
	 */
	public function getModelListByBrand($brandId) {
		$brandId = mysql::escapeFieldForSQL($brandId);

		$query = "  SELECT *
					FROM `{$this->dalinimo_vietos_lentele}`
					WHERE `fk_Sutartisnr `='{$brandId}'";
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Modelio atnaujinimas
	 * @param type $data
	 */
	public function updateModel($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		
		$query = "  UPDATE `{$this->dalinimo_vietos_lentele}`
					SET    `data`='{$data['data']}',
						   `suma`='{$data['suma']}',
						   `fk_Sutartisnr`='{$data['fk_Sutartisnr']}'
					WHERE `nr`='{$data['nr']}'";
		mysql::query($query);
	}
	
	public function lastID()
	{
		$query = "SELECT nr FROM {$this->dalinimo_vietos_lentele} ORDER BY nr DESC LIMIT 1";
		mysql::query($query);
		$data = mysql::select($query);
		if(!empty($data))
		{
			return $data[0]['nr'];
		}
		return 0;

	}

	public function getList() {
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
					FROM {$this->sutartys_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Modelio įrašymas
	 * @param type $data
	 */
	public function insertModel($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		$id = $this->lastID()+50;
		$query = "  INSERT INTO `{$this->dalinimo_vietos_lentele}`
								(
									`fk_Sutartisnr`,
									`data`,
									`suma`,
									`nr`
								)
								VALUES
								(
									'{$data['fk_Sutartisnr']}',
									'{$data['data']}',
									'{$data['suma']}',
									'{$id}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Modelio šalinimas
	 * @param type $id
	 */
	public function deleteModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->dalinimo_vietos_lentele}`
					WHERE `nr`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Nurodyto modelio automobilių kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getCarCountOfModel($id) {
		$query = "  SELECT COUNT(`nr`) as `kiekis`
					FROM {$this->dalinimo_vietos_lentele}";
		$data = mysql::select($query);

		return $data[0]['kiekis'];
	}
	
	
}