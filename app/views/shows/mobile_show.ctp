<div data-role="page" id="mobile-page" data-theme="b" data-back-btn-text="Accueil">
	<div data-role="header" data-theme="b">
    	<h1><?php echo $show['Show']['name']; ?></h1>
    </div>
    
    <div data-role="content">
    	
        <?php echo $html->image('show/' . $show['Show']['menu'] . '_w.jpg', array('align' => 'center', 'style' => 'width:290px; border:2px solid white;')); ?>
        <div align="center"><p>Moyenne : <?php echo $show['Show']['moyenne']; ?> <?php echo $star->convert($show['Show']['moyenne']); ?></p></div>

        
        <div data-role="collapsible">
            <h3>Saisons</h3>
            <ul data-role="listview" data-inset="true" data-theme="d">
            	<?php foreach ($show['Season'] as $season) {
					echo '<li>' . $html->link('Saison ' . $season['name'], '/mobileSeason/' . $season['id']) . '</li>'; 
				} ?>
            </ul>
        </div>
        
		<div data-role="collapsible" data-collapsed="true">
            <h3>Synopsis</h3>
            <p><?php echo $show['Show']['synopsis']; ?></p>
        </div>
        
        <div data-role="collapsible" data-collapsed="true">
            <h3>Avis sur la série (<?php echo count($allcomments); ?>)</h3>
            <?php echo $avis->displayMobile($allcomments, $session->read('Auth.User.id'), $session->read('Auth.User.role', 0), false); ?>
        </div>


    </div>
    
</div>
        
	  
