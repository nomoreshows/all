<table class="data">
	<tr>
    	<th width="25%">Membre</td>
        <th>Commentaire</td>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($comments as $i => $comment): ?>
    
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $comment['User']['login']; ?></td>
        <td><?php echo substr($comment['Comment']['text'], 0, 120) . '...'; ?></td>
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'comments', 'action' => 'edit', 'prefix' => 'admin', $comment['Comment']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'comments', 'action' => 'delete', 'prefix' => 'admin', $comment['Comment']['id']), array('escape' => false)); ?></td>
    </tr>
    <?php endforeach; ?>    
    
</table> 
