<?php
/**
 * Vote Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_VoteController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	/**
	 * Called by AjaxController
	 *
	 * Note the composition
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);

		if (preg_match ( "/(.+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$note = new Twinmusic_Note ( $globb [2] );
			$return = ($note->setValue ( $_GET ['note'] )) ? 'ok' : 'error';
			$this->_setAnswer ( $return );
		} else {
			$this->_setAnswer ( 'error' );
		}
	}
}
