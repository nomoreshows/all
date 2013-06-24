<?php
class CommentsController extends AppController {
	
	var $name = "Comments";
	var $layout = "admin_users";
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('lastComment'));
	}
	
	function listeSerie($serie, $stars) {
		$this->layout = 'default';
	}
	
	//mobile
	function mobileAdd() {
		$this->layout = 'none';
		if (!empty($this->data['Comment']['text']) and strlen($this->data['Comment']['text']) > 100) {
			
			if (empty($this->data['Comment']['episode_id']) && empty($this->data['Comment']['season_id'])) {
				// série
				$alreadyavis = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->data['Comment']['user_id'], 'Comment.show_id' => $this->data['Comment']['show_id'], 'Comment.episode_id' => 0)));
			} elseif (empty($this->data['Comment']['episode_id'])) {
				// saison
				$alreadyavis = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->data['Comment']['user_id'], 'Comment.show_id' => $this->data['Comment']['show_id'], 'Comment.season_id' => $this->data['Comment']['season_id'],'Comment.episode_id' => 0)));
			} else {
				// épisode
				$alreadyavis = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->data['Comment']['user_id'], 'Comment.show_id' => $this->data['Comment']['show_id'], 'Comment.season_id' => $this->data['Comment']['season_id'], 'Comment.episode_id' => $this->data['Comment']['episode_id'])));
			}
			
			if (!empty($alreadyavis)) {
				$result = 'Votre avis a été changé.';
				// Changement de l'avis éventuel de l'utilisateur
				$this->Comment->id = $alreadyavis['Comment']['id'];
				$this->Comment->saveField('text', $this->data['Comment']['text']);
				$this->Comment->saveField('thumb', $this->data['Comment']['thumb']);
				$this->redirect('/mobileEpisode/' . $this->data['Comment']['episode_id']);
			} else {
				$resultat = $this->Comment->save($this->data);
				if ($resultat) {
					$this->redirect('/mobileEpisode/' . $this->data['Comment']['episode_id']);
				} else {
					$this->redirect('/mobileEpisode/' . $this->data['Comment']['episode_id']);	
				}
			}
			$this->set(compact('result'));
		
		// Pas de commentaires
		} else {
			$result = 'Vous devez écrire un commentaire expliquant votre avis (100 caractères min.).';	
			$this->set(compact('result'));
				
		}
	}
	
	
	
	
	function lastComment($cat) {
		$this->layout = 'none';
		if ($cat == 'avis') {
			// Avis
			$comments = $this->Comment->find('all', array('conditions' => array('Comment.article_id' => 0), 'order' => array('Comment.id DESC'), 'limit' => 20));
			$this->set(compact('comments'));
			$this->set(compact('cat'));
		} else {
			// Commentaires
			$comments = $this->Comment->find('all', array('conditions' => array('Comment.article_id !=' => 0), 'order' => array('Comment.id DESC'), 'limit' => 8));
			$this->set(compact('comments'));
			$this->set(compact('cat'));
		}
	}
	
	
	function add($cat, $name) {
		$this->layout = 'default';
		if (empty($this->data)) {
			
			// Série
			if ($cat == 'serie') {
				$show = $this->Comment->Show->findByMenu($name);
				$ratesshow = $this->Comment->Show->Rate->find('all', array('conditions' => array('Rate.show_id' => $show['Show']['id'], 'Rate.season_id' => 0), 'fields' => array('Rate.name', 'User.login')));
				$alreadycomment = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				
				// Affiche les derniers avis
				$comments = $this->Comment->Show->Comment->find('all', array('conditions' => array('Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)), array('order' => array('Comment.id DESC'), 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
			
				if(!empty($comments)) {
					$commentsup = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up','Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$commentsneutral = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' ,'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$commentsdown = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$this->set(compact('commentsup'));
					$this->set(compact('commentsneutral'));
					$this->set(compact('commentsdown'));
				}
				$this->set(compact('ratesshow'));
				$this->set(compact('show'));
				$this->set(compact('cat'));
				$this->set(compact('comments'));
				$this->set(compact('alreadycomment'));
				$this->render('add_serie');
			
			// Saison
			} elseif ($cat == 'saison') {
				$season = $this->Comment->Season->findById($name);
				$show = $this->Comment->Show->findById($season['Season']['show_id']);
				$ratesshow = $this->Comment->Season->Rate->find('all', array('conditions' => array('Rate.show_id' => $season['Season']['show_id'], 'Rate.season_id' => $season['Season']['id']), 'fields' => array('Rate.name', 'User.login')));
				
				
				// Affiche les derniers avis
				$comments = $this->Comment->Show->Comment->find('all', array('conditions' => array('Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)), array('order' => array('Comment.id DESC'), 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
				$alreadycomment = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
			
				if(!empty($comments)) {
					$commentsup = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
					$commentsneutral = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
					$commentsdown = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
					$this->set(compact('commentsup'));
					$this->set(compact('commentsneutral'));
					$this->set(compact('commentsdown'));
				}
				
				$this->set(compact('ratesshow'));
				$this->set(compact('comments'));
				$this->set(compact('show'));
				$this->set(compact('season'));
				$this->set(compact('cat'));
				$this->set(compact('alreadycomment'));
				$this->render('add_saison');
				
			} elseif ($cat == 'episode') {
				
				$episode = $this->Comment->Episode->findById($name);
				$season = $this->Comment->Season->findById($episode['Episode']['season_id']);
				$show = $this->Comment->Show->findById($season['Season']['show_id']);
				$ratesshow = $this->Comment->Season->Rate->find('all', array('conditions' => array('Rate.show_id' => $season['Season']['show_id'], 'Rate.season_id' => $season['Season']['id']), 'fields' => array('Rate.name', 'User.login')));
				
				
				// Affiche les derniers avis
				$comments = $this->Comment->Show->Comment->find('all', array('conditions' => array('Comment.episode_id' => $episode['Episode']['id'])), array('order' => array('Comment.id DESC'), 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
				$alreadycomment = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.episode_id' => $episode['Episode']['id'])));
			
				if(!empty($comments)) {
					$commentsup = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up', 'Comment.episode_id' => $episode['Episode']['id'])));
					$commentsneutral = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral', 'Comment.episode_id' => $episode['Episode']['id'])));
					$commentsdown = $this->Comment->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.episode_id' => $episode['Episode']['id'])));
					$this->set(compact('commentsup'));
					$this->set(compact('commentsneutral'));
					$this->set(compact('commentsdown'));
				}
				
				$this->set(compact('ratesshow'));
				$this->set(compact('comments'));
				$this->set(compact('show'));
				$this->set(compact('season'));
				$this->set(compact('episode'));
				$this->set(compact('cat'));
				$this->set(compact('alreadycomment'));
				$this->render('add_episode');
			}
		 }
	}
	
	function addOk() {
		$this->layout = 'none';
		
		if (!empty($this->data['Comment']['text'])){
			//Traitements sur la chaine
			$txtComment = $this->data['Comment']['text']; //Recup chaine
			
			//Remplacement des caractères en nombre plus important que 4 
			//(Transforme les avis du genre : "kikoooooooooo !!!!!!!" en "kikoooo !!!!")
			$txtComment = preg_replace('/((((.)\4)\4)\4)\4*/', '$1', $txtComment);
			
			
			
			//Suppression des espaces en debut et fin de chaine
			$txtComment = trim($txtComment);
			
			//Suppression des espaces superflus en milieu de chaine
			$txtComment = preg_replace('/ +/', ' ', $txtComment);
			
			if(strlen($txtComment) > 100){
			
				//Modif de $this->data['Comment']['text']) avant sauvegarde pour prendre les nouveaux avis
				$this->data['Comment']['text'] = $txtComment;
				
			
				if (empty($this->data['Comment']['episode_id']) && empty($this->data['Comment']['season_id'])) {
					// série
					$alreadyavis = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->data['Comment']['user_id'], 'Comment.show_id' => $this->data['Comment']['show_id'], 'Comment.season_id' => 0, 'Comment.episode_id' => 0)));
				} elseif (empty($this->data['Comment']['episode_id'])) {
					// saison
					$alreadyavis = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->data['Comment']['user_id'], 'Comment.show_id' => $this->data['Comment']['show_id'], 'Comment.season_id' => $this->data['Comment']['season_id'],'Comment.episode_id' => 0)));
				} else {
					// épisode
					$alreadyavis = $this->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->data['Comment']['user_id'], 'Comment.show_id' => $this->data['Comment']['show_id'], 'Comment.season_id' => $this->data['Comment']['season_id'], 'Comment.episode_id' => $this->data['Comment']['episode_id'])));
				}
				
				if (!empty($alreadyavis)) {
					$result = 'Votre avis a été changé.';
					// Changement de l'avis éventuel de l'utilisateur
					$this->Comment->id = $alreadyavis['Comment']['id'];
					$this->Comment->saveField('text', $this->data['Comment']['text']);
					$this->Comment->saveField('thumb', $this->data['Comment']['thumb']);
				} else {
					$resultat = $this->Comment->save($this->data);
					if ($resultat) {
						$result = 'Votre avis a été ajouté. Merci !';
					} else {
						$result = 'Un problème est survenu lors de l\'ajout de votre avis.';	
					}
				}
				$this->set(compact('result'));
				
			}else{
				//Commentaire pas assez long
				$result = 'Vous devez écrire un commentaire expliquant votre avis (100 caractères min.).';		
				$this->set(compact('result'));
			}
		
		// Pas de commentaires
		} else {
			$result = 'Vous devez écrire un commentaire expliquant votre avis (100 caractères min.).';		
			$this->set(compact('result'));
				
		}
	}
	
	function addNews() {
		$this->layout = 'none';
		$this->Session->write('Temp.referer', $this->referer());
		if (!empty($this->data)) {
			$resultat = $this->Comment->save($this->data);
			if ($resultat) {
				
				App::import('Helper', 'Html');
				$html = new HtmlHelper();
				
				// retrouve le commentaire pour utiliser le nom du nouveau mec qui a commenté
				$idcomment = $this->Comment->id;
				$newcomment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $idcomment), 'contain' => array('User'))); 
				
				// retrouve le mec auteur de l'article + l'article initial pour retrouver la série
				$article = $this->Comment->Article->find('first', array('contain' => array('User'), 'conditions' => array('Article.id' => $this->data['Comment']['article_id'])));
				$user_original = $article['Article']['user_id'];
				
				// retrouve tous les mecs qui ont laissé une réaction sur l'avis
				$comments = $this->Comment->find('all', array('conditions' => array('Comment.article_id' => $this->data['Comment']['article_id']), 'contain' => false));
				
				
				// ajoute une notification pour la personne qui a mis le commentaire (sauf si c'est toi-meme)
				if(($newcomment['Comment']['user_id'] != $this->Auth->user('id')) or ($newcomment['Comment']['user_id'] != $article['User']['id'])){
					$this->Comment->User->Notification->create();
					
					$url_notif = '/article/' . $article['Article']['url'] . '.html';
					$contenu_notif = $html->link($newcomment['User']['login'], '/profil/'.$newcomment['User']['login']) . ' a commenté votre article ' . $article['Article']['name'];
					
					$notif = array('Notification' => array('read' => 0, 'text' => $contenu_notif, 'url' => $url_notif, 'user_id' => $user_original));
					$this->set(compact('notif'));
					$this->Comment->User->Notification->save($notif);
				}
				
				// ajoute une notification pour les personnes qui avaient mis une réaction
				if(!empty($comments)) {
					$users_a_notif = array();
					foreach ($comments as $comment) {
						// uniquement si ce n'est pas toi qui vient de commenter, et si ce n'est pas ton commentaire (car déjà prévenu au-dessus)
						if(($comment['Comment']['user_id'] != $this->Auth->user('id')) and ($comment['Comment']['user_id'] != $article['User']['id']))
							$users_a_notif[] = $comment['Comment']['user_id'];
					}
					
					if(!empty($users_a_notif)) {
						$users_a_notif = array_unique($users_a_notif); // nettoie les doublons (par ex 2 réactions de la meme personne)
						foreach ($users_a_notif as $user_a_notif) {
							$this->Comment->User->Notification->create();
							
							$url_notif = '/article/' . $article['Article']['url'] . '.html';
							$contenu_notif = $html->link($newcomment['User']['login'], '/profil/'.$newcomment['User']['login']) . ' a commenté l\'article ' . $article['Article']['name'];
							
							$notif = array('Notification' => array('read' => 0, 'text' => $contenu_notif, 'url' => $url_notif, 'user_id' => $user_a_notif));
							$this->set(compact('notif'));
							$this->Comment->User->Notification->save($notif);
						}
					}
				}
				
				
				$this->Session->setFlash('Votre commentaire a été ajouté.', 'growl');
				$this->redirect($this->Session->read('Temp.referer'));
			}
		}
	}
	
	/**
	 * Arrivée sur la page de base pour la gestion des commenatires depuis l'admin.
	 * Affichera un formulaire de recherche de la série/siason/épisode puis déclenchera la rechercher
	 */
	function admin_index(){
		$shows = $this->Comment->Show->find('list', array('order' => 'name ASC'));

		$this->set(compact('shows'));
	}
	

	/**
	 * Effectue la recherche des avis en fonction des infos récupérées via le formulaire (admin_index).
	 * Affiche les résultats sous forme d'un tableau proposant l'édition et la suppression des avis.
	 */ 
	function admin_searchresult(){
		$arrayCondition = array();
		$arrayCondition['Comment.show_id =' ]= $this->data['Comment']['show_id'];
		
		
		if(empty($this->data['Comment']['season_id'])){
			//Pas de saison renseignée : recherche sur les avis séries
			$arrayCondition['Comment.season_id =' ] = 0;
			$arrayCondition['Comment.episode_id =' ] = 0;
		}else{
			//recherche sur la saison voulue
			$arrayCondition['Comment.season_id =' ] = $this->data['Comment']['season_id'];
			if(empty($this->data['Comment']['episode_id'])){
				//Pas d'épisode renseigné : recherche sur les avis saison
				$arrayCondition['Comment.episode_id =' ] = 0;
			}else{
				//Recherche des vais sur l'épisode demandé
				$arrayCondition['Comment.episode_id =' ] = $this->data['Comment']['episode_id'];
			}
		}
		
		//Requete de recherche des commentaires
		$liste_comments = $this->Comment->find('all',array(
			'conditions' => $arrayCondition,
			'order' => 'Comment.created DESC'));
	
		$this->set('comments', $liste_comments);
	}
	
	/**
	 * Traitement pour l'edition des commentaires.
	 * Si pas de data post, affichage de la fiche du commentaire et des infos liées, récupérées depuis la BDD.
	 * Si data en post, sauvegarde des data du formulaire en base.
	 */ 
	function admin_edit($id){
		$this->Comment->id = $id;
		
		// Si aucun données envoyées en POST, affichage de l'edit
		if (empty($this->data)) {	
			$this->data = $this->Comment->read();
			
			$this->set('shows', $this->Comment->Show->find('list'));
			$this->set('seasons', $this->Comment->Season->find('list', 
				array('conditions' => array('Season.show_id =' => $this->data['Comment']['show_id'] ),
						'order' => 'Season.id ASC')));
			$this->set('episodes', $this->Comment->Episode->find('list', 
				array('conditions' => array('Episode.season_id =' => $this->data['Comment']['season_id'] ),
						'order' => 'Episode.numero ASC')));
		}else{
			//Modif des données season_id et episode_id si valeur vide (0 au lieu d'une chaine vide qui fait planter)
			if(empty($this->data['Comment']['season_id'])){
				$this->data['Comment']['season_id'] = 0;
			}
			
			if(empty($this->data['Comment']['episode_id'])){
				$this->data['Comment']['episode_id'] = 0;
			}
			
			//Enregistrement
			if ($this->Comment->save( $this->data)) {
					$this->Session->setFlash('Paramètres sauvegardés.', 'growl');	
					$this->redirect(array('controller' => 'comments', 'action' => 'index'));
				} else {
					$this->Session->setFlash('Problème de sauvegarde.', 'growl', array('type' => 'error'));	
					$this->redirect(array('controller' => 'comments', 'action' => 'index'));
				}
		}
		
		 $this->set(compact('id'));
	}
	
	/**
	 * Fonction appelée via requete Ajax lorsque l'utilisateur change la série dans la liste des séries (fiche édition d'avis
	 * ou formulaire de recher). Cherche et charge les saisons et épisodes liés à la nouvelle série, pour mettre à jour le form dans la vue ensuite.
	 */
	function admin_changeshowedit(){
		$this->layout = 'none';
		//Recup nouvelles saisons de la série
		$seasons = $this->Comment->Season->find('list', 
				array('conditions' => array('Season.show_id =' => $this->data['Comment']['show_id'] ),
						'order' => 'Season.id ASC'));
		$this->set('seasons', $seasons );

		//Recup episodes de la saison 1
		$this->set('episodes', $this->Comment->Episode->find('list', 
				array('conditions' => array('Episode.season_id =' => key($seasons)), //Remise à 1 par défaut (this->data contient une vieille valeur)
						'order' => 'Episode.id ASC')));				

	}
	
	/**
	 * Fonction appelée via requete Ajax lorsque l'utilisateur change la saison dans la liste des saison (fiche édition d'avis
	 * ou formulaire de recher). Cherche et charge les épisodes liés à la nouvelle saison, pour mettre à jour le form dans la vue ensuite.
	 */ 
	function admin_changeseasonedit(){
		$this->layout = 'none';

		$this->set('episodes', $this->Comment->Episode->find('list', 
				array('conditions' => array('Episode.season_id =' => $this->data['Comment']['season_id']), 
						'order' => 'Episode.id ASC')));				
		
	}
	
	/**
	 * Supprime un commentaire.
	 * @param $id : id du comment à supprimer
	 */ 
	function admin_delete($id){
		$this->Comment->del($id, true);
		$this->Session->setFlash('L\'avis a été supprimé.'.$moyennes, 'growl');	
		$this->redirect(array('controller' => 'comments', 'action' => 'index'));
	}
	
	function admin_commentindex(){
		$shows = $this->Comment->Show->find('list', array('order' => 'name ASC'));
		$this->set(compact('shows'));
		
		$this->set('categories', $this->Comment->Article->find('list',
			array('fields'=> array('Article.category'),
				'group' => array('Article.category'))));
		
	}

}
