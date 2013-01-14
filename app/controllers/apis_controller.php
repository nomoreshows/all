<?php
class ApisController extends AppController {
	
	var $name = "Apis";
	var $layout = "none";
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('displayAll', 'displayAfter', 'displayCritic', 'displayBilan', 'displayFocus', 'displayNews', 'displayAllNews'));
	}
	
	function displayAll() {
		$this->loadModel('Article');
		
    $this->paginate = array(
			'contain' => array(
				'Show' => array('fields' => array('Show.tvdb_id')), 
				'Season' => array('fields' => array('Season.name')), 
				'Episode' => array('fields' => array('Episode.numero'))
			), 
			'conditions' => array(
				'Article.show_id != 0',
				'Article.etat' => 1
			),
			'fields' => array('Article.id', 'Article.category', 'Article.url', 'Article.name', 'Article.modified'),
			'order' => 'Article.modified ASC',
			'limit' => 20
    );
		
		$articles = $this->paginate('Article');

		$results = array();
		foreach ($articles as $article) {
				if (!empty($article['Show']['tvdb_id'])) {
					$tvdb_id = $article['Show']['tvdb_id'];
					
					switch($article['Article']['category']) {
						
					case 'focus':
						$results['shows'][$tvdb_id]['focus'][] = array('id' => $article['Article']['id'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
						
					case 'news':
						$results['shows'][$tvdb_id]['news'][] = array('id' => $article['Article']['id'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
					
					case 'bilan':
						$results['seasons'][] = array('show_id' => $article['Show']['tvdb_id'], 'number' => $article['Season']['name'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
					
					case 'critique':
						$results['episodes'][] = array('show_id' => $article['Show']['tvdb_id'], 'season_number' => $article['Season']['name'], 'number' => $article['Episode']['numero'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
					
					default:
						break;
					}
				}
				
		}
		$this->view = 'Json';
		//$this->autoRender = false;
		//debug($articles);
		$this->set('json', $results);
	}
	
	function displayAfter($timestamp) {
		$this->loadModel('Article');

		$this->paginate = array(
			'contain' => array(
				'Show' => array('fields' => array('Show.tvdb_id')), 
				'Season' => array('fields' => array('Season.name')), 
				'Episode' => array('fields' => array('Episode.numero'))
			), 
			'conditions' => array(
				'Article.show_id != 0',
				'Article.etat' => 1,
				'Article.modified > "' . date("Y-m-d H:i:s", $timestamp) . '"'
			),
			'fields' => array('Article.id', 'Article.category', 'Article.url', 'Article.name', 'Article.modified'),
			'order' => 'Article.modified ASC',
			'limit' => 20
    );
		
		$articles = $this->paginate('Article');
		
		$results = array();
		foreach ($articles as $article) {
				if (!empty($article['Show']['tvdb_id'])) {
					$tvdb_id = $article['Show']['tvdb_id'];
					
					switch($article['Article']['category']) {
						
					case 'focus':
						$results['shows'][$tvdb_id]['focus'][] = array('id' => $article['Article']['id'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
						
					case 'news':
						$results['shows'][$tvdb_id]['news'][] = array('id' => $article['Article']['id'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
					
					case 'bilan':
						$results['seasons'][] = array('show_id' => $article['Show']['tvdb_id'], 'number' => $article['Season']['name'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
					
					case 'critique':
						$results['episodes'][] = array('show_id' => $article['Show']['tvdb_id'], 'season_number' => $article['Season']['name'], 'number' => $article['Episode']['numero'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
						break;
					
					default:
						break;
					}
				}
				
		}
		$this->view = 'Json';
		//$this->autoRender = false;
		//debug($articles);
		$this->set('json', $results);
	}
	
	
	
	function displayCritic($tvdb_id, $nosaison, $noepisode) {
		$this->loadModel('Article');
		
		if (empty($tvdb_id) || empty($nosaison) || empty($noepisode) || $tvdb_id === 0) {
			echo 'Wrong parameters';
			die();
		}
			
		$show = $this->Article->Show->find('first', array(
			'fields' => array('Show.id', 'Show.tvdb_id'), 
			'conditions'=> array('Show.tvdb_id' => $tvdb_id),
			'contain' => array(
				'Season' => array('fields' => array('Season.id', 'Season.name'), 'conditions' => array('Season.name' => $nosaison), 
					'Episode' => array('fields' => array('Episode.id', 'Episode.numero'), 'conditions' => array('Episode.numero' => $noepisode)), 
				 ))
		));
		
		if (!empty($show['Season']['0']['Episode'])) {
			$critic = $this->Article->find('first', array('contain' => false, 'fields' => array('Article.chapo', 'Article.name', 'Article.text'), 'conditions' => array('Article.show_id' => $show['Show']['id'], 'Article.season_id' => $show['Season'][0]['id'], 'Article.episode_id' => $show['Season'][0]['Episode'][0]['id'], 'Article.category' => 'critique')));
			if (empty($critic['Article']['text'])) {
				$critic = 'Pas de critique disponible.';
			} else {
				$critic = '<html><head></head><body><h1>'. utf8_decode($critic['Article']['name']) . '</h1><br />' . utf8_decode($critic['Article']['chapo']) . '<br /><br />' . $critic['Article']['text'] . '</body></html>';
			}
		} else {
			$critic = 'Cet épisode n\'existe pas.';
		}
		
		$this->autoRender = false;
		echo($critic);
	}

	
	function displayBilan($tvdb_id, $nosaison) {
		$this->loadModel('Article');
		
		if (empty($tvdb_id) || empty($nosaison) || $tvdb_id === 0) {
			echo 'Wrong parameters';
			die();
		}
		
		$show = $this->Article->Show->find('first', array(
			'fields' => array('Show.id', 'Show.tvdb_id'), 
			'conditions'=> array('Show.tvdb_id' => $tvdb_id),
			'contain' => array(
				'Season' => array('fields' => array('Season.id', 'Season.name'), 'conditions' => array('Season.name' => $nosaison)
			))
		));
		
		if (!empty($show['Season']['0'])) {
			$bilan = $this->Article->find('first', array('contain' => false, 'fields' => array('Article.chapo', 'Article.name', 'Article.text'), 'conditions' => array('Article.show_id' => $show['Show']['id'], 'Article.season_id' => $show['Season'][0]['id'], 'Article.episode_id' => 0, 'Article.category' => 'bilan')));
			if (empty($bilan['Article']['text'])) {
				$bilan = 'Pas de bilan disponible.';
			} else {
				$bilan = '<html><head></head><body><h1>'. utf8_decode($bilan['Article']['name']) . '</h1><br />' . utf8_decode($bilan['Article']['chapo']) . '<br /><br />' . $bilan['Article']['text'] . '</body></html>';
			}
		} else {
			$bilan = 'Cette saison n\'existe pas.';
		}
		
		$this->autoRender = false;
		echo($bilan);
	}
	
	
	
	function displayFocus($tvdb_id, $article_id) {
		$this->loadModel('Article');
		
		if (empty($tvdb_id) || empty($article_id) || $tvdb_id === 0 || $article_id === 0) {
			echo 'Wrong parameters';
			die();
		}
			
		$show = $this->Article->Show->find('first', array(
			'fields' => array('Show.id', 'Show.tvdb_id'), 
			'conditions'=> array('Show.tvdb_id' => $tvdb_id),
			'contain' => false
		));
		
		if (!empty($show['Show']['id'])) {
			$focus = $this->Article->find('first', array('contain' => false, 'fields' => array('Article.chapo', 'Article.name', 'Article.text'), 'conditions' => array('category' => 'focus', 'Article.id' => $article_id)));
			if (empty($focus['Article']['text'])) {
				$focus = 'Pas de focus disponible.';
			} else {
				$focus = '<html><head></head><body><h1>'. utf8_decode($focus['Article']['name']) . '</h1><br />' .utf8_decode($focus['Article']['chapo']) . '<br /><br />' . $focus['Article']['text'] . '</body></html>';
			}
		} else {
			$focus = 'Cette série n\'existe pas.';
		}
		
		$this->autoRender = false;
		echo($focus);
	}
	
	function displayNews($tvdb_id, $article_id) {
		$this->loadModel('Article');
		
		if (empty($tvdb_id) || empty($article_id) || $tvdb_id === 0 || $article_id === 0) {
			echo 'Wrong parameters';
			die();
		}
			
		$show = $this->Article->Show->find('first', array(
			'fields' => array('Show.id', 'Show.tvdb_id'), 
			'conditions'=> array('Show.tvdb_id' => $tvdb_id),
			'contain' => false
		));
		
		if (!empty($show['Show']['id'])) {
			$news = $this->Article->find('first', array('contain' => false, 'fields' => array('Article.chapo', 'Article.name', 'Article.text'), 'conditions' => array('category' => 'news', 'Article.id' => $article_id)));
			if (empty($news['Article']['text'])) {
				$news = 'Pas de news disponible.';
			} else {
				$news = '<html><head></head><body><h1>'. utf8_decode($news['Article']['name']) . '</h1><br />' . utf8_decode($news['Article']['chapo']) . '<br /><br />' . $news['Article']['text'] . '</body></html>';
			}
		} else {
			$news = 'Cette série n\'existe pas.';
		}
		
		$this->autoRender = false;
		echo($news);
	}
	
	
	function displayAllNews($year, $month, $day) {
		$this->loadModel('Article');
		$timestamp = strtotime($year . '-' . $month . '-' . $day);
		
		$articles = $this->Article->find('all', array(
			'contain' => array(
				'Show' => array('fields' => array('Show.tvdb_id')), 
			), 
			'conditions' => array(
				'Article.show_id != 0',
				'Article.etat' => 1,
				'Article.category' => 'news',
				'DATE_FORMAT(Article.modified, "%Y-%m-%d") = "' . date("Y-m-d", $timestamp) . '"'
			),
			'fields' => array('Article.id', 'Article.category', 'Article.url', 'Article.name'),
			'order' => 'Article.modified ASC'
		));
		
		if (!empty($articles)) {
			$results = array();
			foreach ($articles as $article) {
				$results[] = array('id' => $article['Article']['id'], 'show_id' => $article['Show']['tvdb_id'], 'url' => $article['Article']['url'] . '.html', 'title' => $article['Article']['name'], 'published_at' => $article['Article']['modified']);
			}
		} else {
			$results = 'Pas de news pour cette date.';
		}

		$this->view = 'Json';
		//$this->autoRender = false;
		//debug($articles);
		$this->set('json', $results);
	}
	

}