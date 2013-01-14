 <?php $this->pageTitle = 'Toute l\'actualité des séries TV'; ?>
   
    
    <div id="col1">
    <div id="all-news"><h1>Toute l'actualite des series tv</h1></div>
    <br />
    <div id="pages" class="padl10">
        <?php echo $this->element('page-critiques'); ?>
    </div>
    <div id="spinner"><?php echo $html->image('spinner.gif', array('class' => 'absmiddle')); ?></div>

    </div>
    
    
    <div id="col2">
    	
        <!-- Derniers articles -->
        <div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('facebook-page', array('cache' => "+1 day")); ?>
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