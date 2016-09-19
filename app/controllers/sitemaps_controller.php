<?php
class SitemapsController extends AppController{

    var $name = 'Sitemaps';
    var $uses = array('Article', 'Show', 'Season', 'Episode', 'User');
    var $helpers = array('Time');
    var $components = array('RequestHandler');
	var $actsAs = array('Containable');

    function index () {    
        $this->set('articles', $this->Article->find('all', array( 'conditions' => array('etat' => 1), 'order' => 'Article.id DESC', 'contain' => false, 'fields' => array('created','id', 'url'))));
       	$this->set('shows', $this->Show->find('all', array('contain' => false, 'fields' => array('id','menu'))));
		$this->set('users', $this->User->find('all', array('contain' => false, 'order' => 'User.role ASC', 'fields' => array('id','login'))));
		
		$this->Show->Season->bindModel(array('belongsTo' => array('Show')));
		$seasons = $this->Show->Season->find('all', array('contain' => array('Show' => array('fields'=> array('Show.id', 'Show.name', 'Show.menu'))), 'order' => 'Season.show_id ASC'));
		$this->set('seasons', $seasons);
		
		$episodes = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'order' => 'Episode.id DESC',
														'limit' => '10000'
													  ));
		$this->set('episodes', $episodes);
		
		//debug logs will destroy xml format, make sure were not in drbug mode
		Configure::write('debug', 0);
    }

	function episode() {
		$episodes = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'order' => 'Episode.id DESC',
														'limit' => '10000, 15000'
													  ));
		$this->set('episodes', $episodes);
		
		Configure::write('debug', 0);
	}
	
	function episode2() {
		$episodes = $this->Episode->find('all', array('contain' => array('Season' => array('fields' => array('Season.name'), 'Show' => array('fields' => array('Show.name', 'Show.menu', 'Show.priority')))), 
													  'order' => 'Episode.id DESC',
														'limit' => '15000, 30000'
													  ));
		$this->set('episodes', $episodes);
		$this->render('episode');
		Configure::write('debug', 0);
	}
}
?> 