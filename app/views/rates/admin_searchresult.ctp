<table class="data">
	<tr>
    	<th width="40%">Série</td>
        <th>Saison</td>
		<th>Episode</td>
        <th>Note</td>
        <th width="35">Supr</td>
	</tr>
	
    <?php foreach($rates as $i => $rate): ?>
    
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
        <td><?php echo $rate['Show']['name']; ?></td>
        <td><?php echo $rate['Season']['name']; ?></td>
        <td><?php echo $rate['Episode']['numero']; ?></td>
		<td><?php echo $rate['Rate']['name']; ?></td>
		<td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'rates', 'action' => 'delete', 'prefix' => 'admin', $rate['Rate']['id'], $rate['User']['id']), array('escape' => false)); ?></td>
    </tr>
    <?php endforeach; ?>    
    
</table> 
