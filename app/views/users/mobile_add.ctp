<div data-role="page" id="mobile-page" data-theme="b">
	<div data-role="header">
    	<h1>Inscription</h1>
    </div>
    
    <div data-role="content">
    	
        <div id="connexion">
			<?php
            echo $form->create('User', array( 'action' => 'mobileAdd')); 
			
			echo '<div data-role="fieldcontain">';
			echo $form->input('login', array('label' => 'Identifiant : <em>(lettres et chiffres)</em>'));
            echo $form->input('password', array('label' => 'Mot de passe : <em>(lettres et chiffres)</em>'));
			echo $form->input('password_confirm', array('type' => 'password', 'label' => 'Confirmer mot de passe :'));
			echo $form->input('email', array('label' => 'Email :'));
			echo '</div>';
			
			echo '<div data-role="fieldcontain">';
			echo $form->input('cap', array('label' => 'Combien font 2 plus 2 ?'));
			echo '</div>';
            ?>
            <div class="ui-grid-a">
                <div class="ui-block-a"><button type="reset" data-theme="c">Annuler</button></div>
                <div class="ui-block-b"><button type="submit" data-theme="b">Valider</button></div>
            </div>
        </div>

    </div>
    
</div>


