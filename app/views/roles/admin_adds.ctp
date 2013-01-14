<br />
<h2 class="green">Ajouter <?php echo $nb; ?> rôles à <?php echo $show['Show']['name']; ?></h2>

<?php echo $form->create('Role', array('action' => 'many')); ?>

<table class="data">
	<tr>
    	<th width="20">#</th>
        <th>Prénom &amp; Nom</th>
        <th>Acteur</th>
        <th>Série</th>
	</tr>
    
    <?php for ($i = 1; $i <= $nb; $i++) { ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $i; ?></td>
       
        <?php 
			$j = $i - 1;
			$name 		= 'Role.' . $j . '.name'; 
			$actor_id 	= 'Role.' . $j . '.actor_id';
			$show_id 	= 'Role.' . $j . '.show_id';
		?>
        
        <td>
			<span class="notes">Nom du rôle</span><br />
			<?php echo $form->input($name, array('label' => false, 'div' => false)); ?> <br /><br />
        </td>
        <td>
			<span class="notes">Acteur associé</span><br />
			<?php echo $form->input($actor_id, array('label' => false, 'div' => false)); ?>
            <?php echo $form->input($show_id, array('type' => 'hidden', 'value' => $show['Show']['id'])); ?>
            <br /><br />
        </td>
        <td><?php echo $show['Show']['name']; ?></td>
        
    </tr>
    <?php } ?>    
    
</table>

<?php echo $form->end('Ajouter'); ?>