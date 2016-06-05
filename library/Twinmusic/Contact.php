<?php
/**
 * Manage a contact
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Contact {

	/**
	 * Contact id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Contact type Id
	 *
	 * @var int
	 */
	private $_type;
	/**
	 * Contact value
	 *
	 * @var string
	 */
	private $_value;
	/**
	 * Contact group Id
	 *
	 * @var int
	 */
	private $_group_id;

	/**
	 * Constructor
	 *
	 * @param int $id Contact id
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_CONTACT WHERE CONTACT_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $results )) {
				$this->_id = $results [0] ['CONTACT_ID'];
				$this->_type = $results [0] ['CONTACTTYPE_ID'];
				$this->_value = $results [0] ['CONTACT_VALUE'];
				$this->_group_id = $results [0] ['GROUP_ID'];
			}
		}
	}

    /**
     * Get contact id
     *
     * @return int
     */
	public function getId() {
		return ($this->_id);
	}

	/**
	 * Get contact type Id
	 *
	 * @return int
	 */
	public function getTypeId() {
		return ($this->_type);
	}
	/**
	 * Get contact value
	 *
	 * @return string
	 */
	public function getValue() {
		return ($this->_value);
	}
	/**
	 * Get contact group id
	 *
	 * @return int
	 */
	public function getGroupId() {
		return ($this->_group_id);
	}

	/**
	 * Set contact type id
	 *
	 * @param int $value Contact type id
	 */
	public function setTypeId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_type = $value;
	}
	/**
	 * Set contact group id
	 *
	 * @param int $value Group id
	 */
	public function setGroupId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_group_id = $value;
	}
	/**
	 * Set contact value
	 *
	 * @param string $value Contact value
	 */
	public function setValue($value) {
		if ($this->_type) {
			$contactType = new Twinmusic_Contacttype($this->_type);
			try {
				$value = Twinmusic_Contactfilter_Factory::run($contactType->getFilter(), $value);
			} catch (Exception $e) {
			}
		}
		$this->_value = strip_tags ( $value );
	}

	/**
	 * Save contact updates
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();

		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_CONTACT SET ";
		$sql .= " CONTACTTYPE_ID = ?, ";
		$sql .= " CONTACT_VALUE = ?, ";
		$sql .= " GROUP_ID = ?";
		if ($this->_id != 0)
			$sql .= " WHERE CONTACT_ID = ?";

		$values = Array ($this->_type, $this->_value, $this->_group_id );
		if ($this->_id != 0)
			$values [] = $this->_id;

		if (is_numeric ( $this->_group_id ) && $this->_group_id > 0 && is_numeric ( $this->_type ) && $this->_type > 0) {
			$db->query ( $sql, $values );
			if ($this->_id == 0)
				$this->_id = $db->lastInsertId ();
		}
	}

	/**
	 * Get all contacts for a given group id
	 *
	 * @param int $id Group Id
	 *
	 * @return Array Array containing informations
	 */
	static public function getGroupContacts($id) {
		$db = Twindoo_Db::getDb ();
		if (is_numeric ( $id ) && $id > 0) {
			$sql = "SELECT * FROM DN_CONTACT a, DN_CONTACTTYPE b WHERE GROUP_ID = ? AND CONTACTTYPE_ACTIVE = 1 AND a.CONTACTTYPE_ID = b.CONTACTTYPE_ID";
			$results = $db->fetchAll ( $sql, Array ($id ) );
			foreach ($results as $line => $infos) {
				if (strlen($infos ['CONTACTTYPE_PATTERN'])) {
					$results [$line] ['CONTACT_VALUE'] = str_replace('%s', Twindoo_Utile::dbResultHtmlSecurise($infos ['CONTACT_VALUE']), $infos ['CONTACTTYPE_PATTERN']);
				}
			}
			return ($results);
		} else
			return (Array ());
	}

	/**
	 * Delete contact
	 *
	 * @return bool Success of the operations
	 */
	public function delete() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "DELETE FROM DN_CONTACT WHERE CONTACT_ID = ?";
			return ($db->query ( $sql, Array ($this->_id ) ));
		}
	}
}
