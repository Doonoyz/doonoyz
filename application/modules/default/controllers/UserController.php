<?php
/**
 * User Blog / Group Blog Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class UserController extends Zend_Controller_Action {

	/**
	 * Init layout
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
	}

	/**
	 * Prevent direct acces by redirecting to search engine
	 *
	 */
	public function indexAction() {
		$this->_redirect ( "/search" );
	}

	/**
	 * Display selected blog or redirects to search engine if not exists
	 *
	 */
	public function blogAction() {
		$this->view->setView('blog');
		$username = strtolower ( $this->_getParam ( 'username' ) );
		$group = Twinmusic_Group::getGroupByUrl ( $username );
		$this->view->addLayoutVar ( 'title', $group->getNom () );
		if ( $group->getId () != 0 ) {
			if ( $group->getCensure ( ) && !isset ( $_COOKIE ['censor'] [$group->getId ()] ) ) {
				$this->_displayCensure ( $group );
				return;
			}
			
			if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				$grouptype = 'admin';
			} else if ($group->inGroup ( Twindoo_User::getCurrentUserId () )) {
				$grouptype = 'group';
			} else {
				$grouptype = 'user';
			}

			$cacheKey = 'user:' . $group->getUrl () . '|usertype:blog' . $grouptype . '|locale:' . Twindoo_User::getLocale(); //if we want to clear cache for a username for all languages, do $this->view->clearCache('user:'.$username);
			$this->view->setCacheKey ( $cacheKey ); //in order to generate the template for this user (will avoid to reload informations about him)
			
			$comment = new Twinmusic_Comment ( );
			$average = $group->getAverage ();
			
			$this->view->nbComment = count ( $comment->getAllForType ($group->getId(), 'blog') );
			$this->view->comments = t_( "Comments" );
			$this->view->showNoteText = sprintf ( t_( "(%s votes)" ), $average [1] );
			$this->view->average = $average [0] / 2;
			$this->view->grouptype = $grouptype;
			
			$this->view->setCacheKey($cacheKey);
			if (! $this->view->isCached ( $cacheKey )) {
				//check if the template is already generated for this user with this language on this template...
				
				$memberList = $group->getUserList ();
				$cleanedMemberList = Array ();
				foreach ( $memberList as $value ) {
					$cleanedMemberList [] = $value ['USER_ID'];
				}
				$memberNumber = count ( $memberList );
				$competences = $group->getCompetencies ();
				$folders = new Twinmusic_Folder ( );
				$grouplabel = new Twinmusic_Label($group->getLabel());
				$news = new Twinmusic_News ( );
				$admin = new Twindoo_User ( $group->getAdmin () );
				$translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );

				$this->view->emptyText = t_( "(empty)" );
				
				$this->view->name = strlen ( $group->getNom () ) ? $group->getNom () : $this->view->emptyText;
				$this->view->lieu = strlen ( $group->getLieu () ) ? $group->getLieu () : $this->view->emptyText;
				$this->view->postal = strlen ( $group->getPostal () ) ? $group->getPostal () : $this->view->emptyText;
				$this->view->pays = strlen ( $group->getPays () ) ? $group->getPays () : $this->view->emptyText;
				$this->view->url = strlen ( $group->getUrl () ) ? $group->getUrl () : $this->view->emptyText;
				$this->view->isFull = !$group->isFull ();
				$this->view->description = strlen ( $group->getDescription () ) ? $group->getDescription () : $this->view->emptyText;
				
				$this->view->memberNumber = $memberNumber;
				$this->view->memberList = $memberList;
				$this->view->labelList = Twinmusic_Label::getList ();
				$this->view->competenceList = Twinmusic_Competence::getList ();
				$this->view->contactList = Twinmusic_Contacttype::getList ();
				$this->view->styleList = Twinmusic_Groupstyle::getList ();
				$this->view->competencies = Twindoo_Utile::dbResultHtmlSecurise ( ($memberNumber == 1 && isset ( $competences [$memberList [$group->getAdmin ()] ['USER_ID']] )) ? $competences [$memberList [$group->getAdmin ()] ['USER_ID']] : $competences );
				$this->view->membersInGroup = Twindoo_User::getInfos ( $cleanedMemberList );
				$this->view->notes = $group->getAllNotes ();
				$this->view->compos = $folders->getAll ( $group->getId (), ! $group->inGroup ( Twindoo_User::getCurrentUserId () ) );
				$this->view->styles = Twindoo_Utile::dbResultHtmlSecurise ( $group->getGroupStyles () );
				$this->view->contactsValue = $group->getContacts ();
				$this->view->news = $news->getNewsByGroup ( $group->getId () );
				$this->view->id = $group->getId ();
				$this->view->adminName = $admin->getLogin ();
				$this->view->adminId = $admin->getId ();
				$this->view->username = $username;
				$this->view->translate = $translate;
				$this->view->labelId = $group->getLabel();
				$this->view->labelName = $grouplabel->getName();
				$this->view->translate = $translate;

				$this->view->noLabel = t_('No label');
				$this->view->nameText = t_( "Name" );
				$this->view->goToStudio = t_( "Go to Studio" );
				$this->view->competenciesText = t_( "Skills" );
				$this->view->newCompetence = t_( "New skill/ability" );
				$this->view->newStyle = t_( "New style" );
				$this->view->newLabel = t_( "New label" );
				$this->view->newContact = t_( "New contact" );
				$this->view->members = t_( "Members" );
				$this->view->lieuText = t_( "Location" );
				$this->view->paysText = t_( "Country" );
				$this->view->postalText = t_( "Zip Code" );
				$this->view->musicalStyle = t_( "Musical Styles" );
				$this->view->contacts = t_( "Contacts" );
				$this->view->languages = t_( "Languages" );
				$this->view->delete = t_( "Delete" );
				$this->view->reportBlog = t_( "Report this blog" );
				$this->view->reportThis = t_( "Report this content" );
				$this->view->addCompetence = t_( "Add a skill/ability" );
				$this->view->addStyle = t_( "Add a style" );
				$this->view->addContact = t_( "Add a contact" );
				$this->view->addCompo = t_( "Add a composition" );
				$this->view->addMember = t_( "Add a member" );
				$this->view->compoName = t_( "Name of Compostion" );
				$this->view->compoPublicate = t_( "Public?" );
				$this->view->newPhoto = t_( "New photo" );
				$this->view->newCompo = t_( "New composition" );
				$this->view->submit = t_( "Submit" );
				$this->view->cancel = t_( "Cancel" );
				$this->view->bidForThis = t_( "Bid for this group" );
				$this->view->inviteUser = t_( "Invite this user" );
				$this->view->groupIsFull = t_( "Accept bid?" );
				$this->view->label = t_( "Label" );
				$this->view->compositionsText = t_( "Compositions" );
				$this->view->nocompoText = t_( "No composition for the moment!" );
				$userFeed = sprintf(t_( "Follow %s's compositions" ), $group->getNom());
				$this->view->userFeed = $userFeed;
				$this->view->addFeed($userFeed, "http://www.doonoyz.com/rss/compo/group/" . $group->getUrl());
				
				$params['content'] = $group->getNom () . $group->getLieu () . $group->getPostal () .
										$group->getPays () . $group->getUrl () . $group->isFull () . 
										$group->getDescription () . $this->view->compos . $this->view->competencies .
										$this->view->membersInGroup . $this->view->styles . $this->view->contactsValue;
				$keywords = new Twindoo_Autokeyword($params);
				$this->view->addLayoutVar('keywords', $keywords->get_keywords());
				$this->view->help = t_( "Help" );

			}
		} else {
			$this->_notExists();
		}
	}

	/**
	 * Upload group avatar action
	 *
	 */
	public function uploadphotoAction() {
		$username = $this->_getParam ( 'username' );
		$group = Twinmusic_Group::getGroupByUrl ( $username );

		$security = Array ('gif', 'png', 'jpg', 'jpeg', 'bmp' );
		if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			if (isset ( $_FILES ['photo'] ) && ! $_FILES ['photo'] ['error'] && $_FILES ['photo'] ['size'] < 500000) {
				$temp = explode ( '.', $_FILES ['photo'] ['name'] );
				$ext = $temp [count ( $temp ) - 1];

				if (in_array ( strtolower ( $ext ), $security )) {
					$file = $_FILES ['photo'] ['tmp_name'];
					if ( is_uploaded_file ( $file ) ) {
						$filePath = ROOT_DIR . "filerepository/" . $group->getId () . '/avatar';
						$filePathMin = ROOT_DIR . "filerepository/" . $group->getId () . '/avatarMin';
						if (! is_dir ( dirname ( $filePath ) ))
							mkdir ( dirname ( $filePath ) );
						if (! file_exists ( $filePath ))
							touch ( $filePath );
						if (! is_dir ( dirname ( $filePathMin ) ))
							mkdir ( dirname ( $filePathMin ) );
						if (! file_exists ( $filePathMin ))
							touch ( $filePathMin );
						@unlink($filePath);
						@unlink($filePathMin);
						$cmd = "convert $file -resize 170x170 $filePath";
						shell_exec ( $cmd );
						$cmd = "convert $file -resize 55x55 $filePathMin";
						shell_exec ( $cmd );
						$this->view->clearAllCache ( 'user:' . $username );
					}
				}
			}
			$this->_redirect ( "/" . $username );
		}
		$this->_redirect ( "/search" );
	}

	/**
	 * Get user avatar action
	 *
	 */
	public function getuseravatarAction() {
		$this->getHelper('viewRenderer')->setNoRender();
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader( 'Content-type', 'image/png' );
		
		$username = str_replace('.png', '', strtolower($this->_getParam ( 'username' )));
		$group = Twinmusic_Group::getGroupByUrl ( $username );
		if ($group->getId ()) {
			$filePath = ROOT_DIR . "filerepository/" . $group->getId () . '/avatar';
			if ($this->_getParam ( 'min' )) {
				$filePath .= 'Min';
			}
			if (!file_exists($filePath)) {
				$filePath = ROOT_DIR . "www/images/unknownProfile.gif";
			}
			$response->setBody ( file_get_contents ( $filePath ));
		}
	}
	
	/**
	 * Display group censor page
	 *
	 */
	private function _displayCensure(Twinmusic_Group $group) {
		$this->view->setView ( 'censor' );
		$cachekey = 'censor:' . strtolower ( $group->getUrl() ) . '|locale:' . Twindoo_User::getLocale();
		$this->view->setCacheKey($cacheKey);
		if (! $this->view->isCached ( $cachekey )) {
			$this->view->groupId = $group->getId();
			$this->view->age = $group->getCensure();
			$this->view->text = sprintf ( t_( "You must certify that you're %s or older to see this group/file page" ), $group->getCensure() );
			$this->view->decline = t_('Decline');
			$this->view->certify = t_('Certify');
		}
	}
	
	/**
	 * Display page if user doesn't exists
	 *
	 */
	private function _notExists() {
		$username = strip_tags( strtolower ( $this->_getParam ( 'username' ) ) );
		$this->view->setView ( 'notexists' );
		$this->view->addLayoutVar ( 'title', _('Not existing group/file') );
		$cacheKey = 'notexists:' . strtolower ( $username ) . '|connected:' . (Twindoo_User::getCurrentUserId() ? 'yes' : 'no') . '|locale:' . Twindoo_User::getLocale();
		$this->view->setCacheKey($cacheKey);
		if (! $this->view->isCached ( $cacheKey )) {
			$this->view->userNotExists = sprintf(t_('The group/file "%s" doesn\'t exist, click the button below to create it!'), $username);
			$this->view->connectToSee = t_("Get connected to create this group/file!");
			$this->view->username = $username;
			$this->view->userId = Twindoo_User::getCurrentUserId();
			$this->view->buttonText = t_("Create this group/file!");
		}
	}
}
