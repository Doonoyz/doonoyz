<?php

/**
 * Search Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class SearchController extends Zend_Controller_Action {

	/**
	 * Init layout
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Search" ) );
		$this->view->setCacheLife(0);
	}

	/**
	 * Redirect the direct acces to the advanced search
	 *
	 */
	public function indexAction() {
		$this->_redirect ( '/search/advanced' );
	}
	
	/**
	 * Start quick search engine and display result first page
	 */
	public function quicksearchAction() {
		$criteria = $this->_getParam ('criteria');
		$criteria = Zend_Filter::get($criteria, 'BaseName');
		$criteria = urlencode($criteria);
		$this->_redirect('/search/quick/criteria/' . $criteria . '/page/1');
	}
	
	/**
	 * SEO, Can pass criteria and Page to display with advanced search within
	 */
	public function quickAction() {
		$this->getHelper ( 'viewRenderer' )->setNoRender ();
		$engine = new Twinmusic_Search_Quicksearch ( );
		$engine->setCriteria ( $this->_getParam ('criteria') );
		$engine->prepareResult ();
		
		$page = abs((int) $this->_getParam ('page'));
		$page = $page ? $page : 1;
		
		
		$this->_forward('advanced', 'search', null, Array('page' => $page));
	}

	/**
	 * Start Advanced search engine and display result first page
	 *
	 */
	public function advancedpostAction() {
		$this->getHelper ( 'viewRenderer' )->setNoRender ();
		
		$filters = $this->_request->getPost( 'filter' );
		$filterSaved = Array ();
		if ( is_array ( $filters ) ) {
			foreach ( $filters as $filterId => $infos ) {
				foreach ( $infos as $filterType => $all ) {
					try {
						$not = isset ( $all ['NOT'] ) ? $all ['NOT'] : false;
						$value = isset ( $all ['VALUE'] ) ? $all ['VALUE'] : '';
						$special = isset ( $all ['SPECIAL'] ) ? $all ['SPECIAL'] : Array ();

						$myFilter = Twinmusic_Search_Filter::factory ( $filterType );
						$myFilter->setNot ( $not );
						$myFilter->setValue ( $value );
						$myFilter->setSpecial ( $special );
						$filterSaved [] = $myFilter;
					} catch ( Exception $e ) {
					}
				}
			}
		}

		$engine = new Twinmusic_Search_Engine ( );
		foreach ( $filterSaved as $filter ) {
			$engine->addFilter ( $filter );
		}
		$engine->run ();
		
		$session = new Zend_Session_Namespace('Twinmusic_Search');
		$session->presetEngine = $this->_request->getPost('presetEngine');
		$session->presetEngineValues = $this->_request->getPost('presetEngineValues');
		$this->_redirect('/search/advanced/page/1');
	}

	/**
	 * Display select page Search Result
	 *
	 */
	protected function _showResult($page) {
		$translate = new Twinmusic_Localized ( );
		$page = ( int ) $page;
		$session = new Zend_Session_Namespace('Twinmusic_Search');
		$pagine = Zend_Paginator::factory((array) $session->searchResult);
		$pagine->setItemCountPerPage(5);
		$pagine->setCurrentPageNumber($page);
		
		$this->view->setView('advanced');
		$this->getHelper ( 'viewRenderer' )->setNoRender (false);
		$this->view->translate = $translate;
		$this->view->nbFound = sprintf(t_('%s result(s) found!'), count($session->searchResult));
		$this->view->results = $pagine->getCurrentItems ();
		$this->view->page = $pagine->getCurrentPageNumber ();
		$this->view->totalPage = $pagine->count ();
		$this->view->noResult = t_('No result was found!');
		$this->view->musicalStyles = t_('Musical Styles');
		$this->view->members = t_('Members');
		$this->view->label = t_('Label');
		$this->view->presetEngine = $session->presetEngine;
		$this->view->presetEngineValues = $session->presetEngineValues;
	}

	/**
	 * Display Advanced Search interface
	 *
	 */
	public function advancedAction() {
		$page = abs((int) $this->_getParam ('page'));
		
		$this->view->competenceList = Twinmusic_Competence::getList ();
		$this->view->styleList = Twinmusic_Groupstyle::getList ();
		$this->view->labelList = Twinmusic_Label::getList ();
		
		$this->view->submit = t_("Submit");
		$this->view->noResult = t_('No result was found !');
		$this->view->musicalStyles = t_('Musical Styles');
		$this->view->delete = t_('Delete Criteria');
		$this->view->toggleAdvanced = t_('Toggle search engine display');
		$this->view->translate = new Twinmusic_Localized ( );
		$this->view->hideEngine = ($page) ? true : false;
		
		$page = $page ? $page : 1;
		try {
			$infos = Twindoo_LocationService::getIpInfos();
			$this->view->persoCountry = $infos['COUNTRY'];
			$this->view->persoCity = $infos['CITY'];
			$this->view->persoPostal = isset($infos['ZIPCODE']) ? $infos['ZIPCODE'] : '';
		} catch (Exception $e) {
		}
		
		$this->_defineKeywords ();
		$this->_defineFilters ();
		
		$this->_showResult($page);
	}
	
	/**
	 * Define filters name selectable in advanced search
	 *
	 */
	public function _defineFilters() {
		$this->view->selectFilter = t_('Select a filter');
		$this->view->addFilter = t_('Add this filter');
		
		$this->view->groupFilter = t_('Filter groups/users');
		$this->view->groupNameFilter = t_('Filter name');
		$this->view->competenceFilter = t_('Filter skill/ability');
		$this->view->styleFilter = t_('Filter style');
		$this->view->groupDescFilter = t_('Filter description');
		$this->view->groupFullFilter = t_('Filter full groups');
		$this->view->groupPaysFilter = t_('Filter country');
		$this->view->groupVilleFilter = t_('Filter city');
		$this->view->groupUrlFilter = t_('Filter URL');
		$this->view->distanceFilter = t_('Filter distance');
		$this->view->labelFilter = t_('Filter label');
	}                                  
	
	/**
	 * Define keywords for advanced search
	 *
	 */
	private function _defineKeywords() {	
		$this->view->isa = t_('Is a');
		$this->view->group = t_('group');
		$this->view->user = t_('user');
		
		$this->view->name = t_('Name');
		$this->view->like = t_('looks like');
		$this->view->notLike = t_('doesn\'t look like');
		
		$this->view->contain = t_("Contains");
		$this->view->notContain = t_("Doesn't contain");
		$this->view->competence = t_("the skill/ability");
		
		$this->view->style = t_("the musical style");
		
		$this->view->description = t_("Description");
		
		$this->view->is = t_("Is");
		$this->view->isNot = t_("Is not");
		$this->view->full = t_("full");
		
		$this->view->country = t_("The country");
		
		$this->view->url = t_("The URL");
		
		$this->view->city = t_("The city");
		
		$this->view->located = t_("Is located at a distance");
		$this->view->lessOrEqual = t_("less than or equal to");
		$this->view->more = t_("greater than");
		$this->view->kmForCity = t_("Km from the city");
		$this->view->wichPostal = t_("wich zip code is (optionnal)");
		$this->view->inCountry = t_("in the country");
		
		$this->view->label = t_("the label");
		$this->view->noLabel = t_('No label');
	}
}
