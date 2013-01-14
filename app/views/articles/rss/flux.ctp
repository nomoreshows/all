<?php
$this->pageTitle = 'Derniers articles de serieall.fr';

echo $rss->items($articles, 'sortieRSS');

 
function sortieRSS($article) {
		// You should import Sanitize
		App::import('Sanitize');
		// This is the part where we clean the body text for output as the description 
		// of the rss item, this needs to have only text to make sure the feed validates


	  return array(
		'title' => $article['Article']['name'],
		'link'  => 'http://www.serieall.fr/article/'.$article['Article']['url'] . '.html',
		'guid' => array('url' => 'http://www.serieall.fr/article/'.$article['Article']['url'] . '.html', 'isPermaLink' => 'true'),
		'description' => $article['Article']['chapo']. '<br /><br />' .$article['Article']['text'],
		'pubDate' => $article['Article']['created']
	  );
}
?>