<?php
/**
 * News engine
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_News {

	/**
	 * News id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Group id
	 *
	 * @var int
	 */
	private $_group_id;
	/**
	 * News title
	 *
	 * @var string
	 */
	private $_title;
	/**
	 * News body
	 *
	 * @var string
	 */
	private $_body;

	/**
	 * Constructor
	 *
	 * @param int $id Id of the news
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_NEWS WHERE NEWS_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $result )) {
				$this->_id = $result [0] ['NEWS_ID'];
				$this->_group_id = $result [0] ['GROUP_ID'];
				$this->_title = $result [0] ['NEWS_TITLE'];
				$this->_body = $result [0] ['NEWS_BODY'];
			}
		}
	}

	/**
	 * Get news id
	 *
	 * @return int Id of the news
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get group id
	 *
	 * @return int Id of the group
	 */
	public function getGroupId() {
		return ($this->_group_id);
	}
	/**
	 * Get news title
	 *
	 * @return string Title of the news
	 */
	public function getTitle() {
		return ( $this->_title );
	}
	
	/**
	 * Get news body
	 *
	 * @return string Body of the news
	 */
	public function getBody() {
		return ( $this->_body );
	}

	/**
	 * Define group id
	 *
	 * @param int $value Id of the group
	 */
	public function setGroupId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_group_id = $value;
	}
	/**
	 * Define news title
	 *
	 * @param string $value Title of the news
	 */
	public function setTitle($value) {
		$this->_title = strip_tags ( $value );
	}
	/**
	 * Define news body
	 *
	 * @param string $value News body
	 */
	public function setBody($value) {
		$this->_body = strip_tags ( $value );
	}

	/**
	 * Save news update
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_NEWS SET ";
		$sql .= "GROUP_ID = ?, ";
		$sql .= "NEWS_TITLE = ?, ";
		$sql .= "NEWS_BODY = ? ";
		if ($this->_id != 0)
			$sql .= " WHERE NEWS_ID = ?";

		$values = Array ($this->_group_id, $this->_title, $this->_body );

		if ($this->_id != 0)
			$values [] = $this->_id;

		$db->query ( $sql, $values );
		if ($this->_id == 0)
			$this->_id = $db->lastInsertId ();
	}

	/**
	 * Get all news by group id
	 *
	 * @param int $id Group Id
	 * 
	 * @return Array News informations
	 */
	public function getNewsByGroup($id = 0) {
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_NEWS WHERE GROUP_ID = ? ORDER BY NEWS_ID DESC";
			return ($db->fetchAll ( $sql, Array ($id ) ));
		} else
			return (Array ());
	}
}
