<?php
/**
 * Invitation Class
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Invitation {
	/**
	 * Get all groups that current user is in
	 *
	 * @return Array Array containing informations
	 */
	static public function getAllMyGroups() {
		$userId = Twindoo_User::getCurrentUserId ();
		if ($userId) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT g.GROUP_ID, g.GROUP_NOM, g.GROUP_URL, BID_ID, g.GROUP_ADMIN, uig.INGROUP_ACTIVE, gc.COMPETENCE_ID, COMPETENCE_NAME FROM DN_USERINGROUP uig JOIN DN_GROUP g ON uig.GROUP_ID = g.GROUP_ID LEFT JOIN DN_GROUPCOMP gc ON gc.GROUP_ID = uig.GROUP_ID AND gc.USER_ID = ? LEFT JOIN DN_COMPETENCE c ON gc.COMPETENCE_ID = c.COMPETENCE_ID AND c.COMPETENCE_ACTIVE = 1 WHERE uig.USER_ID = ? AND g.GROUP_ACTIVE = 1";
			$results = $db->fetchAll ( $sql, Array ($userId, $userId ) );
			$cleaned = Array ();
			foreach ( $results as $line ) {
				$cleaned [$line ['GROUP_ID']] ['GROUP_ID'] = $line ['GROUP_ID'];
				$cleaned [$line ['GROUP_ID']] ['GROUP_NOM'] = $line ['GROUP_NOM'];
				$cleaned [$line ['GROUP_ID']] ['GROUP_URL'] = $line ['GROUP_URL'];
				$cleaned [$line ['GROUP_ID']] ['BID_ID'] = $line ['BID_ID'];
				$cleaned [$line ['GROUP_ID']] ['GROUP_ADMIN'] = $line ['GROUP_ADMIN'];
				$cleaned [$line ['GROUP_ID']] ['ACTIVE'] = $line ['INGROUP_ACTIVE'];
				$cleaned [$line ['GROUP_ID']] ['COMPETENCES'] [$line ['COMPETENCE_ID']] = $line ['COMPETENCE_NAME'];
			}
			return ($cleaned);
		} else
			return (Array ());
	}

	/**
	 * Get competencies assign to current user / selected user in all groups
	 *
	 * @param int $id User id
	 * 
	 * @return Array Array containing informations
	 */
	static public function getAllCompetencies($id = 0) {
		$userId = ((is_numeric ( $id ) && $id) > 0) ? $id : Twindoo_User::getCurrentUserId ();
		if ($userId) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_USERINGROUP uig, DN_GROUP g, DN_GROUPCOMP gc, DN_COMPETENCE c WHERE gc.GROUP_ID = uig.GROUP_ID AND uig.GROUP_ID = g.GROUP_ID AND gc.COMPETENCE_ID = c.COMPETENCE_ID AND c.COMPETENCE_ACTIVE = 1 AND uig.USER_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($userId ) );
			$cleaned = Array ();
			foreach ( $results as $line )
				$cleaned [$line ['COMPETENCE_ID']] = $line ['COMPETENCE_NAME'];
			return ($cleaned);
		} else
			return (Array ());
	}

	/**
	 * Prepare Groups current user is in
	 *
	 * @param bool $active True => Group user is validated in, False => groups user bid / is invited
	 * 
	 * @return Array Array containing informations
	 */
	static public function prepareGroups($active = false) {
		$result = self::getAllMyGroups ();
		foreach ( $result as $groupId => $line ) {
			if ($line ['ACTIVE'] == ($active ? 0 : 1)) {
				unset ( $result [$groupId] );
			}
		}
		return ($result);
	}

	/**
	 * Get groups current user is validated
	 *
	 * @return Array Array containing informations
	 */
	static public function getMyGroups() {
		return (self::prepareGroups ( true ));
	}

	/**
	 * Get groups current user is invited only
	 *
	 * @return Array Array containing informations
	 */
	static public function getMyInvitations() {
		$result = self::prepareGroups ( false );
		foreach ( $result as $groupId => $line ) {
			if ($line ['BID_ID'] != 0) {
				unset ( $result [$groupId] );
			}
		}
		return ($result);
	}
}
