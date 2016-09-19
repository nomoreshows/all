
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les sondages</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'polls', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>



<table class="data">
	<tr>
    	<th>Titre</td>
        <th width="10%">Questions</th>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($polls as $i => $poll): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $poll['Poll']['name']; ?></td>
        <td>-
        </td>
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'genres', 'action' => 'edit', 'prefix' => 'admin', $poll['Poll']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'genres', 'action' => 'delete', 'prefix' => 'admin', $poll['Poll']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>
