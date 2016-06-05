<?php
/**
 * Manage a group event
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Event {

	/**
	 * Event id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Event group id
	 *
	 * @var int
	 */
	private $_group_id;
	/**
	 * Event title
	 *
	 * @var string
	 */
	private $_title;
	/**
	 * Event description
	 *
	 * @var string
	 */
	private $_description;
	/**
	 * Event date
	 *
	 * @var date
	 */
	private $_date;

	/**
	 * Constructor
	 *
	 * @param int $id Event id
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_EVENT WHERE EVENT_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $results )) {
				$this->_id = $results [0] ['EVENT_ID'];
				$this->_group_id = $results [0] ['GROUP_ID'];
				$this->_title = $results [0] ['EVENT_TITLE'];
				$this->_description = $results [0] ['EVENT_DESCRIPTION'];
				$this->_date = $results [0] ['EVENT_DATE'];
			}
		}
	}

	/**
	 * Get event id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get Event group id
	 *
	 * @return int
	 */
	public function getGroupId() {
		return ($this->_group_id);
	}
	/**
	 * Get event title
	 *
	 * @return string
	 */
	public function getTitle() {
		return ( $this->_title );
	}
	/**
	 * Get event description
	 *
	 * @return string
	 */
	public function getDescription() {
		return ( $this->_description );
	}
	/**
	 * Get event date
	 *
	 * @return date
	 */
	public function getDate() {
		return ( $this->_date );
	}

	/**
	 * Set event group id
	 *
	 * @param int $value Group id
	 */
	public function setGroupId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_group_id = $value;
	}
	/**
	 * Set event title
	 *
	 * @param string $value Event title
	 */
	public function setTitle($value) {
		$this->_title = strip_tags ( $value );
	}
	/**
	 * Set event description
	 *
	 * @param string $value Event description
	 */
	public function setDescription($value) {
		$this->_description = strip_tags ( $value );
	}

	/**
	 * Set event date
	 *
	 * @param date $value Event date
	 */
	public function setDate($value) {
		$this->_date = strtotime ( $value );
	}

	/**
	 * Save event updates
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_EVENT SET ";
		$sql .= " GROUP_ID = ?,";
		$sql .= " EVENT_TITLE = ?,";
		$sql .= " EVENT_DESCRIPTION = ?,";
		$sql .= " EVENT_DATE = ?";
		if ($this->_id != 0)
			$sql .= " WHERE EVENT_ID = ?";

		$values = Array ($this->_group_id, $this->_title, $this->_description, $this->_date );
		if ($this->_id != 0)
			$values [] = $this->_id;

		$db->query ( $sql, $values );
		if ($this->_id == 0)
			$this->_id = $db->lastInsertId ();
	}

	/**
	 * Retrieve all events assigned to a group by its group id
	 *
	 * @param int $group Group id
	 *
	 * @return Array Array containing informations
	 */
	public function getGroupEvents($group) {
		if (is_numeric ( $group ) && $group > 0) {
			$sql = "SELECT * FROM DN_EVENT WHERE GROUP_ID = ?";
			$db = Twindoo_Db::getDb ();
			return ($db->fetchAll ( $sql, Array ($group ) ));
		} else
			return (Array ());
	}

	/**
	 * Delete the event
	 *
	 */
	public function delete() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$sql = "DELETE FROM DN_EVENT WHERE EVENT_ID = ?";
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, Array ($this->_id ) );
		}
	}
}
