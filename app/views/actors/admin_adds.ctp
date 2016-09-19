<br />
<h2 class="green">Ajouter <?php echo $nb; ?> acteurs</h2>

<?php echo $form->create('Actor', array('action' => 'many', 'type' => 'file')); ?>

<table class="data">
	<tr>
    	<th width="20">#</th>
        <th>Prénom &amp; Nom</th>
        <th>Date &amp; lieu naissance</th>
        <th>Photo de l'acteur</th>
	</tr>
    
    <?php for ($i = 1; $i <= $nb; $i++) { ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $i; ?></td>
       
        <?php 
			$j = $i - 1;
			$name 		= 'Actor.' . $j . '.name'; 
			$lieunaiss 	= 'Actor.' . $j . '.lieunaiss';
			$datenaiss 	= 'Actor.' . $j . '.datenaiss';
			$picture 	= 'Actor.' . $j . '.picture';
			
        //echo $form->input($show_id, array('type'=>'hidden', 'value' => $show['Show']['id'])); 
		?>
        
        <td>
			<span class="notes">Nom</span><br />
			<?php echo $form->input($name, array('label' => false, 'div' => false)); ?> <br /><br />
        </td>
        <td>
			<span class="notes">Date naissance</span><br />
			<?php echo $form->input($datenaiss, array('label' => false, 'div' => false, 'selected' => '2000-01-01', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'maxYear' => date('Y'))); ?>
            <br /><br />
            <span class="notes">Lieu naissance</span><br />
        	<?php echo $form->input($lieunaiss, array('label' => false, 'div' => false)); ?><br /><br />
        </td>
        <td><?php echo $form->input($picture, array('label' => false, 'div' => false, 'type' => 'file')); ?>
        	<br /><br />
            <span class="notes">Format : 100x100px</span><br />
            <span class="notes">Type : PNG, JPG, GIF</span><br />
        </td>
        
    </tr>
    <?php } ?>    
    
</table>

<?php echo $form->end('Ajouter'); ?>