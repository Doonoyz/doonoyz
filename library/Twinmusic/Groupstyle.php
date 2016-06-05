<?php
/**
 * Managing Group styles
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Groupstyle implements Twinmusic_Admin_Component_Interface {
	
	/**
	 * Style Id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Style name
	 *
	 * @var string
	 */
	private $_name;
	/**
	 * Style active state
	 *
	 * @var bool
	 */
	private $_active;
	
	/**
	 * Constructor
	 *
	 * @param int $id Style Id
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_STYLEMUSIC WHERE STYLE_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $result )) {
				$this->_id = $result [0] ['STYLE_ID'];
				$this->_name = $result [0] ['STYLE_NAME'];
				$this->_active = $result [0] ['STYLE_ACTIVE'];
			}
		}
	}
	
	/**
	 * Get styles list 
	 *
	 * @return Array All group styles
	 */
	static public function getList() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_STYLEMUSIC WHERE STYLE_ACTIVE = '1'";
		$result = $db->fetchAll ( $sql );
		return ($result);
	}
	
	/**
	 * Get Style Id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get Style name
	 *
	 * @return string
	 */
	public function getName() {
		return ( $this->_name );
	}
	/**
	 * Check is style is active
	 *
	 * @return bool
	 */
	public function isActive() {
		return ($this->_active ? true : false);
	}
	
	/**
	 * Set Style Name
	 *
	 * @param string $value Style Name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	/**
	 * Set style active state
	 *
	 * @param bool $value Active State
	 */
	public function setActive($value = true) {
		$this->_active = $value ? 1 : 0;
	}
	
	/**
	 * Save style update
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_STYLEMUSIC SET ";
		$sql .= "STYLE_NAME = ?, ";
		$sql .= "STYLE_ACTIVE = ?";
		if ($this->_id != 0)
			$sql .= " WHERE STYLE_ID = ?";
		
		$values = Array ($this->_name, $this->_active );
		
		if ($this->_id != 0)
			$values [] = $this->_id;
		$db->query ( $sql, $values );
		if ($this->_id == 0) {
			$this->_id = $db->lastInsertId ();
			
			$task = new Twinmusic_Admintask ( );
			$task->setMessage ( Twinmusic_Admintask::NEWSTYLE );
			$task->setMessageArgs ( $this->_name );
			$task->setComponentName ( 'groupstyle' );
			$task->setComponentId ( $this->_id );
			$task->commit ();
		}
	}
	
	/**
	 * Assign this style to group
	 *
	 * @param int $group Group Id
	 * 
	 * @return bool Assigned success
	 */
	public function assignTo($group) {
		if ($this->_id != 0) {
			if (is_numeric ( $group ) && $group > 0) {
				$db = Twindoo_Db::getDb ();
				$sql = "SELECT * FROM DN_GROUPSTYLE WHERE GROUP_ID = ? AND STYLE_ID = ?";
				$values = Array ($group, $this->_id );
				$res = $db->fetchAll ( $sql, $values );
				if (! count ( $res )) {
					$sql = "INSERT INTO DN_GROUPSTYLE SET GROUP_ID = ?, STYLE_ID = ?";
					return ($db->query ( $sql, $values ));
				} else
					return (false);
			}
		} else
			return (false);
	}
	
	/**
	 * Unassign style for group
	 *
	 * @param int $group Group Id
	 *  
	 * @return bool Unassign success
	 */
	public function unassignFor($group) {
		if ($this->_id != 0) {
			if (is_numeric ( $group ) && $group > 0) {
				$db = Twindoo_Db::getDb ();
				$sql = "SELECT * FROM DN_GROUPSTYLE WHERE GROUP_ID = ? AND STYLE_ID = ?";
				$values = Array ($group, $this->_id );
				$res = $db->fetchAll ( $sql, $values );
				if (count ( $res )) {
					$sql = "DELETE FROM DN_GROUPSTYLE WHERE GROUP_ID = ? AND STYLE_ID = ?";
					return ($db->query ( $sql, $values ));
				} else
					return (false);
			}
		} else
			return (false);
	}
	
	/**
	 * Delete the style
	 */
	public function delete() {
		if (is_numeric($this->_id) && $this->_id > 0) {
			$db = Twindoo_Db::getDb();
			$db->beginTransaction();
			try {
				$sql = "DELETE FROM DN_GROUPSTYLE WHERE STYLE_ID = ?";
				$db->query($sql, Array($this->_id));
				$sql = "DELETE FROM DN_STYLEMUSIC WHERE STYLE_ID = ?";
				$db->query($sql, Array($this->_id));
				$db->commit();
			} catch (Exception $e) {
				$db->rollBack();
			}
		}
	}
	
	/**
	 * Replace the groupstyle with selected one(s)
	 *
	 * @param Array[int] $array Array containing ids to replace with
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
		$db = Twindoo_Db::getDb();
		$db->beginTransaction();
		try {
			$sql = "SELECT * FROM DN_GROUPSTYLE WHERE STYLE_ID = ?";
			$result = $db->fetchAll($sql, array($this->_id));
			$sql = "DELETE FROM DN_GROUPSTYLE WHERE STYLE_ID = ?";
			$db->query($sql, Array($this->_id));
			foreach ($result as $line) {
				foreach ($array as $currentId) {
					$gs = new Twinmusic_Groupstyle($currentId);
					if (!$gs->assignFor($line['GROUP_ID'])) {
						throw new Exception;
					}
				}
			}
			$db->commit();
		} catch (Exception $e) {
			$db->rollBack();
			$success = false;
		}
		return ($success);
	}
}
