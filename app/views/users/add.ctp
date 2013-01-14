<?php $this->pageTitle = 'Créér un compte'; ?>

<?php 
echo $javascript->link('jquery.nivo.slider.pack', false); 
echo $javascript->link('perso.signup', false);
?> 

<div class="padl15">
    <br />
    <h2 class="red">Inscription à Série-All</h2><br /><br />
    
    <table>
    <tr>
    <td width="50%">
    	<br /><br />
        <div class="signup">
		<?php echo $form->create('User'); ?>
        <?php echo $form->input('role', array('label' => false, 'type' => 'hidden')); ?>
        
        <?php echo $form->input('login', array('label' => '<span class="notes">*</span> Pseudo :<br /><span class="notes">http://serieall.fr/profil/<strong>pseudo</strong></span>')); ?>
        <?php echo $form->input('password', array('label' => '<span class="notes">*</span> Mot de passe :<br /><span class="notes">lettres et chiffres uniquement</span>')); ?>
        <?php echo $form->input('password_confirm', array('label' => '<span class="notes">*</span> Confirmer  :<br /><span class="notes">confirmer le mot de passe</span>', 'type' => 'password')); ?>
        <?php echo $form->input('email', array('label' => '<span class="notes">*</span> Adresse mail :<br /><span class="notes">n\'est pas affichée ni diffusée</span>')); ?>
        <br /><br />
        <?php echo $form->input('cap', array('label' => '<span class="notes">*</span> Combien font 2+2<br /><span class="notes">contre les robots</span>', 'size' => 2)); ?>
        </div>
        <br /><br />
        <div class="newsletter"><?php echo $form->input('newsletter', array('checked' => 'true', 'label' => false, 'div' => false));?> Je souhaite recevoir la newsletter de Série-All (<span class="notes">une <strong>vraie</strong> newsletter : jolie, mensuelle au maximum, avec du contenu intéressant)</span></div>
        <br /><br />
        <label for="btnsignup">&nbsp;</label><button id="btnsignup" type="submit"></button>
    </td>
    <td width="50%">
    	<div id="slider" class="nivoSlider">
    		<?php echo $html->image('signup-1.png', array('alt' => 'Notez tous les épisodes de vos séries préférées')); ?>
            <?php echo $html->image('signup-2.png', array('alt' => 'Laissez des avis sur les séries que vous regardez')); ?>
            <?php echo $html->image('signup-3.png', array('alt' => 'Organisez les séries dans votre profil')); ?>
            <?php echo $html->image('signup-4.png', array('alt' => 'Bénéficiez d\'un planning personnalisé')); ?>
        </div>
    </td>
    </tr>
    </table>

</div>

