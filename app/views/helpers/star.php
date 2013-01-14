<?php

class StarHelper extends AppHelper {
	
	var $helpers = array('Html');
	
	function add($nombre) {
		$image = '';
		for($i=0; $i < $nombre; $i++) {
			$image .= $this->Html->image('icons/star_white.png', array('alt' => '', 'class' => 'absmiddle'));
		}
		return $this->output($image);
	}
	
    function convert($note) {
		$image = '';
        if ($note <= 10) {
			if ($note == 0) {
				$image = $this->Html->image('icons/emptystar.gif', array('alt' => '', 'class' => 'absmiddle'));
			} else {
				$image = $this->Html->image('icons/star_white.png', array('alt' => '', 'class' => 'absmiddle'));
			}
		} elseif ($note <= 13) {
			for ($i=0; $i < 2; $i++) {
				$image .= $this->Html->image('icons/star_white.png', array('alt' => '', 'class' => 'absmiddle'));
			}
		} elseif ($note <= 15) {
			for ($i=0; $i < 3; $i++) {
				$image .= $this->Html->image('icons/star_white.png', array('alt' => '', 'class' => 'absmiddle'));
			}	
		} else {
			for ($i=0; $i < 4; $i++) {
				$image .= $this->Html->image('icons/star_white.png', array('alt' => '', 'class' => 'absmiddle'));
			}	
		}
		return $this->output($image);
    }
	
	function thumb($name) {
		$image = $this->Html->image('icons/thumb_' . $name . '.png', array('alt' => '', 'class' => 'absmiddle'));
		return $this->output($image);
	}
	
	function avis($name) {
		$image = '';
		if ($name == 'up') {
			$image = 'favorable';
		} elseif ($name == 'neutral') {
			$image = 'neutre';
		} elseif ($name == 'down') {
			$image = 'défavorable';
		}
		return $this->output($image);
	}
	
	function url($text) {
		$text = mb_convert_encoding($text,'HTML-ENTITIES', 'UTF-8');
		//On vire les accents
		$text = preg_replace( array('/ß/','/&(..)lig;/', '/&([aouAOU])uml;/','/&(.)[^;]*;/'), array('ss',"$1","$1".'e',"$1"), $text);
		
		$text = strtolower(str_replace(' ', '-', $text));
		
		//on vire tout ce qui n'est pas alphanumérique
		// $out_text = eregi_replace("[^a-z0-9]",'',$text);
		//on renvoie la chaîne transformée
		return $this->output($text);
	}
	
	function rang($moyenne, $nbnotes) {
		$rang = '';
        if ($moyenne <= 7) {
			if ($nbnotes < 20) {
				$rang = 'Hargneux de passage';
			} elseif ($nbnotes < 200) {
				$rang = 'Râleur professionnel';
			} else {
				$rang = 'Vieux sadique';
			}
		} elseif ($moyenne <= 11) {
			if ($nbnotes < 20) {
				$rang = 'Critique franc';
			} elseif ($nbnotes < 200) {
				$rang = 'Critique sincère';
			} else {
				$rang = 'Critique impartial';
			}
		} elseif ($moyenne <= 15) {
			if ($nbnotes < 20) {
				$rang = 'Jeune critique';
			} elseif ($nbnotes < 200) {
				$rang = 'Critique enthousiaste';
			} else {
				$rang = 'Visioneur raffiné';
			}
		} else {
			if ($nbnotes < 20) {
				$rang = 'Oui-Oui sous exta';
			} elseif ($nbnotes < 200) {
				$rang = 'Michel Drucker des séries';
			} else {
				$rang = 'Bisounours';
			}
		}
		return $this->output($rang);
    }
	
	function role($nb) {
		$role = '';
		switch($nb) {
		case 1:
			$role = 'Administrateur';
			break;
		case 2:
			$role = 'Rédacteur';
			break;
		case 3:
			$role = 'Membre VIP';
			break;
		case 4:
			$role = 'Membre';
			break;
		}
		return $this->output($role);
	}
}

?>
