	<?php $this->pageTitle = 'Série-All Awards - Election des meilleurs séries de 2010'; 
    echo $html->meta('description', 'Participez à l\'élection des meilleurs séries, acteurs, nouveautés de 2010 et des pires...', array('type'=>'description'), false); 
	?>
    
	<div id="col1">  
		<div class="padl20">
        	<br />
            <h1 class="title red">Série-All Awards 2010</h1>
            <br /><br />
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam diam nisl, aliquet non pretium vitae, dignissim vitae nisi. Vestibulum tempus, quam eget ultricies tincidunt, ligula mauris pretium nibh, et aliquam diam nibh eu neque. Praesent sit amet elementum dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
            <br /><br />
            
            <?php foreach($polls as $i => $poll): ?>
            <div class="poll">
                <h2><?php echo $poll['Poll']['name']; ?></h2>            
            </div>
            <?php endforeach; ?>    
        </div>
    </div>
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
    	
		<div id="colright-bup">
            <div class="colrbup-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('pub-sidebar'); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
    </div>

