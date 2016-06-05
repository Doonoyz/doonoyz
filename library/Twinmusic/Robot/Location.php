<?php
/**
 * Robot location processing unit
 *
 * @package    Doonoyz
 * @subpackage library/robot
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Robot_Location {
	/**
	 * List of task to do
	 *
	 * @var Array
	 */
	private $_list;

	/**
	 * Process launcher
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
		$sql = "SELECT * FROM DN_GROUP WHERE GROUP_LOCATION_PROCESSED = '0'";
		$db = Twindoo_Db::getDb ();
		$result = $db->fetchAll ( $sql );
		/** Update the database to avoid robot fetching conflicts */
		foreach ( $result as $value ) {
			$sql = "UPDATE DN_GROUP SET GROUP_LOCATION_PROCESSED = '1' WHERE GROUP_ID = ?";
			$db->query ( $sql, Array ($value ['GROUP_ID'] ) );
		}
		$this->_list = $result;
	}

	/**
	 * Process the tasks to do when work is get
	 *
	 */
	public function startTask() {
		foreach ( $this->_list as $value ) {
			$group = new Twinmusic_Group ( $value ['GROUP_ID'] );
			$location = Twindoo_LocationService::getInfos ( $group->getLieu ( ), $group->getPays ( ), $group->getPostal ( ) );
			if ( $location ['LONGITUDE'] == 0 && $location['LATITUDE'] == 0 ) {
				$this->_sendMp ( $group );
			} else {
				$group->setLong ( $location ['LONGITUDE'] );
				$group->setLat ( $location ['LATITUDE'] );
				$group->commit ( );
			}
		}
	}
	
	/**
	 * Send MP to group admin if location not found
	 *
	 */
	private function _sendMp($group) {
		$title = t_( "Group Location not found" );
		$body = sprintf ( t_( "The location of your group \"%s\" (http://www.doonoyz.com/%s) was not found, please check its availability. If you think it's an error, please contact us at <a href='mailto:contact@doonoyz.com'>contact@doonoyz.com</a>" ), $group->getNom (), $group->getUrl () );
		$db = Twindoo_Db::getDb ();
		$sql = "INSERT INTO DN_MP SET ";
		$sql .= "MP_TITLE = ?,";
		$sql .= "MP_BODY = ?,";
		$sql .= "MP_DATE = ?,";
		$sql .= "MP_READ = '0',";
		$sql .= "USER_ID_SENDER = ?,";
		$sql .= "USER_ID_RECEIVER = ?";
		$values = Array ($title, $body, date ( "Y-m-d H:i:s" ), 0, $group->getAdmin () );
		$db->query ( $sql, $values );
	}
}