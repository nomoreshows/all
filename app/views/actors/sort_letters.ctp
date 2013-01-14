	<?php foreach($actors as $i => $actor): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $actor['Actor']['name']; ?></td>
        <td>
        	<?php
        	$timestamp = strtotime($actor['Actor']['datenaiss']);
			e(strftime("%d %B %Y", $timestamp));
			?>
        </td>
        <td><?php echo $actor['Actor']['lieunaiss']; ?></td>
        <td><?php echo count($actor['Role']); ?></td>
        <td><?php if(!empty($actor['Actor']['picture'])) echo 'x'; ?> </td>   
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'actors', 'action' => 'edit', 'prefix' => 'admin', $actor['Actor']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'actors', 'action' => 'delete', 'prefix' => 'admin', $actor['Actor']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    