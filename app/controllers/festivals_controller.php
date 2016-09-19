<?php
class FestivalsController extends AppController {
	
	var $name = "Festivals";
	var $layout = 'admin_default';

	var $paginate = array (
		'order'     => 'Festival.name ASC',
		'recursive' => -1
	);
 	
	
	function index() {
		$this->layout = 'default';
		$this->set('festivals', $this->Festival->find('all', array('contain' => false)));
	}
 
	function display($url) {
		$this->layout = 'default';
		$festival = $this->Festival->find('first',array(
					'conditions' => array('Festival.url' => $url), 
					'contain' => array('Country', 'Region', 'Genre', 'Day' => array('Artist' => array('order' => 'Artist.popularity DESC'), 'order' => 'Day.date DESC'))
		));
		$this->set('festival', $festival);
	}
	
	
	function admin_addartists() {
		if (!empty($this->data)) {
			
			// enregistre dans artists_festivals
			$this->Festival->habtmAdd('Artist', $this->data['Festival']['festival_id'], $this->data['Artist']['Artist']); 
			
			// enregistre dans artists_days si un jour est précisé
			if ($this->data['Festival']['day_id'] != 0) {
				$this->Festival->Day->habtmAdd('Artist', $this->data['Festival']['day_id'], $this->data['Artist']['Artist']);
			}
			
			$this->Session->setFlash('Les artistes ont été ajoutés.', 'growl');	
			$this->redirect(array('controller' => 'festivals', 'action' => 'index')); 
			
		}
	}
	
	function admin_addartist($festival_id) {
		$festival = $this->Festival->findById($festival_id);
		$this->set('festival', $festival);
		
		$days = $this->Festival->Day->find('list', array('conditions' => array('Day.festival_id =' => $festival_id), 'order' => 'Day.date ASC', 'contain' => false));
		$this->set('artists', $this->Festival->Artist->find('list', array('order' => 'Artist.name ASC')));
		$this->set('days', $days);	
	}
	
	
	function admin_index() {
		$festivals = $this->Festival->find('all', array('order' => 'Festival.name ASC'));
		$this->set('festivals', $festivals);
	}
	
	function admin_add() {
		// Si données envoyée en POST
		if (!empty($this->data)) {
			
			$url = htmlentities($this->data['Artist']['name'], ENT_NOQUOTES, 'utf-8');
			$url = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml|amp)\;#', '\1', $url);
			$url = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $url); // pour les ligatures e.g. '&oelig;'
			$url = str_replace("&amp;", "and", str_replace("'", "-", str_replace(" ", "-", strtolower($url))));
			$this->data['Festival']['url'] = $url;
			
			$resultat = $this->Festival->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('Le festival a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'festivals', 'action' => 'index')); 
			}
		}
		$this->set('regions', $this->Festival->Region->find('list'));
		$this->set('countries', $this->Festival->Country->find('list'));
		$this->set('genres', $this->Festival->Genre->find('list'));
	}
	
	
	function admin_edit($id = null) {
		
		if (!empty($id)) {
			$this->Festival->id = $id;
			
			// Langues à éditer
			$locales = array_values(Configure::read('Config.languages'));
			$this->Festival->locale = $locales;
	 
			if (empty($this->data)) {
				$this->data = $this->Festival->read(null, $id);
			} else {
				$resultat = $this->Festival->save($this->data);
				if ($resultat) {
					$this->Session->setFlash('Le festivale a été modifié.', 'growl');	
					$this->redirect(array('controller' => 'festivals', 'action' => 'index')); 
				}
			}
			
		} else {
			$this->Session->setFlash('Aucun festival trouvé.', 'growl', array('type' => 'error'));	
			$this->redirect(array('controller' => 'festivals', 'action' => 'index'));
		}
		
		$this->set('regions', $this->Festival->Region->find('list'));
		$this->set('countries', $this->Festival->Country->find('list'));
		$this->set('genres', $this->Festival->Genre->find('list'));
		$this->set('data', $this->data);
	}
	
	
	
	function admin_delete($id) {
		$this->Festival->del($id);
		$this->Session->setFlash('Le festival a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'festivals', 'action' => 'index'));
	}

}

?>