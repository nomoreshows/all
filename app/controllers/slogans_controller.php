<?php
class SlogansController extends AppController {
	
	var $name = "Slogans";
	var $layout = "admin_settings";
	
	function admin_index() {
		$liste_slogans = $this->Slogan->find('all', array('order' => array('Slogan.id DESC')));
		$this->set('slogans', $liste_slogans);

	}
	
	function admin_add() {
		if (!empty($this->data)) {
			$resultat = $this->Slogan->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('Le slogan a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'slogans', 'action' => 'index')); 
			}
		}
	}
	
	function admin_edit($id) {
		$this->Slogan->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Slogan->read();
		} else {
			if ($this->Slogan->save( $this->data )) {
				$this->Session->setFlash('Le slogan a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'slogans', 'action' => 'index'));
			}
		}
	}
	
	
	function admin_delete($id) {
		$this->Slogan->del($id);
		$this->Session->setFlash('Le slogan a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'slogans', 'action' => 'index'));
	}
}
?>