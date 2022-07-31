<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */

class models {
	
	private $sutartys_lentele = '';
	private $miestai_lentele = '';
	private $dalinimo_vietos_lentele = '';
	
	public function __construct() {
		$this->sutartys_lentele = 'sutartys';
		$this->miestai_lentele = 'miestai';
		$this->dalinimo_vietos_lentele = 'dalinimo_vietos';
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
					WHERE `id`='{$id}'";
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
		
		$query = "  SELECT `{$this->dalinimo_vietos_lentele}`.`id`,
						   `{$this->dalinimo_vietos_lentele}`.`kabineto_nr`,
						   `{$this->dalinimo_vietos_lentele}`.`adresas`,
						    `{$this->miestai_lentele}`.`pavadinimas` AS `miestai`
					FROM `{$this->dalinimo_vietos_lentele}`
						LEFT JOIN `{$this->miestai_lentele}`
							ON `{$this->dalinimo_vietos_lentele}`.`fk_Miestasid`=`{$this->miestai_lentele}`.`id`{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * Modelių kiekio radimas
	 * @return type
	 */
	public function getModelListCount() {
		$query = "  SELECT COUNT(`{$this->dalinimo_vietos_lentele}`.`id`) as `kiekis`
					FROM `{$this->dalinimo_vietos_lentele}`
						LEFT JOIN `{$this->miestai_lentele}`
							ON `{$this->dalinimo_vietos_lentele}`.`fk_Miestasid`=`{$this->miestai_lentele}`.`id`";
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
					WHERE `fk_Miestasid`='{$brandId}'";
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
					SET    `kabineto_nr`='{$data['kabineto_nr']}',
						   `adresas`='{$data['adresas']}',
						   `fk_Miestasid`='{$data['fk_Miestasid']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	public function lastID()
	{
		$query = "SELECT id FROM {$this->dalinimo_vietos_lentele} ORDER BY id DESC LIMIT 1";
		mysql::query($query);
		$data = mysql::select($query);
		if(!empty($data))
		{
			return $data[0]['id'];
		}
		return 0;

	}

	/**
	 * Modelio įrašymas
	 * @param type $data
	 */
	public function insertModel($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		$id = $this->lastID()+1;
		$query = "  INSERT INTO `{$this->dalinimo_vietos_lentele}`
								(
									`adresas`,
									`kabineto_nr`,
									`id`,
									`fk_Miestasid`
								)
								VALUES
								(
									'{$data['adresas']}',
									'{$data['kabineto_nr']}',
									'{$id}',
									'{$data['fk_Miestasid']}'
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
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Nurodyto modelio automobilių kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getCarCountOfModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->dalinimo_vietos_lentele}`
						INNER JOIN `{$this->sutartys_lentele}`
							ON `{$this->dalinimo_vietos_lentele}`.`id`=`{$this->sutartys_lentele}`.`fk_Dalinimo_vietaid`
					WHERE `{$this->dalinimo_vietos_lentele}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	
}