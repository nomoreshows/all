
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les artistes</h1></td>
    	<td width="50" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'artists', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>


<table class="data">
	<tr>
    	<th width="25"></td>
    	<th width="20%">Nom</td>
        <th width="15%">Genre(s)</th>
        <th>Festival(s)</th>
        <th width="35">Bio</td>
        <th width="35">Pic</td>
        <th width="35">Edit</td>
        <th width="35">Suppr</td>
	</tr>
    
    <?php foreach($artists as $i => $artist): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $html->image('icons/publie_' . $artist['Artist']['home'] . '.png'); ?></td>
    	<td><?php echo $artist['Artist']['name']; ?></td>
        <td>
        	<?php
        	foreach($artist['Genre'] as $j => $genre) {
				if ($j != 0) 
					echo ', ' . $genre['name'];
				else
					echo $genre['name'];
			}
			?>
        </td>
        <td>
        	<?php
        	foreach($artist['Festival'] as $j => $festival) {
				if ($j != 0) 
					echo ', ' . $festival['name'];
				else
					echo $festival['name'];
			}
			?>
        </td>
        <td><?php if(!empty($artist['Biographies'][0]['content'])) echo 'x'; ?><?php if(!empty($artist['Biographies'][1]['content'])) echo 'x'; ?></td>
        
        <td><?php
        	if(!empty($artist['Artist']['photo'])) echo 'x';
		?></td>
        
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'artists', 'action' => 'edit', 'prefix' => 'admin', $artist['Artist']['id']), array('escape' => false, 'title' => 'Modifier l\'artiste')); ?>
        </td>
        <td><?php
			echo $html->link($html->image('icons/delete.png'), array('controller' => 'artists', 'action' => 'delete', 'prefix' => 'admin', $artist['Artist']['id']), array('escape' => false, 'title' => 'Supprimer l\'artiste'), "Etes-vous sûr de vouloir supprimer cet artiste ?"); 
			?>
        </td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>

<?php //debug($artist); ?>