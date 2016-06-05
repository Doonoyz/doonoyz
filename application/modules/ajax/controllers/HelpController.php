<?php
/**
 * Help Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_HelpController extends Zend_Controller_Action {
	
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->setCacheKey('lang:'.Twindoo_User::getLocale());
	}
	/**
	 * Called by AjaxController
	 *
	 * dispatch requested action
	 *
	 */
	public function indexAction() {
		
		if ( isset ( $_GET ['action'] ) ) {
			switch ($_GET['action']) {
				case 'groupadmin' :
					$this->_groupAdmin ();
					break;
				case 'studio' :
					$this->_studio ();
					break;
			}
		}
		$this->view->message = t_('This help doesn\'t exist');
	}

	/**
	 * Display help for group
	 */
	private function _groupAdmin() {
		$this->view->messages = Twinmusic_Help::getMessages('GROUP', 'ADMIN');
	}
	
	/**
	 * Display help for studio
	 */
	private function _studio() {
		$this->view->messages = Twinmusic_Help::getMessages('STUDIO');
	}
}
