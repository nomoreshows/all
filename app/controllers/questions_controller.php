<?php
class QuestionsController extends AppController {
	
	var $name = "Questions";
	var $layout = 'admin_default';

	var $paginate = array(
		'limit'     => 10,
		'recursive' => -1
	);
 	
 
	function view($id = null) {
		$this->set('questions', $this->Question->read(null, $id));
	}

	
	function admin_index() {
		$questions = $this->Question->find('all', array('order' => 'Question.id DESC'));
		$this->set('questions', $questions);
	}
	
	
	function admin_add() {
		// Si données envoyée en POST
		if (!empty($this->data)) {
			$resultat = $this->Question->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('La question a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'questions', 'action' => 'index')); 
			}

		}
	}
	
	
	function admin_edit($id = null) {
		
		if (!empty($id)) {
			$this->Question->id = $id;
	 
			if (empty($this->data)) {
				$this->data = $this->Question->read(null, $id);
			} else {
				$resultat = $this->Question->save($this->data);
				if ($resultat) {
					$this->Session->setFlash('La question a été modifié.', 'growl');	
					$this->redirect(array('controller' => 'questions', 'action' => 'index')); 
				}
			}
			
		} else {
			$this->Session->setFlash('Aucune sondage trouvé.', 'growl', array('type' => 'error'));	
			$this->redirect(array('controller' => 'questions', 'action' => 'index'));
		}
		
		$this->set('countries', $this->Question->Country->find('list'));
		$this->set('data', $this->data);
	}
	
	
	
	function admin_delete($id) {
		$this->Question->del($id);
		$this->Session->setFlash('La question a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'questions', 'action' => 'index'));
	}

}

?>