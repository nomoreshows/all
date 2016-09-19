	
<?php  // PAR GENRE
if ($cat == 'genre') {
	foreach($genres as $i => $genre): ?>
    <h2 class="spacer red"><?php echo $genre['Genre']['name']; ?></h2>
    <br /><br />
		<?php
        foreach($genre['Show'] as $i => $serie): ?>
            <div class="serie">
                <div class="serie-infos">
                    <h2><?php echo $html->link($serie['name'], '/serie/' . $serie['menu'], array('class' => 'nodeco')); ?></h2> 
                    <?php if (strlen($serie['name']) < 23) echo '<br />'; else echo '-'; ?>
                    <span class="grey">
                    
                    </span>
                </div>
                <?php echo $html->link($html->image(('show/' . $serie['menu'] . '_w_serie.jpg'), array('alt' => '', 'width' => '139')), '/serie/' .$serie['menu'], array('class' => 'nodeco', 'escape' => false)); ?>
            </div>
        <?php endforeach; ?>
        <div class="spacer"></div>
    <?php endforeach; ?>
	<div class="spacer"></div>
    
    
    
    
<?php // PAR ANNEE

} elseif ($cat == 'annee') {
	
	$annee_cur = 0;
	
	foreach($series as $i => $serie): 
    $annee = $serie['Show']['annee'];
	if ($annee != $annee_cur) {
		echo '<div class="spacer"><br /><br /></div><h2 class="red spacer">'. $annee .'</h2><div class="spacer"></div>';	
	}
	?>
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
    <?php $annee_cur = $annee; ?>
    <?php endforeach; ?>
	<div class="spacer"></div>
<?php



} elseif ($cat == 'nationalite') { 
	
	$nationalite_cur = 1;
	
	foreach($series as $i => $serie): 
    $nationalite = $serie['Show']['nationalite'];
	if ($nationalite != $nationalite_cur) {
		echo '<div class="spacer"><br /><br /></div><h2 class="red spacer">'. $nationalite .'</h2><div class="spacer"></div>';	
	}
	?>
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
    <?php $nationalite_cur = $nationalite; ?>
    <?php endforeach; ?>
	<div class="spacer"></div>
<?php



} elseif ($cat == 'chaineus') { 
	
	$chaineus_cur = 1;
	
	foreach($series as $i => $serie): 
    $chaineus = $serie['Show']['chaineus'];
	if (!empty($chaineus)) {
	// Si il existe une chaîne
		if ($chaineus != $chaineus_cur) {
			echo '<div class="spacer"><br /><br /></div><h2 class="red spacer">'. $chaineus .'</h2><div class="spacer"></div>';	
		}
		?>
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
    <?php 
	}
	$chaineus_cur = $chaineus;
    endforeach; ?>
	<div class="spacer"></div>
<?php



} elseif ($cat == 'chainefr') { 
	
	$chainefr_cur = 1;
	
	foreach($series as $i => $serie): 
    $chainefr = $serie['Show']['chainefr'];
	if (!empty($chainefr)) {
	// Si il existe une chaîne
		if ($chainefr != $chainefr_cur) {
			echo '<div class="spacer"><br /><br /></div><h2 class="red spacer">'. $chainefr .'</h2><div class="spacer"></div>';	
		}
		?>
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
     <?php
    }
     $chainefr_cur = $chainefr;
     endforeach; ?>
	<div class="spacer"></div>
<?php



} elseif ($cat == 'format') { 
	
	$format_cur = 1;
	
	foreach($series as $i => $serie): 
    $format = $serie['Show']['format'];
	if ($format != $format_cur) {
		echo '<div class="spacer"><br /><br /></div><h2 class="red spacer">'. $format .' min</h2><div class="spacer"></div>';	
	}
	?>
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
     <?php
     $format_cur = $format;
     endforeach; ?>
	<div class="spacer"></div>
<?php
}