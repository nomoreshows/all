<script type="text/javascript">
$(function() {
	$(".tabs").tabs();
});
</script>

<script type="text/javascript">
    tinyMCE.init({
        theme : "advanced",
        mode : "textareas",
		language : 'fr',
        convert_urls : false,
		editor_selector : 'mceAdvanced',
		plugins : "safari,spellchecker,advhr,advimage,advlink,emotions,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,table",

	// Theme options
	theme_advanced_buttons1 : "fullscreen,|,bold,italic,underline,strikethrough,|,h2,bullist,numlist,outdent,indent,blockquote,link,unlink,anchor,|,charmap,emotions,insertimage,image,media,|,tablecontrols",
	theme_advanced_buttons2 : "newdocument,undo,redo,|,cut,copy,paste,pastetext,pasteword,|,formatselect,forecolor,search,replace,|,cleanup,code,spellchecker,preview",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true

});
</script>

<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un(e) <?php echo $cat; ?></h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'articles', 'action' => 'index', 'prefix' => 'admin', $cat), array('escape' => false)); ?>
        </td>
    </tr>
</table>
	<?php 
	
	echo $form->create('Article', array('type' => 'file')); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	if($session->read('Auth.User.isRedac') == 1) echo $form->input('etat', array('label' => 'Publié :')); else echo '<span class="notes">L\'article sera enregistré en tant que brouillon. Pour le publier demandez à quelqu\'un de la "rédaction".</span><br /><br />';
	
	echo $form->input('category', array('type' => 'hidden', 'value' => $cat ));
	echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id') ));
	
	switch($cat) {
	case 'critique':
		// Ajout des 3 id + du titre et URL prérempli
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		echo $form->input('rss_podcast', array('label' => 'Ajout au flux RSS Podcast :'));
		echo $form->input('Episode.name', array('label' => 'Episode :', 'value' => $episode['Episode']['name'], 'disabled' => true));
		echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id'] ));
		echo $form->input('season_id', array('type' => 'hidden', 'value' => $season['Season']['id'] ));
		echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id'] ));
		echo $form->input('caption', array('type' => 'hidden', 'value' => $season['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT)));
		echo $form->input('name', array('label' => 'Titre :', 'size' => '50', 'value' => 'Critique : ' . $show['Show']['name'] . ' '.  $season['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT)));
		echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50', 'value' => 'critique-' . $show['Show']['menu'] . '-' . 's' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT)));
		break;
	case 'news':
	case 'video':
	case 'chronique':
	case 'dossier':
	case 'podcast':
		// Ajout de show_id + titre et URL vides
		if ($show != 0) {
			echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
			echo $form->input('Show.name', array('label' => 'Série :', 'value' => $show['Show']['name'], 'disabled' => true));
			echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id'] ));
			echo $form->input('name', array('label' => 'Titre :', 'size' => '50'));
			//echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50'));
		} else {
			echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
			echo $form->input('name', array('label' => 'Titre :', 'size' => '50'));
			//echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50'));
			echo $form->input('photo', array('type' => 'file', 'label' => 'Image à la une:<br /><span class="notes">(image carrée de préférence, 78*78px)</span>'));
			echo '<br />';
		}
		if ($cat == 'news') {
			echo $form->input('source', array('label' => 'Source:<br /><span class="notes">(mettre uniquement l\'URL)</span>', 'size' => '50', 'value' => 'http://'));
			echo $form->input('caption', array('type' => 'hidden', 'value' => 'News'));
		} elseif($cat == 'video') {
			echo $form->input('caption', array('type' => 'hidden', 'value' => 'Vidéo'));
		} elseif($cat == 'dossier') {
			echo $form->input('caption', array('type' => 'hidden', 'value' => 'Dossier'));
		} elseif($cat == 'chronique') {
			echo $form->input('caption', array('type' => 'hidden', 'value' => 'Edito'));
		}
		break;
	
	case 'focus':
		// Ajout de show_id + titre et URL préremplis
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		echo $form->input('caption', array('type' => 'hidden', 'value' => 'Focus'));
		echo $form->input('Show.name', array('label' => 'Série :', 'value' => $show['Show']['name'], 'disabled' => true));
		echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id'] ));
		echo $form->input('name', array('label' => 'Titre :', 'size' => '50', 'value' => 'Focus sur ' . $show['Show']['name']));
		echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50', 'value' => 'focus-' . $show['Show']['menu']));
		break;
	case 'bilan':
		// Ajout de show_id et season_id + titre et URL préremplis
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		echo $form->input('Season.name', array('label' => 'Saison :', 'value' => $season['Season']['name'], 'disabled' => true));
		echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id'] ));
		echo $form->input('season_id', array('type' => 'hidden', 'value' => $season['Season']['id'] ));
		echo $form->input('caption', array('type' => 'hidden', 'value' => 's'. str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT)));
		echo $form->input('name', array('label' => 'Titre :', 'size' => '50', 'value' => 'Bilan : ' . $show['Show']['name'] . ' saison ' . $season['Season']['name']));
		echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50', 'value' => 'bilan-' . $show['Show']['menu']. '-saison-' . $season['Season']['name']));
		break;
	case 'portrait':
		// Ajout de role_id + titre et URL préremplis
		echo $form->input('une', array('type' => 'hidden', 'value' => 0));
		echo $form->input('Actor.name', array('label' => 'Acteur :', 'value' => $role['Role']['name'], 'disabled' => true));
		echo $form->input('role_id', array('type' => 'hidden', 'value' => $role['Role']['id'] ));
		echo $form->input('actor_id', array('type' => 'hidden', 'value' => $role['Actor']['id'] ));
		echo $form->input('name', array('label' => 'Titre :', 'size' => '50', 'value' => 'Portrait : ' . $role['Role']['name']));
		$role_url = $star->url($role['Role']['name']);
		echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50', 'value' => 'portrait-' . $role_url));
		break;
	}
	
	echo $form->input('chapo', array('rows' => '2', 'cols' => '65', 'label' => 'Chapô :'));
	echo '</fieldset>';
	
	?>
	<br /><br />
    

    
	<div class="tabs spacer">
        <ul>
            <li><a href="#tabs-1">Article</a></li>
            <li><a href="#tabs-2">Uploader une image</a></li>
            <li><a href="#tabs-3">Ajouter une vidéo</a></li>
        </ul>
        <div id="tabs-1">
        	<br />
			<?php echo $form->input('text', array('rows' => '30', 'cols' => '131', 'label' => false, 'class' => 'mceAdvanced')); ?>
            <br />
            <?php
			if($cat == 'podcast'){
					echo $form->input('podcast', array('rows' => '2', 'cols' => '65', 'label' => 'Podcast (code iframe) :'));
				}
				elseif($cat == 'critique')
				{
					echo $form->input('podcast', array('rows' => '2', 'cols' => '65', 'label' => 'Code iframe :'));
				}?>
            <?php echo $form->end('Sauvegarder'); ?>
        </div>
        <div id="tabs-2">
       		Pour ajouter une <strong>image</strong> dans votre article : <br /><br />
            <ul class="play">
            	<li>choisissez l'image à envoyer ci-dessous</li> 
                <li>récupérez l'url de l'image
                <li>allez dans l'onglet Article</li> 
                <li>puis sur l'image <em>Insérer une image</em> dans la barre d'outils</li>
                <li>copiez l'URL <span class="notes">(plus d'infos sur la FAQ de l'administration)</span></li>
            </ul>
            <br />
            <?php
			echo $form->create('Upload', array('type' => 'file', 'id' => 'uploadImageForm', 'name' => 'uploadImageForm')); 
			// echo $ajax->form(array('type' => 'file', 'options' => array('model' => 'Upload', 'url' => array('action' => 'add'), 'update' => 'resultupload')));
			echo 'Votre image : ';
			echo $form->input('name', array('type' => 'file', 'label' => 'Image :', 'label' => false, 'div' => false));
			echo '&nbsp;&nbsp;&nbsp;';
			echo $form->button('Uploader',array('onClick'=>'$(\'#uploadImageForm\').ajaxSubmit({target: \'#resultUpload\',url: \''.$html->url('/uploads/add').'\'}); return false;'));
			echo '<br /><span class="notes">Extensions autorisés en minuscules : JPG, PNG, GIF.</span>';
			echo '<div id="resultUpload"></div>';
			
			echo '<br /><br />';
            echo '</form>'; ?>
            <div id="resultupload">
            </div>
        </div>
        <div id="tabs-3">
        	Pour ajouter une vidéo <strong>Youtube</strong> à l'article : <br /><br />
            <ul class="play">
            	<li>allez dans l'onglet Article</li> 
                <li>puis sur l'image <em>Insérer un fichier média</em> dans la barre d'outils</li>
                <li>copiez l'URL de la vidéo Youtube <span class="notes">(exemple : http://www.youtube.com/watch?v=taqgZruD02A)</span></li>
                <li>cochez <em>Gardez les proportions</em></li>
            </ul>
            <br />
            Pour <strong>uploader</strong> une vidéo sur le site, lisez la partie correspondante dans la FAQ de l'administration.
		</div>
	</div>
        
	
	
