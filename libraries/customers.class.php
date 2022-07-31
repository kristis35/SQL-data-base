<?php
/**
 * Klientų redagavimo klasė
 *
 * @author ISK
 */

class customers {
	
	private $klientai_lentele = '';
	private $sutartys_lentele = '';
	
	public function __construct() {
		$this->klientai_lentele = 'klientai';
		$this->sutartys_lentele = 'sutartys';
	}
	
	/**
	 * Kliento išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM `{$this->klientai_lentele}`
					WHERE `nr`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Klientų sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCustomersList($limit = null, $offset = null) {
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
		
		$query = "  SELECT *
					FROM `{$this->klientai_lentele}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Klientų kiekio radimas
	 * @return type
	 */
	public function getCustomersListCount() {
		$query = "  SELECT COUNT(`nr`) as `kiekis`
					FROM `{$this->klientai_lentele}`";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
	/**
	 * Kliento šalinimas
	 * @param type $id
	 */
	public function deleteCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->klientai_lentele}`
					WHERE `nr`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Kliento atnaujinimas
	 * @param type $data
	 */
	public function updateCustomer($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE `{$this->klientai_lentele}`
					SET    `vardas`='{$data['vardas']}',
						   `pavarde`='{$data['pavarde']}',
						   `fakultetas`='{$data['fakultetas']}',
						   `tel_nr`='{$data['tel_nr']}'
					WHERE `nr`='{$data['nr']}'";
		mysql::query($query);
	}
	
	public function lastID()
	{
		$query = "SELECT nr FROM {$this->klientai_lentele} ORDER BY nr DESC LIMIT 1";
		mysql::query($query);
		$data = mysql::select($query);
		if(!empty($data))
		{
			return $data[0]['nr'];
		}
		return 0;

	}

	/**
	 * Kliento įrašymas
	 * @param type $data
	 */
	public function insertCustomer($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		$id = $this->lastID()+1;
		$query = "  INSERT INTO `{$this->klientai_lentele}`
								(
									`nr`,
									`vardas`,
									`pavarde`,
									`fakultetas`,
									`tel_nr`
								) 
								VALUES
								(
									'{$data['nr']}',
									'{$data['vardas']}',
									'{$data['pavarde']}',
									'{$data['fakultetas']}',
									'{$data['tel_nr']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas klientas, kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->klientai_lentele}`
						INNER JOIN `{$this->sutartys_lentele}`
							ON `{$this->klientai_lentele}`.`nr`=`{$this->sutartys_lentele}`.`fk_Klientasnr`
					WHERE `{$this->klientai_lentele}`.`nr`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['kiekis'];
	}
	
}