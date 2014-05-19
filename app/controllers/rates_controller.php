<?php
class RatesController extends AppController {
	
	var $name = "Rates";
	var $layout = "none";
	
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
}