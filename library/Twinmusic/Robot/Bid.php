<?php
/**
 * Bid processing unit
 *
 * @package    Doonoyz
 * @subpackage library/robot
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Robot_Bid {
	/**
	 * List of task to do
	 *
	 * @var Array
	 */
	private $_list;

	/**
	 * process launcher
	 *
	 */
	public function launch() {
		$this->getMyWork ();
		$this->startTask ();
	}

	/**
	 * Get tasks to do
	 *
	 */
	public function getMyWork() {
		$sql = "SELECT DISTINCT BID_ID FROM DN_USERINGROUP WHERE NOT BID_ID = '0'";
		$db = Twindoo_Db::getDb ();
		$result = $db->fetchAll ( $sql );
		$this->_list = $result;
	}

	/**
	 * Process the tasks to do when work is get
	 *
	 */
	public function startTask() {
		foreach ( $this->_list as $value ) {
			Twinmusic_Bid::proceed ($value);
		}
	}
}