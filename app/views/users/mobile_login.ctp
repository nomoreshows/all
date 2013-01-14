<div data-role="page" id="mobile-page" data-theme="b">
	<div data-role="header">
    	<h1>Série-All</h1>
    </div>
    
    <div data-role="content">
    	
        <div id="connexion">
			<?php
            echo $form->create('User', array( 'action' => 'login')); 
            e($form->input('login', array('label' => 'Identifiant :')));
            e($form->input('password', array('label' => 'Mot de passe :')));
            ?>
            <div class="ui-grid-a">
                <div class="ui-block-a"><button type="reset" data-theme="c">Annuler</button></div>
                <div class="ui-block-b"><button type="submit" data-theme="b">Valider</button></div>
            </div>
        </div>

    </div>
    
</div>



