<?php
class RatesController extends AppController {
	
	var $name = "Rates";
	var $layout = "admin_users";
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('lastRate'));
	}
	
	function mobileAdd() {
	
		$this->layout = 'none';
		$this->Session->write('Temp.referer', $this->referer());
		
		$continue = false;
		
		// Si la note est remplie
		if (!empty($this->data) && !empty($this->data['Rate']['name'])) {
			$note = $this->data['Rate']['name'] ;
			if($note >= 0 && $note <= 20){
				// Si note > 15 et < 10
				if($note  > 15 or $note  < 10) {
					$alreadyavis = $this->Rate->Episode->Comment->find('all', array('conditions' => array('Comment.user_id' => $this->data['Rate']['user_id'], 'Comment.show_id' => $this->data['Rate']['show_id'], 'Comment.season_id' => $this->data['Rate']['season_id'], 'Comment.episode_id' => $this->data['Rate']['episode_id'])));	
					if (count($alreadyavis) == 0) {
						// doit d'abord écrire un avis
						$continue = false;
						if($this->data['Rate']['name'] > 15) {
							$result = "Vous devez d'abord écrire un avis justifiant votre note haute.";
						} else {
							$result = "Vous devez d'abord écrire un avis justifiant votre note basse.";
						}
					} else {
						// avis écrit, good to go
						$continue = true;
					}
				} else {
					// note normale, on autorise
					$continue = true;
				}
			}else{
				//Note non comprise entre 0 et 20 (modification via outils de développement)
				$continue = false;
				$result = "Votre note doit être comprise entre 0 et 20.";
			}
			
		} else {
			// pas de note sélectionnée
			$continue = false;
		}
		
		
		
		if ($continue) {
			
			$alreadyrate = $this->Rate->find('all', array('conditions' => array('Rate.user_id' => $this->data['Rate']['user_id'], 'Rate.episode_id' => $this->data['Rate']['episode_id'])));
			$resultat = $this->Rate->save($this->data);
			
			if ($resultat) {
				$result = 'Note ajoutée.';
				
				// Suppression de la note éventuelle de l'utilisateur
				if (count($alreadyrate) != 0) {
					foreach($alreadyrate as $rate) {
						$this->Rate->del($rate['Rate']['id'], false);
					}
					
				
				} else {
					// ajout +1 aux total des notes épisodes
					$nbnotes = $this->Rate->find('count', array('conditions'=>array('Rate.episode_id' =>$this->data['Rate']['episode_id'])));
					$this->Rate->Episode->id = $this->data['Rate']['episode_id'];
					$this->Rate->Episode->saveField('nbnotes', $nbnotes);
					
					
					// ajout +1 aux total des notes saisons
					$episodes = $this->Rate->Season->Episode->find('all', array('conditions' => array('Episode.season_id' => $this->data['Rate']['season_id'])));
					$totalnotes = 0;
					foreach($episodes as $episode) {
						$totalnotes += $episode['Episode']['nbnotes'];
					}
					$this->Rate->Season->id = $this->data['Rate']['season_id'];
					$this->Rate->Season->saveField('nbnotes', $totalnotes);
					
					/* ajout +1 aux total des notes series*/
					$show = $this->Rate->Show->find('first', array('conditions' => array('Show.id' => $this->data['Rate']['show_id']), array('contain' => false), 'fields' => array('Show.id', 'Show.nbnotes')));
					$nbRates = $this->Rate->find('count', array('conditions' => array('Show.id' => $this->data['Rate']['show_id'])));
			
					$totalnotes = $nbRates + 1;
					$this->Rate->Show->id = $this->data['Rate']['show_id'];
					$this->Rate->Show->saveField('nbnotes', $totalnotes);
										
				}
				
								
				// Recalcul de la moyenne de l'épisode 
				$rates_episodes = $this->Rate->find('all', array('conditions'=>array('Rate.episode_id' =>$this->data['Rate']['episode_id']),'fields' => array('Rate.name')));
				if (!empty($rates_episodes)) {
				  $total = 0;
				  foreach($rates_episodes as $j => $rate) {
					  $total += $rate['Rate']['name'];
				  }
				  $nb = $j+1;
				  $moyenne = round($total / $nb, 2);
				  $this->Rate->Episode->id = $this->data['Rate']['episode_id'];
				  $this->Rate->Episode->saveField('moyenne', $moyenne);
				}
				
				
				// Recalcul de la moyenne de la saison
				$episodessaison = $this->Rate->Episode->find('all', array('conditions' => array('Episode.season_id' => $this->data['Rate']['season_id']), 'fields' => array('Episode.moyenne')));
				if (!empty($episodessaison)) {
				  $total = 0;
				  $nb = 0;
				  foreach($episodessaison as $episode) {
					  if ($episode['Episode']['moyenne'] != 0) {
						$nb++;
						$total += $episode['Episode']['moyenne'];
					  }
				  }
				  $moyenne = round($total / $nb, 2);
				  $this->Rate->Season->id = $this->data['Rate']['season_id'];
				  $this->Rate->Season->saveField('moyenne', $moyenne);
				}
				
				// Recalcul de la moyenne de la série
				$saisonsserie = $this->Rate->Season->find('all', array('conditions' => array('Season.show_id' => $this->data['Rate']['show_id']), 'fields' => array('Season.moyenne')));
				if (!empty($saisonsserie)) {
				  $total = 0;
				  $nb = 0;
				  foreach($saisonsserie as $saison) {
					  if ($saison['Season']['moyenne'] != 0) {
						$nb++;
						$total += $saison['Season']['moyenne'];
					  }
				  }
				  $moyenne = round($total / $nb, 2);
				  $this->Rate->Show->id = $this->data['Rate']['show_id'];
				  $this->Rate->Show->saveField('moyenne', $moyenne);
				}
				
				$this->redirect('/mobileEpisode/' . $this->data['Rate']['episode_id']);
			} else {
				$this->redirect('/mobileEpisode/' . $this->data['Rate']['episode_id']);
			}
		}
		
		
	}
	
	
	function lastRate() {
		$this->layout = 'none';
		/*
		if ($cat == 'redacteurs') {
			$rates = $this->Rate->find('all', array('conditions' => array('User.role <' => 3), 'limit' => 8));
			$this->set(compact('rates'));
		} else {
			$rates = $this->Rate->find('all', array('conditions' => array('User.role >' => 2), 'limit' => 8));
			$this->set(compact('rates'));
		}
		*/
		$rates = $this->Rate->find('all', array('fields'=>array('Rate.name','User.login','Show.name','Season.name','Episode.numero', 'Show.menu'),'limit' => 40));
		$this->set(compact('rates'));
	}
	
	function add() {
		$this->layout = 'none';
		$this->Session->write('Temp.referer', $this->referer());
		
		$continue = false;
		
		// Si la note est remplie
		if (!empty($this->data) && !empty($this->data['Rate']['name'])) {
			
			// Si note > 15 et < 10
			if($this->data['Rate']['name'] > 15 or $this->data['Rate']['name'] < 10) {
				
				$alreadyavis = $this->Rate->Episode->Comment->find('all', array('conditions' => array('Comment.user_id' => $this->data['Rate']['user_id'], 'Comment.show_id' => $this->data['Rate']['show_id'], 'Comment.season_id' => $this->data['Rate']['season_id'], 'Comment.episode_id' => $this->data['Rate']['episode_id'])));	
				if (count($alreadyavis) == 0) {
					// doit d'abord écrire un avis
					$continue = false;
					if($this->data['Rate']['name'] > 15) {
						$result = "Vous devez d'abord écrire un avis justifiant votre note haute.";
					} else {
						$result = "Vous devez d'abord écrire un avis justifiant votre note basse.";
					}
				} else {
					// avis écrit, good to go
					$continue = true;
				}
				
			} else {
				// note normale, on autorise
				$continue = true;
			}
			
		} else {
			// pas de note sélectionnée
			$continue = false;
		}
		
		
		
		if ($continue) {
			
			$alreadyrate = $this->Rate->find('all', array('conditions' => array('Rate.user_id' => $this->data['Rate']['user_id'], 'Rate.episode_id' => $this->data['Rate']['episode_id'])));
			$resultat = $this->Rate->save($this->data);
			
			if ($resultat) {
				$result = 'Note ajoutée.';
				// Suppression de la note éventuelle de l'utilisateur
				if (count($alreadyrate) != 0) {
					foreach($alreadyrate as $rate) {
						$this->Rate->del($rate['Rate']['id'], false);
					}
					
				
				} else {
					// ajout +1 aux total des notes épisodes
					$nbnotes = $this->Rate->find('count', array('conditions'=>array('Rate.episode_id' =>$this->data['Rate']['episode_id'])));
					$this->Rate->Episode->id = $this->data['Rate']['episode_id'];
					$this->Rate->Episode->saveField('nbnotes', $nbnotes);
					
					
					// ajout +1 aux total des notes saisons
					$episodes = $this->Rate->Season->Episode->find('all', array('conditions' => array('Episode.season_id' => $this->data['Rate']['season_id'])));
					$totalnotes = 0;
					foreach($episodes as $episode) {
						$totalnotes += $episode['Episode']['nbnotes'];
					}
					$this->Rate->Season->id = $this->data['Rate']['season_id'];
					$this->Rate->Season->saveField('nbnotes', $totalnotes);
					
					/* ajout +1 aux total des notes series*/
					$show = $this->Rate->Show->find('first', array('conditions' => array('Show.id' => $this->data['Rate']['show_id']), array('contain' => false), 'fields' => array('Show.id', 'Show.nbnotes')));
					$totalnotes = $show['Show']['nbnotes'] + 1;
					$this->Rate->Show->id = $this->data['Rate']['show_id'];
					$this->Rate->Show->saveField('nbnotes', $totalnotes);
					//
					
				}
				
								
				// Recalcul de la moyenne de l'épisode 
				$rates_episodes = $this->Rate->find('all', array('conditions'=>array('Rate.episode_id' =>$this->data['Rate']['episode_id']),'fields' => array('Rate.name')));
				if (!empty($rates_episodes)) {
				  $total = 0;
				  foreach($rates_episodes as $j => $rate) {
					  $total += $rate['Rate']['name'];
				  }
				  $nb = $j+1;
				  $moyenne = round($total / $nb, 2);
				  $this->Rate->Episode->id = $this->data['Rate']['episode_id'];
				  $this->Rate->Episode->saveField('moyenne', $moyenne);
				}
				
				
				// Recalcul de la moyenne de la saison
				$episodessaison = $this->Rate->Episode->find('all', array('conditions' => array('Episode.season_id' => $this->data['Rate']['season_id']), 'fields' => array('Episode.moyenne')));
				if (!empty($episodessaison)) {
				  $total = 0;
				  $nb = 0;
				  foreach($episodessaison as $episode) {
					  if ($episode['Episode']['moyenne'] != 0) {
						$nb++;
						$total += $episode['Episode']['moyenne'];
					  }
				  }
				  $moyenne = round($total / $nb, 2);
				  $this->Rate->Season->id = $this->data['Rate']['season_id'];
				  $this->Rate->Season->saveField('moyenne', $moyenne);
				}
				
				// Recalcul de la moyenne de la série
				$saisonsserie = $this->Rate->Season->find('all', array('conditions' => array('Season.show_id' => $this->data['Rate']['show_id']), 'fields' => array('Season.moyenne')));
				if (!empty($saisonsserie)) {
				  $total = 0;
				  $nb = 0;
				  foreach($saisonsserie as $saison) {
					  if ($saison['Season']['moyenne'] != 0) {
						$nb++;
						$total += $saison['Season']['moyenne'];
					  }
				  }
				  $moyenne = round($total / $nb, 2);
				  $this->Rate->Show->id = $this->data['Rate']['show_id'];
				  $this->Rate->Show->saveField('moyenne', $moyenne);
				}
				
			} else {
				$result = 'Note non ajoutée.';
			}
		}
		
		
		$rates = $this->Rate->find('all', array('conditions' => array('Rate.episode_id' => $this->data['Rate']['episode_id'])));
		$episode = $this->Rate->Episode->findbyId($this->data['Rate']['episode_id']);
		
		$this->set(compact('rates'));
		$this->set(compact('result'));
		$this->set(compact('episode'));
	}
	
	function admin_delete($id, $user_id) {
		$myRate = $this->Rate->find('first',array('conditions' => array('Rate.id' =>$id)));
		//var_dump($rate);
		
		//Recalcule du nb de notes total
		// ajout -1 aux total des notes épisodes
		$nbnotes = $this->Rate->find('count', array('conditions'=>array('Rate.episode_id' =>$myRate['Rate']['episode_id'])));
		$this->Rate->Episode->id = $myRate['Rate']['episode_id'];
		$this->Rate->Episode->saveField('nbnotes', $nbnotes-1);
		
		
		// ajout +1 aux total des notes saisons
		$episodes = $this->Rate->Season->Episode->find('all', array('conditions' => array('Episode.season_id' => $myRate['Rate']['season_id'])));
		$totalnotes = 0;
		foreach($episodes as $episode) {
			$totalnotes += $episode['Episode']['nbnotes'];
		}
		$this->Rate->Season->id = $myRate['Rate']['season_id'];
		$this->Rate->Season->saveField('nbnotes', $totalnotes);
		
		// ajout +1 aux total des notes series
		$show = $this->Rate->Show->find('first', array('conditions' => array('Show.id' => $myRate['Rate']['show_id']), array('contain' => false), 'fields' => array('Show.id', 'Show.nbnotes')));
		$totalnotes = $show['Show']['nbnotes'] - 1;
		$this->Rate->Show->id = $myRate['Rate']['show_id'];
		$this->Rate->Show->saveField('nbnotes', $totalnotes);
		
		//Suppression de la note de l'utilisateur
		$this->Rate->del($id, true);
		
		// Recalcul de la moyenne de l'épisode 
		$rates_episodes = $this->Rate->find('all', array('conditions'=>array('Rate.episode_id' =>$myRate['Rate']['episode_id'])));
		if (!empty($rates_episodes)) {
		  $total = 0;
		  foreach($rates_episodes as $j => $rate) {
			  $total += $rate['Rate']['name'];
		  }
		  $nb = $j+1;
		  $moyenne = round($total / $nb, 2);
		  $this->Rate->Episode->id = $myRate['Rate']['episode_id'];
		  $this->Rate->Episode->saveField('moyenne', $moyenne);
		}else{
			$this->Rate->Episode->id = $myRate['Rate']['episode_id'];
			$this->Rate->Episode->saveField('moyenne', 0);
		}
		
		
		// Recalcul de la moyenne de la saison
		$episodessaison = $this->Rate->Episode->find('all', array('conditions' => array('Episode.season_id' => $myRate['Rate']['season_id']), 'fields' => array('Episode.moyenne')));
		if (!empty($episodessaison)) {
		  $total = 0;
		  $nb = 0;
		  foreach($episodessaison as $episode) {
			  if ($episode['Episode']['moyenne'] != 0) {
				$nb++;
				$total += $episode['Episode']['moyenne'];
			  }
		  }
		  $moyenne = round($total / $nb, 2);
		  $this->Rate->Season->id = $myRate['Rate']['season_id'];
		  $this->Rate->Season->saveField('moyenne', $moyenne);
		}
		
		// Recalcul de la moyenne de la série
		$saisonsserie = $this->Rate->Season->find('all', array('conditions' => array('Season.show_id' => $myRate['Rate']['show_id']), 'fields' => array('Season.moyenne')));
		if (!empty($saisonsserie)) {
		  $total = 0;
		  $nb = 0;
		  foreach($saisonsserie as $saison) {
			  if ($saison['Season']['moyenne'] != 0) {
				$nb++;
				$total += $saison['Season']['moyenne'];
			  }
		  }
		  $moyenne = round($total / $nb, 2);
		  $this->Rate->Show->id = $myRate['Rate']['show_id'];
		  $this->Rate->Show->saveField('moyenne', $moyenne);
		}
		
		
		
		
		$this->Session->setFlash('La note a été supprimée.'.$moyennes, 'growl');
        $this->redirect( array('controller' => 'rates', 'action' => 'searchresult', 'prefix' => 'admin', $user_id));
		
	}
	
	/*
		Recupère la liste des utilisateurrs.
		Affiche la liste pour sélection des notes ensuite.
	*/
	function admin_index() {
		$users = $this->Rate->User->find('list', array('order' => 'login ASC'));
		$this->set(compact('users'));
	}
	
	/**
	 * Recupère l'ensemble des notes de l'utilisateur choisi précédemment (admin_index)
	 * Affiche les résultats sous forme d'un tableau proposant la suppression des notes.
	 */ 
	function admin_searchresult($user_id){
	
		$arrayCondition = array();
		
		if(isset($user_id)){
			$arrayCondition['Rate.user_id =' ]= $user_id;
		}else{
			$arrayCondition['Rate.user_id =' ]= $this->data['Rate']['user_id'];
		}
		
		
		//Requete de recherche des commentaires
		$list_rates = $this->Rate->find('all',array(
			'conditions' => $arrayCondition,
			'order' => 'Rate.created DESC'));
	
		$this->set('rates', $list_rates);
	}
}
