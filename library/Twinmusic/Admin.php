<?php
/**
 * Admin management
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Admin {
	/**
	 * Check if a user is admin by its id
	 *
	 * @param int $userId User id
	 * @return bool User is admin or not
	 */
	static public function isAdmin($userId) {
		if (is_numeric ( $userId ) && $userId > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_ADMIN WHERE USER_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($userId ) );
			return (count ( $results ) ? true : false);
		} else
			return (false);
	}
}
