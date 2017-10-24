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
			$this->loadModel('Comment');
			$this->loadModel('Reaction');
			$limitMaxItemCommu = 38; //Nombre d'items maxi pouvant être affiché dans le volet communauté

			// Dernières notes
			$rates = $this->Rate->find('all', array('order' => array('Rate.created DESC'), 'limit' => $limitMaxItemCommu, 'fields' => array('Rate.name', 'User.login', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero', 'Rate.created')));

            // Dernières avis
			$lastcomments = $this->Comment->find('all', array('order' => 'Comment.created DESC', 'limit' => $limitMaxItemCommu, 'fields' => array('Comment.thumb', 'User.login', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero', 'Article.id', 'Article.name', 'Article.url', 'Comment.id', 'Comment.text', 'Comment.spoiler','Comment.created')));

			//Dernières réactions
			//Custom request pour éviter de se payer 300 requetes en plus (cakephp ne fait pas les jointures naturellement)
			
			$lastreactions = $this->Reaction->query("SELECT Reaction.created, User.login, User2.login, Sh.name, Sh.menu, Season.name, Episode.numero
							FROM reactions AS Reaction 
								LEFT JOIN comments AS Comment on (Reaction.comment_id = Comment.id) 
								LEFT JOIN users AS User on (User.id = Reaction.user_id) 
								LEFT JOIN users AS User2 on (Comment.user_id = User2.id)
								LEFT JOIN shows AS Sh on (Comment.show_id = Sh.id)
								LEFT JOIN seasons AS Season on (Comment.season_id = Season.id)
								LEFT JOIN episodes AS Episode on (Comment.episode_id = Episode.id)
							order by Reaction.created desc
							limit ".$limitMaxItemCommu);
			
			//Fuuuuusion !
			$nbCommuDataToShow = 0;
			$idRates = 0;
			$idComments = 0;
			$idreactions = 0;
			$commuDataToShow = array();
			
			//Tant que l'on a pas le nombre d'items (notes, avis, reactions) désirées pour remplir la colonne communauté
			while($nbCommuDataToShow < $limitMaxItemCommu){
				if($rates[$idRates]['Rate']['created'] <= $lastcomments[$idComments]['Comment']['created'] && $lastreactions[$idreactions]['Reaction']['created'] <= $lastcomments[$idComments]['Comment']['created']){
					//commentaire
					$commuDataToShow[] = $lastcomments[$idComments];
					if(empty($lastcomments[$idComments]['Article']['id'])) {
						//Les avis comptent pour deux places
						$nbCommuDataToShow++;
					}
					$idComments ++;
				}else if($lastcomments[$idComments]['Comment']['created'] <= $rates[$idRates]['Rate']['created'] && $lastreactions[$idreactions]['Reaction']['created'] <= $rates[$idRates]['Rate']['created']){
					//note
					$commuDataToShow[] = $rates[$idRates];
					$idRates ++;
				}else{
					//reaction
					$commuDataToShow[] = $lastreactions[$idreactions];
					$idreactions ++;
				}
				$nbCommuDataToShow++;
			}
			
			//tableau des elemnst pour la colonne communauté
			$this->set(compact('commuDataToShow'));
			
			// Notes de l'utilisateur + Avis
			if ($this->Auth->user('role') > 0) {
				$user = $this->Rate->User->find('first', array('contain'=>('Show'),'conditions' => array('User.id' => $this->Auth->user('id'))));
				$ratesuser = $this->Rate->find('all', array('contain'=>false,'conditions' => array('Rate.user_id' => $this->Auth->user('id')), 'fields' => array('Rate.name')));
				$commentsuser = $this->Article->Comment->find('count', array('contain'=>false,'conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.show_id != 0')));
				$critiquesuser = $this->Article->find('count', array('contain'=>false,'conditions' => array('Article.user_id' => $this->Auth->user('id'))));
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
			

			// A la une : article une et articles spéciaux
			// $articlesspecial = $this->Article->find('all', array('conditions' => array('Article.etat' = 1, 'Article.une' = 2));
			$articlesdoubleune = $this->Article->find('all', array(
				'conditions' => array('Article.etat' => 1, 'Article.une' => 2),
				'fields' => array('Article.name', 'Article.url', 'Article.category', 'Article.caption', 'Article.chapo', 'Show.menu', 'Episode.name', 'User.login'),
				'order' => 'Article.modified DESC', 
				'limit' => 8
			));
			$reste = 8 - count($articlesdoubleune);
			$articlesune = $this->Article->find('all', array(
				'conditions' => array('Article.etat' => 1, 'Article.une' => 1),
				'fields' => array('Article.name', 'Article.url', 'Article.category', 'Article.caption', 'Article.chapo', 'Show.menu', 'Episode.name', 'User.login'),
				'order' => 'Article.modified DESC', 
				'limit' => $reste
			));
			
			//News et vidéows
			$news = $this->Article->find('all', array(
				'conditions' => array('Article.category' => array('news', 'video'), 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'limit' => 5
			));
			
			//Tous les articles sauf critiques, news et vidéos
			$articles = $this->Article->find('all', array(
				'conditions' => '(Article.category = "dossier" OR Article.category = "chronique" OR Article.category = "bilan" OR Article.category = "podcast" OR Article.category = "focus" OR Article.category = "critique") AND Article.etat = 1',
				'fields' => array('Show.name', 'Show.menu', 'Article.url', 'Article.caption', 'Article.name', 'Article.created', 'Article.chapo', 'Article.photo', 'Article.show_id'),
					'order' => 'Article.modified DESC', 
				'limit' => 14
			));
			
			//$this->set(compact('randomuser'));
			//$this->set(compact('randomredacteur'));
			$this->set(compact('bestepisodes'));
			$this->set(compact('bestsaisons'));
			$this->set(compact('bestseries'));
			$this->set(compact('lastcomments'));
			$this->set(compact('lastcritiques'));
			$this->set(compact('articlesune'));
			$this->set(compact('articlesdoubleune'));
			$this->set(compact('news'));
			$this->set(compact('articles'));
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
