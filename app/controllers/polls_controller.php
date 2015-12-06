<?php
class PollsController extends AppController {
	
	var $name = "Polls";
	var $layout = 'admin_default';

	var $paginate = array(
		'limit'     => 10,
		'recursive' => -1
	);
 	
	
	function awards2010() {
		$this->layout = 'default';
		$polls = $this->Poll->find('first', array('contain' => array('Question' => array('Answer')), 'conditions' => array('id' => 1)));
		$this->set('polls', $polls);
	}
	
	function awards2011() {
		$this->layout = 'default';
		
		$polls = $this->Poll->find('first', array('contain' => array('Question' => array('Answer' => array('order' => 'Answer.porcent DESC'))), 'conditions' => array('id' => 2)));
		$this->set('polls', $polls);
	}
	
	function awards2014() {
		$this->layout = 'default';
		$this->loadModel('Vote');
		
		$polls = $this->Poll->find('first', array('contain' => array('Question' => array('Answer' => array('order' => 'Answer.porcent DESC'))), 'conditions' => array('id' => 3)));
		$this->set('polls', $polls);
		
		if ($this->Auth->user('role') > 0) {
				$votes = $this->Vote->find('all', array('conditions'=>array('User.id'=>$this->Auth->user('id'), 'Poll.id'=>3),'order'=>'Question.id ASC'));
				$this->set('votes', $votes);
			} else {
				$this->set('votes', '');
			}
		
		
	}
	
	function awards2015() {
		$this->layout = 'default';
		$this->loadModel('Vote');
		
		$polls = $this->Poll->find('first', array('contain' => array('Question' => array('Answer' => array('order' => 'Answer.porcent DESC'))), 'conditions' => array('id' => 4)));
		$this->set('polls', $polls);
		
		if ($this->Auth->user('role') > 0) {
				$votes = $this->Vote->find('all', array('conditions'=>array('User.id'=>$this->Auth->user('id'), 'Poll.id'=>4),'order'=>'Question.id ASC'));
				$this->set('votes', $votes);
			} else {
				$this->set('votes', '');
			}
		
		
	}
 
	function view($id = null) {
		$this->set('polls', $this->Poll->read(null, $id));
	}

	
	function admin_index() {
		$polls = $this->Poll->find('all', array('order' => 'Poll.id DESC'));
		$this->set('polls', $polls);
	}
	
	
	function admin_add() {
		// Si données envoyée en POST
		if (!empty($this->data)) {
			$resultat = $this->Poll->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('Le sondage a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'polls', 'action' => 'index')); 
			}

		}
		$this->set('countries', $this->Poll->Country->find('list'));
	}
	
	
	function admin_edit($id = null) {
		
		if (!empty($id)) {
			$this->Poll->id = $id;
	 
			if (empty($this->data)) {
				$this->data = $this->Poll->read(null, $id);
			} else {
				$resultat = $this->Poll->save($this->data);
				if ($resultat) {
					$this->Session->setFlash('Le sondage a été modifié.', 'growl');	
					$this->redirect(array('controller' => 'polls', 'action' => 'index')); 
				}
			}
			
		} else {
			$this->Session->setFlash('Aucune sondage trouvé.', 'growl', array('type' => 'error'));	
			$this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		
		$this->set('countries', $this->Poll->Country->find('list'));
		$this->set('data', $this->data);
	}
	
	
	
	function admin_delete($id) {
		$this->Poll->del($id);
		$this->Session->setFlash('Le sondage a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'polls', 'action' => 'index'));
	}

}

?>