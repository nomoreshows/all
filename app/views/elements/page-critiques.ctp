    	
        <?php
        $paginator->options(array('url' => $this->passedArgs, 'critiques')); 
		$paginator->options(array('update' => 'pages', 'indicator' => 'spinner'));
		?>
        
        
        <?php
		if (!empty($articles)) {
		foreach ($articles as $i => $new) {
			if($new['Article']['etat'] == 1) {
			?>
		<div class="onenews">
			<h2><?php echo $html->link($new['Article']['name'], '/article/' . $new['Article']['url']. '.html'); ?></h2> <br />
			<?php 
			if (empty($new['Article']['show_id'])) {
			echo $html->link($html->image('article/thumb.news.' . $new['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $new['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $new['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $new['Article']['url'] . '.html', array('escape' => false)); 
			}
			?>
			<div class="textnews">
				<p class="date"><?php echo $new['Article']['created']; ?></p> <p class="comments"><?php echo count($new['Comment']); ?> commentaire<?php if(count($new['Comment']) > 1) echo 's'; ?></p>
				<p class="text"><?php echo $text->truncate($new['Article']['chapo'], 250, ' ...', false); ?></p>
			</div>
		</div>
			<?php
			}
		}
		}
		?>
        <br /><br /><br />
        
        <div class="bg-share pages">
        <span style="display:block; padding-top:5px;">
         <!-- Affiche les liens des pages précédentes et suivantes -->
        <?php
            echo $paginator->prev('« Plus récentes ', null, null, array('class' => 'disabled'));
        ?> 
        &nbsp;&nbsp;&nbsp;&nbsp;
        <!-- Affiche le nombre de pages -->
		<?php echo $paginator->numbers(); ?>
        
        &nbsp;&nbsp;&nbsp;&nbsp;
        <!-- Affiche les liens des pages précédentes et suivantes -->
        <?php
            echo $paginator->next(' Plus anciennes »', null, null, array('class' => 'disabled'));
        ?> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- Affiche X de Y, où X est la page courante et Y le nombre de pages -->
        <?php echo $paginator->counter(array('format' => 'Page %page% sur %pages%, %current% articles sur %count% au total')); ?>
        </span>
		</div>