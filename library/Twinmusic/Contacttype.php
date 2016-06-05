<?php
/**
 * Manage a contact type
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Contacttype implements Twinmusic_Admin_Component_Interface {

	/**
	 * Contact type id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Contact type name
	 *
	 * @var string
	 */
	private $_name;
	/**
	 * Contact type active state
	 *
	 * @var bool
	 */
	private $_active;
	/**
	 * Contact type logo path
	 *
	 * @var string
	 */
	private $_logo;
	/**
	 * Contact type patter for display
	 *
	 * @var string
	 */
	private $_pattern;
	/**
	 * Contact type filter plugin
	 *
	 * @var string
	 */
	private $_filter;

	/**
	 * Constructor
	 *
	 * @param int $id Contact type id
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_CONTACTTYPE WHERE CONTACTTYPE_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $result )) {
				$this->_id = $result [0] ['CONTACTTYPE_ID'];
				$this->_name = $result [0] ['CONTACTTYPE_NAME'];
				$this->_active = $result [0] ['CONTACTTYPE_ACTIVE'];
				$this->_logo = $result [0] ['CONTACTTYPE_LOGO'];
				$this->_pattern = $result [0] ['CONTACTTYPE_PATTERN'];
				$this->_filter = $result [0] ['CONTACTTYPE_FILTER'];
			}
		}
	}
	/**
	 * Retrieve contact type list
	 *
	 * @return Array Array containing informations
	 */
	static public function getList() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_CONTACTTYPE WHERE CONTACTTYPE_ACTIVE = '1'";
		$results = $db->fetchAll ( $sql );
		return ($results);
	}

	/**
	 * Get contact type id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get contact type name
	 *
	 * @return string
	 */
	public function getName() {
		return ( $this->_name );
	}
	/**
	 * Get contact type pattern
	 *
	 * @return string
	 */
	public function getPattern() {
		return ( $this->_pattern );
	}
	/**
	 * Get contact type filter name
	 *
	 * @return string
	 */
	public function getFilter() {
		return ( $this->_filter );
	}
	/**
	 * Check is contact type is active
	 *
	 * @return bool
	 */
	public function isActive() {
		return ($this->_active ? true : false);
	}
	/**
	 * Get contact type logo path
	 *
	 * @return string
	 */
	public function getLogo() {
		return ( $this->_logo );
	}

	/**
	 * Set contact type name
	 *
	 * @param string $value Contact type name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	/**
	 * Set contact type pattern
	 *
	 * @param string $value Contact type pattern
	 */
	public function setPattern($value) {
		$this->_pattern = $value;
	}
	/**
	 * Set contact type filter
	 *
	 * @param string $value Contact type filter
	 */
	public function setFilter($value) {
		$this->_filter = $value;
	}
	/**
	 * Set contact type active state
	 *
	 * @param bool $value Contact type active state
	 */
	public function setActive($value = true) {
		$this->_active = ($value) ? 1 : 0;
	}
	/**
	 * Set contact type logo path
	 *
	 * @param string $value contact type logo path
	 */
	public function setLogo($value) {
		$this->_logo = strip_tags ( $value );
	}

	/**
	 * Save contact type changes
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();

		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_CONTACTTYPE SET ";
		$sql .= " CONTACTTYPE_NAME = ?, ";
		$sql .= " CONTACTTYPE_ACTIVE = ?, ";
		$sql .= " CONTACTTYPE_PATTERN = ?, ";
		$sql .= " CONTACTTYPE_FILTER = ?, ";
		$sql .= " CONTACTTYPE_LOGO = ?";
		if ($this->_id != 0)
			$sql .= " WHERE CONTACTTYPE_ID = ?";

		$values = Array ($this->_name, $this->_active, $this->_pattern, $this->_filter, $this->_logo );
		if ($this->_id != 0)
			$values [] = $this->_id;

		$db->query ( $sql, $values );
		if ($this->_id == 0) {
			$this->_id = $db->lastInsertId ();

			$task = new Twinmusic_Admintask ( );
			$task->setMessage ( Twinmusic_Admintask::NEWCONTACTTYPE );
			$task->setMessageArgs ( Array ( $this->_name ) );
			$task->setComponentName ( "contacttype" );
			$task->setComponentid ( $this->_id );
			$task->commit ();
		}
	}
	
	/**
	 * Delete the contact type
	 */
	public function delete() {
		if (is_numeric($this->_id) && $this->_id > 0) {
			$db = Twindoo_Db::getDb();
			$db->beginTransaction();
			try {
				$sql = "DELETE FROM DN_CONTACT WHERE CONTACTTYPE_ID = ?";
				$db->query($sql, Array($this->_id));
				$sql = "DELETE FROM DN_CONTACTTYPE WHERE CONTACTTYPE_ID = ?";
				$db->query($sql, Array($this->_id));
				$db->commit();
			} catch (Exception $e) {
				$db->rollBack();
			}
		}
	}
	 
	/**
	 * Replace the groupstyle with selected one
	 *
	 * @param Array[int] $array Array containing id to replace with
	 *
	 * @return bool Success of the operation
	 */
	public function replaceWith($array) {
		$success = true;
		if (!is_array($array)) {
			throw new Exception;
		}
		if (!is_int($this->_id) || $this->_id <= 0) {
			throw new Exception;
		}
		foreach ($array as $id) {
			if (!is_int($id) || $id <= 0) {
				throw new Exception;
			}
		}
		if (count($array) != 1) {
			throw new Exception;
		}
		$db = Twindoo_Db::getDb();
		$db->beginTransaction();
		try {
			$sql = "UPDATE DN_CONTACTTYPE SET CONTACTTYPE_ID = ? WHERE CONTACTTYPE_ID = ?";
			$db->query($sql, Array($array[0], $this->_id));
			$db->commit();
		} catch (Exception $e) {
			$db->rollBack();
			$success = false;
		}
		return ($success);
	}
}
