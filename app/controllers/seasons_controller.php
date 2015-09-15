<?php
class SeasonsController extends AppController {
	
	var $name = "Seasons";
	var $layout = "admin_serie";
	var $paginate = array(
        'contain' => array('User', 'Reaction' => array('User', 'order' => 'Reaction.id ASC')),
        'limit' => 10
    );
	
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('mobileSeason'));
	}
	
	
	function mobileSeason($idseason) {
		$this->layout = 'mobile_default';	
		$season = $this->Season->find('first', array('contain' => array('Show', 'Episode'), 'conditions' => array('Season.id' => $idseason)));	
		$allcomments = $this->paginate('Comment', array('Comment.season_id' => $season['Season']['id'], 'Comment.thumb' != '', 'Comment.episode_id' => 0));
		$this->set('season', $season);
		$this->set('allcomments', $allcomments);
	}
	
	
	
	function admin_index() {
		$this->set('shows', $this->Season->Show->find('list'));
	}
	
	function admin_temp() {
		$show_id = $this->data['Season']['show_id'];
		$this->redirect(array('controller' => 'seasons', 'action' => 'liste', $show_id));
	}
	
	function admin_liste($show_id) {		
		$liste_saisons = $this->Season->find('all', array('conditions' => array('show_id =' => $show_id)));
		
		$show = $this->Season->Show->findById($show_id);
		$this->set('show', $show);
		$this->set('seasons', $liste_saisons);
		$this->set('show_id', $show_id);
		
	}
	
	
	function admin_add() {
		
		$this->set('shows', $this->Season->Show->find('list'));
		
		if (!empty($this->data)) {
			$resultat = $this->Season->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('La season a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'seasons', 'action' => 'index')); 
			}
		} 
	}
	
	
	function admin_edit($id) {
		$this->Season->id = $id;
		
		$this->set('shows', $this->Season->Show->find('list'));
		
		if (empty($this->data)) {
			$this->data = $this->Season->read();
		} else {
			if ($this->Season->save( $this->data )) {
				$this->Session->setFlash('La season a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'seasons', 'action' => 'index'));
			}
		}
	}
	
	
	function fiche($show_menu, $season_numero) {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'none';
		} else {
			$this->layout = 'default';
		}
		$this->Session->write('Temp.referer', $this->referer());
		
		$show = $this->Season->Show->find('first',array('contain' => array('Genre','Season'),'conditions' => array('menu' => $show_menu)));
		$season = $this->Season->find('first', array('conditions' => array('Season.show_id' =>  $show['Show']['id'], 'Season.name' => $season_numero)));
		if(!empty($season['Season']['id'])) {
			
			// Tout ce qui est pour ceux qui sont logués
			if ($this->Auth->user('role') > 0) {
				$alreadycomment = $this->Season->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0), 'contain' => false));
				$this->set(compact('alreadycomment'));
			} else {
				$this->set('alreadycomment', array());
			}
			
			// Affiche les derniers avis
			$comments = $this->Season->Comment->find('all', array(
				'conditions' => array('Comment.season_id' => $season['Season']['id'], 'Comment.thumb' != '', 'Comment.episode_id' => 0),
				'contain' =>  array(
					'User' => array(
						'fields' => array('login'),
					)
				),
				'limit' => 2,
				'order' => array('Comment.id DESC')
			));
			
			// Affiche tous les avis
			$this->paginate['limit'] = 10;
			$this->paginate['order'] = 'Comment.id DESC';
			$allcomments = $this->paginate('Comment', array('Comment.season_id' => $season['Season']['id'], 'Comment.thumb' != '', 'Comment.episode_id' => 0));
			
			
			if(!empty($comments)) {
				$commentsup = $this->Season->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$commentsneutral = $this->Season->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' , 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$commentsdown = $this->Season->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$this->set(compact('commentsup'));
				$this->set(compact('commentsneutral'));
				$this->set(compact('commentsdown'));
			}
			
			// liste des épisodes
			$episodes = $this->Season->Episode->find('all', array(
				'conditions' => array('Episode.season_id' => $season['Season']['id']),
				'contain' => array(
					'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id != 0')),
					'Article' => array(
						'fields' => array('id', 'name', 'url'),
						'conditions' => array('Article.etat' => 1)
					)
				),
				'order' => 'Episode.numero ASC'
			));
			
			// liste des bilans
			$this->loadModel('Article');
			$bilans = $this->Article->find('all', array(
				'conditions' => array('Article.category' =>  'bilan', 'Article.etat' => 1, 'Article.season_id' => $season['Season']['id']),
				'contain' => array(
					'User' => array(
						'fields' => array('login'),
					)
				)
			));
			
			
			// liste des notes = moyenne des épisodes de la saison
			$lastrates = $this->Season->Rate->find('all', array('conditions' => array('Rate.season_id' => $season['Season']['id']), 'fields' => array('Rate.name', 'User.login', 'Season.name', 'Episode.numero', 'Show.menu'), 'limit' => 5));
			
			$rates = $this->Season->Rate->find('count', array('conditions' => array('Rate.season_id' => $season['Season']['id'])));
			
			$this->set('season', $season);
			$this->set(compact('bilans'));
			$this->set(compact('rates'));
			$this->set(compact('lastrates'));
			$this->set(compact('show'));
			$this->set(compact('episodes'));
			$this->set(compact('comments'));
			$this->set(compact('allcomments'));
			
			if($this->RequestHandler->isAjax()) {
				$this->render(DS . 'elements' . DS . 'page-avis');
			} else {
				$this->render('fiche');
			}
			
		} else {
			$this->Session->setFlash('Aucune saison correspondante.', 'growl');	
			$this->redirect($this->Session->read('Temp.referer'));	
		}
	}
	
	
	
	function admin_delete($id) {
		$this->Season->del($id);
		$this->Session->setFlash('La season a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'seasons', 'action' => 'index'));
	}
	
	
	function admin_many() {
		
		if (!empty($this->data)) {
			// Enregistrement de tout le tableau	
			foreach ($this->data['Season'] as $season) {
					$this->Season->id = null;
					$this->Season->save($season);
			}
			$this->Session->setFlash('Les saisons ont été ajoutés.', 'growl');	
			$this->redirect(array('controller' => 'seasons', 'action' => 'index')); 
		}
		
		$this->set('shows', $this->Season->Show->find('list'));
	}
	
	function admin_adds() {
		$this->layout = 'none';
		
		$nombresaisons = $this->data['Season']['nb'];
		$show_id = $this->data['Season']['show_id'];
		$show = $this->Season->Show->findById($show_id);
		$this->set('show', $show);
		$this->set('nb', $nombresaisons);
	}
	
	
	function updatenotes() {
		$this->layout = 'default';
		
		$seasons = $this->Season->find('all', array('fields' => 'Season.id', 'order' => 'Season.id ASC', 'limit' => '0, 100'));
		
		foreach ($seasons as $season) {
			$this->Season->id = $season['Season']['id'];
			$episodes = $this->Season->Episode->find('all', array('conditions' => array('Episode.season_id' => $this->Season->id)));
			
			// Boucle pour additionner toutes les notes des épisodes
			$totalnotes = 0;
			foreach($episodes as $episode) {
				$totalnotes += $episode['Episode']['nbnotes'];
			}
			echo $totalnotes . ' ';
			$this->Season->id = $season['Season']['id'];
			$this->Season->saveField('nbnotes', $totalnotes);
		}
				
	}
	
}
?>