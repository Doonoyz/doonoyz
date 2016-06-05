<?php
/**
 * Ajax Bid Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_BidController extends Zend_Controller_Action {
	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	
	/**
	 * called by AjaxController
	 *
	 * Match the right ID to the right action
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		if (preg_match ( "/([^_]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			switch ($globb [1]) {
				case "accept" :
					Twinmusic_Bid::voteBid ( $globb [2], true );
					break;
				case "decline" :
					Twinmusic_Bid::voteBid ( $globb [2], false );
					break;
			}
			$this->_setAnswer ( t_( 'Your vote has been saved successfully!' ) );
			//$this->_view->clear_cache(null, 'user:'.$group->getUrl());
		} else {
			$this->_setAnswer ( 'error' );
		}
	}
}
