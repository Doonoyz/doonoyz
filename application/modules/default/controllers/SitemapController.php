<?php
/**
 * Sitemap controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class SitemapController extends Zend_Controller_Action {
	/**
	 * Init sitemap layout
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'sitemap' );
	}

	/**
	 * Create the sitemap with groups url
	 *
	 */
	public function indexAction() {
		$engine = new Twinmusic_Search_Engine ( );
		$this->view->results = $engine->initEngine ();
	}
}
