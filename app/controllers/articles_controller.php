<?php
class ArticlesController extends AppController {
	
	var $name = "Articles";
	var $layout = "admin_contenu";
	
	function admin_index($category_name) {
		if ($category_name != 'all') {
			$liste_articles = $this->Article->find('all', array('contain' => false, 'limit' => 100, 'conditions' => array('Article.category' => $category_name), 'fields' => array('Article.id', 'Article.etat', 'Article.name', 'Article.chapo')));
		} else {
			$liste_articles = $this->Article->find('all', array('contain' => false, 'fields' => array('Article.id', 'Article.etat', 'Article.name', 'Article.chapo'), 'limit' => 20));
		}
		$this->set('articles', $liste_articles);
		$this->set('category_name', $category_name);
	}
	
	function flux() {
		$this->layout = 'default';
		$articles = $this->Article->find('all',	array(	'order' => 'Article.id DESC',
				'conditions' => array('etat' => 1, 'rss' => 0), 'contain' => false,
				'limit' => 10
			)
		);
		$channel = array(
			'title' => utf8_encode("Série-All - Webzine séries tv"),
			'description' => utf8_encode("Les derniers articles de serieall.fr"),
			'language' => 'fr',
			'webMaster' => 'serieall.fr@gmail.com'
		);
		$this->set(compact('articles', 'channel'));
	}

	
	
