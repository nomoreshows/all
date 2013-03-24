<?php
class ShowsController extends AppController {
	
	var $name = "Shows";
	var $layout = "admin_serie";
	var $paginate = array(
        'contain' => array('User', 'Reaction' => array('User', 'order' => 'Reaction.id ASC')),
        'limit' => 10,
        'order' => 'Comment.id DESC'
    );
	var $cacheAction = array(
		'classement' => '2 hours',
		'index' => '1 hour',
		'fiche/' => '1 hour'
	);

	
	
	public function beforeFilter() {
   		parent::beforeFilter();
   		$this->Auth->allow(array('sortLetters', 'sortCat', 'mobileShows', 'mobileShow', 'eventRentree2011', 'eventRentree2012'));
	}
	
	// accueil mobile
	function mobile($cat) {
		$this->layout = 'mobile_default';	
		if ($cat == 'populaire') {
			$shows = $this->Show->find('all', array('contain' => false, 'order' => 'Show.nbnotes DESC', 'conditions' => 'priority = 1'));
		} else {
				
		}
		$this->set('cat', $cat);
		$this->set('shows', $shows);
	}
	
	// chercher une série
	function mobileShows($cat) {
		$this->layout = 'mobile_default';	
		if($cat == 'popular') {
			$shows = $this->Show->find('all', array('contain' => false, 'fields' => array('Show.name', 'Show.menu', 'Show.id'), 'order' => 'Show.nbnotes DESC', 'limit' => 20));
			$this->set('shows', $shows);
		} elseif ($cat == 'best') {
			$shows = $this->Show->find('all', array(
				'conditions' => array('Show.moyenne !=' => 0, 'Show.nbnotes >' => 100, 'Show.priority < 3'),
				'fields' => array('Show.name', 'Show.id', 'Show.moyenne', 'Show.menu'),
				'contain' => false,
				'order' => 'Show.moyenne DESC', 
				'limit' => 20
			));
			$this->set('shows', $shows);	
		} elseif ($cat == 'all') {
			$shows = $this->Show->find('all', array('contain' => false, 'fields' => array('Show.name', 'Show.moyenne', 'Show.menu', 'Show.id'), 'order' => 'Show.name ASC'));
			$this->set('shows', $shows);
		} elseif ($cat == 'perso') {
			$this->loadModel('User');
			$this->User->Followedshows->bindModel(array('belongsTo' => array('Show')));
			$shows = $this->User->Followedshows->find('all', array('conditions' => array('Followedshows.user_id' => $this->Auth->user('id'), 'Followedshows.etat' => 1), 'contain' => array('Show' => array('fields'=> array('Show.id', 'Show.moyenne', 'Show.name', 'Show.menu'))), 'order' => 'Show.name ASC'));
			$this->set('shows', $shows);
		}
	}
	
