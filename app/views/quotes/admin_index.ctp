
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les citations</h1></td>
    	<td width="50" class="center">
        </td>
        <!-- <td width="40" class="center">
        </td> -->
    </tr>
</table>
<br />

<table class="data">
	<tr>
    	<th width="15%">Episode</th>
        <th width="40%">Citation</th>
        <th>Rôle</th>
        <th>Créé le</th>
        <th>Par</th>
        <th width="35">Edit</th>
        <th width="35">Supr</th>
	</tr>
    
    <?php foreach($quotes as $i => $quote): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td><?php echo $quote['Episode']['numero'] . '. ' . $quote['Episode']['name']; ?></td>
        <td><?php echo substr($quote['Quote']['text'], 0, 100); ?></td>
		
        <td><?php echo $quote['Role']['name']; ?></td>
        
        <td><?php
        	$timestamp = strtotime($quote['Quote']['created']);
			e(strftime("%d %B %Y", $timestamp));
		?></td>
        
        <td><?php echo $quote['User']['login']; ?></td>
        
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'quotes', 'action' => 'edit', 'prefix' => 'admin', $quote['Quote']['id']), array('escape' => false, 'title' => 'Modifier la citation')); ?>
        </td>
        <td><?php if ($user['User']['role'] != 'admin') {
			echo $html->link($html->image('icons/delete.png'), array('controller' => 'quotes', 'action' => 'delete', 'prefix' => 'admin', $quote['Quote']['id']), array('escape' => false, 'title' => 'Supprimer l\'utilisateur'), "Etes-vous sûr de vouloir supprimer cette citation ?"); 
			} ?>
        </td>
        
    </tr>
    <?php endforeach; ?>    
    
</table>