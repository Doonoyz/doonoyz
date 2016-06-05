<?php
/**
 * Private Message Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_MpController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	
	/**
	 * Called From AjaxController
	 *
	 * Match the right id to the right action
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		$mp = new Twinmusic_Mp ( );
		switch ($_GET ['action']) {
			case 'read' :
				$mp->readMp ( $_GET ['id'] );
				break;
			case 'delete' :
				$mp->deleteMp ( $_GET ['id'] );
				break;
			case 'deleteAll' :
				$mp->deleteAllMp ();
				break;
		}
		$this->_setAnswer ( 'ok' );
	}
}