	// fiche série mobile
	function mobileShow($idshow) {
		$this->layout = 'mobile_default';	
		$show = $this->Show->find('first', array('contain' => array('Season'), 'conditions' => array('Show.id' => $idshow)));	
		$allcomments = $this->paginate('Comment', array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => 0));
		$this->set('show', $show);
		$this->set('allcomments', $allcomments);
	}
	
	
	function admin_index() {
		$shows = $this->Show->find('list');
		$this->set('shows', $shows);
	}
	
	function admin_temp() {
		$show_id = $this->data['Show']['show_id'];
		$this->redirect(array('controller' => 'shows', 'action' => 'edit', $show_id));
	}
	
	function index() {
		$this->layout = 'default';
		$lettre = 'a';
		$series = $this->Show->find('all', array('conditions' => array('Show.name LIKE' => $lettre .'%')));
		$this->set('series', $series);
		
		$popularseries = $this->Show->find('all', array('conditions' => 'priority = 1', 'fields' => array('Show.menu', 'Show.name', 'Show.annee'), 'contain' => false, 'limit' => 5, 'order' => 'Show.nbnotes DESC'));
		$lastseries = $this->Show->find('all', array('fields' => array('Show.menu', 'Show.name', 'Show.annee'), 'contain' => false, 'limit' => 5, 'order' => 'Show.id DESC'));
		$this->set('lastseries', $lastseries);
		$this->set('popularseries', $popularseries);
	}
	
	
	
	function fiche($menu) {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'none';
		} else {
			$this->layout = 'default';
		}
		$this->Session->write('Temp.referer', $this->referer());
		
		$show = $this->Show->findByMenu($menu);
		if(!empty($show['Show']['id'])) {
			
			// spécial Glee
			if($show['Show']['name'] == 'Glee') {
				$focus = $this->Show->Article->find('first', array('conditions' => array('Article.category' => 'focus', 'Article.show_id' => $show['Show']['id'])));
				$this->set(compact('focus'));
			}
			
			// Tout ce qui est pour ceux qui sont logués
			if ($this->Auth->user('role') > 0) {
				$alreadycomment = $this->Show->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$this->set(compact('alreadycomment'));
			} else {
				$this->set('alreadycomment', array());
			}
			
			// Avis pilot
			$season1 = $this->Show->Season->find('first', array('conditions' => array('Season.show_id' => $show['Show']['id']), 'contain' => false));
			$episode1 = $this->Show->Season->Episode->find('first', array('order' => 'id DESC', 'contain' => false, 'conditions' => array('Episode.season_id' => $season1['Season']['id'], 'Episode.numero' => 1)));
			$avispilot = $this->Show->Comment->find('all', array('contain' => array('User', 'Reaction' => array('User', 'order' => 'Reaction.id ASC')), 'conditions' => array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => $season1['Season']['id'], 'Comment.episode_id' => $episode1['Episode']['id'])));
			$this->set(compact('avispilot'));
			
			$avissaison1 = $this->Show->Comment->find('all', array('contain' => array('User', 'Reaction' => array('User', 'order' => 'Reaction.id ASC')), 'conditions' => array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => $season1['Season']['id'], 'Comment.episode_id' => 0)));
			$this->set(compact('avissaison1'));
			
			// derniers articles
			$articles = $this->Show->Article->find('all', array('contain' => false, 'conditions' => array('show_id' => $show['Show']['id'], 'category != "critique"', 'etat = 1'), 'fields' => array('id', 'show_id', 'category', 'name', 'url'), 'limit' => 10));
			
			$critiques = $this->Show->Article->find('all', array('contain' => false, 'conditions' => array('show_id' => $show['Show']['id'], 'category = "critique"', 'etat = 1'), 'fields' => array('id', 'show_id', 'category', 'name', 'url'), 'limit' => 6));
			$this->set(compact('critiques'));
			
			// Affiche rôles + saisons
			$roles = $this->Show->Role->find('all', array('contain' => array('Actor'), 'conditions' => array('show_id' => $show['Show']['id'])));
			$seasons = $this->Show->Season->find('all', array('conditions' => array('Season.show_id' => $show['Show']['id']), 'contain' => array('Show', 'Episode', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0')))));
			
			// Affiche les notes de la série = note de tous les épisodes
			$ratesshow = $this->Show->Rate->find('all', array('conditions' => array('Rate.show_id' => $show['Show']['id']), 'fields' => array('Rate.name', 'User.login', 'Season.name', 'Episode.numero', 'Show.menu')));
			
			// Affiche les derniers avis
			$comments = $this->Show->Comment->find('all', array('conditions' => array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => 0), 'order' => 'Comment.id DESC', 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
			
			// Affiche tous les avis
			$allcomments = $this->paginate('Comment', array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => 0));
			
			// Pourcentage d'abandon
			$this->Show->Followedshows->bindModel(array('belongsTo' => array('Show')));
			if ($show['Show']['encours']) {
				$followedshow = $this->Show->Followedshows->find('count', array('conditions' => 'Followedshows.show_id = ' . $show['Show']['id'] . ' AND ' . '(Followedshows.etat = 1 OR Followedshows.etat = 2)'));
			} else {
				$followedshow = $this->Show->Followedshows->find('count', array('conditions' => array('Followedshows.show_id' => $show['Show']['id'], 'Followedshows.etat' => 3)));
			}
			$abortedshow = $this->Show->Followedshows->find('count', array('conditions' => array('Followedshows.show_id' => $show['Show']['id'], 'Followedshows.etat' => 4)));
			$this->set(compact('followedshow'));
			$this->set(compact('abortedshow'));
			
			// Meilleurs épisodes
			$seasonin = '';
			foreach($seasons as $i => $season) {
				if ($i != 0) {
					$seasonin .= ', ';
				}
				$seasonin .= $season['Season']['id'];
			}
			$bestepisodes = $this->Show->Season->Episode->find('all', array('contain' => array('Season'), 'conditions' => array('Episode.moyenne != 0', 'Episode.season_id IN (' . $seasonin . ')'), 'order' => 'Episode.moyenne DESC', 'limit' => 8));
			$this->set(compact('bestepisodes'));
			
			if(!empty($comments)) {
				$commentsup = $this->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up','Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$commentsneutral = $this->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' ,'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$commentsdown = $this->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$this->set(compact('commentsup'));
				$this->set(compact('commentsneutral'));
				$this->set(compact('commentsdown'));
			}
			
			$this->set(compact('articles'));
			$this->set(compact('show'));
			$this->set(compact('seasons'));
			$this->set(compact('roles'));
			$this->set(compact('ratesshow'));
			$this->set(compact('comments'));
			$this->set(compact('allcomments'));
			
			if($this->RequestHandler->isAjax()) {
				$this->render(DS . 'elements' . DS . 'page-avis');
			} else {
				$this->render('fiche');
			}
			
		} else {
			$this->Session->setFlash('Aucune série correspondante.', 'growl');	
			$this->redirect($this->Session->read('Temp.referer'));	
		}
	}
	
	function sortLetters($lettre) {
		$this->layout = 'none';
		if ($lettre == 2) {
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'conditions' => array('Show.name LIKE "2%" OR Show.name LIKE "$%" OR Show.name LIKE "6%" OR Show.name LIKE "5%" OR Show.name LIKE "4%" OR Show.name LIKE "6%" OR Show.name LIKE "7%" OR Show.name LIKE "8%" OR Show.name LIKE "1%" OR Show.name LIKE "3%" OR Show.name LIKE "9%"'), 'fields' => array('Show.name', 'Show.menu', 'Show.id')));
		} else {
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'conditions' => array('Show.name LIKE' => $lettre .'%'), 'fields' => array('Show.name', 'Show.menu', 'Show.id')));
		}
		
		$this->set('series', $series);
		
		$this->render('sort_letters');
	}
	
	function sortCat() {
		$this->layout = 'none';
		$cat = $this->data['Show']['cat'];
		$this->set('cat', $cat);
		
		switch ($cat) {
		case 'genre':
			$genres = $this->Show->Genre->find('all');
			$this->set('genres', $genres);
			break;
		case 'format':
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'fields' => array('Show.name', 'Show.format', 'Show.menu'), 'order' => 'Show.format DESC'));
			$this->set('series', $series);
			break;
		case 'nationalite':
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'fields' => array('Show.name', 'Show.nationalite', 'Show.menu'), 'order' => 'Show.nationalite ASC'));
			$this->set('series', $series);
			break;
		case 'annee':
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'fields' => array('Show.name', 'Show.annee', 'Show.menu'), 'order' => 'Show.annee DESC'));
			$this->set('series', $series);
			break;
		case 'chaineus':
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'fields' => array('Show.name', 'Show.chaineus', 'Show.menu'), 'order' => 'Show.chaineus ASC'));
			$this->set('series', $series);
			break;
		case 'chainefr':
			$series = $this->Show->find('all', array('contain' => array('Season' => array('fields' => array('Season.id'))), 'fields' => array('Show.name', 'Show.chainefr', 'Show.menu'), 'order' => 'Show.chainefr ASC'));
			$this->set('series', $series);
			break;
		default:
			break;			
		}	
	}
	
	
	// Page des classements 
	function classement() {
		$this->layout = 'default';
		$bestseries = $this->Show->find('all', array(
			'conditions' => array('Show.moyenne !=' => 0, 'Show.nbnotes >' => 100),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$bestseriesus = $this->Show->find('all', array(
			'conditions' => array('Show.nationalite' => 'Américaine', 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 100),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$bestseriesfr = $this->Show->find('all', array(
			'conditions' => array('Show.nationalite' => 'Française', 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 20),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$bestseriesuk = $this->Show->find('all', array(
			'conditions' => array('Show.nationalite' => 'Anglaise', 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 30),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$this->Show->bindModel(array('hasOne' => array('GenresShow')));
		$bestseriesdrama = $this->Show->find('all', array(
			'conditions' => array('GenresShow.genre_id' => 5, 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 100),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('GenresShow', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$bestseriescomedie = $this->Show->find('all', array(
			'conditions' => array('GenresShow.genre_id' => 3, 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 100),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('GenresShow', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$bestseriessf = $this->Show->find('all', array(
			'conditions' => array('GenresShow.genre_id' => 11, 'GenresShow.genre_id' => 7, 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 100),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('GenresShow', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));
		
		$bestseriespolice = $this->Show->find('all', array(
			'conditions' => array('GenresShow.genre_id' => 8, 'GenresShow.genre_id' => 10, 'Show.moyenne !=' => 0, 'Show.nbnotes >' => 50),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'contain' => array('GenresShow', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0'))),
			'order' => 'Show.moyenne DESC', 
			'limit' => 15
		));

		$bestepisodes = $this->Show->Season->Episode->find('all', array(
			'conditions' => array('Episode.moyenne !=' => 0, 'Episode.nbnotes >' => 6),
			'recursive' => 2,
			'contain' => array(
				'Season' => array(
					'Show' => array(
						'fields' => array('id', 'name', 'menu')
					)
				),
				'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id != 0'))
			),
			'order' => 'Episode.moyenne DESC',
			'limit' => 15
		));
		$bestsaisons = $this->Show->Season->find('all', array(
			'conditions' => array('Season.moyenne !=' => 0, 'Season.nbnotes >' => 50),
			'order' => 'Season.moyenne DESC', 
			'limit' => 15,
			'contain' => array('Show', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0')))
		));	
		
		$flopseries = $this->Show->find('all', array(
			'conditions' => array('Show.moyenne !=' => 0, 'Show.nbnotes >' => 10,),
			'fields' => array('Show.name', 'Show.moyenne', 'Show.menu, Show.priority'),
			'order' => 'Show.moyenne ASC', 
			'limit' => 15,
			'contain' => array('Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0 AND Comment.season_id = 0')))
		));
		
		$flopsaisons = $this->Show->Season->find('all', array(
			'conditions' => array('Season.moyenne !=' => 0, 'Season.nbnotes >' => 5),
			'order' => 'Season.moyenne ASC', 
			'limit' => 15,
			'contain' => array('Show', 'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id = 0')))
		));	
		$flopepisodes = $this->Show->Season->Episode->find('all', array(
			'conditions' => array('Episode.moyenne !=' => 0, 'Episode.nbnotes >' => 4),
			'recursive' => 2,
			'contain' => array(
				'Season' => array(
					'Show' => array(
						'fields' => array('id', 'name', 'menu')
					)
				),
				'Comment' => array('conditions' => array('Comment.article_id = 0 AND Comment.episode_id != 0'))
			),
			'order' => 'Episode.moyenne ASC',
			'limit' => 15
		));
		
		// rédac
		$topredac = $this->Show->Rate->find('all', array('conditions' => array('User.isRedac' => 1), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'COUNT(DISTINCT(User.id)) AS NbRedac', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu'), 'group' => 'Rate.show_id HAVING NbRedac > 3', 'order' => 'Moyenne DESC', 'limit' => 20));
		$this->set(compact('topredac'));
		//debug($topredac);
		
		$flopredac = $this->Show->Rate->find('all', array('conditions' => array('User.role < 3', 'Show.moyenne != 0'), 'fields' => array('AVG(Rate.name) as Moyenne', 'COUNT(Rate.name) as Somme', 'COUNT(DISTINCT(User.id)) AS NbRedac', 'Rate.name', 'Rate.show_id', 'Show.name', 'Show.menu'), 'group' => 'Rate.show_id HAVING NbRedac > 3', 'order' => 'Moyenne ASC', 'limit' => 20));
		$this->set(compact('flopredac'));
		
		$bestchannels = $this->Show->find('all', array(
			'conditions' => array('Show.moyenne !=' => 0, 'Show.nbnotes >' => 40),
			'fields' => array('AVG(Show.moyenne) AS Moyenne', 'COUNT(Show.chaineus) AS nbseries', 'Show.name', 'Show.chaineus'),
			'contain' => false,
			'group' => 'Show.chaineus HAVING nbseries > 3',
			'order' => 'Moyenne DESC', 
			'limit' => 10
		));	
		
		$flopchannels = $this->Show->find('all', array(
			'conditions' => array('Show.moyenne !=' => 0, 'Show.nbnotes >' => 10),
			'fields' => array('AVG(Show.moyenne) AS Moyenne', 'COUNT(Show.chaineus) AS nbseries', 'Show.name', 'Show.chaineus'),
			'contain' => false,
			'group' => 'Show.chaineus HAVING nbseries > 3',
			'order' => 'Moyenne ASC', 
			'limit' => 10
		));	
		$this->set('bestchannels', $bestchannels);
		$this->set('flopchannels', $flopchannels);
		
		$popularseries = $this->Show->find('all', array('conditions' => 'priority = 1', 'fields' => array('Show.menu', 'Show.name', 'Show.annee'), 'contain' => false, 'limit' => 15, 'order' => 'Show.nbnotes DESC'));
		$lastseries = $this->Show->find('all', array('fields' => array('Show.menu', 'Show.name', 'Show.annee'), 'contain' => false, 'limit' => 15, 'order' => 'Show.id DESC'));
		$this->set('lastseries', $lastseries);
		$this->set('popularseries', $popularseries);
		
		$this->set('bestseries', $bestseries);
		$this->set('bestseriesus', $bestseriesus);
		$this->set('bestseriesuk', $bestseriesuk);
		$this->set('bestseriesfr', $bestseriesfr);
		$this->set('bestseriesdrama', $bestseriesdrama);
		$this->set('bestseriescomedie', $bestseriescomedie);
		$this->set('bestseriessf', $bestseriessf);
		$this->set('bestseriespolice', $bestseriespolice);
		//$this->set('bestseriesworld', $bestseriesworld);
		$this->set('bestsaisons', $bestsaisons);
		$this->set('bestepisodes', $bestepisodes);
		$this->set('flopseries', $flopseries);
		$this->set('flopsaisons', $flopsaisons);
		$this->set('flopepisodes', $flopepisodes);
		
	}
	
	// RENTREE 2011
	function eventRentree2011($filter) {
		$this->layout = 'default';
		$contain = array('User', 'Season', 'Role');
		
		switch($filter) {
		
		case 'start':
		case 'all':
			$filterTitle = 'Toutes les nouveautés';
			$shows = $this->Show->find('all', array(
			   'conditions' => array('Show.is_rentree2011' => true),
			   'contain' => $contain,
			   'order' => 'diffusionus ASC'
			));
			break;
		
		case 'popular':
			$filterTitle = 'Les blockbusters';
			$shows = $this->Show->find('all', array(
			   'conditions' => array('Show.is_popular2011' => true),
			   'contain' => $contain,
			   'order' => 'diffusionus ASC'
			));
			break;
		
		case 'press':
			$filterTitle = 'Les séries qui vont conquérir les critiques';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (345, 508, 452, 526)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'fear':
			$filterTitle = 'Les séries dont on a très peur';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (640, 620, 562, 639)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'girls':
			$filterTitle = 'Les séries à regarder (ou subir) avec votre moitié';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (478, 496, 634, 471, 503, 493, 497)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'lost':
			$filterTitle = 'Les séries des anciens de Lost';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (466, 467, 491, 636)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'abc':
			$filterTitle = 'Les séries d\'ABC (Lost, Desperate H., Grey\'s...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.chaineus' => 'ABC'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'hbo':
			$filterTitle = 'Les séries de HBO (Six Feet Under, True Blood...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.is_rentree2011' => true, 'Show.chaineus' => 'HBO'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'nbc':
			$filterTitle = 'Les séries de NBC (Scrubs, Chuck, Community...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.chaineus' => 'NBC'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'cw':
			$filterTitle = 'Les séries de CW (Gossip Girl, Vampire Diaries...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.chaineus' => 'The CW'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'showtime':
			$filterTitle = 'Les séries de Showtime (Dexter, Californication...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.chaineus' => 'Showtime'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'cbs':
			$filterTitle = 'Les séries de CBS (NCIS, Mentalist, HIMYM...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.chaineus' => 'CBS'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
			
		case 'fox':
			$filterTitle = 'Les séries de FOX (Fringe, Bones...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.chaineus' => 'FOX'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;

		case 'police':
			$filterTitle = 'Les nouvelles séries policières';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id' => 10), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2011' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'comic':
			$filterTitle = 'Les nouvelles comédies';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id' => 3), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2011' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'drama':
			$filterTitle = 'Les nouveaux drama';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id' => 5), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2011' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'fantas':
			$filterTitle = 'Les nouvelles séries fantastiques';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id = 7'), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2011' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'uk':
			$filterTitle = 'Les nouvelles séries british';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.nationalite' => 'Anglaise'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'fr':
			$filterTitle = 'Les nouvelles séries de chez nous';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2011' => true, 'Show.nationalite' => 'Française'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'lol':
			$filterTitle = 'Les séries à regarder alcoolisé';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (488, 607, 616, 468)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		default: 
			break;
		}
		
		$this->set('shows', $shows);
		$this->set('filterTitle', $filterTitle);
		if ($filter != 'start') {
			$this->layout = 'none';
			$this->render('/elements/event-rentree2011');
		}
	}
	
	
	// RENTREE 2012
	function eventRentree2012($filter) {
		$this->layout = 'default';
		$contain = array('Season', 'Role');
		
		switch($filter) {
		
		case 'all':
			$filterTitle = 'Toutes les nouveautés';
			$shows = $this->Show->find('all', array(
			   'conditions' => array('Show.is_rentree2012' => true),
			   'contain' => $contain,
			   'order' => 'diffusionus ASC'
			));
			break;
		
		case 'start':
		case 'te':
			$filterTitle = 'Les séries les plus prometteuses';
			$shows = $this->Show->find('all', array(
			   'conditions' => array('Show.is_rentree2012 = 1 AND Show.te_rentree2012 > 49'),
			   'contain' => $contain,
			   'order' => 'diffusionus ASC'
			));
			break;
		
		case 'te-':
			$filterTitle = 'Les séries dont on attend pas grand chose';
			$shows = $this->Show->find('all', array(
			   'conditions' => array('Show.is_rentree2012 = 1 AND Show.te_rentree2012 < 50 AND Show.te_rentree2012 > 19'),
			   'contain' => $contain,
			   'order' => 'diffusionus ASC'
			));
			break;
		
		case 'te--':
			$filterTitle = 'On vous conseille vivement d\'éviter de les croiser';
			$shows = $this->Show->find('all', array(
			   'conditions' => array('Show.is_rentree2012 = 1 AND Show.te_rentree2012 < 20 AND Show.te_rentree2012 != 0'),
			   'contain' => $contain,
			   'order' => 'diffusionus ASC'
			));
			break;
		
		case 'popular':
			$filterTitle = 'Les blockbusters';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (345, 508, 452, 526)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'press':
			$filterTitle = 'Les séries qui vont conquérir les critiques';
			$shows = $this->Show->find('all', array('conditions' => array('Show.id IN (345, 508, 452, 526)'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'abc':
			$filterTitle = 'Les séries d\'ABC (Lost, Desperate H., Grey\'s...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus' => 'ABC'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'hbo':
			$filterTitle = 'Les séries de HBO (Six Feet Under, Game of Thrones...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus' => 'HBO'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'nbc':
			$filterTitle = 'Les séries de NBC (Scrubs, Chuck, Community...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus' => 'NBC'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'cw':
			$filterTitle = 'Les séries de CW (Gossip Girl, Vampire Diaries...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus LIKE "%CW%"'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'showtime':
			$filterTitle = 'Les séries de Showtime (Dexter, Californication...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus' => 'Showtime'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'cbs':
			$filterTitle = 'Les séries de CBS (NCIS, Mentalist, HIMYM...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus' => 'CBS'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
			
		case 'fox':
			$filterTitle = 'Les séries de FOX (Fringe, Bones...)';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.chaineus LIKE "%FOX%"'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;

		case 'police':
			$filterTitle = 'Les nouvelles séries policières';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id' => 10), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2012' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'comic':
			$filterTitle = 'Les nouvelles comédies';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id' => 3), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2012' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'drama':
			$filterTitle = 'Les nouveaux drama';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id' => 5), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2012' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'fantas':
			$filterTitle = 'Les nouvelles séries fantastiques';
			$shows = $this->Show->Genre->find('all', array('conditions' => array('Genre.id = 7'), 'contain' => array('Season', 'User', 'Role', 'Show' => array('conditions' => array('Show.is_rentree2012' => true), 'order' => 'diffusionus ASC'))));
			$shows = $shows[0]['Show'];
			foreach($shows as $i => $show) {
				$tmpshow = $shows[$i];
				unset($shows[$i]);
				$shows[$i]['Show'] = $tmpshow;
			}
			break;
		
		case 'uk':
			$filterTitle = 'Les séries anglaises';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.nationalite' => 'Anglaise'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'us':
			$filterTitle = 'Les séries américaines';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.nationalite' => 'Américaine'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		case 'ca':
			$filterTitle = 'Les séries canadiennes';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.nationalite' => 'Canadienne'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;

		
		case 'fr':
			$filterTitle = 'Les séries françaises';
			$shows = $this->Show->find('all', array('conditions' => array('Show.is_rentree2012' => true, 'Show.nationalite' => 'Française'), 'order' => 'diffusionus ASC', 'contain' => $contain));
			break;
		
		default: 
			break;
		}
		
		$this->set('shows', $shows);
		$this->set('filterTitle', $filterTitle);
		if ($filter != 'start') {
			$this->layout = 'none';
			$this->render('/elements/event-rentree2012');
		}
	}

	
	function autoComplete() {
		$this->layout = 'default';
		// Configure::write('debug', 0);
		$shows = $this->Show->find('all', array(
		   'conditions' => array('Show.name LIKE' => $this->params['url']['q'].'%'),
		   'fields' => array('name', 'id')));
		$this->set('shows', $shows);
	}

	
	function admin_add() {
		if (!empty($this->data)) {
			$resultat = $this->Show->save($this->data);
			if ($resultat) {
				$this->Session->setFlash('La série a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'shows', 'action' => 'index')); 
			}
		}
		$this->set('genres', $this->Show->Genre->find('list'));
		$this->set('users', $this->Show->User->find('list', array('order' => 'User.role ASC')));
	}
	
	function admin_edit($id) {
		$this->Show->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Show->read();
		} else {
			if ($this->Show->save( $this->data )) {
				$this->Session->setFlash('La série a été modifié.', 'growl');	
				$this->redirect(array('controller' => 'shows', 'action' => 'index'));
			}
		}
		$this->set('genres', $this->Show->Genre->find('list'));
		$this->set('users', $this->Show->User->find('list', array('order' => 'User.role ASC')));
	}
	
	
	function admin_delete($id) {
		$this->Show->del($id);
		$this->Session->setFlash('La série a été supprimé.', 'growl');	
		$this->redirect(array('controller' => 'shows', 'action' => 'index'));
	}	
	
	function updatenotes() {
		$this->layout = 'default';
		
		$shows = $this->Show->find('all', array('fields' => 'Show.id', 'contain' => array('Season'), 'order' => 'Show.id ASC'));
		
		foreach ($shows as $show) {
			$total = 0;
			foreach($show['Season'] as $season) {
				$total += $season['nbnotes'];
			} 
			echo $total . ' ';
			$this->Show->id = $show['Show']['id'];
			$this->Show->saveField('nbnotes', $total);
		}
				
	}
	
	
}
?>
