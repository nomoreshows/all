	<?php $this->pageTitle = 'Nous contacter'; 
	echo $html->meta('Contactez-nous pour nous suggérer des améliorations, si vous souhaitez devenir rédacteur sur le site, ou toute demande de partenariat.', array('type'=>'description'), false); 
	?>	

<div id="col1">
	
    <div class="padl15">
    <h2 class="red">Formulaire de contact</h2><br /><br />
    
    <div class="article">
    Vous pouvez nous contacter par email <!-- <a class="decoblue" href="mailto:contact@serieall.fr">contact[at]serieall.fr</a> --> si :
    <br /><br />
    <ul>
    	<li>vous voulez nous suggérer une amélioration / constater un bug</li>
    	<li>vous souhaitez devenir rédacteur sur serieall.fr</li>
        <li>vous êtes intéressés par un espace publicitaire sur le site</li>
        <li>vous voulez nous proposer un partenariat (nous étudions toute demande)</li>
        <li>vous avez quelque chose de complètement différent à nous dire</li>
    </ul>
    <br />
    <br />
    Contactez nous par mail : serieall.fr[at]gmail.com<br />
    <!--
    <?php e($form->create('Contact', array('url' => '/contacts/index'))); ?>
     
    <fieldset>
        <legend>Vos coordonnées</legend>
        <?php
        e($form->input('nom', array('label' => "Nom :", 'size' => 20)));
        e($form->input('prenom', array('label' => "Prénom :", 'size' => 20)));
        e($form->input('email', array('label' => "Adresse mail :", 'size' => 20)));
        ?>
    </fieldset>
     
    <fieldset>
        <legend>Votre message</legend>
        <?php e($form->textarea('message', array('cols' => 90, 'rows' => 12))); ?> 
        <?php e($form->error('message')); ?> 
    </fieldset>
     
    <?php e($form->end("Envoyer")); ?>
    -->
    </div>
    </div>

</div>

<div id="col2">
	<div id="colright-stats">
        <div class="colrstats-header"></div>
        <div class="colr-content">
        	<br /><br />
            <strong>Statistiques sur le public et les visites du site disponibles prochainement.</strong>
            <br /><br />
        </div>
        <div class="colr-footer"></div>
    </div>

</div>