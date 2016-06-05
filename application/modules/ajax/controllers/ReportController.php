<?php
/**
 * Report Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_ReportController extends Zend_Controller_Action {

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
	public function run() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		if (preg_match ( "/(.+)_([0-9]+).*/", $_GET ['id'], $globb )) {
			switch ($globb [1]) {
				case "reportBlog" :
					$this->reportBlog ();
					break;
				case "reportMusic" :
					$this->reportMusic ();
					break;
				case "reportNews" :
					$this->reportNews ();
					break;
			}
			$this->_setAnswer ( 'ok' );
		} else {
			$this->_setAnswer ( 'error' );
		}
	}

	/**
	 * Report a blog
	 *
	 */
	private function reportBlog() {
		if (preg_match ( "/(.+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$group = new Twinmusic_Group ( $globb [2] );
			if ($group->getId ()) {
				$task = new Twinmusic_Admintask ( );
				$task->setMessage ( Twinmusic_Admintask::REPORTBLOG );
				$task->setMessageArgs ( $group->getNom () );
				$task->setComponentName ( 'group' );
				$task->setComponentId ( $group->getId () );
				$task->commit ();
			}
		}
	}

	/**
	 * Report a music
	 *
	 */
	private function reportMusic() {
		if (preg_match ( "/(.+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$compo = new Twinmusic_Compo ( $globb [2] );
			if ($compo->getId ()) {
				$task = new Twinmusic_Admintask ( );
				$task->setMessage ( Twinmusic_Admintask::REPORTCOMPO );
				$task->setMessageArgs ( $compo->getName () );
				$task->setComponentName ( 'compo' );
				$task->setComponentId ( $compo->getId () );
				$task->commit ();
			}
		}
	}

	/**
	 * Report a news
	 *
	 */
	private function reportNews() {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			//@todo send MP or MAIL Twindoo_User(Twindoo_User::getCurrentUserId()) signale que la news Twinmusic_News($globb[2])->getName du blog Twinmusic_Group($globb[2])->getUrl est a observer
		}
	}
}
