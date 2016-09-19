<br />
<h2 class="green">Ajouter <?php echo $nb; ?> saisons à <?php echo $show['Show']['name']; ?></h2>

<?php echo $form->create('Season', array('action' => 'many')); ?>

<table class="data">
	<tr>
    	<th width="100">Saison</th>
        <th>Bande Annonce (&lt;embed&gt; Youtube)</th>
        <th>BO  (&lt;embed&gt; Deezer)</th>
	</tr>
    
    <?php for ($i = 1; $i <= $nb; $i++) { ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td>Saison <?php echo $i; ?></td>
       
        <?php 
			$j = $i - 1;
			$ba 	= 'Season.' . $j . '.ba'; 
			$bo		= 'Season.' . $j . '.bo';
			$name 	= 'Season.' . $j . '.name';
			$show_id= 'Season.' . $j . '.show_id';
			
		echo $form->input($name, array('type'=>'hidden', 'value' => $i));
        echo $form->input($show_id, array('type'=>'hidden', 'value' => $show['Show']['id'])); 
		?>
        
        <td><?php echo $form->input($ba, array('label' => false)); ?></td>
        <td><?php echo $form->input($bo, array('label' => false)); ?></td>
        
    </tr>
    <?php } ?>    
    
</table>

<?php echo $form->end('Ajouter'); ?>