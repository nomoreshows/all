 <?php $this->pageTitle = 'Tous les membres'; ?>
   
    
    <div id="col1">
        <div id="all-membres"><h1>Tous les membres</h1></div>
        <div class="padl10">
        	<div id="membres-table">
           	<?php echo $this->element('page-membres'); ?>
           </div>
        	<div id="spinner"><?php echo $html->image('spinner.gif', array('class' => 'absmiddle')); ?></div>
            
        </div>
    </div>
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des membres', '/membres', array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
    	<!-- Informations 
    	<div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
            	<h3 class="red">Membres les plus actifs</h3> 
    			<br /><br />
                <ul class="play">
                	<li></li>
                </ul>
                <br />
                
                <h3 class="red">Membres les plus joyeux</h3> 
                <br /><br />
                
                <h3 class="red">Membres les plus méchants</h3> 
                <br /><br />
        	</div>
            <div class="colr-footer"></div>
        </div>
        -->
        <div id="colright-bup">
            <div class="colrbup-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('pub-sidebar'); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
    </div>