	function display($url) {
		$this->layout = 'default';
		$url = explode('.', $url);
		
		//modif elpio : get uniquement l'id de l'article, qu'importe le exte avant. Pour limiter la casse pour les pb de mauvaises urls (avec accents, etc.)
		$url = explode('_', $url[0]);  //decoupe l'url en fonction de l'underscore pour separer le texte et l'id
		$url = end($url); 	//recup de l'id sous forme a123 ou 123 est l'id
		$id = substr($url,1); //suppression du a avant l'id
		
		//$article = $this->Article->findByUrl($url[0]); //=> old code
		$article = $this->Article->findById($id); //Recherche de l'article avec l'id
		
		// Infos rédacteur
		$ratesredac = $this->Article->User->Rate->find('all', array(
				'conditions' => array('Rate.user_id' => $article['Article']['user_id']),
				'fields' => array('Rate.name'),
				'contains' => false
			));
		$avisredac = $this->Article->User->Comment->find('count', array(
			'conditions' => array('Comment.user_id' => $article['Article']['user_id'], 'Comment.article_id' => 0),
			'contains' => false
		));
		$this->set(compact('ratesredac'));
		$this->set(compact('avisredac'));
		
		switch($article['Article']['category']) {
		case 'critique':
			$show = $this->Article->Show->find('first',array('contain' => array('Genre', 'Season'),'conditions' => array('id' => $article['Article']['show_id'])));
			$season = $this->Article->Season->find('first',array('contain' => false,'conditions' => array('Season.id' => $article['Article']['season_id'])));
			$episode = $this->Article->Episode->find('first',array('conditions' => array('Episode.id' => $article['Article']['episode_id'])));
			$rates = $this->Article->Episode->Rate->find('all', array('contain' => array('User'),'conditions' => array('Rate.episode_id' => $episode['Episode']['id'])));
			$comments = $this->Article->Comment->find('all', array(
				'conditions' => array('Comment.article_id' => $article['Article']['id']),
				'fields' => array('Comment.text', 'User.login', 'Comment.created', 'User.email'),
				'order' => 'Comment.id ASC', 
				'contains' => false
			));
			$nbnotes = $this->Article->Episode->Rate->find('count', array('conditions' => array('Rate.episode_id' => $episode['Episode']['id'])));
			
			// Tout ce qui est pour ceux qui sont logués
			if ($this->Auth->user('role') > 0) {
				$alreadycomment = $this->Article->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.episode_id' => $episode['Episode']['id'])));
				$this->set(compact('alreadycomment'));
			} else {
				$this->set('alreadycomment', array());
			}
			// Autres articles sur la série
			$articlesserie = $this->Article->find('all', 
				array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
					'contain' => false,
					'fields' => array('Article.name', 'Article.url'), 
					'order' => array('Article.id DESC'), 
					'limit' => 5));
			$this->set(compact('articlesserie'));
			// Dernières critiques de la série
			$critiquesserie = $this->Article->find('all', 
				array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id !=' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
					'fields' => array('Article.name', 'Article.url'), 
					'contain' => false,
					'order' => array('Article.id DESC'), 
					'limit' => 5));
			$this->set(compact('critiquesserie'));
			// Affiche les derniers avis
			$avisserie = $this->Article->Comment->find('all', array('contain' => ('User'),'conditions' => array('Comment.episode_id' => $episode['Episode']['id'], 'Comment.thumb' != '')), array('order' => 'Comment.id DESC', 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
			$this->set(compact('avisserie'));
			
			if(!empty($avisserie)) {
				$commentsup = $this->Article->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up', 'Comment.episode_id' => $episode['Episode']['id'])));
				$commentsneutral = $this->Article->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' , 'Comment.episode_id' => $episode['Episode']['id'])));
				$commentsdown = $this->Article->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.episode_id' => $episode['Episode']['id'])));
				$this->set(compact('commentsup'));
				$this->set(compact('commentsneutral'));
				$this->set(compact('commentsdown'));
			}
			$this->set(compact('comments'));
			$this->set(compact('show'));
			$this->set(compact('season'));
			$this->set(compact('episode'));
			$this->set(compact('rates'));
			$this->set(compact('article'));
			$this->render('display_critique');
			break;
		case 'bilan':
			$show = $this->Article->Show->find('first',array('contain' => array('Genre', 'Season'),'conditions' => array('id' => $article['Article']['show_id'])));
			$season = $this->Article->Season->find('first',array('contain' => false,'conditions' => array('Season.id' => $article['Article']['season_id'])));
			$comments = $this->Article->Comment->find('all', array(
				'conditions' => array('Comment.article_id' => $article['Article']['id']),
				'fields' => array('Comment.text', 'User.login', 'Comment.created', 'User.email'),
				'order' => 'Comment.id ASC', 
				'contains' => false
			));
			// Affiche les derniers avis
			$avisserie = $this->Article->Season->Comment->find('all', 
				array('conditions' => array('Comment.season_id' => $article['Article']['season_id'], 'Comment.thumb' != '', 'Comment.episode_id' => 0)), 
				array('order' => array('Comment.id DESC'), 
				'limit' => 2, 
				'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
			$this->set(compact('avisserie'));
			if(!empty($avisserie)) {
				$commentsup = $this->Article->Season->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$commentsneutral = $this->Article->Season->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' , 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$commentsdown = $this->Article->Season->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$this->set(compact('commentsup'));
				$this->set(compact('commentsneutral'));
				$this->set(compact('commentsdown'));
			}
			// Tout ce qui est pour ceux qui sont logués
			if ($this->Auth->user('role') > 0) {
				$alreadycomment = $this->Article->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.season_id' => $season['Season']['id'], 'Comment.episode_id' => 0)));
				$this->set(compact('alreadycomment'));
			} else {
				$this->set('alreadycomment', array());
			}
			// Autres articles sur la série
			$articlesserie = $this->Article->find('all', 
				array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
				'fields' => array('Article.name', 'Article.url'), 
				'order' => array('Article.id DESC'),
				'contain' => false,				
				'limit' => 5));
			$this->set(compact('articlesserie'));
			// Dernières critiques de la série
			$critiquesserie = $this->Article->find('all', 
			array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id !=' => 0, 'Article.id !=' => $article['Article']['id'],'Article.etat' => 1), 
			'fields' => array('Article.name', 'Article.url'), 
			'order' => array('Article.id DESC'), 
			'contain' => false,
			'limit' => 5));
			$this->set(compact('critiquesserie'));
			
			// liste des notes = moyenne des épisodes de la saison
			$rates = $this->Article->Season->Rate->find('all', array('conditions' => array('Rate.season_id' => $season['Season']['id']), 'fields' => array('Rate.name', 'User.login', 'Season.name', 'Episode.numero', 'Show.menu')));
			$this->set(compact('rates'));
			$this->set(compact('avis'));
			
			// Dernières news
			$news = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières bilans
			$bilans = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières focus
			$focus = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières portraits
			$portraits = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières portraits
			$videos = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières critiques
			$critiques = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
				'contain' => array('Show'),
				'limit' => 3, 
			));
			$this->set(compact('news'));
			$this->set(compact('bilans'));
			$this->set(compact('focus'));
			$this->set(compact('portraits'));
			$this->set(compact('videos'));
			$this->set(compact('critiques'));
			
