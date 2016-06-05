<?php
/**
 * Manage on group
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Group {
	/**
	 * Group id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Group Country
	 *
	 * @var string
	 */
	private $_pays = NULL;
	/**
	 * Group city
	 *
	 * @var string
	 */
	private $_lieu = NULL;
	/**
	 * Group Postal code
	 *
	 * @var string
	 */
	private $_postal = NULL;
	/**
	 * Group name
	 *
	 * @var string
	 */
	private $_nom = NULL;
	/**
	 * Group description
	 *
	 * @var string
	 */
	private $_description = NULL;
	/**
	 * Group Active state
	 *
	 * @var bool
	 */
	private $_active = 1;
	/**
	 * Group Censure
	 *
	 * @var int
	 */
	private $_censure = 0;
	/**
	 * Group is full
	 *
	 * @var bool
	 */
	private $_full = 0;
	/**
	 * Group Admin Id
	 *
	 * @var int
	 */
	private $_admin = 0;
	/**
	 * Group longitude point
	 *
	 * @var float
	 */
	private $_long = 0;
	/**
	 * Group latitude point
	 *
	 * @var float
	 */
	private $_lat = 0;
	/**
	 * Group Url
	 *
	 * @var string
	 */
	private $_url = '';
	
	/**
	 * Group Location Processed
	 *
	 * @var bool
	 */
	private $_locationProcessed = 0;
	/**
	 * Group Creation Date
	 *
	 * @var timestamp
	 */
	private $_creationDate = null;
	/**
	 * Group Delete Date
	 *
	 * @var timestamp
	 */
	private $_deleteDate = null;
	/**
	 * Group Label
	 *
	 * @var int
	 */
	private $_labelId = 0;
	
	/**
	 * Group Members list
	 *
	 * @var Array
	 */
	private $_userList = Array ();
	
	
	/**
	 * Constructor
	 *
	 * @param int $id Group ID
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_GROUP WHERE GROUP_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $result )) {
				$this->_id = $result [0] ['GROUP_ID'];
				$this->_pays = $result [0] ['GROUP_PAYS'];
				$this->_lieu = $result [0] ['GROUP_LIEU'];
				$this->_postal = $result [0] ['GROUP_POSTAL'];
				$this->_nom = $result [0] ['GROUP_NOM'];
				$this->_description = $result [0] ['GROUP_DESCRIPTION'];
				$this->_active = $result [0] ['GROUP_ACTIVE'];
				$this->_censure = $result [0] ['GROUP_CENSURE'];
				$this->_full = $result [0] ['GROUP_FULL'];
				$this->_admin = $result [0] ['GROUP_ADMIN'];
				$this->_long = $result [0] ['GROUP_LONG'];
				$this->_lat = $result [0] ['GROUP_LAT'];
				$this->_url = $result [0] ['GROUP_URL'];
				$this->_labelId = $result [0] ['LABEL_ID'];
				$this->_locationProcessed = $result [0] ['GROUP_LOCATION_PROCESSED'];
				$this->_creationDate = $result [0] ['GROUP_DATE_CREATION'];
				$this->_deleteDate = $result [0] ['GROUP_DATE_DELETE'];
				$this->refreshUserList ();
			}
		}
	}
	
	/**
	 * Get Group Id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	
	/**
	 * Get Country
	 *
	 * @return string
	 */
	public function getPays() {
		return ( $this->_pays);
	}
	/**
	 * Get City
	 *
	 * @return string
	 */
	public function getLieu() {
		return ( $this->_lieu );
	}
	/**
	 * Get Group Name
	 *
	 * @return string
	 */
	public function getNom() {
		return ( $this->_nom );
	}
	/**
	 * Get Postal code
	 *
	 * @return string
	 */
	public function getPostal() {
		return ( $this->_postal );
	}
	/**
	 * Get Group description
	 *
	 * @return string
	 */
	public function getDescription() {
		return ( $this->_description );
	}
	
	/**
	 * Get Group creation date
	 *
	 * @return timestamp
	 */
	public function getCreationDate() {
		return ( $this->_creationDate );
	}
	
	/**
	 * Get Group delete date
	 *
	 * @return timestamp
	 */
	public function getDeleteDate() {
		return ( $this->_deleteDate );
	}
	
	/**
	 * Check if group is active
	 *
	 * @return bool
	 */
	public function isActive() {
		return ($this->_active ? true : false);
	}
	/**
	 * Check if group location is processed
	 *
	 * @return bool
	 */
	public function isLocationProcessed() {
		return ($this->_locationProcessed ? true : false);
	}
	/**
	 * Get Group censure
	 *
	 * @return int
	 */
	public function getCensure() {
		return ($this->_censure);
	}
	/**
	 * Check if Group is full 
	 *
	 * @return bool
	 */
	public function isFull() {
		return ($this->_full ? true : false);
	}
	/**
	 * Get admin user Id
	 *
	 * @return int
	 */
	public function getAdmin() {
		return ($this->_admin);
	}
	/**
	 * Get label Id
	 *
	 * @return int
	 */
	public function getLabel() {
		return ($this->_labelId);
	}
	/**
	 * Get group longitude
	 *
	 * @return float
	 */
	public function getLong() {
		return ( $this->_long );
	}
	/**
	 * Get group latitude
	 *
	 * @return float
	 */
	public function getLat() {
		return ( $this->_lat );
	}
	/**
	 * Get group url
	 *
	 * @return string
	 */
	public function getUrl() {
		return ( $this->_url );
	}
	
	/**
	 * Set group country
	 *
	 * @param string $value group country
	 */
	public function setPays($value) {
		$this->_pays = strip_tags ( $value );
		$this->_lat = 0;
		$this->_long = 0;
		$this->_locationProcessed = 0;
	}
	/**
	 * Set group city
	 *
	 * @param string $value group city
	 */
	public function setLieu($value) {
		$this->_lieu = strip_tags ( $value );
		$this->_lat = 0;
		$this->_long = 0;
		$this->_locationProcessed = 0;
	}
	
	/**
	 * Set group postal code
	 *
	 * @param string $value postal code
	 */
	public function setPostal($value) {
		$this->_postal = strip_tags ( $value );
		$this->_lat = 0;
		$this->_long = 0;
		$this->_locationProcessed = 0;
	}
	
	/**
	 * Set group description
	 *
	 * @param string $value group description
	 */
	public function setDescription($value) {
		$this->_description = Twindoo_Utile::cleanHtml ( $value );
	}
	/**
	 * Set group longitude
	 *
	 * @param float $value Longitude
	 */
	public function setLong($value) {
		$this->_long = strip_tags ( $value );
	}
	/**
	 * Set group latitude
	 *
	 * @param float $value Latitude
	 */
	public function setLat($value) {
		$this->_lat = strip_tags ( $value );
	}
	/**
	 * Set group name
	 *
	 * @param string $value Group Name
	 */
	public function setNom($value) {
		$this->_nom = strip_tags ( $value );
	}
	/**
	 * Set group url
	 *
	 * @param string $value Group Url
	 * 
	 * @return bool Url is valid ?
	 */
	public function setUrl($value) {
		$config = Zend_Registry::getInstance ()->config;
		$security = $config->forbidden->groupname->toArray();
		if (! in_array ( $value, $security )) {
			if (preg_match ( '/^[a-zA-Z0-9_.-]+$/', $value )) {
				$db = Twindoo_Db::getDb ();
				$sql = "SELECT * FROM DN_GROUP WHERE GROUP_URL = ?";
				$result = $db->fetchAll ( $sql, Array ($value ) );
				if (! count ( $result )) {
					$this->_url = $value;
					return (true);
				} else
					return (false);
			} else {
				return (false);
			}
		} else {
			return (false);
		}
	}
	
	/**
	 * Set group Admin user id
	 *
	 * @param int $value Admin user id
	 */
	public function setAdmin($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_admin = $value;
	}
	/**
	 * Set group Label id
	 *
	 * @param int $value Label id
	 */
	public function setLabel($value = 0) {
		if (is_numeric ( $value ) && $value >= 0)
			$this->_labelId = $value;
	}
	/**
	 * Set group active state
	 *
	 * @param bool $value Group active state
	 */
	public function setActive($value = true) {
		$this->_active = $value ? 1 : 0;
	}
	/**
	 * Set group location processed state
	 *
	 * @param bool $value Group location processed state
	 */
	public function setLocationProcessed($value = true) {
		$this->_locationProcessed = $value ? 1 : 0;
	}
	
	/**
	 * Set group censure
	 *
	 * @param int $value Censure age
	 */
	public function setCensure($value) {
		$security = Array (0, 10, 12, 16, 18, 21 );
		if (in_array ( $value, $security ))
			$this->_censure = $value;
	}
	/**
	 * Set group full state
	 *
	 * @param bool $value Group full state 
	 */
	public function setFull($value = true) {
		$this->_full = $value ? 1 : 0;
	}
	
	/**
	 * Save group updates
	 *
	 */
	public function commit() {
		$db = Twindoo_Db::getDb ();
		if ($this->_id == 0) {
			$this->_creationDate = date ( "Y-m-d H:i:s" );
		}
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_GROUP SET ";
		$sql .= "GROUP_PAYS = ?, ";
		$sql .= "GROUP_LIEU = ?, ";
		$sql .= "GROUP_POSTAL = ?, ";
		$sql .= "GROUP_NOM = ?, ";
		$sql .= "GROUP_DESCRIPTION = ?, ";
		$sql .= "GROUP_ACTIVE = ?, ";
		$sql .= "GROUP_CENSURE = ?, ";
		$sql .= "GROUP_FULL = ?, ";
		$sql .= "GROUP_ADMIN = ?, ";
		$sql .= "GROUP_LONG = ?, ";
		$sql .= "GROUP_LAT = ?, ";
		$sql .= "GROUP_LOCATION_PROCESSED = ?, ";
		$sql .= "GROUP_DATE_CREATION = ?, ";
		$sql .= "GROUP_DATE_DELETE = ?, ";
		$sql .= "LABEL_ID = ?, ";
		$sql .= "GROUP_URL = ?";
		if ($this->_id != 0)
			$sql .= " WHERE GROUP_ID = ?";
		
		$values = Array ($this->_pays, $this->_lieu, $this->_postal, $this->_nom, $this->_description, $this->_active, $this->_censure, $this->_full, $this->_admin, $this->_long, $this->_lat, $this->_locationProcessed, $this->_creationDate, $this->_deleteDate, $this->_labelId, $this->_url );
		
		if ($this->_id != 0)
			$values [] = $this->_id;
		
		$db->query ( $sql, $values );
		if ($this->_id == 0)
			$this->_id = $db->lastInsertId ();
	}
	
	/**
	 * Get group members list
	 *
	 * @return Array Array containing members user id
	 */
	public function getUserList() {
		$res = $this->_userList;
		foreach ( $res as $k => $line ) {
			if ($line ['BID_ID'] != 0) {
				unset ( $res [$k] );
			}
		}
		return ($res);
	}
	
	/**
	 * Check if user id is in group
	 *
	 * @param int  $item      User id
	 * @param bool $activated User is validated
	 * 
	 * @return bool User is in group
	 */
	public function inGroup($item, $activated = true) {
		$bool = false;
		if (is_array ( $this->_userList )) {
			foreach ( $this->_userList as $line ) {
				if ($item == $line ['USER_ID']) {
					$bool = true;
					if ($activated) {
						if ($line ['INGROUP_ACTIVE'] == 0) {
							$bool = false;
						}
					}
				}
			}
		}
		return ($bool);
	}
	
	/**
	 * Add user to group
	 *
	 * @param Array $array Array of users to add in group
	 */
	public function addToGroup($array) {
		$db = Twindoo_Db::getDb ();
		foreach ( $array as $item ) {
			if (! $this->inGroup ( $item, false ) && is_numeric ( $item ) && $item > 0) {
				$sql = "INSERT INTO DN_USERINGROUP SET GROUP_ID = ?, USER_ID = ?, INGROUP_ACTIVE = ?, BID_ID = ?, USER_NAME = ?";
				$usernames = Twindoo_User::getInfos ( Array ($item ) );
				$values = Array ($this->_id, $item, '0', '0', $usernames [$item] );
				try {
					$db->query ( $sql, $values );
				} catch ( Exception $e ) {
					throw new Exception ( $e->getMessage () );
				}
				$this->refreshUserList ();
			}
		}
	}
	/**
	 * Activate users in group
	 *
	 * @param Array $array Array of all users to activate in this group
	 */
	public function activateInGroup($array) {
		$db = Twindoo_Db::getDb ();
		foreach ( $array as $item ) {
			if ($this->inGroup ( $item, false )) {
				$sql = "UPDATE DN_USERINGROUP SET INGROUP_ACTIVE = ?, BID_ID = ? WHERE GROUP_ID = ? AND USER_ID = ?";
				$values = Array ('1', '0', $this->_id, $item );
				$db->query ( $sql, $values );
				$this->refreshUserList ();
			}
		}
	}
	
	/**
	 * Refresh group members list
	 *
	 */
	private function refreshUserList() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_USERINGROUP WHERE GROUP_ID = ?";
		$res = $db->fetchAll ( $sql, Array ($this->_id ) );
		foreach ( $res as $k => $info ) {
			$this->_userList [$info ['USER_ID']] = $res [$k];
		}
	}
	
	/**
	 * Remove members from group
	 *
	 * @param array $array Array of user id to remove from group
	 */
	public function removeFromGroup($array) {
		$db = Twindoo_Db::getDb ();
		foreach ( $array as $item ) {
			if ($this->inGroup ( $item, false ) && $item != $this->_admin) {
				$sql = "DELETE FROM DN_USERINGROUP WHERE GROUP_ID = ? AND USER_ID = ?";
				$values = Array ($this->_id, $item );
				$db->query ( $sql, $values );
				$this->refreshUserList ();
			}
		}
	}
	
	/**
	 * Get average note of all compositions notes
	 *
	 * @return Array Array containing informations
	 */
	public function getAverage() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_NOTE n, DN_COMPO c WHERE n.COMPO_ID = c.COMPO_ID AND GROUP_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($this->_id ) );
			if (count ( $result )) {
				$count = 0;
				foreach ( $result as $res ) {
					$count += $res ['NOTE_VALUE'];
				}
				return (Array ($count / count ( $result ), count ( $result ) ));
			} else
				return (Array (0, 0 ));
		}
		return (Array (0, 0 ));
	}
	
	/**
	 * Retrieve all informations aboute composition notes
	 *
	 * @return Array Array containing informations
	 */
	public function getAllNotes() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_NOTE n, DN_COMPO c WHERE n.COMPO_ID = c.COMPO_ID AND GROUP_ID = ? ORDER BY c.COMPO_ID asc";
			$result = $db->fetchAll ( $sql, Array ($this->_id ) );
			$notes = $this->_arrangeNotes ( $result );
			$return = Array ();
			foreach ( $notes as $id => $notes ) {
				$return [$id] ['average'] = 0;
				foreach ( $notes as $value ) {
					$return [$id] ['average'] += $value;
				}
				$return [$id] ['average'] /= count ( $notes ) * 2; // * 2 because note is shown on 5 stars
				$return [$id] ['nbvote'] = count ( $notes );
				$return [$id] ['line'] = sprintf ( t_( "(%s / %s on %s votes)" ), $return [$id] ['average'], 5, $return [$id] ['nbvote'] );
			}
			return ($return);
		}
		return (Array ());
	}
	
	/**
	 * Rearrange notes for composition ID
	 *
	 * @param Array $result Return of SQL Request
	 * 
	 * @return Array Array containing informations 
	 */
	private function _arrangeNotes($result) {
		$return = Array ();
		foreach ( $result as $line ) {
			$return [$line ['COMPO_ID']] [] = $line ['NOTE_VALUE'];
		}
		return ($return);
	}
	
	/**
	 * Get recent groups
	 *
	 * @param int $limit Number of result
	 * 
	 * @return Array Array containing informations
	 */
	static public function getRecentGroups($limit = 3) {
		if (is_numeric ( $limit ) && $limit > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = Twinmusic_Search_Engine::ENGINE_SQL . " order by g.GROUP_ID DESC";
			$result = $db->fetchAll ( $sql ); 
			$result = Twinmusic_Search_Engine::prepareResults($result);
			$return = array();
			for ($i = 0; $i < $limit; $i++) {
				$return [] = array_shift($result);
			}
			return ($return);
		} else
			return (Array ());
	}
	
	/**
	 * Get most appreciated groups
	 *
	 * @return Array Array containing informations
	 */
	static public function getMostAppreciated() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_MOSTAPPRECIATED ma ORDER BY MA_ORDER";
		$list = $db->fetchAll ( $sql );
		$values = array();
		$question = array();
		foreach ($list as $line) {
			$values[] = $line['GROUP_ID'];
			$question[] = '?';
		}
		if (!count($values)) {
			$values[] = 0;
			$question[] = "?";
		}
		$sql = Twinmusic_Search_Engine::ENGINE_SQL . " AND g.GROUP_ID IN (" . implode(',', $question) . ")";
		$return = $db->fetchAll ( $sql , $values );
		$result = Twinmusic_Search_Engine::prepareResults($return);
		$finalReturn = array();
		foreach ($list as $line) {
			foreach ($result as $key => $resline) {
				if ($resline['GROUP_ID'] == $line [ 'GROUP_ID' ]) {
					$finalReturn [ $line [ 'GROUP_ID' ] ] = $result [ $key ];
				}
			}
		}
		return ($finalReturn);
	}
	
	/**
	 * Set most appreciated groups
	 *
	 * @param array $mostAp Array of Group Id
	 */
	static public function setMostAppreciated($mostAp) {
		$db = Twindoo_Db::getDb ();
		$db->beginTransaction();
		try {
			$sql = "DELETE FROM DN_MOSTAPPRECIATED";
			$db->query($sql);
			if (is_array($mostAp)) {
				$order = 0;
				$alreadyInserted = array();
				foreach ($mostAp as $groupId) {
					if (!in_array($groupId, $alreadyInserted)) {
						$sql = 'INSERT INTO DN_MOSTAPPRECIATED SET GROUP_ID = ?, MA_ORDER = ?';
						$db->query($sql, array($groupId, $order));
						$order++;
						$alreadyInserted[] = $groupId;
					}
				}
			}
			$db->commit();
		} catch (Exception $e) {
			$db->rollBack();
		}
	}
	
	/**
	 * Get Group by its url
	 *
	 * @param string $url Url of the group
	 * 
	 * @return Twinmusic_Group Group instance
	 */
	static public function getGroupByUrl($url) {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_GROUP WHERE GROUP_URL = ? AND GROUP_ACTIVE = 1";
		$result = $db->fetchAll ( $sql, Array ($url ) );
		return (count ( $result ) ? new Twinmusic_Group ( $result [0] ['GROUP_ID'] ) : new Twinmusic_Group ( ));
	}
	
	/**
	 * Get competencies for each user
	 *
	 * @return Array Array containing informations
	 */
	public function getCompetencies() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_GROUPCOMP gc, DN_COMPETENCE c WHERE gc.COMPETENCE_ID = c.COMPETENCE_ID AND COMPETENCE_ACTIVE = '1' AND gc.GROUP_ID = ?";
		$result = $db->fetchAll ( $sql, array ($this->_id ) );
		$return = Array ();
		if (count ( $result )) {
			foreach ( $result as $line ) {
				$return [$line ['USER_ID']] [$line ['COMPETENCE_ID']] = $line ['COMPETENCE_NAME'];
			}
		}
		return ($return);
	}
	/**
	 * Get group styles
	 *
	 * @return Array Array containing informations
	 */
	public function getGroupStyles() {
		$db = Twindoo_Db::getDb ();
		$sql = "SELECT * FROM DN_GROUPSTYLE gs, DN_STYLEMUSIC sm WHERE gs.STYLE_ID = sm.STYLE_ID AND GROUP_ID = ? AND STYLE_ACTIVE = '1'";
		$result = $db->fetchAll ( $sql, array ($this->_id ) );
		$return = Array ();
		if (count ( $result )) {
			foreach ( $result as $line ) {
				$return [$line ['STYLE_ID']] = $line ['STYLE_NAME'];
			}
		}
		return ($return);
	}
	
	/**
	 * Get group contacts
	 *
	 * @return Array Array containing informations
	 */
	public function getContacts() {
		$db = Twindoo_Db::getDb ();
		$result = Twinmusic_Contact::getGroupContacts($this->_id );
		$return = Array ();
		if (count ( $result )) {
			$i = 0;
			foreach ( $result as $line ) {
				$return [$i] ['value'] = $line ['CONTACT_VALUE'];
				$return [$i] ['logo'] = $line ['CONTACTTYPE_LOGO'];
				$return [$i] ['type'] = $line ['CONTACTTYPE_NAME'];
				$return [$i] ['id'] = $line ['CONTACT_ID'];
				$i ++;
			}
		}
		return ($return);
	}
	
	/**
	 * Bid to group
	 *
	 * @param int $id User id that bid to group
	 */
	public function bidToGroup($id) {
		if (! $this->_full) {
			$db = Twindoo_Db::getDb ();
			if (! $this->inGroup ( $id, false ) && is_numeric ( $id ) && $id > 0) {
				$sql = "INSERT INTO DN_USERINGROUP SET GROUP_ID = ?, USER_ID = ?, INGROUP_ACTIVE = ?, BID_ID = ?, USER_NAME = ?";
				$usernames = Twindoo_User::getInfos ( Array ( $id ) );
				$values = Array ($this->_id, $id, '0', time () . rand ( 0, 99 ), $usernames [$id] );
				$db->query ( $sql, $values );
				$this->refreshUserList ();
			}
		}
	}
	
	/**
	 * Retrieve all groups current user is admin
	 *
	 * @return Array Array containing informations
	 */
	static public function getManagingGroups() {
		$userId = Twindoo_User::getCurrentUserId ();
		if ($userId) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_GROUP g WHERE g.GROUP_ADMIN = ?";
			$results = $db->fetchAll ( $sql, Array ($userId ) );
			$cleaned = Array ();
			foreach ( $results as $line ) {
				$cleaned [$line ['GROUP_ID']] ['GROUP_ID'] = $line ['GROUP_ID'];
				$cleaned [$line ['GROUP_ID']] ['GROUP_NOM'] = $line ['GROUP_NOM'];
				$cleaned [$line ['GROUP_ID']] ['GROUP_URL'] = $line ['GROUP_URL'];
			}
			return ($cleaned);
		} else
			return (Array ());
	}
	
	/**
	 * Rename a user in the group
	 *
	 * @param int    $user User id of the member to rename
	 * @param string $name New name of the user
	 */
	public function renameInGroup($user, $name) {
		$db = Twindoo_Db::getDb();
		$name = trim ( strip_tags ( $name ) );
		if ($name == "") {
			$usernames = Twindoo_User::getInfos ( Array ( $user ) );
			$name = $usernames [$id];
		}
		if ( $this->inGroup ( $user, false) && is_numeric ( $user) && $user > 0) {
			$sql = "UPDATE DN_USERINGROUP SET USER_NAME = ? WHERE GROUP_ID = ? AND USER_ID = ?";
			$values = Array ($name, $this->_id, $user);
			$db->query ( $sql, $values );
			$this->refreshUserList ();
		}
	}
	
	/**
	 * Retrieve groups active or not sorted by url
	 *
	 * @param bool $active Active state, null to be ignored
	 *
	 * @return Array Array containing groups informations
	 */
	static public function getAllGroups($active = null) {
		$values = array();
		$sql = "SELECT * FROM DN_GROUP ";
		
		if ($active != null) {
			$active = $active ? '1' : '0';
			$sql .= " WHERE GROUP_ACTIVE = ?";
			$values[] = $active;
		}
		
		$sql .= " ORDER BY GROUP_URL ASC";
		
		$db = Twindoo_Db::getDb();
		$return = $db->fetchAll($sql, $values);
		return ($return);
	}
	
	/**
	 * Delete the group
	 */
	public function delete() {
		$this->_deleteDate = date ( "Y-m-d H:i:s" );
		$this->setActive(false);
	}
}
