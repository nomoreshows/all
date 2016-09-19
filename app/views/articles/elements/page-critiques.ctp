        <div id="spinner" style="display: none;">
			<?php echo $html->image('spinner.gif'); ?>
    	</div>
    	<table class="data" id="test">
            <tr> 
                <th><?php echo $paginator->sort('Date', 'id'); ?></th> 
                <th><?php echo $paginator->sort('Titre', 'name'); ?></th> 
            </tr> 
               <?php foreach($critiques as $critique): ?> 
            <tr> 
                <td><?php echo $critique['Article']['created']; ?> </td> 
                <td><?php echo $critique['Article']['chapo']; ?> </td> 
            </tr> 
            <?php endforeach; ?> 
        </table> 
        
        <!-- Affiche le nombre de pages -->
		<?php echo $paginator->numbers(); ?>
        <!-- Affiche les liens des pages précédentes et suivantes -->
        <?php
            echo $paginator->prev('« Plus récentes ', null, null, array('class' => 'disabled'));
            echo $paginator->next(' Plus anciennes »', null, null, array('class' => 'disabled'));
        ?> 
        <!-- Affiche X de Y, où X est la page courante et Y le nombre de pages -->
        <?php echo $paginator->counter(array('format' => 'Page %page% sur %pages%, %current% critiques affichées sur %count% au total, starting on record %start%, ending on %end%'
)); 
 ?>