 <?php $this->pageTitle = 'Toutes les critiques de séries tv'; ?>
   
    
    <div id="col1">
    <div id="all-critiques"><h1>Toutes les critiques de series tv</h1></div>
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
        
    	<div>
            <div></div>
            <div class="colr-content">
            </div>
            <div ></div>
        </div>
        
    </div>
