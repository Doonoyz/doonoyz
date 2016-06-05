<?php
/**
 * Manage all bids
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Bid {
	/**
	 * Retrieve bids current user requested
	 *
	 * @return Array Array containing informations
	 */
	static public function getAllMyBid() {
		if (Twindoo_User::getCurrentUserId ()) {
			$db = Twindoo_Db::getDb ();
			$groupList = Twinmusic_Invitation::getAllMyGroups ();
			$values = Array ();
			$sql = "SELECT * FROM DN_USERINGROUP uig, DN_GROUP g WHERE NOT uig.BID_ID = 0 AND (";
			foreach ( $groupList as $line ) {
				if ($line ['ACTIVE']) {
					$sql .= "uig.GROUP_ID = ? OR ";
					$values [] = $line ['GROUP_ID'];
				}
			}
			$sql .= "uig.GROUP_ID = 0) AND uig.GROUP_ID = g.GROUP_ID ORDER BY uig.GROUP_ID ASC";
			$toKeep = $db->fetchAll ( $sql, $values );
			$sql = "SELECT * FROM DN_BID WHERE VOTINGUSER_ID = ?";
			$result = $db->fetchAll ( $sql, Twindoo_User::getCurrentUserId () );
			$final = Array ();
			foreach ( $result as $line )
				foreach ( $toKeep as $key => $value )
					if ($line ['BID_ID'] == $value ['BID_ID'])
						unset ( $toKeep [$key] );

			foreach ( $toKeep as $line )
				$final [$line ['GROUP_ID']] [] = $line;
			return ($final);
		} else
			return (Array ());
	}

	/**
	 * Vote for a user that bid into a group that current user is member
	 *
	 * @param int  $id     Bid Id
	 * @param bool $accept Accept or not the bid of this user
	 */
	static public function voteBid($id, $accept = true) {
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_BID WHERE BID_ID = ? AND VOTINGUSER_ID = ?";
			$values = Array ($id, Twindoo_User::getCurrentUserId () );
			$res = $db->fetchAll ( $sql, $values );
			if (! count ( $res )) {
				$sql = "INSERT INTO DN_BID SET BID_ID = ?, VOTINGUSER_ID = ?, BID_VALUE = ?";
				$values = Array ($id, Twindoo_User::getCurrentUserId (), ($accept ? 1 : 0) );
				$db->query ( $sql, $values );
				self::proceed($id);
			}
		}
	}

	/**
	 * Retrieve informations about the users that bid
	 *
	 * @param Array $list Array containing informations
	 *
	 * @return Array Array containing informations
	 */
	static public function getInfosForUserInGroup($list) {
		if (is_array ( $list )) {
			$final = Array ();
			foreach ( $list as $item ) {
				$user = isset ( $item [0] ) ? $item [0] : 0;
				$group = isset ( $item [1] ) ? $item [1] : 0;
				if (is_numeric ( $user ) && is_numeric ( $group ) && $user > 0 && $group > 0) {
					$db = Twindoo_Db::getDb ();
					$sql = "SELECT * FROM DN_USERINGROUP uig, DN_GROUPCOMP gc, DN_COMPETENCE c WHERE gc.GROUP_ID = uig.GROUP_ID AND gc.COMPETENCE_ID = c.COMPETENCE_ID AND c.COMPETENCE_ACTIVE = 1 AND uig.USER_ID = ? AND uig.GROUP_ID = ?";
					$results = $db->fetchAll ( $sql, Array ($user, $group ) );
					foreach ( $results as $line )
						$final [$group] [$user] [$line ['COMPETENCE_ID']] = $line;
				}
			}
			return ($final);
		} else
			return (Array ());
	}

	/**
	 * Execute the bid process to count how many voted yes or no
	 *
	 * @param int $bidId Bid Id
	 */
	static public function proceed($bidId) {
		if (is_numeric ( $bidId ) && $bidId > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_USERINGROUP uig WHERE uig.BID_ID = ?";
			$res = $db->fetchAll ( $sql, Array ($bidId ) );
			if (count ( $res )) {
				$groupId = $res [0] ['GROUP_ID'];
				$userId = $res [0] ['USER_ID'];
				$group = new Twinmusic_Group ( $groupId );
				$sql = "SELECT * FROM DN_BID WHERE BID_ID = ?";
				$res = $db->fetchAll ( $sql, Array ($bidId ) );
				if (count ( $res )) {
					$admin = 2;
					$members ['ok'] = 0;
					$members ['no'] = 0;
					foreach ( $res as $line ) {
						if ($group->getAdmin () == $line ['VOTINGUSER_ID']) {
							$admin = $line ['BID_VALUE'];
						} else if ($group->inGroup ( $line ['VOTINGUSER_ID'], true )) {
							if ($line ['BID_VALUE']) {
								$members ['ok'] ++;
							} else {
								$members ['no'] ++;
							}
						}
					}
					self::_proceedCompute ( $admin, $members ['ok'], $members ['no'], $group, $bidId, $userId );
				}
			}
		}
	}

	/**
	 * Compute the votes for the bid
	 *
	 * @param bool            $admin  Admin vote
	 * @param int             $ok     Numbers of vote yes
	 * @param int             $no     numbers of vote no
	 * @param Twinmusic_Group $group  Object of the group implicated
	 * @param int             $id     Bid Id
	 * @param int             $userId User id of the bider
	 */
	static protected function _proceedCompute($admin, $ok, $no, $group, $id, $userId) {
		$db = Twindoo_Db::getDb ();
		$time = substr ( $id, 0, strlen ( time ( ) ) );
		$now = time ();
		$nbVoters = ( $ok  + $no ) + 1;
		if (($time + (60 * 60 * 24 * 7)) < $now || ($nbVoters) == count ( $group->getUserList () )) {
			//if bid is older than 7 days
			if ($admin == 1) {
				//$admin must be 1, 0 => said no, 2 => no answer
				if ($nbVoters >= ((count ( $group->getUserList () )) / 2)) {
					//most of members voted
					if ($ok + 1 > ($nbVoters / 2)) {
						//accepted
						$group->activateInGroup ( Array ($userId ) );
						$sql = "DELETE FROM DN_BID WHERE BID_ID = ?";
						$db->query ( $sql, $id );
						self::_sendAutomaticMpFromBid ( $userId, $group->getAdmin (), sprintf ( t_( "Bid for %s" ), $group->getNom () ), t_( "You have been accepted, welcome!" ) );
					} else if ( $ok  + 1 == ($nbVoters / 2)) {
						//no choice
						$group->removeFromGroup ( Array ($userId ) );
						$sql = "DELETE FROM DN_BID WHERE BID_ID = ?";
						$db->query ( $sql, $id );
						self::_sendAutomaticMpFromBid ( $userId, $group->getAdmin (), sprintf ( t_( "Bid for %s" ), $group->getNom () ), t_( "The group didn't make a choice between imparted time, please try again later..." ) );
					} else {
						//refused
						$group->removeFromGroup ( Array ($userId ) );
						$sql = "DELETE FROM DN_BID WHERE BID_ID = ?";
						$db->query ( $sql, $id );
						self::_sendAutomaticMpFromBid ( $userId, $group->getAdmin (), sprintf ( t_( "Bid for %s" ), $group->getNom () ), t_( "The group refused you, sorry..." ) );
					}
				} else {
					//no choice
					$group->removeFromGroup ( Array ($userId ) );
					$sql = "DELETE FROM DN_BID WHERE BID_ID = ?";
					$db->query ( $sql, $id );
					self::_sendAutomaticMpFromBid ( $userId, $group->getAdmin (), sprintf ( t_( "Bid for %s" ), $group->getNom () ), t_( "The group didn't make a choice between imparted time, please try again later..." ) );
				}
			} else {
				if ($admin == 2) {
					//no choice because of admin
					self::_sendAutomaticMpFromBid ( $userId, $group->getAdmin (), sprintf ( t_( "Bid for %s" ), $group->getNom () ), t_( "The group didn't make a choice between imparted time, please try again later..." ) );
				} else {
					//admin refused
					self::_sendAutomaticMpFromBid ( $userId, $group->getAdmin (), sprintf ( t_( "Bid for %s" ), $group->getNom () ), t_( "The group refused you, sorry..." ) );
				}
				$group->removeFromGroup ( Array ($userId ) );
				$sql = "DELETE FROM DN_BID WHERE BID_ID = ?";
				$db->query ( $sql, $id );
			}
		}
	}

	/**
	 * Send the MP to the concerned user
	 *
	 * @param int    $userId  User id of the concerned user
	 * @param int    $adminId User Id of the group admin
	 * @param string $title   Message Title
	 * @param string $body    Message Body
	 */
	static protected function _sendAutomaticMpFromBid($userId, $adminId, $title, $body) {
		$db = Twindoo_Db::getDb ();
		$sql = "INSERT INTO DN_MP SET ";
		$sql .= "MP_TITLE = ?,";
		$sql .= "MP_BODY = ?,";
		$sql .= "MP_DATE = ?,";
		$sql .= "MP_READ = '0',";
		$sql .= "USER_ID_SENDER = ?,";
		$sql .= "USER_ID_RECEIVER = ?";
		$values = Array ($title, $body, date ( "Y-m-d H:i:s" ), $adminId, $userId );
		$db->query ( $sql, $values );
	}
}
