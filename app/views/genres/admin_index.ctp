
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les genres</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'genres', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>



<table class="data">
	<tr>
    	<th>Intitulé</td>
        <th>Séries associées</th>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($genres as $i => $genre): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $genre['Genre']['name']; ?></td>
        <td><?php
        	foreach($genre['Show'] as $j => $show) {
				if ($j != 0) 
					echo ', ' . $show['name'];
				else
					echo $show['name'];
			}
			?>
            
        </td>
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'genres', 'action' => 'edit', 'prefix' => 'admin', $genre['Genre']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'genres', 'action' => 'delete', 'prefix' => 'admin', $genre['Genre']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>
