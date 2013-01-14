<?php
class EpisodesController extends AppController {
	
	var $name = "Episodes";
	var $layout = "admin_serie";
	var $paginate = array(
        'contain' => array('User', 'Reaction' => array('User', 'order' => 'Reaction.id ASC')),
        'limit' => 10,
		'order' => 'Comment.id DESC'
    );
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('planningToday', 'planningYesterday', 'planningTomorrow', 'mobileEpisode', 'mobilePlanning'));
	}
	
	
	function mobileEpisode($idepisode) {
		//Configure::write('debug', 2);
		$this->layout = 'mobile_default';	
		$episode = $this->Episode->find('first', array('contain' => array('Season' => array('Show')), 'conditions' => array('Episode.id' => $idepisode)));	
		$allcomments = $this->paginate('Comment', array('Comment.thumb' != '', 'Comment.episode_id' => $episode['Episode']['id']));
		if ($this->Auth->user('role') > 0) {
			$alreadycomment = $this->Episode->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.episode_id' => $idepisode)));
			$alreadyrate = $this->Episode->Rate->find('first', array('conditions' => array('Rate.user_id' => $this->Auth->user('id'), 'Rate.episode_id' => $idepisode)));
			$this->set(compact('alreadycomment'));
			$this->set(compact('alreadyrate'));
		} else {
			$this->set('alreadycomment', array());
			$this->set('alreadyrate', array());
		}
		$this->set('episode', $episode);
		$this->set('allcomments', $allcomments);
	}
	
	function mobilePlanning($cat) {
	
	}
	
	
	function planningToday() {
		$this->layout = 'none';
		$programme = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
		'conditions' => 'diffusionus = CURDATE()', 
		
		'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC',
		'limit' => 6
		));
		$this->set(compact('programme'));
		$this->render(DS . 'elements' . DS . 'planning-home');
	}
	
	
	
	function planningYesterday() {
		$this->layout = 'none';
		$programme = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
		'conditions' => 'diffusionus = DATE_ADD(CURDATE(), INTERVAL -1 DAY)', 
		
		'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC',
		'limit' => 6
		));
		$this->set(compact('programme'));
		$this->render(DS . 'elements' . DS . 'planning-home');
	}
	
	function planningTomorrow() {
		$this->layout = 'none';
		$programme = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
		'conditions' => 'diffusionus = DATE_ADD(CURDATE(), INTERVAL 1 DAY)', 
		
		'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC',
		'limit' => 6
		));
		$this->set(compact('programme'));
		$this->render(DS . 'elements' . DS . 'planning-home');
	}
	
	
	function admin_index() {
		$this->set('shows', $this->Episode->Season->Show->find('list'));
	}
	
	function admin_temp() {
		$show_id = $this->data['Episode']['show_id'];
		$this->redirect(array('controller' => 'episodes', 'action' => 'liste', $show_id));
	}
	
	function fiche($show_menu, $season_episode) {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'none';
		} else {
			$this->layout = 'default';
		}
		$this->Session->write('Temp.referer', $this->referer());
		
		$show = $this->Episode->Season->Show->findByMenu($show_menu);
		$no_saison = substr($season_episode, 1, 2); //s01e01
		$no_episode = substr($season_episode, -2); 
		
		$episode = $this->Episode->find('first', array('contain' => array('Season', 'Quote' => array('Role', 'User')), 'conditions' => array('Season.show_id' =>  $show['Show']['id'], 'Season.name' => $no_saison, 'Episode.numero' => $no_episode)));
		$season = $this->Episode->Season->findById($episode['Episode']['season_id']);
																	 
		
		if(!empty($episode['Episode']['id'])) {
						
			// Tout ce qui est pour ceux qui sont logués
			if ($this->Auth->user('role') > 0) {
				$alreadycomment = $this->Episode->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.episode_id' => $episode['Episode']['id'])));
				$this->set(compact('alreadycomment'));
			} else {
				$this->set('alreadycomment', array());
			}
			
			// Affiche les derniers avis
			$comments = $this->Episode->Comment->find('all', array('conditions' => array('Comment.episode_id' => $episode['Episode']['id'], 'Comment.thumb' != ''), 'order' => 'Comment.id DESC', 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
			
			// Affiche tous les avis
			$allcomments = $this->paginate('Comment', array('Comment.thumb' != '', 'Comment.episode_id' => $episode['Episode']['id']));
			
			if(!empty($comments)) {
				$commentsup = $this->Episode->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up', 'Comment.episode_id' => $episode['Episode']['id'])));
				$commentsneutral = $this->Episode->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' , 'Comment.episode_id' => $episode['Episode']['id'])));
				$commentsdown = $this->Episode->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.episode_id' => $episode['Episode']['id'])));
				$this->set(compact('commentsup'));
				$this->set(compact('commentsneutral'));
				$this->set(compact('commentsdown'));
			}
			
			// liste des critiques
			$this->loadModel('Article');
			$critiques = $this->Article->find('all', array('conditions' => array('Article.etat' => 1, 'Article.category' =>  'critique', 'Article.episode_id' => $episode['Episode']['id'])));
			
			// liste des notes
			$rates = $this->Episode->Rate->find('all', array('conditions' => array('Rate.episode_id' => $episode['Episode']['id'])));
			
			$this->set('episode', $episode);
			$this->set(compact('critiques'));
			$this->set(compact('rates'));
			$this->set(compact('show'));
			$this->set(compact('season'));
			$this->set(compact('comments'));
			$this->set(compact('allcomments'));
			
			if($this->RequestHandler->isAjax()) {
				$this->render(DS . 'elements' . DS . 'page-avis');
			} else {
				$this->render('fiche');
			}
			
		} else {
			$this->Session->setFlash('Aucun épisode correspondant.', 'growl');	
			$this->redirect($this->Session->read('Temp.referer'));	
		}
	}
	
	
	
	function admin_liste($show_id) {		
		$liste_episodes = $this->Episode->find('all', array('conditions' => array('show_id =' => $show_id)));
		
		$show = $this->Episode->Season->Show->findById($show_id);
		$this->set('show', $show);
		$this->set('episodes', $liste_episodes);
		$this->set('show_id', $show_id);
		
	}
	
	function admin_add($show_id) {
		$this->set('seasons', $this->Episode->Season->find('list', array('conditions' => array('show_id =' => $show_id))));
		$this->set('show_id', $show_id);
	}
	
	function admin_addredirect() {
		if (!empty($this->data)) {
			$show_id = $this->data['Episode']['show_id'];
			$resultat = $this->Episode->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('L\'épisode a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'episodes', 'action' => 'liste', $show_id)); 
			}
		}
	}
	
	
	
	function admin_edit($id) {
		$this->Episode->id = $id;
		$this->Season->order = 'Season.name ASC';
		$this->set('seasons', $this->Episode->Season->find('list'));
		
		if (empty($this->data)) {
			$this->data = $this->Episode->read();
		} else {
			if ($this->Episode->save( $this->data )) {
				$this->Session->setFlash('L\'épisode a été modifié.', 'growl');	
				$this->redirect($this->Session->read('Temp.referer'));
			}
		}
		$this->Session->write('Temp.referer', $this->referer());
	}
	
	
	function admin_delete($id) {
		$this->Episode->del($id);
		$this->Session->setFlash('L\'épisode a été supprimé.', 'growl');	
		$this->Session->write('Temp.referer', $this->referer());
		$this->redirect($this->Session->read('Temp.referer'));
	}
	
	function admin_many($show_id) {
		$this->set('seasons', $this->Episode->Season->find('list', array('conditions' => array('show_id =' => $show_id))));
		$show = $this->Episode->Season->Show->findById($show_id);
		$this->set('show', $show);
	}
	
	function admin_addmany() {
		if (!empty($this->data)) {
			// Enregistrement de tout le tableau	
			$show_id = $this->data['Episode']['show_id'];
			
			foreach ($this->data['Episode'] as $episode) {
					$this->Episode->id = null;
					$this->Episode->save($episode);
			}
			$this->Session->setFlash('Les épisodes ont été ajoutés.', 'growl');	
			$this->redirect(array('controller' => 'episodes', 'action' => 'liste', $show_id)); 
		}	
	}
	
	function admin_adds() {
		$this->layout = 'none';
		
		$nombreepisode = $this->data['Episode']['nb'];
		$season_id = $this->data['Episode']['season_id'];
		$show_id = $this->data['Episode']['show_id'];
		
		$season = $this->Episode->Season->findById($season_id);
		$show = $this->Episode->Season->Show->findById($show_id);
		
		$this->set('season', $season);
		$this->set('show', $show);
		$this->set('nb', $nombreepisode);
	}
	
	function updatenotes() {
		$this->layout = 'default';
		
		/* $episodes = $this->Episode->find('all', array('fields' => 'Episode.id', 'order' => 'Episode.id ASC', 'limit' => '10000, 10884'));
		
		foreach ($episodes as $episode) {
			$this->Episode->id = $episode['Episode']['id'];
			$rates = $this->Episode->Rate->find('count', array('conditions' => array('Rate.episode_id' => $this->Episode->id)));
			$this->Episode->saveField('nbnotes', $rates);
		}*/
		
				
	}
	
	function planning() {
		$this->layout = 'default';
		// sélection de 6 jours avant et 7 jours aprés
		// tant que c'est pas un lundi, on n'affiche pas
		// une fois que ça en est, compteur décrémentif de 7
		
		$this->Episode->Behaviors->attach('Containable');
		
		$episodes = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'conditions' => 'diffusionus BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 DAY) AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)', 
													  
													  'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC'
													  ));
		
		$episodesnext = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'conditions' => 'diffusionus BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 13 DAY)', 
													  'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC'
													  ));
		
		// Planning perso
		if ($this->Auth->user('role') > 0) {
			$this->loadModel('Followedshows');
			$seriesencours = $this->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $this->Auth->user('id') , 'Followedshows.etat' => 1), 'contain' => false));
			
			// Si profil rempli
			if (count($seriesencours > 0)) {
				$seriesin = '';
				foreach($seriesencours as $i => $show) {
					if ($i != 0) {
						$seriesin .= ', ';
					}
					// création du tableau avec la liste des shows
					$seriesin .= $show['Followedshows']['show_id'];
				}
				
				$mesepisodes = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name', 'Season.nbnotes', 'Season.show_id'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'conditions' => 'diffusionus BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 DAY) AND DATE_ADD(CURDATE(), INTERVAL 13 DAY) AND Season.show_id IN (' . $seriesin . ')', 
													  'order' => 'Episode.diffusionus ASC, Season.nbnotes DESC'
				));
			}
			
		}
		
		$this->set('mesepisodes', $mesepisodes);
		$this->set('episodes', $episodes);
		$this->set('episodesnext', $episodesnext);
		
	}
	
}
?>