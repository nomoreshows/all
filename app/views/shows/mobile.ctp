<?php $this->pageTitle = 'Mobile version';  ?>

<div data-role="page" id="mobile-page" data-back-btn-text="Accueil">
	<div id="mobile-header">
    	<?php echo $html->image('mobile/logo.jpg', array('alt' => 'Série-All')); ?> 
        <?php if($session->read('Auth.User.role') > 0) { ?> <br />Bienvenue <?php echo $session->read('Auth.User.login'); ?> ! <?php } ?>
    </div>
    
    <div data-role="content">
    	<?php if($session->read('Auth.User.role') > 0) { ?>
            <div class="ui-grid-a">
                <div class="ui-block-a"><?php echo $html->link('Mon profil', '/mobilePlanning', array('data-role' => 'button')); ?></div>
                <div class="ui-block-b"><?php echo $html->link('Déconnexion', '/mobileLogout', array('data-role' => 'button', 'data-transition' => 'fade')); ?></div>
            </div>
            <div class="ui-grid-a">
                <div class="ui-block-a"><?php echo $html->link('Mon planning', '/mobilePlanning/perso', array('data-role' => 'button', 'data-transition' => 'flip')); ?></div>
                <div class="ui-block-b"><?php echo $html->link('Planning US', '/mobilePlanning/all', array('data-role' => 'button', 'data-transition' => 'flip')); ?></div>
            </div>
            
		<?php } else { ?>
        	<strong>Avec un compte Série-All</strong> vous pourrez : 
            <ul>
                <li>noter les épisodes de votre mobile</li>
                <li>consulter votre planning personnalisé</li>
                <li>lire les avis des séries / saisons / épisodes</li>
                <li>accéder aux séries de votre profil en quelques secondes</li>
            </ul>
            <div class="ui-grid-a">
                <div class="ui-block-a"><?php echo $html->link('Connexion', '/mobileLogin', array('data-role' => 'button')); ?></div>
                <div class="ui-block-b"><?php echo $html->link('Inscription', '/mobileInscription', array('data-role' => 'button', 'data-theme' => 'b')); ?></div>
            </div>
           	<?php echo $html->link('Planning US complet', '/mobilePlanning/all', array('data-role' => 'button', 'data-transition' => 'flip')); ?>
        <?php } ?>
    	
    	
        
        <br /><br />
        
        <ul data-role="listview" data-theme="b">
        	<?php if($session->read('Auth.User.role') > 0) { ?><li><?php echo $html->link('Mes séries en cours', '/mobileShows/perso'); ?></li><?php } ?>
            <li><?php echo $html->link('Chercher une série...', '/mobileShows/all'); ?></li>
            <li><?php echo $html->link('Les 20 meilleurs séries', '/mobileShows/best'); ?></li>
            <li><?php echo $html->link('Les 20 séries les plus populaires', '/mobileShows/popular'); ?></li>
        </ul>

    </div>
    

</div>