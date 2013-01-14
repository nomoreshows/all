<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class AppController extends Controller {
	
	
	var $helpers = array ('Html', 'Text', 'Form', 'Javascript', 'Ajax', 'Star', 'Gravatar', 'Paginator', 'Cache', 'Avis');
	var $components = array('Auth', 'Thumb', 'RequestHandler');
 
 
	function beforeFilter() {
		
		Security::setHash('md5');
		
    	if(isset($this->Auth)) {
			
			$this->Auth->userModel = 'User';
			$this->Auth->fields = array('username' => 'login', 'password' => 'password');
			$this->Auth->userScope = array('User.disabled' => 0);
			$this->Auth->loginAction = '/users/login';
			$this->Auth->loginRedirect = $this->params['url'];
			$this->Auth->loginError = "Identifiant ou mot de passe incorrects.";
			$this->Auth->logoutRedirect = '/';
			$this->Auth->authError = "Vous n'avez pas accès à cette page.";
			$this->Auth->autoRedirect = true;
			$this->Auth->authorize = 'controller';
 			
			// Si la variable ['prefix'] n’existe pas ou qu’elle ne vaut pas admin, et que l’action demandée n’est pas le login, alors on autorise l’accès.
      		if((empty($this->params['prefix']) || $this->params['prefix'] != 'admin') && $this->action != 'login') {
        		$this->Auth->allow();
      		}
			if ( $this->RequestHandler->isAjax() ) {
			  $this->Auth->allow();
			  Configure::write('debug',0);
			}
			
    	}
  	}
 
  	function isAuthorized() {
			
			$role = $this->Auth->user('role');
			$this->set(compact('role'));
			
			if ($role < 4) {
				$admin = true;
				$this->set(compact('admin'));
				return true;
			} else {
				$admin = false;
				$this->set(compact('admin'));
				return true;
				
				/*if ($this->action == 'editEmail' || $this->action == 'editPassword') {
					return true;
				} else {
					return false;
				}*/
			}
  	}
	
	function beforeRender() {

		// Layout de l'administration
		if(isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			if($this->Auth->user('role') == 4) {
				$this->redirect('/');
			}
		}
 
		// Pour le layout public
		if($this->layout == 'default') {
			$this->loadModel('Show');
			$quickshows = $this->Show->find('list', array('fields' => array('Show.menu', 'Show.name')));
			$this->set(compact('quickshows'));
			
			$this->loadModel('Slogan');
			$slogan = $this->Slogan->find('first', array('order' => array('RAND()')));
			$this->set(compact('slogan'));
			
			$id = $this->Auth->user('id');
			if(!empty($id)) {
				$this->loadModel('Notification');
				$nbnotifications = $this->Notification->find('count', array('conditions' => array('Notification.read' => 0, 'Notification.user_id' => $this->Auth->user('id'))));
				$this->set(compact('nbnotifications'));
			}
		}

	}
}




?>