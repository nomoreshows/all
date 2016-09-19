<?php
class ArtistsController extends AppController {
	
	var $name = "Artists";
	var $layout = 'admin_default';
	
	var $paginate = array(
		'order'     => 'Artist.name ASC',
		'recursive' => -1
	);
 	
	
	function index() {
		$this->layout = 'default';
		$this->set('artists', $this->Artist->find('all', array('contain' => false)));
	}
	
	function display($url) {
		$this->layout = 'default';
		$artist = $this->Artist->find('first', array('conditions' => array('Artist.url' => $url), 'contain' => array('Country', 'Genre', 'Day' => array('Festival' => array('Country', 'Region', 'Genre')))));
		$this->set('artist', $artist);
	}
 
	
	function home() {
		$artists = $this->Artist->find('all', array('conditions' => array('Artist.home' => 1), 'contain' => 0));	
		$genres = $this->Artist->Genre->find('all', array('contain' => 0));
		$this->set('artists', $artists);
		$this->set('genres', $genres);
		$this->layout = 'default';
	}
	

	function admin_index() {
		$artists = $this->Artist->find('all', array('order' => 'Artist.name ASC'));
		$this->set('artists', $artists);
	}
	
	function admin_add() {
		// Si données envoyée en POST
		if (!empty($this->data)) {
			
			$url = htmlentities($this->data['Artist']['name'], ENT_NOQUOTES, 'utf-8');
			$url = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml|amp)\;#', '\1', $url);
			$url = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $url); // pour les ligatures e.g. '&oelig;'
			$url = str_replace("&amp;", "and", str_replace("'", "-", str_replace(" ", "-", strtolower($url))));
			$this->data['Artist']['url'] = $url;
			
			$resultat = $this->Artist->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('L\'artiste a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'artists', 'action' => 'index')); 
			}

		}
		$this->set('genres', $this->Artist->Genre->find('list'));
		$this->set('countries', $this->Artist->Country->find('list'));
	}
	
	
	function admin_edit($id = null) {
		
		if (!empty($id)) {
			$this->Artist->id = $id;
			
			// Langues à éditer
			$locales = array_values(Configure::read('Config.languages'));
			$this->Artist->locale = $locales;
	 
			if (empty($this->data)) {
				$this->data = $this->Artist->read(null, $id);
			} else {
				$resultat = $this->Artist->save($this->data);
				if ($resultat) {
					$this->Session->setFlash('L\'artiste a été modifié.', 'growl');	
					$this->redirect(array('controller' => 'artists', 'action' => 'index')); 
				}
			}
			
		} else {
			$this->Session->setFlash('Aucun artiste trouvé.', 'growl', array('type' => 'error'));	
			$this->redirect(array('controller' => 'artists', 'action' => 'index'));
		}
		
		$this->set('data', $this->data);
		$this->set('genres', $this->Artist->Genre->find('list'));
		$this->set('countries', $this->Artist->Country->find('list'));
	}
	
	
	
	function admin_delete($id) {
		$this->Artist->del($id);
		$this->Session->setFlash('L\'artiste a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'artists', 'action' => 'index'));
	}

}

?>