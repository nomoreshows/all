
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les saisons de <?php echo $show['Show']['name']; ?></h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'seasons', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
        <td width="40" class="center">
		<?php echo $html->link($html->image('icons/adds.png') . '<br />Plusieurs', array('controller' => 'seasons', 'action' => 'many', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>


<table class="data">
	<tr>
    	<th width="25%">S&eacute;rie</td>
        <th>Saison</td>
        
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($seasons as $i => $season): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $season['Show']['name']; ?></td>
        <td>Saison <?php echo $season['Season']['name']; ?></td>
        
       
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'seasons', 'action' => 'edit', 'prefix' => 'admin', $season['Season']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'seasons', 'action' => 'delete', 'prefix' => 'admin', $season['Season']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>

