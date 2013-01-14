<div data-role="page" id="mobile-page" data-theme="b">
	<div data-role="header">
    	<h1>Inscription</h1>
    </div>
    
    <div data-role="content">
    	
        <div id="connexion">
			<?php
            echo $form->create('User'); 
			echo $form->input('login', array('label' => 'Identifiant'));
            echo $form->input('password', array('label' => 'Mot de passe :'));
			echo $form->input('password_confirm', array('label' => 'Confirmer pass :'));
			echo $form->input('email', array('label' => 'Email :'));
			echo $form->input('cap', array('label' => 'Combien font 2 plus 2 ?', 'size' => 2));
            ?>
            <div class="ui-grid-a">
                <div class="ui-block-a"><button type="reset" data-theme="c">Annuler</button></div>
                <div class="ui-block-b"><button type="submit" data-theme="b">Valider</button></div>
            </div>
        </div>

    </div>
    
</div>


