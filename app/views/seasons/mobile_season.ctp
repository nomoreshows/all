<div data-role="page" id="mobile-page" data-theme="b">
	<div data-role="header" data-theme="b">
    	<h1><?php echo $season['Show']['name']; ?></h1>
    </div>
    
    <div data-role="content">
    	
        <?php echo $html->image('show/' . $season['Show']['menu'] . '_w.jpg', array('align' => 'center', 'style' => 'width:320px; border:2px solid white;')); ?>
        <div align="center"><p>Saison <?php echo $season['Season']['name']; ?></p></div>
        
        
        <div data-role="collapsible">
            <h3>Episodes (<?php echo count($season['Episode']); ?>)</h3>
            <ol data-role="listview" data-inset="true" data-theme="d">
            	<?php foreach ($season['Episode'] as $episode) {
					echo '<li>' . $html->link($episode['name'], '/mobileEpisode/' . $episode['id']) . '</li>'; 
				} ?>
            </ol>
        </div>
        
        <div data-role="collapsible" data-collapsed="true">
            <h3>Avis sur la saison (<?php echo count($allcomments); ?>)</h3>
            <?php echo $avis->displayMobile($allcomments, $session->read('Auth.User.id'), $session->read('Auth.User.role', 0), false); ?>
        </div>


    </div>
    
</div>
        
	  
