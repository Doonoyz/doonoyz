<?php
/**
 * Object for labels
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Label implements Twinmusic_Admin_Component_Interface {
	/**
	 * Label Id
	 *
	 * @var int
	 */
	private $_id = 0;

	/**
	 * Label active state
	 *
	 * @var bool
	 */
	private $_active;
	
	/**
	 * Label name
	 *
	 * @var string
	 */
	private $_name;
	
	/**
	 * Label constructor
	 *
	 * @param int $id Id of the label to load (optionnal)
	 */
	public function __construct($id = 0) {
		if (is_numeric($id) && $id > 0) {
			$db = Twindoo_Db::getDb();
			$sql = "SELECT * FROM DN_LABEL WHERE LABEL_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($id ) );
			if (count($result)) {
				$this->_id = $result [0] ['LABEL_ID'];
				$this->_active = $result [0] ['LABEL_ACTIVE'];
				$this->_name = $result [0] ['LABEL_NAME'];
			}
		}
	}
	
	/**
	 * Retrieve Label Id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	
	/**
	 * Retrieve Label active state
	 *
	 * @return bool
	 */
	public function isActive() {
		return ((bool) $this->_active);
	}
	
	/**
	 * Retrieve Label name
	 *
	 * @return string
	 */
	public function getName() {
		return ($this->_name);
	}
	
	/**
	 * Define Label active state
	 *
	 * @param bool $value Active state (optionnal default true)
	 */
	public function setActive($value = true) {
		$this->_active = ($value) ? 1 : 0;
	}
	
	/**
	 * Set label name
	 *
	 * @param string $value Label Name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	
	/**
	 * Save modifications
	 *
	 */
	public function commit() {
		$sql = ($this->_id == 0) ? 'INSERT INTO' : 'UPDATE';
		$sql .= ' DN_LABEL SET ';
		$sql .= ' LABEL_NAME = ?,';
		$sql .= ' LABEL_ACTIVE = ?';
		
		$values = array();
		$values [] = $this->_name;
		$values [] = $this->_active;
		if ($this->_id != 0) {
			$sql .= ' WHERE LABEL_ID = ?';
			$values[] = $this->_id;
		}
		$db = Twindoo_Db::getDb();
		$db->query($sql, $values);
		if ($this->_id == 0) {
			$this->_id = $db->lastInsertId();
			
			$task = new Twinmusic_Admintask ( );
			$task->setMessage ( Twinmusic_Admintask::NEWLABEL );
			$task->setMessageArgs ( Array ($this->_name ) );
			$task->setComponentName ( "label" );
			$task->setComponentid ( $this->_id );
			$task->commit ();
		}
	}
	
	
	/**
	 * Retrieve all active labels
	 *
	 */
	static public function getList() {
		$db = Twindoo_Db::getDb();
		$sql = "SELECT * FROM DN_LABEL WHERE LABEL_ACTIVE = '1' ORDER BY LABEL_NAME";
		$results = $db->fetchAll ( $sql );
		return ($results);
	}
	
	/**
	 * Delete the current label
	 *
	 */
	public function delete() {
		if ($this->_id != 0) {
			$db = Twindoo_Db::getDb();
			$sql = 'SELECT * FROM DN_LABEL WHERE LABEL_ID = ?';
			$db->query($sql, array($this->_id));
		}
	}
	
	/**
	 * Replace the current label by thoses passed in params
	 *
	 * @param Array[int] $array Array of ids (warning, it must contain only one id)
	 *
	 * @throws Exception
	 */
	public function replaceWith($array) {
		if (is_array($array) && count($array) == 1 && $this->_id != 0) {
			$id = current($array);
			$db = Twindoo_Db::getDb();
			$sql = 'UPDATE DN_GROUP SET LABEL_ID = ? WHERE LABEL_ID = ?';
			$db->query($sql, array($id, $this->_id));
		} else {
			throw new Exception('Can\'t replace one label by some labels, you have to choose one');
		}
	}
}