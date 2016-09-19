	 <?php $this->pageTitle = 'Paramètres - Profil de ' . $user['User']['login']; ?>
     
     <script type="text/javascript">
		$(function() {
			$("a.delfollow").bind("click", function() {
				$(this).parent().parent().parent().parent().fadeOut("slow");			 
			});

		});
		</script>
     
    <div id="col1">
    	<div class="padl10">
      
        		<h1 class="red title"><?php echo $user['User']['login']; ?> &raquo; Notes</h1>
            <?php echo $this->element('profil-menu'); ?>
        	  
            <div id="profil-parametres">     
             	<?php 
                echo $form->create('User', array('url' => '/profil/' . $user['User']['login'] . '/parametres')); 
				
                echo '<fieldset><legend>Informations du compte</legend>';
                echo $form->input('id', array('type'=>'hidden'));
								echo $form->input('email', array('label' => 'Adresse mail :'));
                echo $form->input('password', array('label' => 'Mot de passe : <span class="notes">(ne rien mettre pour ne pas écraser l\'actuel)</span>', 'value' => ''));
                echo $form->input('password_confirm', array('type' => 'password', 'label' => 'Confirmer le mot de passe :'));
								echo $form->input('antispoilers', array('label' => 'Anti-spoilers : <span class="notes">cocher pour activer</span>'));
								//echo $form->input('decalage', array('label' => 'Décalage : <span class="notes">cocher pour décaler les diffusions US d\'une journée pour correspondre avec la sortie en France</span>'));
								//echo $form->input('feedcat', array('label' => 'Afficher sur la page d\'accueil le flux :', 'options' => array('essential' => 'des essentiels du site','contacts' => 'de mes abonnements', 'shows' => 'des séries', 'webshows' => 'des webséries')));
								echo '</fieldset>';
						
								echo '<fieldset><legend>Informations personnelles</legend>';
                echo $form->input('name', array('label' => 'Prénom :')); 
                echo $form->input('lname', array('label' => 'Nom :'));
                echo $form->input('sex', array('options' => array('homme' => 'Homme', 'femme' => 'Femme',), 'label' => 'Sexe :'));
                echo $form->input('birthdate', array('label' => 'Date de naissance :', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'maxYear' => date('Y')));
                echo $form->input('city', array('label' => 'Ville :'));
                echo $form->input('department', array('label' => 'Département :'));
                echo $form->input('country', array('label' => 'Pays :'));
                echo $form->input('job', array('label' => 'Profession :'));
                echo $form->input('twitter', array('label' => 'Compte twitter :'));
                echo $form->input('facebook', array('label' => 'Compte facebook :'));
                echo '</fieldset>';
                ?>
                <label for="btnValid"></label><button id="btnValid" type="submit"><span>Valider</span></button>
            </div>
    	</div>
    </div>
    
    <?php echo $this->element('profil-sidebar'); ?>
