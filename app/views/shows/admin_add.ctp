<table class="toolbar">
	<tr>
    	<td><h1>Ajouter une série</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'shows', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

<?php

	echo $form->create('Show');
	echo '<fieldset><legend>Informations à remplir </legend>';
	echo $form->input('tvdb_id', array('size' => 5, 'label' => 'id de <a href="http://thetvdb.com">TheTVDB</a> :<br /><span class="notes">(voir <a href="http://www.diigo.com/item/image/1cnjf/jgx0?size=o">exemple</a>)</span>'));
	echo '<br /><br />';
	/*
	echo $form->input('name', array('label' => 'Titre original :<br /><span class="notes">(titre affiché)</span>'));
	echo $form->input('titrefr', array('label' => 'Titre français :'));
	echo $form->input('menu', array('label' => 'Titre dans l\'URL :<br /><span class="notes">(titre en minuscule sans accents ni espaces)</span>'));
	echo $form->input('encours', array('label' => 'En cours :'));
	echo $form->input('synopsis', array('rows' => '4', 'cols' => '65', 'label' => 'Synopsis :'));
	echo $form->input('format', array('label' => 'Format :<br /><span class="notes">(nombre de minutes)</span>', 'size' => '3'));
	*/
	echo $form->input('Genre');

	echo $form->input('nationalite', array('label' => 'Nationalité :', 'options' => array('Américaine' => 'Américaine','Anglaise' => 'Anglaise','Française' => 'Française','Canadienne' => 'Canadienne','Coréenne'=>'Coréenne','Belge' => 'Belge','Espagnole' => 'Espagnole','Allemande' => 'Allemande','Italienne' => 'Italienne', 'Japonaise' => 'Japonaise', 'Danoise' => 'Danoise', 'Australienne' => 'Australienne', 'Norvégienne' => 'Norvégienne', 'Suédoise' => 'Suédoise', 'Mexicaine' => 'Mexicaine' )));

	/*
	echo $form->input('annee', array('label' => 'Année création :', 'size' => '4'));
	*/
	echo $form->input('createurs', array('label' => 'Créateurs :<br /><span class="notes">(séparés par virgule)</span>', 'size' => '50'));
	echo $form->input('realisateurs', array('label' => 'Réalisateurs :<br /><span class="notes">(séparés par virgule)</span>', 'size' => '50'));
	echo $form->input('scenaristes', array('label' => 'Scénaristes :<br /><span class="notes">(séparés par virgule)</span>', 'size' => '50'));

	echo $form->input('chainefr', array('label' => 'Chaîne VF :', 'size' => '10'));
	echo $form->input('diffusionfr', array('label' => 'Première diffusion VF :', 'dateFormat' => 'DMY', 'selected' => '2000-01-01', 'minYear' => '1950'));

	/*
	echo $form->input('chaineus', array('label' => 'Chaîne VO :', 'size' => '10'));
	echo $form->input('diffusionus', array('label' => 'Première diffusion VO :', 'dateFormat' => 'DMY', 'selected' => '2000-01-01', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
	echo $form->input('chainefr', array('label' => 'Chaîne VF :', 'size' => '10'));
	echo $form->input('diffusionfr', array('label' => 'Première diffusion VF :', 'dateFormat' => 'DMY', 'selected' => '2000-01-01', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
	*/

	echo $form->input('particularite', array('label' => 'Particularité :<br /><span class="notes">(facultatif)</span>', 'size' => '50'));

	echo $form->input('location', array('label' => 'Lieu de la série :<br /><span class="notes">(ville ou région)</span>', 'size' => '50'));
	echo $form->input('location_film', array('label' => 'Lieu de tournage :<br /><span class="notes">(utiliser "Studio" si besoin)</span>', 'size' => '50'));

	echo $form->input('generique', array('label' => 'Générique :<br /><span class="notes">(copier le code &lt;embed&gt; d\'une vidéo Youtube)</span>', 'cols' => '65'));
	//echo $form->input('bo', array('label' => 'BO :<br /><span class="notes">(copier le code &lt;embed&gt; d\'une playlist Deezer)', 'cols' => '65',));

	//echo $form->input('forum', array('label' => 'Lien forum :<br /><span class="notes">(uniquement l\'URL)</span>', 'value' => 'http://'));
	//echo $form->input('user_id', array('label' => 'Rédacteur en charge :'));
	echo $form->input('is_rentree2016', array('label' => 'Rentrée 2016 :'));
	echo $form->input('te_rentree', array('label' => 'Taux érectile :<br /><span class="notes">(uniquement le nb en %)</span>'));
	echo $form->input('avis_rentree', array('cols' => '65', 'label' => 'Avis Série-All :<br /><span class="notes">(quelques lignes)</span>'));
	
    echo $form->end('Ajouter');
	echo '</fieldset>';
?>

