<?php
/**
 * Rss Controller to display all RSS feeds
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class RssController extends Zend_Controller_Action {
	
	/**
	 * Private array for RSS Feed
	 *
	 * @var array
	 */
	private $_feedArray = array();
	
	/**
	 * Disable view render
	 */
	public function init() {
		$this->_helper->viewRenderer->setNoRender();
	}
	
	/**
	 * Prepare common informations
	 */
	public function preDispatch() {
		$this->_feedArray = array(
            'charset' => 'utf-8',
            'author' => 'Doonoyz',
            'email' => 'contact@doonoyz.com',
            'copyright' => '© Doonoyz ' . date('Y'),
            'generator' => 'Doonoyz',
            'language' => Twindoo_User::getLocale(), 
            'entries' => array()
        );
	}
	
	/**
	 * RSS Feed that displays all groups updates
	 */
	public function compoAction() {
		$groupUrl = $this->_getParam('group');
		$group = Twinmusic_Group::getGroupByUrl($groupUrl);
		if ( $group->getId() && $group->isActive()) {
			$title = sprintf(t_('%s (%s) recent updates'), $group->getNom(), $group->getUrl());
			$link = 'http://www.doonoyz.com/' . $group->getUrl();
			$desc = $group->getDescription();
		} else if ( $group->getId() && !$group->isActive()) {
			$title = t_('Group is blocked');
			$link = 'http://www.doonoyz.com';
			$desc = t_('Group is blocked');
		} else {
			$title = t_('Group doesn\'t exist');
			$link = 'http://www.doonoyz.com';
			$desc = t_('Group doesn\'t exist');
		}
		$this->_feedArray['title'] = 'Doonoyz :: ' . $title;
		$this->_feedArray['link'] = $link;
		$this->_feedArray['description'] = $desc;
		
		$folders = new Twinmusic_Folder ( );
		$compos = $folders->getAll ( $group->getId (), true );
		foreach ($compos as $info) {
			foreach ($info['COMPO'] as $k => $compo) {
				$array = array();
				$array['title'] = sprintf(t_("%s (%s) publicated %s !"), $group->getNom(), $group->getUrl(), $compo['NAME']);
				$array['link'] = 'http://www.doonoyz.com/' . $group->getUrl();
				$array['description'] = sprintf(t_("%s (%s) publicated %s !"), $group->getNom(), $group->getUrl(), $compo['NAME']);
				$array['content'] = sprintf(t_("%s (%s) publicated %s !"), $group->getNom(), $group->getUrl(), $compo['NAME']);
				$array['pubDate'] = $compo['CREATION'];
				$this->_feedArray['entries'][] = $array;
			}
		}
	}
	
	/**
	 * Display Recently created Groups
	 */
	public function recentgroupsAction() {
		$this->_feedArray['title'] = t_("Doonoyz :: Recent Groups");
		$this->_feedArray['link'] = "http://www.doonoyz.com";
		$this->_feedArray['description'] = t_("Recent groups");
		
		$groups = Twinmusic_Group::getRecentGroups(20);
		foreach ($groups as $entry) {
			$array = array();
			$array['title'] = sprintf(t_("%s (%s) has just joined!"), $entry['GROUP_NOM'], $entry['GROUP_URL']);
			$array['link'] = 'http://www.doonoyz.com/' . $entry['GROUP_URL'];
			$array['description'] = $entry['GROUP_DESCRIPTION'].'&nbsp;';
			$array['content'] = $entry['GROUP_DESCRIPTION'].'&nbsp;';
			$array['pubDate'] = $entry['GROUP_DATE_CREATION'];
			$this->_feedArray['entries'][] = $array;
		}
	}
	
	/**
	 * Displays the feed
	 */
	public function postDispatch () {
		$feed = Zend_Feed::importArray ( $this->_feedArray, 'rss' );
        $feed -> send();
	}
}