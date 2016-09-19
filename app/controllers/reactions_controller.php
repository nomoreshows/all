<?php
class ReactionsController extends AppController {
	
	var $name = "Reactions";
	var $layout = "admin_users";
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('lastReaction'));
	}
	
	function add() {
		$this->layout = 'none';
		$this->Session->write('Temp.referer', $this->referer());
		if (!empty($this->data)) {
			$resultat = $this->Reaction->save($this->data);
			if ($resultat) {
				
				App::import('Helper', 'Html');
				$html = new HtmlHelper();
				
				// retrouve la réaction pour utiliser le nom du nouveau mec qui a commenté
				$idreaction = $this->Reaction->id;
				$newreaction = $this->Reaction->find('first', array('conditions' => array('Reaction.id' => $idreaction), 'contain' => array('User'))); 
				
				// retrouve le mec auteur de l'avis + l'avis initial pour retrouver la série
				$comment = $this->Reaction->Comment->find('first', array('contain' => array('Show', 'Season', 'Episode', 'User'), 'conditions' => array('Comment.id' => $this->data['Reaction']['comment_id'])));
				$user_original = $comment['Comment']['user_id'];
				
				// retrouve tous les mecs qui ont laissé une réaction sur l'avis
				$reactions = $this->Reaction->find('all', array('conditions' => array('Reaction.comment_id' => $this->data['Reaction']['comment_id']), 'contain' => false));
				
				
				// ajoute une notification pour la personne qui a mis le commentaire (sauf si c'est toi-meme)
				if(($newreaction['Reaction']['user_id'] != $this->Auth->user('id')) or ($newreaction['Reaction']['user_id'] != $comment['User']['id'])){
					$this->Reaction->User->Notification->create();
					
					if(!empty($comment['Comment']['episode_id'])) {
						// episode
						$url_notif = '/episode/' . $comment['Show']['menu'] . '/s' . str_pad($comment['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT);
						$contenu_notif = $html->link($newreaction['User']['login'], '/profil/'.$newreaction['User']['login']) . ' a commenté votre avis sur ' . $comment['Show']['name'] . ' ' . $comment['Season']['name'] . '.' .  str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT);
					} elseif(!empty($comment['Comment']['season_id'])) {
						// saison
						$url_notif = '/saison/' . $comment['Show']['menu']. '/' . $comment['Season']['name'];
						$contenu_notif = $html->link($newreaction['User']['login'], '/profil/'.$newreaction['User']['login']) . ' a commenté votre avis sur la saison ' . $comment['Season']['name'] . ' de ' . $comment['Show']['name'];
					} else {
						// série
						$url_notif = '/serie/' . $comment['Show']['menu'] . '#tabs-2';
						$contenu_notif = $html->link($newreaction['User']['login'], '/profil/'.$newreaction['User']['login']) . ' a commenté votre avis sur ' . $comment['Show']['name'];
					}
					
					$notif = array('Notification' => array('read' => 0, 'text' => $contenu_notif, 'url' => $url_notif, 'user_id' => $user_original));
					$this->set(compact('notif'));
					$this->Reaction->User->Notification->save($notif);
				}
				
				// ajoute une notification pour les personnes qui avaient mis une réaction
				if(!empty($reactions)) {
					$users_a_notif = array();
					foreach ($reactions as $reaction) {
						// uniquement si ce n'est pas toi qui vient de commenter, et si ce n'est pas ton commentaire (car déjà prévenu au-dessus)
						if(($reaction['Reaction']['user_id'] != $this->Auth->user('id')) and ($reaction['Reaction']['user_id'] != $comment['User']['id']))
							$users_a_notif[] = $reaction['Reaction']['user_id'];
					}
					
					if(!empty($users_a_notif)) {
						$users_a_notif = array_unique($users_a_notif); // nettoie les doublons (par ex 2 réactions de la meme personne)
						foreach ($users_a_notif as $user_a_notif) {
							$this->Reaction->User->Notification->create();
							
							if(!empty($comment['Comment']['episode_id'])) {
								// episode
								$url_notif = '/episode/' . $comment['Show']['menu'] . '/s' . str_pad($comment['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT);
								$contenu_notif = $html->link($newreaction['User']['login'], '/profil/'.$newreaction['User']['login']) . ' a commenté l\'avis de ' . $html->link($comment['User']['login'], '/profil/'.$comment['User']['login'])  . ' sur ' . $comment['Show']['name'] . ' ' . $comment['Season']['name'] . '.' .  str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT);
							} elseif(!empty($comment['Comment']['season_id'])) {
								// saison
								$url_notif = '/saison/' . $comment['Show']['menu']. '/' . $comment['Season']['name'];
								$contenu_notif = $html->link($newreaction['User']['login'], '/profil/'.$newreaction['User']['login']) . ' a commenté l\'avis de ' . $html->link($comment['User']['login'], '/profil/'.$comment['User']['login'])  . ' sur la saison ' . $comment['Season']['name'] . ' de ' . $comment['Show']['name'];
							} else {
								// série
								$url_notif = '/serie/' . $comment['Show']['menu'] . '#tabs-2';
								$contenu_notif = $html->link($newreaction['User']['login'], '/profil/'.$newreaction['User']['login']) . ' a commenté l\'avis de ' . $html->link($comment['User']['login'], '/profil/'.$comment['User']['login'])  . ' sur ' . $comment['Show']['name'];
							}
							
							$notif = array('Notification' => array('read' => 0, 'text' => $contenu_notif, 'url' => $url_notif, 'user_id' => $user_a_notif));
							$this->set(compact('notif'));
							$this->Reaction->User->Notification->save($notif);
						}
					}
				}
				
				$this->Session->setFlash('Votre réaction a été ajoutée.', 'growl');
				$this->redirect($this->Session->read('Temp.referer'));
			}
		}
	}
	
	function lastReaction() {
		$this->layout = 'none';
		$comments = $this->Reaction->find('all', array('order' => array('Reaction.id DESC'),'contain' => array('User', 'Comment' => array('Episode', 'Season', 'Show', 'User'), 'Reaction' => array('User')), 'limit' => 40));
		$this->set(compact('comments'));
	}
	
	/**
	 * Supprime une réaction.
	 * @param $id : id de la réaction à supprimer
	 */ 
	function admin_delete($id){
		$this->Reaction->del($id, true);
		$this->Session->setFlash('La réaction a été supprimé.'.$moyennes, 'growl');
        $this->redirect($this->referer());
	}
	
	/**
	 * Traitement pour l'edition des réactions.
	 * Si pas de data post, affichage de la fiche de la réaction et des infos liées, récupérées depuis la BDD.
	 * Si data en post, sauvegarde des data du formulaire en base.
	 */ 
	function admin_edit($id){
		$this->Reaction->id = $id;
		
		// Si aucun données envoyées en POST, affichage de l'edit
		if (empty($this->data)) {	
			$this->data = $this->Reaction->read();
			
		}else{
			
			//Enregistrement
			if ($this->Reaction->save( $this->data)) {
					$this->Session->setFlash('Paramètres sauvegardés.', 'growl');	
					$this->redirect(array('controller' => 'comments', 'action' => 'index'));
				} else {
					$this->Session->setFlash('Problème de sauvegarde.', 'growl', array('type' => 'error'));	
					$this->redirect(array('controller' => 'comments', 'action' => 'index'));
				}
		}
		
		 $this->set(compact('id'));
	}
}
?>