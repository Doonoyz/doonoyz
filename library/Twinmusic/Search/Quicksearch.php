<?php
/**
 * Quicksearch engine
 *
 * @package    Doonoyz
 * @subpackage library/search
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Quicksearch {
	/**
	 * Searched values
	 *
	 * @var string
	 */
	private $_value = "";

	/**
	 * Set the criteria search
	 *
	 * @param string $value Criteria to search
	 */
	public function setCriteria($value) {
		$this->_value = strip_tags ( addslashes ( $value ) );
	}
	
	/**
	 * Get the criteria search
	 *
	 * @return string Criteria searched
	 */
	public function getCriteria() {
		return ($this->_value );
	}

	/**
	 * Compute the result
	 *
	 */
	public function prepareResult() {
		$db = Twindoo_Db::getDb ();
		$this->_value = "%{$this->_value}%";
		$sql = Twinmusic_Search_Engine::ENGINE_SQL . " AND (";
		$sql .= " g.GROUP_NOM LIKE ? OR
				  g.GROUP_URL LIKE ? OR
				  g.GROUP_PAYS LIKE ? OR
				  g.GROUP_LIEU LIKE ? OR
				  g.GROUP_DESCRIPTION LIKE ? OR
				  uig.USER_NAME LIKE ?";
		$sql .= ")";
		$values = Array ($this->_value, $this->_value, $this->_value, $this->_value, $this->_value, $this->_value );
		$res = $db->fetchAll ( $sql, $values );
		$final = Twinmusic_Search_Engine::prepareResults ( $res );
		$session = new Zend_Session_Namespace('Twinmusic_Search');
		$session->searchResult = $final;
	}
}
