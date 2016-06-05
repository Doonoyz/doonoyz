<?php
/**
 * Advanced Search engine
 *
 * @package    Doonoyz
 * @subpackage library/search
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Engine {
	/**
	 * Results returned by the search engine
	 *
	 * @var Array
	 */
	private $_results = Array ();
	/**
	 * Filter list
	 *
	 * @var array
	 */
	private $_filterList = Array ();
	/**
	 * Engine SQL Query
	 *
	 */
	CONST ENGINE_SQL = "SELECT *
			FROM DN_USERINGROUP uig
			RIGHT JOIN DN_GROUP g
				ON uig.GROUP_ID = g.GROUP_ID 
				AND uig.INGROUP_ACTIVE = 1
			LEFT JOIN DN_GROUPSTYLE gs
				ON gs.GROUP_ID = g.GROUP_ID
			LEFT JOIN DN_STYLEMUSIC sm
				ON sm.STYLE_ID = gs.STYLE_ID
				AND sm.STYLE_ACTIVE = 1
			LEFT JOIN DN_GROUPCOMP gc
				ON gc.GROUP_ID = uig.GROUP_ID
				AND uig.USER_ID = gc.USER_ID
			LEFT JOIN DN_COMPETENCE c
				ON gc.COMPETENCE_ID = c.COMPETENCE_ID
				AND c.COMPETENCE_ACTIVE = 1
			LEFT JOIN DN_LABEL l
				ON g.LABEL_ID = l.LABEL_ID
				AND l.LABEL_ACTIVE = 1
			WHERE 
				g.GROUP_ACTIVE = 1";

	/**
	 * Add a filter to the search engine
	 *
	 * @param Twinmusic_Search_Filter $filter Filter to add
	 */
	public function addFilter(Twinmusic_Search_Filter $filter) {
		$this->_filterList [] = $filter;
	}

	/**
	 * Init the search engine by preparing all the results of the DB
	 * 
	 * @uses Zend_Cache
	 *
	 * @return array All the results
	 */
	static public function initEngine() {
		$registry = Zend_Registry::getInstance ();
		$cache = $registry->get ( 'cache' );

		if (! $final = $cache->load ( 'searchEngine' )) {
			$sql = self::ENGINE_SQL;
			$db = Twindoo_Db::getDb ();
			$result = $db->fetchAll ( $sql );
			$final = self::prepareResults ( $result );
			$cache->save ( $final, 'searchEngine' );
		}
		return ($final);
	}

	/**
	 * Process all the filters added
	 *
	 * @param array $result Results to filter
	 * 
	 * @return array Results filtered
	 */
	private function _engineFilter($result) {
		foreach ( $this->_filterList as $filter ) {
			$result = $filter->run ( $result );
		}
		return ($result);
	}

	/**
	 * Start the engine
	 *
	 */
	public function run() {
		$resultCriteria = $this->initEngine ();
		$this->filterResults ( $resultCriteria );
	}

	/**
	 * Save the results filtered
	 *
	 * @param Array $results Results to be filtered
	 */
	public function filterResults($results) {
        $session = new Zend_Session_Namespace('Twinmusic_Search');
		$session->searchResult = $this->_engineFilter ( $results );
	}

	/**
	 * Engine for formatting results
	 *
	 * @param Array $result Results returned by ENGINE_SQL
	 * 
	 * @return Array Right formatted results
	 */
	static public function prepareResults($result) {
		$groups = Array ();
		$users = Array ();
		$styles = Array ();
		$competencies = Array ();
		foreach ( $result as $infos ) {
			$groups [$infos ['GROUP_ID']] = $infos;
			if ($infos ['USER_ID']) {
				$users [$infos ['GROUP_ID']] [$infos ['USER_ID']] = $infos;
			}
			if ($infos ['COMPETENCE_ID']) {
				$competencies [$infos ['USER_ID']] [$infos ['COMPETENCE_ID']] = $infos;
			}
			if ($infos ['STYLE_ID']) {
				$styles [$infos ['GROUP_ID']] [$infos ['STYLE_ID']] = $infos;
			}
		}

		$final = Array ();
		$i = 0;
		foreach ( $groups as $key => $info ) {
			$final [$i] = $info;
			$final [$i] ['USERS'] = Array ();
			if (isset ( $users [$key] )) {
				$final [$i] ['USERS'] = $users [$key];
				foreach ( $users [$key] as $userId => $val ) {
					$final [$i] ['USERS'] [$userId] ['COMPETENCIES'] = Array ();
					if (isset ( $competencies [$userId] )) {
						$final [$i] ['USERS'] [$userId] ['COMPETENCIES'] = $competencies [$userId];
					}
				}
			}
			$final [$i] ['STYLES'] = Array ();
			if (isset ( $styles [$key] )) {
				$final [$i] ['STYLES'] = $styles [$key];
			}
			$i ++;
		}

		return ($final);
	}
}
