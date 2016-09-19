 <?php $this->pageTitle = 'Artistes'; ?>
 	
    <ul>
    <?php
 	foreach ($artists as $artist) {
 		echo '<li>' . $html->link($artist['Artist']['name'], '/artist/' . $artist['Artist']['url']) . '</li>';
	}
	?>
	</ul>