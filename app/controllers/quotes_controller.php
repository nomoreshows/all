<?php
class QuotesController extends AppController {
	
	var $name = "Quotes";
	var $layout = "admin_serie";
	
	function admin_index() {
		$liste_quotes = $this->Quote->find('all');
		$this->set('quotes', $liste_quotes);
	}
	
	function admin_edit($id) {
		$this->Quote->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Quote->read();
		} else {
			if ($this->Quote->save( $this->data )) {
				$this->Session->setFlash('La citation a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'roles', 'action' => 'index'));
			}
		}
		$this->set('shows', $this->Quote->Show->find('list'));
		$this->set('actors', $this->Quote->Actor->find('list'));
	}
	
	
	function admin_delete($id) {
		$this->Quote->del($id);
		$this->Session->setFlash('La citation a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'roles', 'action' => 'index'));
	}
}
?>