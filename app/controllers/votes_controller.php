<?php
class VotesController extends AppController {
	
	var $name = "Votes";
	var $layout = 'admin_default';

	var $paginate = array(
		'limit'     => 10,
		'recursive' => -1
	);
	
	
	function add($answer_id, $question_id, $poll_id, $user_id) {
		$this->layout = 'none'; 
		
		$record = array('Vote' => array('answer_id' => $answer_id, 'question_id' => $question_id, 'poll_id' => $poll_id, 'user_id' => $user_id));
		
		
		// vérifier que l'user est logué
		if (!empty($user_id)) {
			
			// vérifier que l'user n'a pas déjà voté
			$nbvote = $this->Vote->find('first', array('conditions' => array('Vote.user_id' => $user_id, 'Vote.question_id' => $question_id)));
			
			if (empty($nbvote)) {
				// ajoute un nouveau vote
				$this->Vote->create();
				if($this->Vote->save($record)) {
					$result = 'Vote pris en compte.';
				} else {
					$result = 'Impossible de voter pour le moment.';	
				}
				
			} else {
				// modifie le vote
				$this->Vote->id = $nbvote['Vote']['id'];
				$this->Vote->saveField('answer_id', $answer_id);
				$result = 'Vote modifié.';
			}
			
			
		}  else {
			$result = 'Vous devez vous avoir un compte pour participer. <a href="/inscription">Incrivez-vous</a> en 30 secondes chrono.';	
		}
		
		
		$this->set('result', $result);
	}

}