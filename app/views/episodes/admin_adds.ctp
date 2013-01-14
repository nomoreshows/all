<br />
<h2 class="green">Ajouter <?php echo $nb; ?> épisodes à la saison <?php echo $season['Season']['name']; ?> de <?php echo $show['Show']['name']; ?></h2>

<?php echo $form->create('Episode', array('action' => 'addmany')); ?>

<table class="data">
	<tr>
    	<th>Episode</th>
        <th>Titre VO / VF</th>
        <th>Diffusion US</th>
        <th>Diffusion FR</th>
        <th>Guests + Résumé)</th>
	</tr>
    
    <?php for ($i = 1; $i <= $nb; $i++) { ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $i; ?></td>
        <?php 
			$j = $i - 1;
			$name 			= 'Episode.' . $j . '.name'; 
			$titrefr 		= 'Episode.' . $j . '.titrefr'; 
			$numero			= 'Episode.' . $j . '.numero'; 
			$diffusionus	= 'Episode.' . $j . '.diffusionus';
			$diffusionfr 	= 'Episode.' . $j . '.diffusionfr';
			$guests			= 'Episode.' . $j . '.guests'; 
			$bo				= 'Episode.' . $j . '.bo';
			$bo				= 'Episode.' . $j . '.ba';
			$resume			= 'Episode.' . $j . '.resume';
			$season_id		= 'Episode.' . $j . '.season_id';
			
		echo $form->input($numero, array('type'=>'hidden', 'value' => $i));
        echo $form->input($season_id, array('type'=>'hidden', 'value' => $season['Season']['id'])); 
		?>
        <td><?php echo $form->input($name, array('label' => false)); ?> <?php echo $form->input($titrefr, array('label' => false)); ?></td>
        <td><?php echo $form->input($diffusionus, array('label' => false, 'minYear' => date('Y') - 70, 'selected' => '2000-01-01')); ?><span class="notes">(laisser la valeur par défaut si aucune date)</span></td>
        <td><?php echo $form->input($diffusionfr, array('label' => false, 'minYear' => date('Y') - 70, 'selected' => '2000-01-01')); ?><span class="notes">(laisser la valeur par défaut si aucune date)</span></td>
        <td><?php echo $form->input($guests, array('label' => false)); ?> <br />
        	<?php echo $form->input($resume, array('label' => false)); ?> <br />
            <?php // echo $form->input($ba, array('label' => false)); ?>
        </td>
        
    </tr>
    <?php } ?>    
    
    <?php echo $form->input('show_id', array('type'=>'hidden', 'value' => $show['Show']['id'])); ?>
    
</table>

<?php echo $form->end('Ajouter'); ?>