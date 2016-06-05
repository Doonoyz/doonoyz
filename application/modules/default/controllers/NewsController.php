<?php
/**
 * News controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class NewsController extends Zend_Controller_Action {

	/**
	 * Prepare RSS
	 *
	 */
	public function init() {
		$this->view->setCacheLife ( 0 );
		$this->view->setLayout ( 'rss' );
	}

	/**
	 * Prevent direct access
	 *
	 */
	public function indexAction() {
		$this->_redirect ( "/" );
	}

	/**
	 * Display RSS for selected group
	 *
	 */
	public function showAction() {
		$username = $this->_getParam ( 'username' );
		$group = Twinmusic_Group::getGroupByUrl ( $username );
		if ($group->getId () != 0) {
			$this->view->setCacheLife ( 0 );
		} else {
			$this->_redirect ( "/" );
		}
	}
}
