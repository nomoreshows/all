<?php 

/*$this->pageTitle = "Identification requise";
 
 Formulaire de connexion
e($form->create('User', array('action' => 'login')));
e($form->input('login', array('label' => 'Identifiant :')));
e($form->input('password', array('label' => 'Mot de passe :')));
e($form->end("Connexion"));*/


?>

<?php if ($session->check('Message.auth')) $session->flash('auth'); ?>


<form id="UserLoginForm" method="post" action="/serieall/users/login">
	<input type="hidden" name="_method" value="POST" />
    
    <p class="pform">
		<label class="login" for="UserLogin">Identifiant :</label>
		<input class="bginput" name="data[User][login]" type="text" maxlength="16" value="" id="UserLogin" />
    </p>
    
    <p class="pform">
    	<label class="login" for="UserPassword">Mot de passe :</label>
		<input class="bginput" type="password" name="data[User][password]" value="" id="UserPassword" />
    </p>
    
    <p class="pform">
        <label class="login" for="submit"></label>
        <input type="image" id="submit" src="/cakephp/img/login/btn_valider.png" /> 
        <?php echo $html->link($html->image('login/btn_password.png'), '#', array('escape' => false)); ?>
    </p>
</form>



