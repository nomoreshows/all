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
		plugins : "safari,spellchecker,advhr,advimage,advlink,emotions,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	// Theme options
	theme_advanced_buttons1 : "fullscreen,|,bold,italic,underline,strikethrough,|,bullist,numlist,outdent,indent,blockquote,link,unlink,|,charmap,emotions,image,media",
	theme_advanced_buttons2 : "newdocument,undo,redo,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,cleanup,code,spellchecker,preview",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

});
</script>

<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un(e) <?php echo strtolower($cat['Category']['name']); ?></h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'articles', 'action' => 'index', 'prefix' => 'admin', $cat['Category']['name']), array('escape' => false)); ?>
        </td>
    </tr>
</table>
	<?php 
	
	echo $form->create('Article'); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Titre :', 'size' => '50'));
	echo $form->input('url', array('label' => 'Titre URL:<br /><span class="notes">(affiché dans l\'URL)</span>', 'size' => '50'));
	echo $form->input('etat', array('label' => 'Publié :'));
	
	echo $form->input('category_name', array('type' => 'hidden', 'value' => $cat['Category']['name'] ));
	echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id') ));
	echo $form->input('category_id', array('label' => 'Catégorie :<br /><span class="notes">(ne pas changer !!)</span>', 'value' => $cat['Category']['id']));
	
	switch($cat['Category']['name']) {
	case 'Critique':
		echo $form->input('Episode.name', array('label' => 'Episode :', 'value' => $episode['Episode']['name'], 'disabled' => true));
		echo $form->input('ext_id', array('type' => 'hidden', 'value' => $episode['Episode']['id'] ));
		break;
	case 'News':
	case 'Dossier':
		if ($show != 0) {
		echo $form->input('Show.name', array('label' => 'Série :', 'value' => $show['Show']['name'], 'disabled' => true));
		echo $form->input('ext_id', array('type' => 'hidden', 'value' => $show['Show']['id'] ));
		} else {
			echo $form->input('ext_id', array('type' => 'hidden', 'value' => 0 ));
		}
		break;
	case 'Focus':
		echo $form->input('Show.name', array('label' => 'Série :', 'value' => $show['Show']['name'], 'disabled' => true));
		echo $form->input('ext_id', array('type' => 'hidden', 'value' => $show['Show']['id'] ));
		break;
	case 'Bilan':
		echo $form->input('Season.name', array('label' => 'Saison :', 'value' => $season['Season']['name'], 'disabled' => true));
		echo $form->input('ext_id', array('type' => 'hidden', 'value' => $season['Season']['id'] ));
		break;
	case 'Portrait':
		echo $form->input('Actor.name', array('label' => 'Acteur :', 'value' => $actor['Actor']['name'], 'disabled' => true));
		echo $form->input('ext_id', array('type' => 'hidden', 'value' => $actor['Actor']['id'] ));
		break;
	}
	
	echo $form->input('chapo', array('rows' => '2', 'cols' => '65', 'label' => 'Chapô :'));
	echo '</fieldset>';
	
	?>
	<br /><br />
	<div class="tabs" id="tabs1">
    <?php 
	echo $form->input('Paragraphs.0.numero', array('type' => 'hidden', 'value' => 1 )); 
	echo $form->input('Paragraphs.0.id', array('type' => 'hidden')); 
	?>
        <ul>
            <li><a href="#tabs-1-1">Paragraphe 1</a></li>
            <li><a href="#tabs-2-1">Photo</a></li>
            <li><a href="#tabs-3-1">Vidéo</a></li>
        </ul>
        <div id="tabs-1-1">
        	<br />
            Titre :
            <?php 
			echo $form->input('Paragraphs.0.name', array('label' => false, 'div' => false, 'size' => '128'));
			echo '<br /><br />';
			echo $form->input('Paragraphs.0.text', array('rows' => '15', 'cols' => '131', 'label' => false, 'class' => 'mceAdvanced')); ?>
            <span class="notes"><a href="#remove" onclick='javascript:$("#tabs1").fadeOut();' class="link">Supprimer ce paragraphe</a></span>
        </div>
        <div id="tabs-2-1">
        <table>
        <tr>
        	<td width="60%">
            <?php
			echo $form->input('Paragraphs.0.picture', array('type' => 'file', 'label' => 'Photo :<br /><span class="notes">(Format autorisés : png, jpg et gif)</span>'));
			echo $form->input('Paragraphs.0.align', array('type' => 'select', 'label' => 'Alignement :', 'options' => array('left' => 'Gauche', 'right' => 'Droite', 'top' => 'Au-dessus', 'bottom' => 'En-dessous'))); ?>
            </td>
            <td width="30%">
            Exemples d'alignement : <br /><br />
			<?php echo $html->image('icons/align_left.gif'); ?>
			<?php echo $html->image('icons/align_right.gif'); ?>
			<?php echo $html->image('icons/align_top.gif');  ?>
			<?php echo $html->image('icons/align_bottom.gif'); ?>
            </td>
        </tr>
        </table>
        </div>
        <div id="tabs-3-1">
        	<?php
            echo $form->input('Paragraphs.0.video', array('type' => 'file', 'label' => 'Vidéo maison :<br /><span class="notes">(FLV, 10 Mo max.)</span>'));
            echo $form->input('Paragraphs.0.embed', array('label' => 'Vidéo &lt;embed&gt; :<br /><span class="notes">(copier-coller le code exportable)</span>', 'cols' => 65));
			?>
        </div>
    </div>
    
    
	
    <?php
	echo '<span class="notes">';
	echo $ajax->link( 
		'Ajouter un paragraphe', 
		array( 'controller' => 'articles', 'action' => 'newParagraph', 'prefix' => 'admin', 2 ), 
		array( 'update' => 'tabs-form', 'position' => 'after' )
	); 
	echo '</span>';
	
    echo $form->end('Ajouter');
	
	?>
	