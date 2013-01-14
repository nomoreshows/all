<?php
/* SVN FILE: $Id: bootstrap.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
 
 	function displayDuration($nbsecondes) {
		if ($nbsecondes >= 86400) {
			$jour = floor($nbsecondes/86400);
			$reste = $nbsecondes%86400;
			$heure = floor($reste/3600);
			$reste = $reste%3600;
			$minute = floor($reste/60);
			$seconde = $reste%60;
				if($jour == 1) $result = $jour.' jour, '; else $result = $jour.' jours, ';
				if($heure == 1) $result .= $heure.' heure et '; else $result .= $heure.' heures et ';
				if($minute == 1) $result .= $minute.' minute'; else $result .= $minute.' minutes';
				
		} elseif ($nbsecondes < 86400 AND $nbsecondes>=3600) {
			$heure = floor($nbsecondes/3600);
			$reste = $nbsecondes%3600;
			$minute = floor($reste/60);
			$seconde = $reste%60;
				if($heure == 1) $result .= $heure.' heure et '; else $result = $heure.' heures et ';
				if($minute == 1) $result .= $minute.' minute'; else $result .= $minute.' minutes';
			
		} elseif ($nbsecondes<3600 AND $nbsecondes>=60) {
			$minute = floor($nbsecondes/60);
			$seconde = $nbsecondes%60;
			if($minute == 1) $result .= $minute.' minute'; else $result = $minute.' minutes';
		}
		return $result;
	}
	
	function getAge($dob) {
		$dob = strtotime($dob);
		$age = 0;
		while( time() > $dob = strtotime('+1 year', $dob)) {
			++$age;
		}
		return $age;
	}
	

	if(env('REMOTE_ADDR') == '127.0.0.1') {
	 	// Local (Windows dans notre cas)
		$locale = 'french';
	} else {
	  	// En ligne
		$locale = 'fr_FR.utf8';
	}
	// Définition de la locale pour toutes les fonctions php relatives à la de gestion du temps :
	setlocale(LC_TIME, $locale);

?>