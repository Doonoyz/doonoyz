<?php
/**
 * Composition note class
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Note {
	
	/**
	 * Id of the composition
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Voting user id
	 *
	 * @var int
	 */
	private $_user_id;
	/**
	 * All notes for a composition
	 *
	 * @var Array
	 */
	private $_results;
	
	/**
	 * Constructor
	 *
	 * @param int $id Compo id
	 */
	public function __construct($id = 0) {
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_NOTE WHERE COMPO_ID = ?";
			$this->_results = $db->fetchAll ( $sql, Array ($id ) );
		}
		$this->_id = $id;
	}
	
	/**
	 * Get the average note of this composition
	 *
	 * @return int Average note
	 */
	public function getAverage() {
		if (count ( $this->_results )) {
			$count = 0;
			foreach ( $this->_results as $result ) {
				$count += $result ['NOTE_VALUE'];
			}
			return (Array ($count / count ( $this->_results ), count ( $this->_results ) ));
		} else
			return (Array (0, 0 ));
	}
	
	/**
	 * Check if a user already voted
	 *
	 * @param int $id User id
	 * 
	 * @return bool True if user already voted
	 */
	private function alreadyVoted($id) {
		$bool = false;
		
		foreach ( $this->_results as $result ) {
			if ($result ['USER_ID'] == $id)
				$bool = true;
		}
		return ($bool);
	}
	
	/**
	 * Set the note for current user id on this compo
	 *
	 * @param int $value Note to attribute
	 * 
	 * @return bool True if it worked, false if already voted or note not authorized
	 */
	public function setNote($value) {
		$notes = Array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
		if (in_array ( $value, $notes )) {
			if (! $this->_alreadyVoted ( Twindoo_User::getCurrentUserId () )) {
				$db = Twindoo_Db::getDb ();
				$sql = "INSERT INTO DN_NOTE SET USER_ID = ?, NOTE_VALUE = ?, COMPO_ID = ?";
				$db->query ( $sql, Array (Twindoo_User::getCurrentUserId (), $value, $this->_id ) );
				return (true);
			}
		}
		return (false);
	}
}
