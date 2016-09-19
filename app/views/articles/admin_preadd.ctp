<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un(e) <?php echo $cat; ?></h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'articles', 'action' => 'index', 'prefix' => 'admin', $cat), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 

	switch($cat) {
	case 'news':
	case 'dossier':
	case 'video':
	case 'podcast':
	case 'chronique':
		// Formulaire normal -> passage à add() directement avec show_id
		echo $form->create('Article'); 
		echo '<fieldset><legend>Informations à remplir </legend>';
		echo $form->input('category', array('type' => 'hidden', 'value' => $cat));
		echo $form->input('show_id', array('label' => 'Série :'));
		echo $form->input('isserie', array('type' => 'checkbox', 'label' => 'Cocher si cela ne concerne pas une série'));
		echo $form->end('Suivant');
		echo '</fieldset>';
		break;
	case 'focus':
		// Formulaire normal -> passage à add() directement avec show_id
		echo $form->create('Article'); 
		echo '<fieldset><legend>Informations à remplir </legend>';
		echo $form->input('category', array('type' => 'hidden', 'value' => $cat));
		echo $form->input('show_id', array('label' => 'Série :'));
		echo $form->end('Suivant');
		echo '</fieldset>';
		break;
	case 'critique':
	case 'bilan':
		// Formulaire Ajax -> passage à loadSeasons() pour rechercher les saisons
		echo $ajax->form('Article', 'post', array('model' => 'Article', 'url' => array('controller' => 'articles', 'action' => 'loadSeasons'), 'update' => 'season-ajax'));
		echo '<fieldset><legend>Informations à remplir </legend>';
		echo $form->input('category', array('type' => 'hidden', 'value' => $cat));
		echo $form->input('show_id', array('label' => 'Série :'));
		echo $form->end('Suivant');
		echo '<div id="season-ajax"></div>';
		echo '<div id="episode-ajax"></div>';
		echo '</fieldset>';
		break;
	
	case 'portrait':
		// Formulaire normal -> passage à add() directement avec actor_id
		echo $form->create('Article'); 
		echo '<fieldset><legend>Informations à remplir </legend>';
		echo $form->input('category', array('type' => 'hidden', 'value' => $cat));
		echo $form->input('role_id', array('label' => 'Rôle concerné :'));
		echo $form->end('Suivant');
		echo '</fieldset>';
		break;
	}

	
	//debug($shows);?>
	