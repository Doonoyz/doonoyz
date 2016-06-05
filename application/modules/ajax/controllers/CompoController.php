<?php
/**
 * Composition Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_CompoController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	
	/**
	 * Called by AjaxController
	 *
	 * Match the right id to the right action
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		$compo = new Twinmusic_Compo ( $_GET ['compoId'] );
		$group = new Twinmusic_Group ( $compo->getGroupId () );
		if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			switch ($_GET ['action']) {
				case 'rename' :
					$compo->setName ( $_GET ['name'] );
					$compo->commit ();
					break;
				case 'delete' :
					$compo->delete ();
					break;
				case 'status' :
					$compo->setPublic ( ($_GET ['status'] == "public") ? true : false );
					$compo->commit ();
					break;
			}
			$this->_setAnswer ( 'ok' );
		} else {
			$this->_setAnswer ( 'error' );
		}
	}
}
