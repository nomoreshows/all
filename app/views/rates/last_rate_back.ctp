		    
    
    <ul class="play">
    <?php 
            foreach($rates as $rate) { ?>
                <li>
                <span class="lblue"><?php echo $rate['Rate']['name']; ?></span> 
                par <?php echo $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')); ?> 
                -
                <?php 
                echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
				echo ' ';
				
				// Note d'un épisode
				echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
                ?>
                </li>
            <?php } ?>
    </ul>