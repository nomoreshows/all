<?php

class ShowimgHelper extends AppHelper {
		
	function displayName($menu, $img) { 
		if($img) 
			$output = $menu;	
		else
			$output = 'default';
		
		return $this->output($output);
	}
}

?>
