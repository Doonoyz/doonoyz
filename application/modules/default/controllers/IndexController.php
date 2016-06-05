<?php
/**
 * Index Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class IndexController extends Zend_Controller_Action {

	/**
	 * Init the home page
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Home" ) );
	}

	/**
	 * Display the home page
	 *
	 */
	public function indexAction() {
		$cacheKey = Twindoo_User::getLocale();
		$this->view->newUsers = Twinmusic_Group::getRecentGroups();
		$this->view->translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );
		$this->view->setCacheKey ( $cacheKey ); //save cache for this locale
		if (! $this->view->isCached ( $cacheKey )) {
			$keywords = array(t_('meeting'),
				t_('friends'),
				t_('listen'),
				t_('music'),
				t_('free'),
				t_('artists'),
				t_('exclusivity'),
				t_('clips'),
				t_('videos'),
				t_('fan'),
				t_('lyrics'),
				t_('discover'),
				t_('network'),
				t_('social'),
				t_('group'),
				t_('concert'),
				t_('composition'),
				t_('creation'),
				t_('band')
			);
			$this->view->addLayoutVar('keywords', implode(', ', $keywords));
			//check if the template is already generated for this locale to avoid multiple sql connection
			$this->view->presentation = t_( 'Presentation' );
			$this->view->textPresentation = Array(
				'<b>' . t_('Welcome, dear Doonoyzian!') . '</b>',
				t_('Whether you are amateur, professional or just curious, if you want to create a group with a Polish singer, an Australian drummer, a French guitarist or even a Peruvian saxophonist, this site is dedicated to you.'),
				t_('Whether you are a mixer, whether you are a musician, singer or even in possession of an incongruous instrument, this site dedicated to you.'),
				t_('If you just want to discover groups and artists who are in your area or elsewhere, if you want to have a good time, if you\'re wondering what you doing there, if you are fan of peanuts, or if you have not yet understood, this site is dedicated to you.'),
				t_('Doonoyz is there for you to create groups of virtual or real music online. Form your group, compose, record, arrange and broadcast in one place!'),
				t_('You like it? You want more? So, go quickly discover your site! Yes go!'),
			);
			$this->view->mostAppreciated = t_( 'Most Appreciated' );
			$this->view->newcommers = t_( 'Newcomers' );
			$this->view->bestUser = Twinmusic_Group::getMostAppreciated();
			$this->view->setCacheLife ( 60 * 60 * 24 * 7); //set 1 day caching
		}
	}
}
