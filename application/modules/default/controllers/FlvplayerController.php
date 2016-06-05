<?php
/**
 * FlvPlayer controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class FlvplayerController extends Zend_Controller_Action {
	/**
	 * No display for this controller
	 *
	 */
	public function init() {
		$this->getHelper ( 'viewRenderer' )->setNoRender ();
	}

	/**
	 * Prevent from direct access
	 *
	 */
	public function index() {
		$this->_redirect ( '/' );
	}

	/**
	 * Read the right composition if the user is able to
	 *
	 */
	public function streamAction() {
		$id = ( int ) $this->_getParam ( 'file' );
		$compo = new Twinmusic_Compo ( $id );
		$group = new Twinmusic_Group ( $compo->getGroupId () );
		if ( true ) {//$this->getRequest ()->isFlashRequest () ) {
			if ($compo->getId () && ((! $compo->isDeleted () && ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || $compo->isPublic ())) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () ))) {
				if (! $group->inGroup ( Twindoo_User::getCurrentUserId () ) && ! Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
					//if not in group and not admin (and not deleted and public)
					$compo->addView ();
					$compo->commit ();
				}
				$this->getResponse()->clearBody();
				
				$seekat = 0;
				if ($this->_getParam ('start')) {
					$position = $this->_getParam ('start');
					if (is_numeric ($position)) {
						$seekat = intval($position);
					}
					if ($seekat < 0) {
						$seekat = 0;
					}
				}

				$compo->stream($seekat);
			} else {
				$this->_redirect ( 'csrf', 'error', 'default' );
			}
		} else {
			$this->_redirect ( 'csrf', 'error', 'default' );
		}
	}

	/**
	 * download the right composition if the user is able to
	 *
	 */
	public function originalAction() {
		$id = ( int ) $this->_getParam ( 'id' );
		$compo = new Twinmusic_Compo ( $id );
		$group = new Twinmusic_Group ( $compo->getGroupId () );
		if ($compo->getId () && ((! $compo->isDeleted () && ($group->inGroup ( Twindoo_User::getCurrentUserId () ))) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () ))) {
			$this->getResponse()->clearBody();
			$compo->download();
		} else {
			$this->_redirect ( 'csrf', 'error', 'default' );
		}
	}
	/**
	 * Show the preview image of the composition is the user is able to
	 *
	 */
	public function previewAction() {
		/* @todo preview action */
	}
}
