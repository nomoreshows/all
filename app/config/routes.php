<?php
/* SVN FILE: $Id: routes.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::parseExtensions('rss','xml', 'json'); 
 	Router::connect('/focus', array('controller' => 'articles', 'action' => 'liste', 'focus'));
	
	// API
	Router::connect('/critics', array('controller' => 'apis', 'action' => 'displayAll'));
	Router::connect('/critics/after/*', array('controller' => 'apis', 'action' => 'displayAfter'));
	Router::connect('/news/all/*', array('controller' => 'apis', 'action' => 'displayAllNews'));
	Router::connect('/news/*', array('controller' => 'apis', 'action' => 'displayNews'));
	Router::connect('/critic/*', array('controller' => 'apis', 'action' => 'displayCritic'));
	Router::connect('/focus/*', array('controller' => 'apis', 'action' => 'displayFocus'));
	Router::connect('/bilan/*', array('controller' => 'apis', 'action' => 'displayBilan'));
	
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/a-propos', array('controller' => 'pages', 'action' => 'display', 'apropos'));
	Router::connect('/notre-equipe', array('controller' => 'pages', 'action' => 'display', 'equipe'));
	Router::connect('/mentions-legales', array('controller' => 'pages', 'action' => 'display', 'mentionslegales'));
	Router::connect('/contact', array('controller' => 'contacts', 'action' => 'index'));
	Router::connect('/membres', array('controller' => 'users', 'action' => 'index'));
	Router::connect('/series-tv', array('controller' => 'shows', 'action' => 'index'));
	Router::connect('/inscription', array('controller' => 'users', 'action' => 'add'));
	Router::connect('/planning-series-tv', array('controller' => 'episodes', 'action' => 'planning'));
	Router::connect('/classement-series-tv', array('controller' => 'shows', 'action' => 'classement'));
	
	Router::connect('/article/*', array('controller' => 'articles', 'action' => 'display'));
	Router::connect('/critiques', array('controller' => 'articles', 'action' => 'liste', 'critiques'));
	Router::connect('/podcasts', array('controller' => 'articles', 'action' => 'liste', 'podcasts'));
	Router::connect('/actualite', array('controller' => 'articles', 'action' => 'liste', 'news'));
	Router::connect('/videos-trailers', array('controller' => 'articles', 'action' => 'liste', 'videos'));
	Router::connect('/dossiers', array('controller' => 'articles', 'action' => 'liste', 'dossiers'));
	Router::connect('/bilans', array('controller' => 'articles', 'action' => 'liste', 'bilans'));
	
	Router::connect('/portraits', array('controller' => 'articles', 'action' => 'liste', 'portraits'));
	
	Router::connect('/awards-2010', array('controller' => 'polls', 'action' => 'awards2010'));
	Router::connect('/awards-2011', array('controller' => 'polls', 'action' => 'awards2011'));
	Router::connect('/series-rentree-2013', array('controller' => 'shows', 'action' => 'rentree2013', 'start'));
	Router::connect('/series-rentree-2011', array('controller' => 'shows', 'action' => 'eventRentree2011', 'start'));
	Router::connect('/nouvelles-series-2012-2013', array('controller' => 'shows', 'action' => 'eventRentree2012', 'start'));
	Router::connect('/nouvelles-series-2014-2015', array('controller' => 'shows', 'action' => 'rentree2014', 'start'));
	
	
	// Mobile
	Router::connect('/mobile', array('controller' => 'shows', 'action' => 'mobile', 'populaire'));
	Router::connect('/mobileLogin', array('controller' => 'users', 'action' => 'mobileLogin'));
	Router::connect('/mobileInfo', array('controller' => 'users', 'action' => 'mobileInfo'));
	Router::connect('/mobileInscription', array('controller' => 'users', 'action' => 'mobileAdd'));
	Router::connect('/mobileLogout', array('controller' => 'users', 'action' => 'mobileLogout'));
	
	Router::connect('/mobileShows/popular', array('controller' => 'shows', 'action' => 'mobileShows', 'popular'));
	Router::connect('/mobileShows/best', array('controller' => 'shows', 'action' => 'mobileShows', 'best'));
	Router::connect('/mobileShows/all', array('controller' => 'shows', 'action' => 'mobileShows', 'all'));
	Router::connect('/mobileShows/perso', array('controller' => 'shows', 'action' => 'mobileShows', 'perso'));
	
	Router::connect('/mobilePlanning/all', array('controller' => 'episodes', 'action' => 'mobilePlanning', 'all'));
	Router::connect('/mobilePlanning/perso', array('controller' => 'episodes', 'action' => 'mobilePlanning', 'perso'));
	
	Router::connect('/mobileShow/*', array('controller' => 'shows', 'action' => 'mobileShow'));
	Router::connect('/mobileSeason/*', array('controller' => 'seasons', 'action' => 'mobileSeason'));
	Router::connect('/mobileEpisode/*', array('controller' => 'episodes', 'action' => 'mobileEpisode'));
	Router::connect('/rates/mobileAddrate', array('controller' => 'rates', 'action' => 'mobileAdd'));
	Router::connect('/mobileAddcomment/*', array('controller' => 'comments', 'action' => 'mobileAdd'));
	Router::connect('/comments/mobileAddcomment/*', array('controller' => 'comments', 'action' => 'mobileAdd'));
	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/serie/*', array('controller' => 'shows', 'action' => 'fiche'));
	Router::connect('/saison/*', array('controller' => 'seasons', 'action' => 'fiche'));
	Router::connect('/episode/*', array('controller' => 'episodes', 'action' => 'fiche'));
	
	Router::connect('/profil/:login', array('controller' => 'users', 'action' => 'profil', 'accueil'), array('pass' => 'login'));
	Router::connect('/profil/:login/notifications', array('controller' => 'users', 'action' => 'profil', 'notifications'), array('pass' => 'login'));
	
	Router::connect('/profil/:login/series', array('controller' => 'users', 'action' => 'profil', 'series'), array('pass' => 'login'));
	Router::connect('/profil/:login/notes', array('controller' => 'users', 'action' => 'profil', 'notes'), array('pass' => 'login'));
	Router::connect('/profil/:login/avis', array('controller' => 'users', 'action' => 'profil', 'avis'), array('pass' => 'login'));
	Router::connect('/profil/:login/classements', array('controller' => 'users', 'action' => 'profil', 'classements'), array('pass' => 'login'));
	Router::connect('/profil/:login/parametres', array('controller' => 'users', 'action' => 'profil', 'parametres'), array('pass' => 'login'));
	
	
	// AVIS
	// http://localhost/serieall/avis/serie/24-heures-chrono/all
	Router::connect('/avis/serie/*', array('controller' => 'comments', 'action' => 'listeSerie'));
	Router::connect('/avis/saison/*', array('controller' => 'saison', 'action' => 'listeSaison'));
	Router::connect('/avis/episode/*', array('controller' => 'episode', 'action' => 'listeEpisode'));
	// http://localhost/serieall/avis/add/serie/24-heures-chrono
	Router::connect('/avis/add/*', array('controller' => 'comments', 'action' => 'add'));

	
	//Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'annuaire', 'url' => array('ext'=>'xml'))); 
	Router::connect('/sitemap1', array('controller' => 'sitemaps', 'action' => 'index', 'url' => array('ext'=>'xml'))); 
	Router::connect('/sitemap2', array('controller' => 'sitemaps', 'action' => 'episode', 'url' => array('ext'=>'xml'))); 
	Router::connect('/sitemap3', array('controller' => 'sitemaps', 'action' => 'episode2', 'url' => array('ext'=>'xml'))); 
	
/**
 * Administration
 */	
	Router::connect('/admin', array('controller' => 'users', 'action' => 'administration', 'prefix' => 'admin' ));
?>