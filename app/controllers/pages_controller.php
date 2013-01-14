<?php
/* SVN FILE: $Id: pages_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';
/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		
		
		switch ($page) {
			
		case 'home':
			$this->loadModel('Article');
			$this->loadModel('Rate');
			// Dernières notes
			$rates = $this->Rate->find('all', array('order' => array('Rate.id DESC'), 'limit' => 8, 'fields' => array('Rate.name', 'User.login', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero')));
			$this->set(compact('rates'));
			// Notes de l'utilisateur + Avis
			if ($this->Auth->user('role') > 0) {
				$user = $this->Rate->User->findById($this->Auth->user('id'));
				$ratesuser = $this->Rate->find('all', array('conditions' => array('Rate.user_id' => $this->Auth->user('id')), 'fields' => array('Rate.name')));
				$commentsuser = $this->Article->Comment->find('count', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'))));
				$critiquesuser = $this->Article->find('count', array('conditions' => array('Article.user_id' => $this->Auth->user('id'))));
				$this->set(compact('user'));
				$this->set(compact('ratesuser'));
				$this->set(compact('commentsuser'));
				$this->set(compact('critiquesuser'));
			}
			
			
			$programme = $this->Article->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'conditions' => 'diffusionus = CURDATE()', 
													  
													  'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC',
													  'limit' => 6
													  ));
			
			/* Dernières critiques
			$lastcritiques = $this->Article->find('all', array(
				'conditions' => array('Article.etat' => 1, 'Article.category' => 'critique'),
				'fields' => array('Article.url', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero', 'Episode.moyenne'),
				'order' => 'Article.id DESC', 
				'limit' => 10
			));
			*/
			
			// Classements 
			$bestseries = $this->Article->Show->find('all', array(
				'conditions' => array('Show.moyenne !=' => 0, 'Show.nbnotes >' => 100),
				'contain' => false,
				'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
				'order' => 'Show.moyenne DESC', 
				'limit' => 10
			));
			$bestepisodes = $this->Article->Show->Season->Episode->find('all', array(
				'conditions' => array('Episode.moyenne !=' => 0, 'Episode.nbnotes >' => 6),
				'recursive' => 2,
				'contain' => array(
					'Season' => array(
						'Show' => array(
							'fields' => array('id', 'name', 'menu'),
						)
					)
				),
				'order' => 'Episode.moyenne DESC',
				'limit' => 10
			));
			$bestsaisons = $this->Article->Show->Season->find('all', array(
				'conditions' => array('Season.moyenne !=' => 0, 'Season.nbnotes >' => 50),
				'contain' => array('Show'),
				'order' => 'Season.moyenne DESC', 
				'limit' => 15
			));

			$topredac = $this->Article->User->Show->Rate->find('all', array('conditions' => array('User.isRedac' => 1), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'COUNT(DISTINCT(User.id)) AS NbRedac', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu'), 'group' => 'Rate.show_id HAVING NbRedac > 3', 'order' => 'Moyenne DESC'));
			$this->set(compact('topredac'));
			
			// Dernières avis
			$lastcomments = $this->Article->Comment->find('all', array('order' => 'Comment.id DESC', 'limit' => 8, 'fields' => array('Comment.thumb', 'User.login', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero', 'Article.id', 'Article.name', 'Article.url', 'Comment.id', 'Comment.text')));
			
			// A la une
			// $articlesspecial = $this->Article->find('all', array('conditions' => array('Article.etat' = 1, 'Article.une' = 2));
			$articlesdoubleune = $this->Article->find('all', array(
				'conditions' => array('Article.etat' => 1, 'Article.une' => 2),
				'fields' => array('Article.name', 'Article.url', 'Article.category', 'Article.caption', 'Article.chapo', 'Show.menu', 'Episode.name', 'User.login'),
				'order' => 'Article.id DESC', 
				'limit' => 8
			));
			$reste = 8 - count($articlesdoubleune);
			$articlesune = $this->Article->find('all', array(
				'conditions' => array('Article.etat' => 1, 'Article.une' => 1),
				'fields' => array('Article.name', 'Article.url', 'Article.category', 'Article.caption', 'Article.chapo', 'Show.menu', 'Episode.name', 'User.login'),
				'order' => 'Article.id DESC', 
				'limit' => $reste
			));
			$news = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'limit' => 10
			));
			$portraits = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
				'fields' => array('Role.name', 'Article.url', 'Actor.picture'),
				'order' => 'Article.id DESC', 
				'limit' => 6
			));
			$bilans = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
				'fields' => array('Show.name', 'Show.menu', 'Article.url', 'Article.caption'),
				'order' => 'Article.id DESC', 
				'limit' => 6
			));
			$focus = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
				'fields' => array('Show.name', 'Show.menu', 'Article.url', 'Article.caption'),
				'order' => 'Article.id DESC', 
				'limit' => 6
			));
			$videos = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
				'fields' => array('Show.id', 'Show.name', 'Show.menu', 'Article.url', 'Article.photo', 'Article.caption', 'Article.name', 'Article.created'),
				'order' => 'Article.id DESC', 
				'limit' => 6 
			));
			$dossiers = $this->Article->find('all', array(
				'conditions' => '(Article.category = "dossier" OR Article.category = "chronique") AND Article.etat = 1',
				'fields' => array('Show.name', 'Show.menu', 'Article.url', 'Article.caption', 'Article.name', 'Article.created', 'Article.chapo', 'Article.photo', 'Article.show_id'),
				'order' => 'Article.id DESC', 
				'limit' => 3
			));
			$this->set(compact('randomuser'));
			$this->set(compact('randomredacteur'));
			$this->set(compact('bestepisodes'));
			$this->set(compact('bestsaisons'));
			$this->set(compact('bestseries'));
			$this->set(compact('lastcomments'));
			$this->set(compact('lastcritiques'));
			$this->set(compact('articlesune'));
			$this->set(compact('articlesdoubleune'));
			$this->set(compact('portraits'));
			$this->set(compact('bilans'));
			$this->set(compact('focus'));
			$this->set(compact('news'));
			$this->set(compact('videos'));
			$this->set(compact('dossiers'));
			$this->set(compact('programme'));
			
			/* magpierss
			require_once("app/vendors/magpierss/rss_fetch.inc"); 
			$url_feed = 'http://serieall.fr/forum/index.php?/rss/forums/1-serie-all-forum-derniers-messages/';
			$nb_items_affiches = 7;
			
			// lecture du fichier distant (flux XML) 
			$rss = fetch_rss($url_feed); 
			
			// si la lecture s'est bien passee, on lit les elements 
			if (is_array($rss->items)) { 
				// on ne récupère que les éléments les plus récents 
				$items = array_slice($rss->items, 0, $nb_items_affiches); 
				
				// debut de la liste
				// (vous pouvez indiquer un style CSS pour la formater) 
				$html = "<ul class='playe'>\n"; // boucle sur tous les elements 
				foreach ($items as $item) { 
					$html .= "<li><a class='decoblue' href='". $item['link']."'>"; 
					$html .= $item['title']."</a> <span class='grey'>". strftime("créé le %d/%m/%Y", $item['date_timestamp'])." </li>\n";
				} 
				$html .= "</ul>\n"; 
			} 
			*/
			
			// retourne le code HTML à inclure dans la page 
			$this->set('rssforum', '');
			
			break;

		case 'a-propos':
			
			break;

		
		default:
			break;
		}
		
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
		
	}
	
	
}

?>