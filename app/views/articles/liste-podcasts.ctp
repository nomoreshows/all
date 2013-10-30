 <?php $this->pageTitle = 'Tous les podcasts de la rédaction'; ?>
   
    
    <div id="col1">
    <div id="all-podcasts"><h1>Tous les podcasts de la rédaction</h1></div>
    <br />
    <div id="pages" class="padl10">
        <?php echo $this->element('page-critiques'); ?>
    </div>
    <div id="spinner"><?php echo $html->image('spinner.gif', array('class' => 'absmiddle')); ?></div>

    </div>
    
    
    <div id="col2">
    	
        <!-- Derniers articles -->
        <div id="colright-lastarticles">
            <div class="colrlastart-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('last-articles', array('cache' => "+1 day")); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        
    	<div id="colright-bup">
            <div class="colrbup-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('pub-sidebar'); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        
    </div>