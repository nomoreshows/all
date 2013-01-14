	<?php
    $i = $numero - 1; // numéro de data 
	$j = $numero; // numérodu paragraphe
	$k = $numero + 1; // numéro du prochain paragraphe
	?>

<div class="tabs" id="tabs<?php echo $j; ?>">
	<?php
	echo $form->input('Paragraphs.' . $i . '.numero', array('type' => 'hidden', 'value' => $j )); 
	echo $form->input('Paragraphs.' . $i . '.id', array('type' => 'hidden')); 
	?>
        <ul>
            <li><a href="#tabs-1-<?php echo $j; ?>">Paragraphe <?php echo $j; ?></a></li>
            <li><a href="#tabs-2-<?php echo $j; ?>">Photo</a></li>
            <li><a href="#tabs-3-<?php echo $j; ?>">Vidéo</a></li>
        </ul>
        <div id="tabs-1-<?php echo $j; ?>">
        	<br />
            Titre :
            <?php 
			echo $form->input('Paragraphs.' . $i . '.name', array('label' => false, 'div' => false, 'size' => '128'));
			echo '<br /><br />';
			echo $form->input('Paragraphs.' . $i . '.text', array('rows' => '15', 'cols' => '131', 'label' => false, 'class' => 'mceAdvanced')); ?>
            <span class="notes"><a href="#remove" onclick='javascript:$("#tabs<?php echo $j; ?>").fadeOut();' class="link">Supprimer ce paragraphe</a></span>
        </div>
        <div id="tabs-2-<?php echo $j; ?>">
        <table>
        <tr>
        	<td width="60%">
            <?php
			echo $form->input('Paragraphs.' . $i . '.picture', array('type' => 'file', 'label' => 'Photo :<br /><span class="notes">(Format autorisés : png, jpg et gif)</span>'));
			echo $form->input('Paragraphs.' . $i . '.align', array('type' => 'select', 'label' => 'Alignement :', 'options' => array('left' => 'Gauche', 'right' => 'Droite', 'top' => 'Au-dessus', 'bottom' => 'En-dessous'))); ?>
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
        <div id="tabs-3-<?php echo $j; ?>">
        	<?php
            echo $form->input('Paragraphs.' . $i . '.video', array('type' => 'file', 'label' => 'Vidéo maison :<br /><span class="notes">(FLV, 10 Mo max.)</span>'));
            echo $form->input('Paragraphs.' . $i . '.embed', array('label' => 'Vidéo &lt;embed&gt; :<br /><span class="notes">(copier-coller le code exportable)</span>', 'cols' => 65));
			?>
		</div>
    
</div>

echo '<span class="notes">';
	echo $ajax->link( 
		'Ajouter un paragraphe', 
		array( 'controller' => 'articles', 'action' => 'newParagraph', 'prefix' => 'admin', 2 ), 
		array( 'update' => 'tabs-form', 'position' => 'after' )
	); 
	echo '</span>';