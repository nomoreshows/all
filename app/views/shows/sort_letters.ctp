	
<?php 	
	foreach($series as $i => $serie): ?>
    <div class="serie">
        <div class="serie-infos">
            <h2><?php echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco')); ?></h2> 
            <?php if (strlen($serie['Show']['name']) < 23) echo '<br />'; else echo '-'; ?>
            <span class="grey">
            <?php echo count($serie['Season']);
            if (count($serie['Season']) == 1) {
                echo ' saison'; 
            } else { 
                echo ' saisons'; 
            } ?>
            </span>
        </div>
        <?php echo $html->link($html->image(('show/' . $serie['Show']['menu'] . '_w_serie.jpg'), array('alt' => '', 'width' => '139')), '/serie/' .$serie['Show']['menu'], array('class' => 'nodeco', 'escape' => false)); ?>
    </div>
    <?php endforeach; ?>
	<div class="spacer"></div>
