<?php
class ActorsController extends AppController {
	
	var $name = "Actors";
	var $layout = "admin_serie";
	
	function admin_index($lettre) {
		if(empty($lettre)) { $lettre = 'a'; }
		$liste_acteurs = $this->Actor->find('all', array('conditions' => array('Actor.name LIKE' => $lettre . '%')));
		$this->set('actors', $liste_acteurs);
	}
	
	
	function admin_add() {
		
		if (!empty($this->data)) {
			$resultat = $this->Actor->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('L\'acteur a été ajoutée.', 'growl');	
				$this->redirect(array('controller' => 'actors', 'action' => 'index')); 
			}
		}
	}
	
	function admin_many() {
		if (!empty($this->data)) {
			// Enregistrement de tout le tableau
			foreach ($this->data['Actor'] as $actor) {
					$this->Actor->id = null;
					$this->Actor->save($actor);
			}
			
			debug($this->data);
			$this->Session->setFlash('Les acteurs ont été ajoutés.', 'growl');	
			$this->redirect(array('controller' => 'actors', 'action' => 'index')); 
		}
	}
	
	
	function admin_adds() {
		$this->layout = 'none';
		
		$nombresaisons = $this->data['Actor']['nb'];
		$this->set('nb', $nombresaisons);
	}
	
	
	function admin_edit($id) {
		$this->Actor->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Actor->read();
		} else {
			if ($this->Actor->save( $this->data )) {
				$this->Session->setFlash('L\'acteur a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'actors', 'action' => 'index'));
			}
		}
		$this->set('data', $this->data);
	}
	
	
	function admin_delete($id) {
		$this->Actor->del($id);
		$this->Session->setFlash('L\'acteur a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'actors', 'action' => 'index'));
	}
}
?>