<?php
class UsersController extends AppController {
	
	var $name = "Users";
	var $layout = "admin_users";
	var $components = array('RequestHandler');
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('mobileLogin', 'filtershowComments', 'filterseasonComments', 'sortRates', 'developShow'));
	}
	
	function login() {
		$this->Session->write('Temp.referer', $this->referer());
  		$this->layout = 'none';
		$this->redirect($this->Session->read('Temp.referer'));
	}
	
	function logout() {
		$this->Session->setFlash('Vous êtes maintenant déconnecté.', 'growl');	
  		$this->redirect($this->Auth->logout());
	}
	
	function admin_temp() {
		$user_id = $this->data['User']['user_id'];
		$this->redirect(array('controller' => 'users', 'action' => 'edit', $user_id));
	}
	
	function admin_administration() {
		$this->layout = 'admin_default';
	}
	
	function admin_index() {
		$users = $this->User->find('list', array('order' => 'login ASC'));
		//$this->set('users', $listUser);
		
		//$users = $this->paginate('User');
		$this->set(compact('users'));
	}
	
	
	// Mobile
	function mobileLogin() {
		$this->layout = 'mobile_default';	
	}
	
	function mobilelogout() {
		$this->Auth->logout();
  		$this->redirect('/mobile');
	}
	
	
	
	function index() {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'none';
		} else {
			$this->layout = 'default';
		}
		
		$this->paginate['limit'] = 20;
		$users = $this->paginate('User');
		
		$this->set(compact('users'));
		
		if($this->RequestHandler->isAjax()) {
			$this->render(DS . 'elements' . DS . 'page-membres');
		} else {
			$this->render('index');
		}
		
	}
	
	function admin_add() {
		// Si données envoyée en POST
		if (!empty($this->data)) {
			
			// Si les mots de passes correspondent
			if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
				$resultat = $this->User->save($this->data);
				if ($resultat) {
					$this->Session->setFlash('L\'utilisateur a été ajouté.', 'growl');	
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
				}
			} else {
				$this->Session->setFlash('Les mots de passes ne correspondent pas.', 'growl', array('type' => 'error'));	
				$this->redirect(array('controller' => 'users', 'action' => 'add'));
			}
		}
        
	}
	
	
	function admin_edit($id) {
		$this->User->id = $id;
		
		// Si aucun données envoyées en POST, affichage de l'edit
		if (empty($this->data)) {
			$this->data = $this->User->read();
		
		// Sinon enregistrement
		} else {
			
			// Si le mot de passe est vide => pas de sauvegarde du mot de passe
			if (empty($this->data['User']['password_confirm'])) {
				$fields = array('id', 'login', 'name', 'role', 'disabled', 'edito', 'isRedac');
			} else {
				$fields = array('id', 'login', 'password', 'name', 'role', 'disabled', 'edito', 'isRedac');
			}
			
			// Si les mots de passes correspondent
			if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
			
				// Sauvegarde des champs du tableau fields
				if ($this->User->save( $this->data, true, $fields )) {
					$this->Session->setFlash('Paramètres sauvegardés.', 'growl');	
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
				} else {
					$this->Session->setFlash('Problème de sauvegarde.', 'growl', array('type' => 'error'));	
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
				}
			
			// Sinon message d'erreur sur les mots de passe
			} else {
				$this->Session->setFlash('Les mots de passes ne correspondent pas.', 'growl', array('type' => 'error'));	
				$this->redirect(array('controller' => 'users', 'action' => 'index'));
			}
		}
		
        $this->set(compact('id'));
	}
	
	
	
	function admin_delete($id) {
		//Suppression des notes de l'utilisateur
		//$this->User->Rate->deleteAll();
		$moyennes = $this->User->Rate->find('all');
		/*, 
			array('conditions' => array('Rate.user_id' => $user['User']['id']), 
			'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Show.menu ASC'));
*/
		
		
		//Suppression des réactions de l'utilisateur
		
		//Suppression des avis de l'utilisateur
		
		//Suppression de l'utilisateur
		//$this->User->del($id);
		$this->Session->setFlash('L\'utilisateur a été supprimé.'.$moyennes, 'growl');	
		$this->redirect(array('controller' => 'users', 'action' => 'index'));
	}
	
	function inscription() {
		$this->layout = 'default';
	}
	
	function admin_twitter() {
		$this->layout = 'admin_settings';
	}
	
	function profil($cat) {
		
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'none';
		} else {
			$this->layout = 'default';
		}
		
		$this->Session->write('Temp.referer', $this->referer());
		
		App::import('Core', 'sanitize');
		$user = $this->User->find('first', array('contain' => array('Comment', 'Rate'), 'conditions' => array('login' => Sanitize::clean($this->params['login']) )));
		$this->set(compact('user'));
		$this->set(compact('cat'));
		
		// nombre d'avis fav - neu - def (sidebar & avis)
		$aviscount = $this->User->Show->Comment->find('all', array('contain' => false, 'conditions' => array('Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0), 'fields' => array('COUNT(Comment.thumb) as Somme', 'Comment.thumb'), 'group' => 'Comment.thumb'));
		$this->set(compact('aviscount'));
		
		switch ($cat) {

		case '':
		case 'accueil':
			// Si MAJ de l'édito
			if (!empty($this->data['User']['edito'])) {
				$edito = Sanitize::clean($this->data['User']['edito']);
				$this->User->id = $this->data['User']['id'];
				$this->User->saveField('edito', $edito);
				$this->set('edito', $edito);
				$this->render('edit_edito');
				
			} else {
				$moyennes = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id']), 'fields' => array('COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.id', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Show.menu ASC'));
				$this->set(compact('moyennes'));
				
				$articlescount = $this->User->Article->find('count', array('contain' => false, 'conditions' => array('Article.user_id' => $user['User']['id'])));
				$this->set(compact('articlescount'));
				
				$this->User->Followedshows->bindModel(array('belongsTo' => array('Show')));
				$followedshows = $this->User->Followedshows->find('count', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 1), 'contain' => array('Show' => array('fields'=> array('Show.id'))), 'order' => 'Show.name ASC'));
				$pausedshows = $this->User->Followedshows->find('count', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 2), 'contain' => array('Show' => array('fields'=> array('Show.id'))), 'order' => 'Show.name ASC'));
				$finishedshows = $this->User->Followedshows->find('count', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 3), 'contain' => array('Show' => array('fields'=> array('Show.id'))), 'order' => 'Show.name ASC'));
				$abortedshows = $this->User->Followedshows->find('count', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 4), 'contain' => array('Show' => array('fields'=> array('Show.id'))), 'order' => 'Show.name ASC'));
				$this->set(compact('finishedshows'));
				$this->set(compact('followedshows'));
				$this->set(compact('pausedshows'));
				$this->set(compact('abortedshows'));
			}
			break;
	
		// AVIS
		case 'avis':
			
			// derniers avis series
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisshow'));
			
			// derniers avis saisons
			$lastavisseason = $this->User->Show->Comment->find('all', array('contain' => array('Show', 'Season'), 'conditions' => array('Comment.season_id != 0', 'Comment.episode_id' => 0, 'Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisseason'));

			//derniers avis episodes
			$lastavisepisode = $this->User->Show->Comment->find('all', array('contain' => array('Show', 'Season', 'Episode'), 'conditions' => array('Comment.season_id != 0', 'Comment.episode_id != 0', 'Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisepisode'));
			
			// nombre d'avis sur les séries - saisons - épisodes
			$avisshowcount = $this->User->Show->Comment->find('count', array('contain' => false, 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0)));
			$avisseasoncount = $this->User->Show->Comment->find('count', array('contain' => false, 'conditions' => array('Comment.season_id != 0', 'Comment.episode_id' => 0, 'Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0)));
			$avisepisodecount = $this->User->Show->Comment->find('count', array('contain' => false, 'conditions' => array('Comment.episode_id != 0', 'Comment.user_id' => $user['User']['id'], 'Comment.article_id' => 0)));
			$this->set(compact('avisshowcount'));
			$this->set(compact('avisseasoncount'));
			$this->set(compact('avisepisodecount'));
			
			$this->render('profil_avis');
			break;

		// Notes
		case 'notes':
			$moyennes = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id']), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Show.menu ASC'));
			$this->set(compact('moyennes'));
			$this->render('profil_notes');
			break;	
		
		// Séries suivies
		case 'series':
			$shows = $this->User->Show->find('list');
			$this->set(compact('shows'));
			
			$this->User->Followedshows->bindModel(array('belongsTo' => array('Show')));
			$followedshows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 1), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
			$pausedshows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 2), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
			$finishedshows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 3), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
			$abortedshows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 4), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
			$toseeshows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $user['User']['id'], 'Followedshows.etat' => 5), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
			
			$this->set(compact('finishedshows'));
			$this->set(compact('followedshows'));
			$this->set(compact('abortedshows'));
			$this->set(compact('pausedshows'));
			$this->set(compact('toseeshows'));
			
			// Liste des séries terminées
			$quickshowsf = $this->User->Show->find('list', array('conditions' => array('Show.encours' => 0), 'fields' => array('Show.menu', 'Show.name')));
			$ajout = array('0' => '-- Choisir --');
			$quickshowsf = $ajout + $quickshowsf;
			$this->set(compact('quickshowsf'));
			
			$this->render('profil_series');
			break;
		
		// Classements 
		case 'classements':
			$topepisodes = $this->User->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id'], 'Rate.name >' => 11), 'fields' => array('Rate.name', 'Rate.episode_id', 'Rate.season_id', 'Rate.show_id', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero'), 'order' => 'Rate.name DESC', 'limit' => 10));
			$flopepisodes = $this->User->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id'], 'Rate.name <' => 11), 'fields' => array('Rate.name', 'Rate.episode_id', 'Rate.season_id', 'Rate.show_id', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero'), 'order' => 'Rate.name ASC', 'limit' => 10));
			$topsaisons = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id']), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu', 'Show.format', 'Season.name'), 'group' => 'Rate.season_id', 'order' => 'Moyenne DESC'));
			
			$flopsaisons = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id']), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu', 'Show.format', 'Season.name'), 'group' => 'Rate.season_id', 'order' => 'Moyenne ASC'));
			
			$topseries = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id']), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Moyenne DESC'));
			
			$flopseries = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id']), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Moyenne ASC'));
			
			$toppilots = $this->User->Rate->find('all', array('contain' => array('Show', 'Episode', 'Season'), 'conditions' => array('Episode.numero' => 1, 'Season.name' => 1, 'Rate.user_id' => $user['User']['id'], 'Rate.name >' => 11), 'fields' => array('Rate.name', 'Rate.episode_id', 'Rate.season_id', 'Rate.show_id', 'Show.name', 'Show.menu', 'Season.name', 'Show.img', 'Episode.numero'), 'order' => 'Rate.name DESC', 'limit' => 10));
			
			$floppilots = $this->User->Rate->find('all', array('contain' => array('Show', 'Episode', 'Season'), 'conditions' => array('Episode.numero' => 1, 'Season.name' => 1, 'Rate.user_id' => $user['User']['id'], 'Rate.name <' => 11), 'fields' => array('Rate.name', 'Rate.episode_id', 'Rate.season_id', 'Rate.show_id', 'Show.name', 'Show.menu', 'Season.name', 'Show.img', 'Episode.numero'), 'order' => 'Rate.name ASC', 'limit' => 10));
			
			// $commentsuser = $this->User->Comment->find('all', array('conditions' => array('Comment.user_id' => $user['User']['id'])));
			$this->set(compact('user'));
			$this->set(compact('topepisodes'));
			$this->set(compact('flopepisodes'));
			$this->set(compact('toppilots'));
			$this->set(compact('floppilots'));
			$this->set(compact('topsaisons'));
			$this->set(compact('flopsaisons'));
			$this->set(compact('topseries'));
			$this->set(compact('flopseries'));
			$this->render('profil_classements');
			break;
		
		// Notifications
		case 'notifications':
			if($this->params['login'] == $this->Auth->user('login')) {
			
				$user = $this->User->find('first', array('contain' => array('Comment', 'Rate'), 'conditions' => array('login' => $this->params['login'])));
				// todo > pagination
				$notifications = $this->User->Notification->find('all', array('conditions' => array('Notification.user_id' => $user['User']['id']), 'limit' => 40));
				
				$topepisodes = $this->User->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id'], 'Rate.name >' => 11), 'fields' => array('Rate.name', 'Rate.episode_id', 'Rate.season_id', 'Rate.show_id', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero'), 'order' => 'Rate.name DESC', 'limit' => 10));
				$flopepisodes = $this->User->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id'], 'Rate.name <' => 11), 'fields' => array('Rate.name', 'Rate.episode_id', 'Rate.season_id', 'Rate.show_id', 'Show.name', 'Show.menu', 'Season.name', 'Episode.numero'), 'order' => 'Rate.name ASC', 'limit' => 10));
				
				$this->User->Notification->updateAll (
					array('Notification.read' => '1'),
					array('Notification.user_id' => $user['User']['id'])
				);
	
				$this->set(compact('user'));
				$this->set(compact('notifications'));
				$this->set(compact('topepisodes'));
				$this->set(compact('flopepisodes'));
				
				$this->render('profil_notifications');
				
			} else {
				$this->redirect($this->Session->read('Temp.referer'));
			}
			break;
		
		// PARAMETRES
		case 'parametres':
			
			$this->Session->write('Temp.referer', $this->referer());
			
			// vérifie qu'on est log
			if(	$this->Auth->user('id')	== $user['User']['id']) {
				$this->User->id = $user['User']['id'];
				
				$fields = array('id', 'login', 'name', 'lname', 'email', 'sex', 'birthdate', 'city', 'department', 'country', 'job', 'website', 'twitter', 'facebook', 'antispoilers');
				
				if (empty($this->data)) {
					$this->User->unbindModel(array('hasMany' => array('Article', 'Quote', 'Reaction', 'Comment', 'Rate'))); 
					$this->data = $this->User->read($fields);
				} else {
					
					// Si le mot de passe est renseigné, ajout du pass au tableau 
					if (!empty($this->data['User']['password_confirm'])) {
						$fields[] = 'password';
					}
					
					// Si les mots de passes correspondent ou que les 2 mots de passe ne sont pas renseignés, on save
					if (($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm']) or (empty($this->data['User']['password']) and empty($this->data['User']['password_confirm'])))) {
					
						// Sauvegarde des champs du tableau fields
						if ($this->User->save( $this->data, true, $fields )) {
							$this->Session->setFlash('Paramètres sauvegardés.', 'growl');	
							$this->redirect($this->Session->read('Temp.referer'));
						} else {
							$this->Session->setFlash('Problème de sauvegarde.', 'growl', array('type' => 'error'));	
							$this->redirect($this->Session->read('Temp.referer'));
						}
					
					} else {
						$this->Session->setFlash('Les mots de passes ne correspondent pas.', 'growl', array('type' => 'error'));	
						$this->redirect($this->Session->read('Temp.referer'));
					}
				}
			} else {
				$this->redirect($this->Session->read('Temp.referer'));
			}
			
			$this->set(compact('id'));
			$this->render('profil_parametres');
			break;
		
		default:
			break;
		
		}
		
	}
	
	// profil > avis > filtre des saisons
	function filterseasonComments($userid, $cat) {
		switch(substr($cat, 0, 3)) {
			
		case 'fav': // favorable
			$lastavisseason = $this->User->Show->Comment->find('all', array('contain' => array('Show', 'Season'), 'conditions' => array('Comment.thumb' => 'up', 'Comment.season_id != 0', 'Comment.episode_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$filtre = 'Avis favorables (' . count($lastavisseason) . ')';
			$this->set(compact('lastavisseason'));
			$this->set(compact('filtre'));
			
			break;
		
		case 'neu': // neutre
			$lastavisseason = $this->User->Show->Comment->find('all', array('contain' => array('Show', 'Season'), 'conditions' => array('Comment.thumb' => 'neutral', 'Comment.season_id != 0', 'Comment.episode_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$filtre = 'Avis neutres (' . count($lastavisseason) . ')';
			$this->set(compact('lastavisseason'));
			$this->set(compact('filtre'));
			break;
		
		case 'def': // défavorable
			$lastavisseason = $this->User->Show->Comment->find('all', array('contain' => array('Show', 'Season'), 'conditions' => array('Comment.thumb' => 'down', 'Comment.season_id != 0', 'Comment.episode_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$filtre = 'Avis défavorables (' . count($lastavisseason) . ')';
			$this->set(compact('lastavisseason'));
			$this->set(compact('filtre'));
			break;

		case 'las': // derniers avis
			$filtre = 'Derniers avis';
			$lastavisseason = $this->User->Show->Comment->find('all', array('contain' => array('Show', 'Season'), 'conditions' => array('Comment.season_id != 0', 'Comment.episode_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisseason'));
			$this->set(compact('filtre'));
			break;
		
		default:
			break;
		}
	}
	
	
	// profil > avis > filtre des séries
	function filtershowComments($userid, $cat) {
		switch(substr($cat, 0, 3)) {
			
		case 'fav': // favorable
			$filtre = 'Avis favorables';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.thumb' => 'up', 'Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			
			break;
		
		case 'neu': // neutre
			$filtre = 'Avis neutres';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.thumb' => 'neutral', 'Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
		
		case 'def': // défavorable
			$filtre = 'Avis défavorables';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.thumb' => 'down', 'Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
			
		case 'new': // séries récentes
			$filtre = 'De la plus récente à la plus ancienne';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Show.diffusionus DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
		
		case 'old': // moyenne
			$filtre = 'De la plus ancienne à la plus récente';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Show.diffusionus ASC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
		
		case 'moy': // moyenne
			$filtre = 'De la mieux à la moins bien notée';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Show.moyenne DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
		
		case 'moy': // moyenne
			$filtre = 'De la mieux à la moins bien notée';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Show.moyenne DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
		
		case 'nat': // nationalité
			break;
		
		case 'cus': // chaine us
			break;
		
		case 'cfr': // chaine fr
			break;
		
		case 'las': // chaine fr
			$filtre = 'Derniers avis';
			$lastavisshow = $this->User->Show->Comment->find('all', array('contain' => array('Show'), 'conditions' => array('Comment.season_id' => 0, 'Comment.user_id' => $userid, 'Comment.article_id' => 0), 'order' => 'Comment.id DESC'));
			$this->set(compact('lastavisshow'));
			$this->set(compact('filtre'));
			break;
		
		default:
			break;
		}
	}
	
	// profil > notes > tri des moyennes
	function sortRates($userid, $cat) {
		$this->layout = 'none';
		$user = $this->User->find('first', array('contain' => array('Rate'), 'conditions' => array('id' => $userid)));
		$this->set(compact('user'));
		
		if($cat == 'moyenne') { 
			$moyennes = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $userid), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Moyenne DESC'));
		} elseif ($cat == 'serie') {
			$moyennes = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $userid), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Show.menu ASC'));
		} elseif ($cat == 'nombre') {
			$moyennes = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $userid), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Rate.name', 'Rate.show_id', 'Show.id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.show_id', 'order' => 'Somme DESC'));
		}
		$this->set(compact('moyennes'));
		$this->render('sort_rates');
	}
	
	// profil > notes > développe les moyennes par saison
	function developShow($userid, $showid, $moyenneshow, $nbnotes) {
		$this->layout = 'none';
		$user = $this->User->find('first', array('contain' => array('Rate'), 'conditions' => array('id' => $userid)));
		$this->set(compact('user'));
		
		$moyennes = $this->User->Show->Rate->find('all', array('conditions' => array('Rate.user_id' => $user['User']['id'], 'Rate.show_id' => $showid), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'Season.name', 'Show.id', 'Rate.name', 'Rate.show_id', 'Rate.season_id', 'Show.name', 'Show.menu', 'Show.format'), 'group' => 'Rate.season_id', 'order' => 'Rate.season_id ASC'));
		$this->set(compact('moyennes'));
		$this->set(compact('moyenneshow'));
		$this->set(compact('nbnotes'));
	}
	
	
	function favshows() {
		if (!empty($this->data)) {
			if (count($this->data['Show']['Show']) > 8) {
				$this->Session->setFlash('Vous ne pouvez avoir que 8 séries favorites au maximum.', 'growl');	
			} else {
				$this->User->habtmDeleteAll('Show', $this->data['User']['id']); 
				$this->User->habtmAdd('Show', $this->data['User']['id'], $this->data['Show']['Show']);
				$this->Session->setFlash('Vos séries préférées ont été modifiées.', 'growl');	
			}
		} 
		$user = $this->User->findById($this->data['User']['id']);
		$this->redirect('/profil/' . $user['User']['login']);
	}
	
	
	// Création d'un compte
	function add() {
		$this->layout = 'default';
		if (!empty($this->data)) {
			
			// Vérifier Captcha
			if ($this->data['User']['cap'] == '5') {
				
				if(!(strpos($this->data['User']['email'],"youdontcare.com")
				|| strpos($this->data['User']['email'],"kredits24.com")
				|| strpos($this->data['User']['email'],"ocry.com")
				|| strpos($this->data['User']['email'],"mrbasic.com")
				|| strpos($this->data['User']['email'],"1.info")
				|| strpos($this->data['User']['email'],".biz")
				|| strpos($this->data['User']['email'],"oprogressi.com")
				|| strpos($this->data['User']['email'],"qpoe.com")
				|| strpos($this->data['User']['email'],"zoho.com")
				|| strpos($this->data['User']['email'],"makre-proj.com")
				|| strpos($this->data['User']['email'],"mrbonus.com")
				|| strpos($this->data['User']['email'],"agrandar-pene.net")
				|| strpos($this->data['User']['email'],".pl")
				|| strpos($this->data['User']['email'],"2waky.com")
				|| strpos($this->data['User']['email'],"1st-sport.com")
				|| strpos($this->data['User']['email'],"mylftv.com")
				|| strpos($this->data['User']['email'],"gettrials.com")
				|| strpos($this->data['User']['email'],"dnset.com"))){
					// Si les mots de passes correspondent
					if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
					
						// Vérifier si le login est unique
						$login = $this->data['User']['login'];
						$nblogin = $this->User->find('count', array('conditions' => array('User.login' => $login)));
						if ($nblogin == 0) {
						
							/* Générer mot de passe
							$string = "";
							$car = 6;
							$chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							srand((double)microtime()*1000000);
							for($i=0; $i<$car; $i++) {
								$string .= $chaine[rand()%strlen($chaine)];
							}
							$this->data['User']['password'] = md5($string);
							$this->data['User']['role'] = 4;
							
							$email = $this->data['User']['email'];
							*/
							
							// Enregistrer dans bdd
	
							$this->data['User']['role'] = 4;
							$this->data['User']['password'] = md5($this->data['User']['password_confirm']);
							
							//Sauvegarde de l'ip de l'utilisateur
							$this->data['User']['ip'] = $this->RequestHandler->getClientIp();
							
							//Compte désactivés par défaut
							//$this->data['User']['disabled'] = 1;
							
							$resultat = $this->User->save($this->data);
							if ($resultat) {
								
								/* Envoyer un mail
								$headers ='From: "Série-All"<noreply@serieall.fr>'."\n"; 
								$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
								$objet = 'Inscription à Serie All';
								$message = '
								Bienvenue sur Série All,
								<br /><br />
								Vous pouvez dès à présent commenter les articles, critiques et autres dossiers, noter les épisodes et participer au forum en vous connectant à votre compte :
								<br /><br />
								<strong>Login</strong> : ' . $login . '
								<br /><strong>Mot de passe</strong> : ' . $string	. '			
								<br /><br />
								Ce mot de passe a été généré aléatoirement, allez dans votre espace membre pour le changer.<br /><br />
								A bientôt sur <a href="http://www.serieall.fr">www.serieall.fr</a>.
								';
								if (!mail($email, $objet, $message, $headers)) {
									$this->Session->setFlash('Adresse mail non valide.', 'growl');
								} else {
									$this->redirect('/users/confirm');	
								}
								*/
								
								//Recup la litse des admins
								/*
								$admins = $this->User->find('all', array('conditions' => array('User.role' => 1)));
								
								//Notifie les admins d'une nouvelle inscription
								foreach ($admins as $admin) {
									$this->User->Notification->create();
									
									$url_notif = '/admin/users/edit/'.$this->User->getInsertID();
									$contenu_notif = $login . ' vient de s\'inscrire. ' ;
									
									$notif = array('Notification' => array('read' => 0, 'text' => $contenu_notif, 'url' => $url_notif, 'user_id' => $admin['User']['id']));
									$this->set(compact('notif'));
									$this->User->Notification->save($notif);
								}
	
								*/
								$this->redirect('/users/confirm');
								
							} else {
								$this->Session->setFlash('Informations manquantes.', 'growl');
							}
						} else {
							$this->Session->setFlash('Ce login est déjà utilisé.', 'growl');
						}
					} else {
						$this->Session->setFlash('Les mots de passe ne correspondent pas.', 'growl');
					}
				} else {
						$this->Session->setFlash('Email invalide', 'growl');
					}
			} else {
				$this->Session->setFlash('Réponse à la question non valide.', 'growl');
			}

			
		}
		
	}
	
	function confirm() {$this->layout = 'default';}
	
	function editEmail() {
		$this->Session->write('Temp.referer', $this->referer());
		$this->User->id = $this->data['User']['id'];
		
		$resultat = $this->User->save($this->data);
		if ($resultat) {
			$this->Session->setFlash('L\'adresse mail a été modifiée.', 'growl');
			$this->redirect($this->Session->read('Temp.referer'));
		} else {
			$this->Session->setFlash('Adresse mail non valide.', 'growl');
			$this->redirect($this->Session->read('Temp.referer'));
		}
		
	}
	
	function editPassword() {
		$this->Session->write('Temp.referer', $this->referer());
		$this->User->id = $this->data['User']['id'];
		/* Si les mots de passes correspondent */
		if ($this->data['User']['password'] == $this->data['User']['password_confirm']) {
			$password = md5($this->data['User']['password']);
			
			$resultat = $this->User->saveField('password', $password);
			if ($resultat) {
				$this->Session->setFlash('Le mot de passe a été modifié.', 'growl');
				$this->redirect($this->Session->read('Temp.referer'));
			} else {
				$this->Session->setFlash('FAIL.', 'growl');
				$this->redirect($this->Session->read('Temp.referer'));
			}
		} else {
			$this->Session->setFlash('Les mots de passe ne correspondent pas.', 'growl');
			$this->redirect($this->Session->read('Temp.referer'));
		} 
	}
	
	function editEdito() {
        
		App::import('Core', 'sanitize');
		$edito = Sanitize::clean($this->data['User']['edito']);
		
		$this->User->id = $this->data['User']['id'];
		$this->User->saveField('edito', $edito);
		$this->set('edito', $edito);
		$this->render('edit_edito');
	}
	
	
	function addfollow() {
		$this->layout = 'none';
		$show = $this->User->Show->find('first', array('conditions' => array('Show.menu' => $this->data['User']['show_id']), 'fields' => array('Show.id', 'Show.name', 'Show.menu'), 'contain' => false));
		
		// sauvegarde de l'ajout de la série
		if(!empty($this->data['User']['text'])) {
			$save = array('user_id' => $this->Auth->user('id'), 'show_id' => $show['Show']['id'], 'etat' => $this->data['User']['etat'], 'priority' => 100, 'text' => $this->data['User']['text']);
		} else {
			$save = array('user_id' => $this->Auth->user('id'), 'show_id' => $show['Show']['id'], 'etat' => $this->data['User']['etat'], 'priority' => 100);
		}
			
		$result = $this->User->Followedshows->save($save);
		
		// Séries suivies
		$this->User->Followedshows->bindModel(array('belongsTo' => array('Show')));
		$followedshows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $this->Auth->user('id'), 'Followedshows.etat' => $this->data['User']['etat']), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
		$this->set(compact('followedshows'));
		
		if ($this->data['User']['etat'] == 4) {
			$this->render('addaborted');
		} else {
			$this->render('addfollow');
		}
	}
	
	
	function delfollow($show_id) {
		$this->layout = 'none';
		$this->User->Followedshows->deleteAll(array('Followedshows.show_id' => $show_id, 'Followedshows.user_id' => $this->Auth->user('id')));
	}
	
	function updateshows() {
		$this->layout = 'default';
		/* $user = $this->User->Show->find('all', array('contain' => array(
			'Followedshows' => array(
				'conditions' => array('Followedshows.user_id =' => 25),
				'order' => 'Followedshows.priority ASC'
			)
		), 'limit' => 10));
		*/
		
		
		// $this->set(compact('user'));
		
		$this->User->Followedshows->bindModel(array('belongsTo' => array('Show')));
		$test = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => 25, 'Followedshows.etat' => 1), 'contain' => array('Show' => array('fields'=> array('Show.name')))));
		
		
		debug($test);
	}

}

?>
