<?php
/**
 * Template renderer
 *
 * @package    Doonoyz
 * @subpackage library/view
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_View_Smarty extends Twindoo_View_Smarty {

	/**
	 * RSS Feeds
	 *
	 * @var array
	 */
	protected $_rss = array();
	
	/**
	 * Function to initialize the Layout var 
	 *
	 */
	protected function _initLayout() {
		//$this->setCacheLife(0);
		$this->addFeed(t_("Doonoyz :: Recent Groups"), 'http://www.doonoyz.com/rss/recentgroups');
		
		$this->addJSText ( 'confirmDeleteAllMp', t_( "Are you sure you want to DELETE all your messages?" ) );
		$this->addJSText ( 'confirmDeleteMp', t_( "Are you sure you want to DELETE this message?" ) );
		$this->addJSText ( 'confirmDisconnect', t_( "Are you sure you wish to disconnect?" ) );
		$this->addJSText ( 'urlTaken', nl2br ( t_( "Url already taken or not valid!\nAuthorized characters: alphanumerical (a-z A-Z 0-9), underscore (_), dot (.) and hyphen (-)" ) ) );
		$this->addJSText ( 'createGroupSuccess', t_( "Created successfully, you can access your group to URL" ) );
		$this->addJSText ( 'fileFormats', t_( "Your file must be in these file formats:" ) );
		$this->addJSText ( 'alertSent', t_( "Your alert has been sent" ) );
		$this->addJSText ( 'competenceAdded', t_( "Your skill/ability has been added! (you have to refresh to see changes)" ) );
		$this->addJSText ( 'newCompetenceAdded', t_( "Your skill/ability has been added and will be assigned as soon as validated by admin." ) );
		$this->addJSText ( 'styleAdded', t_( "Your style has been added! (you have to refresh to see changes)" ) );
		$this->addJSText ( 'newStyleAdded', t_( "Your style has been added and will be assigned as soon as validated by admin." ) );
		$this->addJSText ( 'newCompetenceName', t_( "New skill/ability name?" ) );
		$this->addJSText ( 'newLabelName', t_( "New label name?" ) );
		$this->addJSText ( 'newStyleName', t_( "New style name?" ) );
		$this->addJSText ( 'contactTypeAddress', t_( "What is the address/pseudo of this contact type?" ) );
		$this->addJSText ( 'contactTypeAdded', t_( "Your contact has been added! (you have to refresh to see changes)" ) );
		$this->addJSText ( 'labelAdded', t_( "Your label has been added!" ) );
		$this->addJSText ( 'newContactType', t_( "New contact type name?" ) );
		$this->addJSText ( 'newContactTypeAddress', t_( "What is the address of this contact type ?" ) );
		$this->addJSText ( 'newContactTypeAddressAdded', t_( "Your contact type has been added and will be assigned as soon as validated by admin." ) );
		$this->addJSText ( 'newLabelAdded', t_( "Your label has been added and will be assigned as soon as validated by admin." ) );
		$this->addJSText ( 'loginOrMail', t_( "New member mail or login?" ) );
		$this->addJSText ( 'commentAdded', t_( "Your comment has been added successfully!" ) );
		$this->addJSText ( 'deleteCompo', t_( "Are you sure you want to DELETE this composition?" ) );
		$this->addJSText ( 'compoDeleted', t_( "Deleted successfully!" ) );
		$this->addJSText ( 'folderDeleted', t_( "Deleted successfully!" ) );
		$this->addJSText ( 'deleteFolderAndContent', t_( "Are you sure you want to DELETE this folder and ALL ITS CONTENT?" ) );
		$this->addJSText ( 'compoPub', t_( "Published successfully!" ) );
		$this->addJSText ( 'compoUnpub', t_( "Unpublished successfully!" ) );
		$this->addJSText ( 'folderPub', t_( "Published successfully!" ) );
		$this->addJSText ( 'folderUnpub', t_( "Unpublished successfully!" ) );
		$this->addJSText ( 'changeFolder', t_( "Folder changed successfully!" ) );
		$this->addJSText ( 'newFolderName', t_( "Name of new folder?" ) );
		$this->addJSText ( 'editFolderName', t_( "Which new name for this folder?" ) );
		$this->addJSText ( 'folderCreated', t_( "Your folder has been created successfully! refresh to see it." ) );
		$this->addJSText ( 'folderEdited', t_( "Your folder has been edited successfully! refresh to see the changes." ) );
		$this->addJSText ( 'compoCreated', t_( "Your composition has been uploaded successfully! Refresh to see it." ) );
		$this->addJSText ( 'thankVote', t_( "Thanks for your vote" ) );
		$this->addJSText ( 'clickToEdit', t_( "Click to edit..." ) );
		$this->addJSText ( 'cancel', t_( "Cancel" ) );
		$this->addJSText ( 'ok', t_( "OK" ) );
		$this->addJSText ( 'confirmDeleteUser', t_( "Are you sure you want to BLOCK this user for using Doonoyz services?" ) );
		$this->addJSText ( 'userDeleted', t_( "The user has been blocked from using Doonoyz services" ) );
		$this->addJSText ( 'confirmDeleteAdminTask', t_( "Are you sure you want to DELETE this task?" ) );
		$this->addJSText ( 'adminTaskDeleted', t_( "The task has been successfully deleted" ) );
		$this->addJSText ( 'confirmBlockGroup', t_( "Are you sure you want to BLOCK this group?" ) );
		$this->addJSText ( 'groupBlocked', t_( "The group has been blocked." ) );
		$this->addJSText ( 'groupActive', t_( "The group has been actived." ) );
		$this->addJSText ( 'directLinkShare', t_( "Direct link" ) );
		$this->addJSText ( 'browse', t_( "Browse" ) );
		$this->addJSText ( 'bigError', t_( "Something went wrong, please try again later..." ) );
		$this->addJSText ( 'noChangeOrError', t_( "Don't change interface while uploading!" ) );
		$this->addJSText ( "loading", t_( "Loading..." ) );
		$this->addJSText ( "skillMusicalAddForget", t_( "Don't forget to click the add link to validate your choice!" ) );
		
		$this->addJSText ( 'acceptedFiles', implode(';', Twinmusic_Compo::getAcceptedExtension('ACCEPT')) );
		$this->addJSText ( 'userId', "userId:" . Twindoo_User::getCurrentUserId() );

		$this->addLayoutVar ( "userId", Twindoo_User::getCurrentUserId() );
		$this->addLayoutVar ( "myUsername", Twindoo_User::getCurrentLogin() );

		$mp = new Twinmusic_Mp ( );
		$this->addLayoutVar ( "newMPNumber", count ( $mp->getMyMp ( true ) ) );
		$this->addLayoutVar ( "newInvitationNumber", count ( Twinmusic_Invitation::getMyInvitations () ) );
		$this->addLayoutVar ( "newBidNumber", count ( Twinmusic_Bid::getAllMyBid () ) );
		$this->addLayoutVar ( "serverUrl", $_SERVER ['SERVER_NAME'] );
		$this->addLayoutVar ( "veryPoor", t_( "Very Poor" ) );
		$this->addLayoutVar ( "poor", t_( "Poor" ) );
		$this->addLayoutVar ( "notThatBad", t_( "Not that Bad" ) );
		$this->addLayoutVar ( "fair", t_( "Fair" ) );
		$this->addLayoutVar ( "average", t_( "Average" ) );
		$this->addLayoutVar ( "almostGood", t_( "Almost Good" ) );
		$this->addLayoutVar ( "good", t_( "Good" ) );
		$this->addLayoutVar ( "veryGood", t_( "Very Good" ) );
		$this->addLayoutVar ( "excellent", t_( "Excellent" ) );
		$this->addLayoutVar ( "perfect", t_( "Perfect" ) );
		$this->addLayoutVar ( "answerMp", t_( "Anwser" ) );
		$this->addLayoutVar ( "deleteMp", t_( "Delete" ) );
		$this->addLayoutVar ( "submit", t_( "Submit" ) );
		$this->addLayoutVar ( "environment", ENVIRONMENT );
		$this->addLayoutVar ( "isAdmin", Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () ) );

		$this->addLayoutVar ( "bugOrContact", t_( "Report a bug or suggest an improvment!" ) );
		$this->addLayoutVar ( "home", t_( "Home" ) );
		$this->addLayoutVar ( "admin", t_( "Admin" ) );
		$this->addLayoutVar ( "login", t_( "Connection" ) );
		$this->addLayoutVar ( "register", t_( "Register an account" ) );
		$this->addLayoutVar ( "privateMP", t_( "Private Mail" ) );
		$this->addLayoutVar ( "invitations", t_( "New invitations" ) );
		$this->addLayoutVar ( "disconnect", t_( "Disconnect" ) );
		$this->addLayoutVar ( "manageMyGroups", t_( "Manage Groups" ) );
		$this->addLayoutVar ( "createGroup", t_( "Create a group/file" ) );
		$this->addLayoutVar ( "studio", t_( "Studio" ) );
		$this->addLayoutVar ( "newBid", t_( "New bid" ) );
		$this->addLayoutVar ( "advancedSearch", t_( "Advanced Search" ) );
		$this->addLayoutVar ( "search", t_( "Search" ) );
		$this->addLayoutVar ( "loading", t_( "Loading..." ) );
		$this->addLayoutVar ( "languageText", t_( "Language" ) );
		$this->addLayoutVar ( "year", date ( 'Y' ) );
		$this->addLayoutVar ( "tokenUser", Twindoo_Token::getToken ( 'user' ) );
		$this->addLayoutVar ( "rssFeeds", $this->_rss );
		
		$this->addLayoutVar ( "jsver",  filemtime ( ROOT_DIR . 'www/javascript/engine.js' ) );
		$this->addLayoutVar ( "cssver", filemtime ( ROOT_DIR . 'www/css/engine.css' ) );
		
		$this->addLayoutVar ( "languages", Zend_Registry::getInstance()->languages );
		
		$this->addLayoutVar ( 'tasks', t_( "Tasks" ) );
		$this->addLayoutVar ( 'manageGroups', t_( "Manage Groups" ) );
		$this->addLayoutVar ( 'editComponent', t_( "Edit Component" ) );
		$this->addLayoutVar ( 'editUser', t_( "Manage User" ) );
		$this->addLayoutVar ( 'manageHome', t_( "Manage Home" ) );
	}
	
	/**
	 * Add a RSS Feed to the layout
	 */
	public function addFeed($title, $link) {
		$this->_rss[$link] = $title;
	}
}