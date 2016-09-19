<?php
class RolesController extends AppController {
	
	var $name = "Roles";
	var $layout = "admin_serie";
	
	
	function admin_index($lettre) {
		if(empty($lettre)) { $lettre = 'a'; }
		$liste_roles = $this->Role->find('all', array('conditions' => array('Role.name LIKE' => $lettre . '%')));
		$this->set('roles', $liste_roles);
	}
	
	function admin_add() {
		
		$this->set('shows', $this->Role->Show->find('list'));
		$this->set('actors', $this->Role->Actor->find('list'));
		
		if (!empty($this->data)) {
			$resultat = $this->Role->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('Le rôle a été ajoute.', 'growl');	
				$this->redirect(array('controller' => 'roles', 'action' => 'index')); 
			}
		}
	}
	
	function admin_many() {
		if (!empty($this->data)) {
			// Enregistrement de tout le tableau
			foreach ($this->data['Role'] as $role) {
					$this->Role->id = null;
					$this->Role->save($role);
			}
			
			debug($this->data);
			$this->Session->setFlash('Les rôles ont été ajoutés.', 'growl');	
			$this->redirect(array('controller' => 'roles', 'action' => 'index')); 
		}
		$this->set('shows', $this->Role->Show->find('list'));
	}
	
	
	function admin_adds() {
		$this->layout = 'none';
		$nombresaisons = $this->data['Role']['nb'];
		$show_id = $this->data['Role']['show_id'];
		$show = $this->Role->Show->findById($show_id);
		
		$this->set('actors', $this->Role->Actor->find('list'));
		$this->set('show', $show);
		$this->set('nb', $nombresaisons);
	}

	
	function admin_edit($id) {
		$this->Role->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Role->read();
		} else {
			if ($this->Role->save( $this->data )) {
				$this->Session->setFlash('L\'acteur a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'roles', 'action' => 'index'));
			}
		}
		$this->set('shows', $this->Role->Show->find('list'));
		$this->set('actors', $this->Role->Actor->find('list'));
	}
	
	
	function admin_delete($id) {
		$this->Role->del($id);
		$this->Session->setFlash('Le rôle a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'roles', 'action' => 'index'));
	}
}
?>