<?php $this->pageTitle = $artist['Artist']['name']; ?>
 	
    <div id="col">
        <h1 class="title nomarg"><?php echo $artist['Artist']['name']; ?></h1>
        
        <?php echo $html->image('flags/' . $artist['Country']['locale'] . '.png', array('class' => 'absmiddle')); ?>
        <span class="genre">
        <?php
        foreach($artist['Genre'] as $j => $genre) {
            if ($j != 0) 
                echo ', ' . $genre['name'];
            else
                echo $genre['name'];
        }
        ?>
        </span>
        <div class="bio"><?php echo $artist['Artist']['bio']; ?></div>
        <?php // debug($artist); ?>
	</div>
    
    <div id="sidebar">
    	<h2 class="title">Festivals</h2>
        
        <?php if (!empty($artist['Day'])) { ?>
			
             <?php echo $html->image('flags/' . $artist['Day'][0]['Festival']['Country']['locale'] . '.png', array('class' => 'absmiddle')); ?>
             <h3><?php echo $html->link($artist['Day'][0]['Festival']['name'], '/festival/' . $artist['Day'][0]['Festival']['url'], array('class' => 'decoblue')); ?></h3> <br />
             <?php echo $html->image('festival/thumb.festival.' . $artist['Day'][0]['Festival']['photo_c'], array('class' => 'festival-imgc')); ?>
             
             <span class="infos-festival">
             	<p class="infos-date">
                <?php
					$timestamp = strtotime($artist['Day'][0]['date']);
					e(strftime("%d %B %Y", $timestamp));
				?>
                </p>
                <p class="infos-country"><?php echo $artist['Day'][0]['Festival']['Country']['name']; 
				if (!empty($artist['Day'][0]['Festival']['Region']['name'])) echo ', ' . $artist['Day'][0]['Festival']['Region']['name']; ?>
                </p>
                <p class="infos-places"><?php echo $artist['Day'][0]['Festival']['places']; ?> places</p>
                <p class="infos-price"><?php echo $artist['Day'][0]['Festival']['price']; ?> euros</p>
             </span>
             <div class="spacer"></div>
			  <?php
              foreach($artist['Day'][0]['Festival']['Genre'] as $j => $genre) {
                      echo '<span class="tag">' . $genre['name'] . '</span>';
              }
              ?>
            
       	<?php } ?>
    </div>
    
