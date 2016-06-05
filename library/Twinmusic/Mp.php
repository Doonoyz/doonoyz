<?php
/**
 * Private messager
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Mp {
	
	/**
	 * Receiver User ID
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Array of MPs
	 *
	 * @var Array
	 */
	private $_results;
	/**
	 * New MP Title
	 *
	 * @var string
	 */
	private $_title;
	/**
	 * New MP Body
	 *
	 * @var string
	 */
	private $_body;
	/**
	 * Sender User Id
	 *
	 * @var string
	 */
	private $_user_id = 0;
	
	/**
	 * Constructor MP engine
	 *
	 */
	public function __construct() {
		$this->_id = Twindoo_User::getCurrentUserId ();
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_MP WHERE USER_ID_RECEIVER = ? ORDER BY MP_READ ASC, MP_ID DESC";
			$this->_results = $db->fetchAll ( $sql, Array ($this->_id ) );
		}
	}
	
	/**
	 * Retrieve Current user MPs
	 *
	 * @param bool $onlyUnread Only unread messages
	 * 
	 * @return Array
	 */
	public function getMyMp($onlyUnread = false) {
		if ($onlyUnread && count ( $this->_results )) {
			foreach ( $this->_results as $k => $line ) {
				if ($line ['MP_READ'] == 1) {
					unset ( $this->_results [$k] );
				}
			}
		}
		return ($this->_results);
	}
	
	/**
	 * Delete MP
	 *
	 * @param int $id Id of MP to delete
	 */
	public function deleteMp($id) {
		if (is_numeric ( $id ) && $id > 0) {
			$sql = "DELETE FROM DN_MP WHERE MP_ID = ? AND USER_ID_RECEIVER = ?";
			$values = Array ($id, $this->_id );
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, $values );
		}
	}
	
	/**
	 * Get Concerned User informations about all MPs
	 *
	 * @return Array User Informations
	 */
	public function getConcernedUser() {
		$array = array ();
		foreach ( $this->_results as $result ) {
			$array [$result ['USER_ID_SENDER']] = $result ['USER_ID_SENDER'];
		}
		return (Twindoo_User::getInfos ( $array ));
	}
	
	/**
	 * Set New MP Title
	 *
	 * @param string $value Mp Title
	 */
	public function setTitle($value) {
		$this->_title = htmlentities ( strip_tags (  utf8_decode ( $value ) ) );
		if (empty ($this->_title)) {
			$this->_title = t_('(empty)');
		}
	}
	
	/**
	 * Set New MP Body
	 *
	 * @param string $value Mp Body
	 */
	public function setBody($value) {
		/*if (strlen($value) > 1000) {
			$value = substr($value, 0, 1000) . ' [...]';
		}/**/
		$this->_body = nl2br ( htmlentities ( strip_tags ( utf8_decode ( $value )  ) ) );
	}
	
	/**
	 * Set New MP Receiver User ID
	 *
	 * @param int $user_id Receiver user id
	 */
	
	public function setReceiver($user_id) {
		if (is_numeric ( $user_id ) && $user_id > 0)
			$this->_user_id = $user_id;
	}
	
	/**
	 * Send the new MP
	 *
	 */
	public function sendMp() {
		if (is_numeric ( $this->_user_id ) && $this->_user_id > 0) {
			$sql = "INSERT INTO DN_MP SET ";
			$sql .= "MP_TITLE = ?,";
			$sql .= "MP_BODY = ?,";
			$sql .= "MP_DATE = ?,";
			$sql .= "MP_READ = '0',";
			$sql .= "USER_ID_SENDER = ?,";
			$sql .= "USER_ID_RECEIVER = ?";
			$values = Array ($this->_title, $this->_body, date ( "Y-m-d H:i:s" ), $this->_id, $this->_user_id );
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, $values );
		}
	}
	
	/**
	 * Delete all current user MP 
	 *
	 */
	public function deleteAllMp() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$sql = "DELETE FROM DN_MP WHERE USER_ID_RECEIVER = ?";
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, Array ($this->_id ) );
		}
	}
	
	/**
	 * Mark MP ad read by its id
	 *
	 * @param int $id MP Id
	 */
	public function readMp($id) {
		if (is_numeric ( $id ) && $id > 0) {
			$sql = "UPDATE DN_MP SET MP_READ = '1' WHERE MP_ID = ? AND USER_ID_RECEIVER = ?";
			$values = Array ($id, $this->_id );
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, $values );
		}
	}
}
