<?php
/**
 * Manage a competence
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Competence implements Twinmusic_Admin_Component_Interface {

	/**
	 * Competence id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Competence name
	 *
	 * @var string
	 */
	private $_name;
	/**
	 * Competence active state
	 *
	 * @var bool
	 */
	private $_active;

	/**
	 * Constructor
	 *
	 * @param int $id Competence If
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_COMPETENCE WHERE COMPETENCE_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $results )) {
				$this->_id = $results [0] ['COMPETENCE_ID'];
				$this->_name = $results [0] ['COMPETENCE_NAME'] ;
				$this->_active = $results [0] ['COMPETENCE_ACTIVE'] ;
			}
		}
	}

	/**
	 * Retrieve all competencies available
	 *
	 * @return Array Array containing informations
	 */
	static public function getList() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_COMPETENCE WHERE COMPETENCE_ACTIVE = '1' ORDER BY COMPETENCE_NAME";
		$results = $db->fetchAll ( $sql );
		return ($results);
	}

	/**
	 * Get competence Id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id );
	}

	/**
	 * Get competence Name
	 *
	 * @return string
	 */
	public function getName() {
		return ($this->_name );
	}

	/**
	 * Check if the competence is active
	 *
	 * @return bool
	 */
	public function isActive() {
		return ($this->_active ? true : false);
	}

	/**
	 * Set competence name
	 *
	 * @param string $value Competence name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	/**
	 * Set competence active state
	 *
	 * @param bool $value Competence active state
	 */
	public function setActive($value = true) {
		$this->_active = ($value ? 1 : 0);
	}

	/**
	 * Save all competence updates
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_COMPETENCE SET ";
		$sql .= " COMPETENCE_NAME = ?,";
		$sql .= " COMPETENCE_ACTIVE = ?";
		if ($this->_id != 0)
			$sql .= " WHERE COMPETENCE_ID = ?";

		$values = Array ($this->_name, $this->_active );
		if ($this->_id != 0)
			$values [] = $this->_id;

		$db->query ( $sql, $values );
		if ($this->_id == 0) {
			$this->_id = $db->lastInsertId ();

			$task = new Twinmusic_Admintask ( );
			$task->setMessage ( Twinmusic_Admintask::NEWCOMPETENCE );
			$task->setMessageArgs ( Array ($this->_name ) );
			$task->setComponentName ( "competence" );
			$task->setComponentid ( $this->_id );
			$task->commit ();
		}
	}

	/**
	 * Assign competence to user in group
	 *
	 * @param int $user  User id to assign competence
	 * @param int $group Group id where user is to assign competence
	 *
	 * @return bool Success of the operation
	 */
	public function assignTo($user, $group) {
		$db = Twindoo_Db::getDb ();
		if ($this->_id != 0) {
			if (is_numeric ( $group ) && is_numeric ( $user ) && $group > 0 && $user > 0) {
				$sql = "SELECT * FROM DN_GROUPCOMP WHERE COMPETENCE_ID = ? AND GROUP_ID = ? AND USER_ID = ?";
				$values = Array ($this->_id, $group, $user );
				$res = $db->fetchAll ( $sql, $values );
				if (! count ( $res )) {
					$sql = "INSERT INTO DN_GROUPCOMP SET COMPETENCE_ID = ?, GROUP_ID = ?, USER_ID = ?";
					return ($db->query ( $sql, $values ));
				} else
					return (false);
			}
		} else
			return (false);
	}

	/**
	 * Unassign competence to user in group
	 *
	 * @param int $user  User id to unassign competence
	 * @param int $group Group id where user is to unassign competence
	 *
	 * @return bool Success of the operation
	 */
	public function unAssignFor($user, $group) {
		$db = Twindoo_Db::getDb ();
		if ($this->_id != 0) {
			if (is_numeric ( $group ) && is_numeric ( $user ) && $group > 0 && $user > 0) {
				$sql = "DELETE FROM DN_GROUPCOMP WHERE COMPETENCE_ID = ? AND GROUP_ID = ? AND USER_ID = ?";
				$values = Array ($this->_id, $group, $user );
				return ($db->query ( $sql, $values ));
			}
		} else
			return (false);
	}

	/**
	 * Delete Competence
	 *
	 */
	public function delete() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$db = Twindoo_Db::getDb ();
			$db->beginTransaction();
			try {
				$sql = "DELETE FROM DN_GROUPCOMP WHERE COMPETENCE_ID = ?";
				$db->query ( $sql, Array ($this->_id ) );
				$sql = "DELETE FROM DN_COMPETENCE WHERE COMPETENCE_ID = ?";
				$db->query ( $sql, Array ($this->_id ) );
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
			$sql = "SELECT * FROM DN_GROUPCOMP WHERE COMPETENCE_ID = ?";
			$result = $db->fetchAll($sql, array($this->_id));
			$sql = "DELETE FROM DN_GROUPCOMP WHERE COMPETENCE_ID = ?";
			$db->query($sql, Array($this->_id));
			foreach ($result as $line) {
				foreach ($array as $currentId) {
					$comp = new Twinmusic_Competence($currentId);
					if (!$comp->assignTo($line['USER_ID'], $line['GROUP_ID'])) {
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