			$this->set(compact('comments'));
			$this->set(compact('show'));
			$this->set(compact('season'));
			$this->set(compact('article'));
			$this->render('display_bilan');
			break;
			
		case 'focus':
			$show = $this->Article->Show->find('first',array('contain' => array('Genre', 'Season'),'conditions' => array('id' => $article['Article']['show_id'])));
			$comments = $this->Article->Comment->find('all', array(
				'conditions' => array('Comment.article_id' => $article['Article']['id']),
				'fields' => array('Comment.text', 'User.login', 'Comment.created', 'User.email'),
				'order' => 'Comment.id ASC', 
				'contain' => array('Comment', 'User')
			));
			// Tout ce qui est pour ceux qui sont logués
			if ($this->Auth->user('role') > 0) {
				$alreadycomment = $this->Article->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$this->set(compact('alreadycomment'));
			} else {
				$this->set('alreadycomment', array());
			}
			// Affiche les notes de la série = note de tous les épisodes
			$ratesshow = $this->Article->Show->Rate->find('all', array('conditions' => array('Rate.show_id' => $show['Show']['id']), 'fields' => array('Rate.name', 'User.login', 'Season.name', 'Episode.numero', 'Show.menu')));
			
			// Affiche les derniers avis
			$avisserie = $this->Article->Show->Comment->find('all', array('contain' => array('Comment', 'User'),'conditions' => array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => 0)), array('order' => array('Comment.id DESC'), 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
			$this->set(compact('avisserie'));
			// Autres articles sur la série
			$articlesserie = $this->Article->find('all', 
				array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
					'fields' => array('Article.name', 'Article.url'), 
					'order' => array('Article.id DESC'), 
					'limit' => 5));
			$this->set(compact('articlesserie'));
			// Dernières critiques de la série
			$critiquesserie = $this->Article->find('all', 
				array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id !=' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
				'fields' => array('Article.name', 'Article.url'), 
				'order' => array('Article.id DESC'), 
				'limit' => 5));
			$this->set(compact('critiquesserie'));
			
			if(!empty($avisserie)) {
				$commentsup = $this->Article->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up','Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$commentsneutral = $this->Article->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' ,'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$commentsdown = $this->Article->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
				$this->set(compact('commentsup'));
				$this->set(compact('commentsneutral'));
				$this->set(compact('commentsdown'));
			}
			$this->set(compact('ratesshow'));
			$this->set(compact('comments'));
			$this->set(compact('show'));
			$this->set(compact('article'));
			$this->render('display_focus');
			break;
		case 'podcast':	
		case 'news':
		case 'dossier':
		case 'video':
		case 'chronique':
			if ($article['Article']['show_id'] != 0) {
				// Série concernée
				$show = $this->Article->Show->find('first',array('contain' => array('Genre', 'Season'),'conditions' => array('id' => $article['Article']['show_id'])));
				$this->set(compact('show'));
				// Autres articles sur la série
				$articlesserie = $this->Article->find('all', 
					array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
						'fields' => array('Article.name', 'Article.url'), 
						'order' => array('Article.id DESC'), 
						'limit' => 5));
				$this->set(compact('articlesserie'));
				// Dernières critiques de la série
				$critiquesserie = $this->Article->find('all', 
					array('conditions' => array('Article.show_id' => $article['Article']['show_id'], 'Article.episode_id !=' => 0, 'Article.id !=' => $article['Article']['id'], 'Article.etat' => 1), 
					'fields' => array('Article.name', 'Article.url'), 
					'order' => array('Article.id DESC'), 
					'limit' => 5));
				$this->set(compact('critiquesserie'));

				// Affiche les derniers avis
				$avisserie = $this->Article->Show->Comment->find('all', array('conditions' => array('Comment.show_id' => $show['Show']['id'], 'Comment.thumb' != '', 'Comment.season_id' => 0)), array('order' => array('Comment.id DESC'), 'limit' => 2, 'fields' => array('Comment.text', 'User.login', 'Comment.thumb', 'Show.name', 'Show.id')));
				$this->set(compact('avisserie'));
				if(!empty($avisserie)) {
					$commentsup = $this->Article->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'up','Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$commentsneutral = $this->Article->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'neutral' ,'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$commentsdown = $this->Article->Show->Comment->find('count', array('conditions' => array('Comment.thumb' => 'down', 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$this->set(compact('commentsup'));
					$this->set(compact('commentsneutral'));
					$this->set(compact('commentsdown'));
				}
				// Tout ce qui est pour ceux qui sont logués
				if ($this->Auth->user('role') > 0) {
					$alreadycomment = $this->Article->Comment->find('first', array('conditions' => array('Comment.user_id' => $this->Auth->user('id'), 'Comment.show_id' => $show['Show']['id'], 'Comment.season_id' => 0)));
					$this->set(compact('alreadycomment'));
				} else {
					$this->set('alreadycomment', array());
				}
			}
			// Dernières news
			$news = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
                'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières bilans
			$bilans = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
                'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières focus
			$focus = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
                'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières portraits
			$portraits = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
                'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières portraits
			$videos = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
                'contain' => array('Show'),
				'limit' => 3, 
			));
			// Dernières critiques
			$critiques = $this->Article->find('all', array(
				'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
				'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
				'order' => 'Article.id DESC', 
                'contain' => array('Show'),
				'limit' => 3, 
			));
			$this->set(compact('news'));
			$this->set(compact('bilans'));
			$this->set(compact('focus'));
			$this->set(compact('portraits'));
			$this->set(compact('videos'));
			$this->set(compact('critiques'));
			// Commentaires de la news
			$comments = $this->Article->Comment->find('all', array(
				'conditions' => array('Comment.article_id' => $article['Article']['id']),
				'fields' => array('Comment.text', 'User.login', 'Comment.created', 'User.email'),
				'order' => 'Comment.id ASC', 
			));
			$this->set(compact('comments'));
			$this->set(compact('article'));
			$render = 'display_' . $article['Article']['category'];
			if($article['Article']['category'] == 'chronique') $render = 'display_dossier';
			$ratesshow = $this->Article->Show->Rate->find('all', array('conditions' => array('Rate.show_id' => $show['Show']['id']), 'fields' => array('Rate.name', 'User.login', 'Season.name', 'Episode.numero', 'Show.menu'), 'limit' => 5));
			$this->set(compact('ratesshow'));
			$this->render($render);
			break;
			
		case 'portrait':
			$role = $this->Article->Role->findbyId($article['Article']['role_id']);
			$show = $this->Article->Show->find('first',array('contain' => array('Genre'),'conditions' => array('id' => $article['Article']['show_id'])));
			$this->set(compact('role'));
			$this->set(compact('show'));
			$this->set(compact('article'));
			$comments = $this->Article->Comment->find('all', array(
					'conditions' => array('Comment.article_id' => $article['Article']['id']),
					'fields' => array('Comment.text', 'User.login', 'Comment.created', 'User.email'),
					'order' => 'Comment.id ASC', 
				));
			$this->set(compact('comments'));
			// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
			// Autres articles sur la série
			$articlesserie = $this->Article->find('all', array('conditions' => array('Article.show_id' => $show['Show']['id'], 'Article.episode_id' => 0, 'Article.id !=' => $article['Article']['id']), 'fields' => array('Article.name', 'Article.url'), 'order' => array('Article.id DESC'), 'limit' => 6));
			$this->set(compact('articlesserie'));
			// Dernières critiques de la série
			$critiquesserie = $this->Article->find('all', array('conditions' => array('Article.show_id' => $show['Show']['id'], 'Article.episode_id !=' => 0, 'Article.id !=' => $article['Article']['id']), 'fields' => array('Article.name', 'Article.url'), 'order' => array('Article.id DESC'), 'limit' => 6));
			$this->set(compact('critiquesserie'));
			// Affiche les notes de la série = note de tous les épisodes
			$ratesshow = $this->Article->Show->Rate->find('all', array('conditions' => array('Rate.show_id' => $show['Show']['id']), 'fields' => array('Rate.name', 'User.login', 'Season.name', 'Episode.numero', 'Show.menu'), 'limit' => 5));
			$this->set(compact('ratesshow'));
			$this->render('display_portrait');
			break;
		default:
		}
		
	}
	
	
	
	function liste($category) {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'none';
		} else {
			$this->layout = 'default';
		}
		
		switch($category) {
			case 'podcasts':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category = "podcast"', 'Article.etat' => 1));
				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-podcasts');
				}
				break;
			case 'news':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category' => 'news', 'Article.etat' => 1));
				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-news');
				}
				break;
			case 'critiques':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category' => 'critique', 'Article.etat' => 1));
				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-critiques');
				}
				break;
			case 'dossiers':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category = "dossier" OR Article.category = "chronique"', 'Article.etat' => 1));
				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-dossiers');
				}
				break;
			case 'videos':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category' => 'video', 'Article.etat' => 1));
				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-videos');
				}
				break;
			case 'bilans':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category' => 'bilan', 'Article.etat' => 1));
				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-bilans');
				}
				break;
			case 'focus':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category' => 'focus', 'Article.etat' => 1));
   				$// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-focus');
				}
				break;
			case 'portraits':
				$this->paginate['limit'] = 15;
				$articles = $this->paginate('Article', array('Article.category' => 'portrait', 'Article.etat' => 1));
   				// Dernières news
				$news = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'news', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières bilans
				$bilans = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'bilan', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières focus
				$focus = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'focus', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$portraits = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'portrait', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières portraits
				$videos = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'video', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				// Dernières critiques
				$critiques = $this->Article->find('all', array(
					'conditions' => array('Article.category' => 'critique', 'Article.etat' => 1),
					'fields' => array('Article.name', 'Article.photo', 'Article.url', 'Article.show_id', 'Article.chapo', 'Show.menu', 'Article.created'),
					'order' => 'Article.id DESC', 
                    'contain' => array('Show'),
					'limit' => 3, 
				));
				$this->set(compact('news'));
				$this->set(compact('bilans'));
				$this->set(compact('focus'));
				$this->set(compact('portraits'));
				$this->set(compact('videos'));
				$this->set(compact('critiques'));
   				$this->set('articles', $articles);
				if($this->RequestHandler->isAjax()) {
					$this->render(DS . 'elements' . DS . 'page-critiques');
				} else {
					$this->render('liste-portraits');
				}
				break;
		}
		
	}
	
	
	
	
	function admin_preadd($category_name) {
		$this->set('cat', $category_name);
		switch($category_name) {
		case 'news':
		case 'critique':
		case 'bilan':
		case 'focus':
		case 'dossier':
		case 'video':
		case 'podcast':
		case 'chronique':
			$this->loadModel('Show');
			$this->set('shows', $this->Show->find('list'));
			break;
		case 'portrait':
			$this->loadModel('Role');
			$this->set('roles', $this->Role->find('list'));
			break;
		}
	}
	
	function admin_loadSeasons() {
		$this->layout = 'none';
		$category = $this->data['Article']['category'];

		// Recherche des saisons correspondant au show_id
		$show_id = $this->data['Article']['show_id'];
		$this->loadModel('Season');
		$seasons = $this->Season->find('list', array('conditions' => array('Season.show_id =' => $show_id)));
		$this->set('seasons', $seasons);
		$this->set('show_id', $show_id);
		$this->set('category', $category);
	}
	
	function admin_loadEpisodes() {
		$this->layout = 'none';
		$season_id = $this->data['Article']['season_id'];
		$category = $this->data['Article']['category'];
		
		$this->loadModel('Episode');
		$episodes = $this->Episode->find('list', array('conditions' => array('Episode.season_id =' => $season_id), 'fields' => array('Episode.id', 'Episode.numero'), 'order' => 'Episode.numero ASC'));
		$this->set('episodes', $episodes);
		$this->set('category', $category);
	}
	

	function admin_add() {
		
		if (!empty($this->data['Article']['user_id'])) {
			// Ajout à la BDD
			$category_name = $this->data['Article']['category'];
			
			// Récupération du dernier id pour l'ajouter à la fin de l'url
			$lastarticle = $this->Article->find('first', array('order' => 'Article.id DESC'));
			$lastid = $lastarticle['Article']['id'] + 1;
			
			//Modif Elpio : automatisation du remplissage du champ pour eviter les soucis d'urls : on recup le titre 
			//et retire accents etc., ajoute des - a la place des espaces, tout en minuscule
			$substitut = array ('À'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a', 'Å'=>'a', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o', 'Ø'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'È'=>'e', 'É'=>'e', 'Ê'=>'e', 'Ë'=>'e', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'Ç'=>'c', 'ç'=>'c', 'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'Ù'=>'u', 'Ú'=>'u', 'Û'=>'u', 'Ü'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ÿ'=>'y', 'Ñ'=>'n', 'ñ'=>'n', '('=>'', ')'=>'', '['=>'', ']'=>'', '\\'=>'', '\''=>'-', '"'=>'', '~'=>'', '$'=>'', '&'=>'and', '%'=>'', '*'=>'', '@'=>'', 'ç'=>'c', '!'=>'', '?'=>'', ';'=>'', ','=>'', ':'=>'', '/'=>'', '^'=>'', '€'=>'e', '¨'=>'', '{'=>'', '}'=>'', '<'=>'', '>'=>'', '|'=>'', '+'=>'', '.'=>'', '-'=>'-', '_'=>'-', ' '=>'-', '’'=>'');
			$urlArticle = strtolower(strtr($this->data['Article']['name'],$substitut));
			$urlArticle = preg_replace('/(([-])\2)\2*/', '-', $urlArticle);//retrait des doublons de tirets
			$this->data['Article']['url'] = $urlArticle;
				
			$this->data['Article']['url'] = $this->data['Article']['url'] . '_a' . $lastid; //=> old code : ajoute l'id au bout
			
			$resultat = $this->Article->save($this->data);
			if ($resultat) {
				
				/*
				if($this->data['Article']['etat'] === 1 && $this->data['Article']['category'] === 'news' && $this->data['Article']['show_id'] !== 0) {
					
					$show = $this->Article->Show->find('first', array(
						'fields' => array('Show.id', 'Show.tvdb_id'), 
						'conditions'=> array('Show.id' => $this->data['Article']['show_id'])
					));
		
					$url = 'http://api.tozelabs.com/v2/show/' . $show['Show']['tvdb_id'] . '/news';
					$fields = array(
								'news_id'=>urlencode($this->Article->id),
								'url'=>urlencode($this->data['Article']['url'] . '.html')
							);

					//url-ify the data for the POST
					foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
					rtrim($fields_string,'&');

					//open connection
					$ch = curl_init();

					//set the url, number of POST vars, POST data
					curl_setopt($ch,CURLOPT_URL,$url);
					curl_setopt($ch,CURLOPT_POST,count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

					//execute post
					$result = curl_exec($ch);

					//close connection
					curl_close($ch);
				}
				*/
				
				$this->Session->setFlash('L\'article a été ajouté.', 'growl');	
				$this->redirect(array('controller' => 'articles', 'action' => 'index', 'prefix' => 'admin', $category_name));
			}
		} 
			
		$category = $this->data['Article']['category'];
		$this->set('cat', $category);
		
		switch($category) {
		
		case 'critique':
			// Spécificité : Nom de l'épisode dans le formulaire
			$episode_id = $this->data['Article']['episode_id'];
			$this->loadModel('Episode');
			$episode = $this->Episode->findById($episode_id);
			$this->loadModel('Season');
			$season = $this->Season->findById($episode['Episode']['season_id']);
			$this->loadModel('Show');
			$show = $this->Show->findById($season['Season']['show_id']);
			$this->set('episode', $episode);
			$this->set('season', $season);
			$this->set('show', $show);
			break;
			
		case 'news':
		case 'dossier':
		case 'video':
		case 'podcast':
		case 'chronique':
			if ($this->data['Article']['isserie'] == 0) {
				// Concerne une série
				$show_id = $this->data['Article']['show_id'];
				$this->loadModel('Show');
				$show = $this->Show->findById($show_id);
				$this->set('show', $show);
			} else {
				// Ne concerne pas une série	
				$this->set('show', 0);
			}
			break;
		case 'bilan':
			// Spécificité : Nom de la saison dans le formulaire
			$season_id = $this->data['Article']['season_id'];
			$this->loadModel('Season');
			$season = $this->Season->findById($season_id);
			$this->loadModel('Show');
			$show = $this->Show->findById($season['Season']['show_id']);
			$this->set('season', $season);
			$this->set('show', $show);
			break;
			break;
		case 'focus':
			// Spécificité : Nom de la série dans le formulaire
			$show_id = $this->data['Article']['show_id'];
			$this->loadModel('Show');
			$show = $this->Show->findById($show_id);
			$this->set('show', $show);
			break;
		case 'portrait':
			// Spécificité : Nom de l'acteur dans le formulaire
			$role_id = $this->data['Article']['role_id'];
			$this->loadModel('Role');
			$role = $this->Role->findById($role_id);
			$this->set('role', $role);
			break;
		}
		
		$this->Session->write('Temp.referer', $this->referer());
	}
	
	
	
	function admin_edit($id) {
		$this->Article->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Article->read();
			$cat = $this->data['Article']['category'];
			
			$users = $this->Article->User->find('list');
			$this->set(compact('users'));
			
			switch($cat) {
			case 'critique':
				$episode_id = $this->data['Article']['episode_id'];
				$episodes = $this->Article->Episode->find('list', array('conditions' => array('Episode.season_id =' => $this->data['Article']['season_id']), 'fields' => array('Episode.id', 'Episode.numero'), 'order' => 'Episode.numero ASC'));
				$this->set(compact('episodes'));
				break;
			case 'news':
			case 'podcast':
			case 'dossier':
				$show_id = $this->data['Article']['show_id'];
				if (empty($show_id)) {
					$this->set('show', 0);
				} else {
					$show = $this->Article->Show->findById($show_id);
					$shows = $this->Article->Show->find('list');
					$this->set(compact('shows'));
					$this->set(compact('show'));
				}
				break;
			case 'portrait':
				$role_id = $this->data['Article']['role_id'];
				$role = $this->Article->Role->findById($role_id);
				$roles = $this->Article->Role->find('list');
				$this->set(compact('role'));
				$this->set(compact('roles'));
			}
		} else {
			if ($this->Article->save( $this->data)) {
				$this->Session->setFlash('L\'article a été modifié.', 'growl');	
				$this->redirect($this->Session->read('Temp.referer'));
			}
		}
		$this->Session->write('Temp.referer', $this->referer());
	}

	
	
	function admin_delete($id) {
		$this->Session->write('Temp.referer', $this->referer());
		$this->Article->del($id);
		$this->Session->setFlash('L\'article a été supprimé.', 'growl');	
		$this->redirect($this->Session->read('Temp.referer'));
		
	}
}
?>
