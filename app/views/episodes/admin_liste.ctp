
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les épisodes de <?php echo $show['Show']['name']; ?></h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'episodes', 'action' => 'add', 'prefix' => 'admin', $show_id), array('escape' => false)); ?>
        </td>
        <td width="40" class="center">
		<?php echo $html->link($html->image('icons/adds.png') . '<br />Plusieurs', array('controller' => 'episodes', 'action' => 'many', 'prefix' => 'admin', $show_id), array('escape' => false)); ?>
        </td>
        <td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Retour', array('controller' => 'episodes', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>


<table class="data">
	<tr>
    	<th width="35%">Titre VO</td>
        <th width="35%">Titre FR</td>
        <th>Saison</td>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($episodes as $i => $episode): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	
        <td><?php echo $episode['Episode']['numero'] . ' - ' . $episode['Episode']['name']; ?></td>
        <td><?php echo $episode['Episode']['titrefr']; ?></td>
        <td>Saison <?php echo $episode['Season']['name']; ?></td>
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'episodes', 'action' => 'edit', 'prefix' => 'admin', $episode['Episode']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'episodes', 'action' => 'delete', 'prefix' => 'admin', $episode['Episode']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>
