
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les slogans</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'slogans', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>



<table class="data">
	<tr>
    	<th width="70%">Slogan</td>
        <th width="20%">Source</th>
        <th width="25">URL</th>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($slogans as $i => $slogan): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $slogan['Slogan']['name']; ?></td>
        <td><?php echo $slogan['Slogan']['source']; ?></td>
        <td><?php if(!empty($slogan['Slogan']['url'])) echo 'x'; ?>
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'slogans', 'action' => 'edit', 'prefix' => 'admin', $slogan['Slogan']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'slogans', 'action' => 'delete', 'prefix' => 'admin', $slogan['Slogan']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>
