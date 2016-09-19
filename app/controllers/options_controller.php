<?php
class OptionsController extends AppController {
	
	var $name = "Options";
	
	function admin_edit($id) {
		$this->Option->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Option->read();
		} else {
			if ($this->Option->save( $this->data )) {
				$this->Session->setFlash('Les images ont été modifiées.', 'growl');	
				$this->redirect(array('controller' => 'options', 'action' => 'index'));
			}
		}
	}
	

	
}