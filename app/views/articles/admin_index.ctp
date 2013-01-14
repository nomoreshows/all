
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les <?php if ($category_name != 'all') echo $category_name; else echo 'articles'; ?></h1></td>
        
    	<?php if ($category_name != 'all') { 
		// Enlever le bouton d'ajout si vue globale
		?>
        <td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'articles', 'action' => 'preadd', 'prefix' => 'admin', $category_name), array('escape' => false)); ?>
        </td>
        <?php } ?>
    </tr>
</table>



<table class="data">
	<tr>
    	<th width="25"></th>
    	<th width="25%">Titre</td>
        <th>Chapô</td>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
    <?php foreach($articles as $i => $article): ?>
    <tr <?php if ($i&1) echo 'class="pair"'; ?>>
    	<td>
			<?php echo $html->image('icons/publie_' . $article['Article']['etat'] . '.png'); ?>
        </td>
    	<td><?php echo $article['Article']['name']; ?></td>
        <td><?php echo substr($article['Article']['chapo'], 0, 120) . '...'; ?></td>
        <td><?php echo $html->link($html->image('icons/edit.png'), array('controller' => 'articles', 'action' => 'edit', 'prefix' => 'admin', $article['Article']['id']), array('escape' => false)); ?></td>
        <td><?php echo $html->link($html->image('icons/delete.png'), array('controller' => 'articles', 'action' => 'delete', 'prefix' => 'admin', $article['Article']['id']), array('escape' => false)); ?></td>
        
    </tr>
    <?php endforeach; ?>    
    
</table> 

<?php  ?>

