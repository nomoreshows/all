
	<br /><br />
	<strong><?php echo $message; ?></strong><br /><br />
    
    <?php
	if ($error == 0) {
		
		echo 'URL : ' . $html->link('http://serieall.fr/img/article/' . $upload['Upload']['name'], '/img/article/' . $upload['Upload']['name']);
		echo '<br /><span class="notes">Copiez cette URL dans votre article.</span><br /><br />';
		echo $html->image('article/' . $upload['Upload']['name']);
		
	}
	
?>