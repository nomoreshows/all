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

<?php $cat = $this->data['Article']['category']; ?>

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
	echo $form->input('id', array('type' => 'hidden'));
	
	echo $form->input('name', array('label' => 'Titre :', 'size' => '50'));
	echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(<a href="http://serieall.fr/article/'.$this->data['Article']['url'].'">Voir le rendu</a>)</span>', 'size' => '50'));
	
	switch($cat) {
	case 'critique':
		// Ajout des 3 id + du titre et URL prérempli
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		echo $form->input('rss_podcast', array('label' => 'Ajout au flux RSS Podcast :'));
		echo $form->input('episode_id');
		echo $form->input('caption');
		break;
	case 'news':
	case 'chronique':
	case 'dossier':
		// Ajout de show_id + titre et URL vides
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		if ($show != 0) {
		echo $form->input('show_id');
		} else {
			echo $form->input('photo', array('type' => 'file', 'label' => 'Image à la une:<br /><span class="notes">(image carrée de préférence)</span>'));
		if ($this->data['Article']['photo'] != '') {
			// AFFICHAGE DE L'IMAGE ET SUPPRESSION
			echo '
			<div class="input file">
			<label for="currentpicture"></label>
			';
			echo $html->image('article/thumb.news.' . $this->data['Article']['photo'], array('id' => 'currentpicture'));
			echo '
			</div>
			';
			echo $form->input('Article.photo.remove', array('type' => 'checkbox', 'value' => 'false', 'label' => 'Supprimer la photo :'));
		}
		echo '<br />';
		}
		if ($cat == 'news')
		echo $form->input('source', array('label' => 'Source:<br /><span class="notes">(mettre uniquement l\'URL)</span>', 'size' => '50'));
		break;
	case 'focus':
		// Ajout de show_id + titre et URL préremplis
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		echo $form->input('caption');
		break;
	case 'bilan':
		// Ajout de show_id et season_id + titre et URL préremplis
		echo $form->input('une', array('label' => 'A la une :', 'type' => 'select', 'options' => array( 0 => 'Non', 1 => 'Oui', 2 => 'Spécial')));
		echo $form->input('caption');
		break;
	case 'portrait':
		// Ajout de role_id + titre et URL préremplis
		echo $form->input('une', array('type' => 'hidden', 'value' => 0));
		echo $form->input('role_id');
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
            <br /><br />
            Rédacteur : <?php echo $form->input('user_id', array('label' => false, 'div' => false));?> 
            <br /><br />
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
        
	
	
