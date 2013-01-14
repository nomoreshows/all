
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les acteurs</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'actors', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
        <td width="40" class="center">
		<?php echo $html->link($html->image('icons/adds.png') . '<br />Plusieurs', array('controller' => 'actors', 'action' => 'many', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>
<br />
 <?php
                echo $html->link($html->image('lettres/a.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'a'), array('escape' => false));
				echo $html->link($html->image('lettres/b.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'b'), array('escape' => false));
				echo $html->link($html->image('lettres/c.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'c'), array('escape' => false));
				echo $html->link($html->image('lettres/d.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'd'), array('escape' => false));
                echo $html->link($html->image('lettres/e.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'e'), array('escape' => false));
                echo $html->link($html->image('lettres/f.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'f'), array('escape' => false));
                echo $html->link($html->image('lettres/g.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'g'), array('escape' => false));
                echo $html->link($html->image('lettres/h.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'h'), array('escape' => false));
                echo $html->link($html->image('lettres/i.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'i'), array('escape' => false));
				echo $html->link($html->image('lettres/j.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'j'), array('escape' => false));
				echo $html->link($html->image('lettres/k.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'k'), array('escape' => false));
				echo $html->link($html->image('lettres/l.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'l'), array('escape' => false));
				echo $html->link($html->image('lettres/m.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'm'), array('escape' => false));
				echo $html->link($html->image('lettres/n.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'n'), array('escape' => false));
				echo $html->link($html->image('lettres/o.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'o'), array('escape' => false));
				echo $html->link($html->image('lettres/p.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'p'), array('escape' => false));
				echo $html->link($html->image('lettres/q.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'q'), array('escape' => false));
				echo $html->link($html->image('lettres/r.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'r'), array('escape' => false));
				echo $html->link($html->image('lettres/s.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 's'), array('escape' => false));
				echo $html->link($html->image('lettres/t.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 't'), array('escape' => false));
				echo $html->link($html->image('lettres/u.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'u'), array('escape' => false));
				echo $html->link($html->image('lettres/v.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'v'), array('escape' => false));
				echo $html->link($html->image('lettres/w.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'w'), array('escape' => false));
				echo $html->link($html->image('lettres/x.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'x'), array('escape' => false));
				echo $html->link($html->image('lettres/y.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'y'), array('escape' => false));
				echo $html->link($html->image('lettres/z.png'), array('controller' => 'actors','action' => 'index', 'prefix' => 'admin', 'z'), array('escape' => false));
				?>
                
<div id="liste-actor">
<table class="data">
	<tr>
    	<th width="25%">Acteur</td>
        <th>Date naissance</td>
        <th>Lieu naissance</td>
        <th>Rôle(s)</td>
        <th>Photo</td>
        <th width="35">Edit</td>
        <th width="35">Supr</td>
	</tr>
    
   
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
    
    
</table>
</div>
