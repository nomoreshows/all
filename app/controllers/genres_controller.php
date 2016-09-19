<?php
class GenresController extends AppController {
	
	var $name = "Genres";
	var $layout = "admin_serie";
	
	function admin_index() {
		$liste_genres = $this->Genre->find('all');
		$this->set('genres', $liste_genres);

	}
	
	function admin_add() {
		if (!empty($this->data)) {
			$resultat = $this->Genre->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('Le genre a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'genres', 'action' => 'index')); 
			}
		}
	}
	
	function admin_edit($id) {
		$this->Genre->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Genre->read();
		} else {
			if ($this->Genre->save( $this->data )) {
				$this->Session->setFlash('Le genre a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'genres', 'action' => 'index'));
			}
		}
	}
	
	
	function admin_delete($id) {
		$this->Genre->del($id);
		$this->Session->setFlash('Le genre a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'genres', 'action' => 'index'));
	}
}
?>