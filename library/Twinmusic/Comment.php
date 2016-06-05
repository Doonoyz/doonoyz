<?php
/**
 * Manage a comment
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Comment {

	/**
	 * Comment id
	 *
	 * @var int
	 */
	private $_id = 0;
	/**
	 * Component Id that comment is assigned to
	 *
	 * @var int
	 */
	private $_type_id = 0;
	/**
	 * Comment send user id
	 *
	 * @var int
	 */
	private $_user_id = 0;
	/**
	 * Comment active state
	 *
	 * @var int
	 */
	private $_active = 1;
	/**
	 * Comment body
	 *
	 * @var string
	 */
	private $_body = "";
	/**
	 * Comment type (component name)
	 *
	 * @var string
	 */
	private $_type = "";

	/**
	 * Informations about users that sent a comment on a type
	 *
	 * @var Array
	 */
	private $_userList;

	/**
	 * Constructor
	 *
	 * @param int $id Comment id
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_COMMENT WHERE COMMENT_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $results )) {
				$this->_id = $results [0] ['COMMENT_ID'];
				$this->_type_id = $results [0] ['COMMENT_TYPE_ID'];
				$this->_user_id = $results [0] ['USER_ID'];
				$this->_active = $results [0] ['COMMENT_ACTIVE'];
				$this->_body = $results [0] ['COMMENT_BODY'];
				$this->_type = $results [0] ['COMMENT_TYPE'];
				$this->_date = $results [0] ['COMMENT_DATE'];
			}
		}
	}

	/**
	 * Get Comment id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get comment type id (id of the component the comment is assigned to)
	 *
	 * @return int
	 */
	public function getTypeId() {
		return ($this->_type_id);
	}
	/**
	 * Get sender user id
	 *
	 * @return int
	 */
	public function getUserId() {
		return ($this->_user_id);
	}
	/**
	 * Check if the comment is active
	 *
	 * @return bool
	 */
	public function isActive() {
		return ($this->_active ? true : false);
	}
	/**
	 * Get the comment body
	 *
	 * @return string
	 */
	public function getBody() {
		return ( $this->_body );
	}
	/**
	 * Get the component type that the comment is assigned to
	 *
	 * @return string
	 */
	public function getType() {
		return ($this->_type);
	}
	/**
	 * Get comment sent date
	 *
	 * @return date
	 */
	public function getDate() {
		return ($this->_date);
	}

	/**
	 * Set the component id
	 *
	 * @param int $value Component id
	 */
	public function setTypeId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_type_id = $value;
	}
	/**
	 * Set sender user id
	 *
	 * @param int $value User Id of the sender
	 */
	public function setUserId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_user_id = $value;
	}
	/**
	 * Set the active state of the comment
	 *
	 * @param bool $value Active state of the comment
	 */
	public function setActive($value = true) {
		$this->_active = ($value ? 1 : 0);
	}
	/**
	 * Set comment body
	 *
	 * @param string $value Body of the comment
	 */
	public function setBody($value) {
		$this->_body = htmlentities ( strip_tags ( $value ) );
	}
	/**
	 * Set component type
	 *
	 * @param string $value Component type
	 */
	public function setType($value) {
		$security = Array ('compo', 'news', 'blog' );
		if (in_array ( $value, $security ))
			$this->_type = $value;
	}

	/**
	 * Save all comment updates
	 *
	 */
	public function commit() {
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_COMMENT SET ";
		$sql .= " COMMENT_TYPE_ID = ?, ";
		$sql .= " USER_ID = ?, ";
		$sql .= " COMMENT_ACTIVE = ?, ";
		$sql .= " COMMENT_BODY = ?, ";
		$sql .= " COMMENT_DATE = ?, ";
		$sql .= " COMMENT_TYPE = ? ";
		if ($this->_id != 0)
			$sql .= ", WHERE COMMENT_ID = ?";

		$values = Array ($this->_type_id, $this->_user_id, $this->_active, $this->_body, (($this->_id == 0) ? date ( "Y-m-d H:i:s" ) : $this->_date), $this->_type );
		if ($this->_id != 0)
			$values [] = $this->_id;
		$db = Twindoo_Db::getDb ();
		try {
			$db->query ( $sql, $values );
		} catch ( Exception $e ) {
			//	die($e->getMessage());
		}
		if ($this->_id == 0)
			$this->_id = $db->lastInsertId ();
	}

	/**
	 * Delete the comment
	 *
	 */
	public function delete() {
		$db = Twindoo_Db::getDb ();
		if ($this->_id != 0) {
			$db->query ( "DELETE FROM DN_COMMENT WHERE COMMENT_ID = ?", Array ($this->_id ) );
		}
	}

	/**
	 * Retrieve all comments assigned to a component type and its id
	 *
	 * @param int    $id   Component Id
	 * @param string $type Component name
	 *
	 * @return Array Array containing informations
	 */
	public function getAllForType($id = 0, $type = "") {
		$this->setType ( $type );
		if (is_numeric ( $id ) && $id > 0 && $this->_type != "") {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_COMMENT WHERE COMMENT_TYPE_ID = ? AND COMMENT_TYPE = ? ORDER BY COMMENT_ID DESC";
			$results = $db->fetchAll ( $sql, Array ($id, $this->_type ) );
			$this->_userList = Array ();
			if (count ( $results )) {
				foreach ( $results as $id => $line ) {
					$this->_userList [$line ['USER_ID']] = $line ['USER_ID'];
				}
			}
			$this->_userList = Twindoo_User::getInfos ( $this->_userList );
			return ($results);
		} else
			return (Array ());
	}

	/**
	 * Get the informations about users that posted a comment on selected component
	 *
	 * @return Array Array containing informations
	 */
	public function getConcernedUsers() {
		return ($this->_userList);
	}
}
