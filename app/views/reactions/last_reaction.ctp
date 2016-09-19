		<ul class="play">
        	<?php 
            foreach($comments as $comment) { ?>
        	<li>
            	<span class="red"><?php echo $html->link($comment['User']['login'], '/profil/'. $comment['User']['login'], array('class' => 'nodeco')); ?> </span> - 
				<?php 
                echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
                echo ' ';
				if (empty($comment['Comment']['Season']['name']) && empty($comment['Comment']['Episode']['name'])) {
						// Avis d'une série
						echo $html->link($comment['Comment']['Show']['name'], '/serie/' . $comment['Comment']['Show']['menu'], array('class' => 'decoblue'));
					} elseif(empty($comment['Comment']['Episode']['numero'])) {
						// Avis d'une saison		
						echo $html->link($comment['Comment']['Show']['name'] . ' saison ' . $comment['Comment']['Season']['name'], '/saison/' . $comment['Comment']['Show']['menu'] . '/' . $comment['Comment']['Season']['name'], array('class' => 'decoblue'));
					} else {
						// Avis d'un épisode
						echo $html->link($comment['Comment']['Show']['name'] . ' ' . $comment['Comment']['Season']['name'] . '.' . str_pad($comment['Comment']['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $comment['Comment']['Show']['menu'] . '/s' . str_pad($comment['Comment']['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($comment['Comment']['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
					}
                ?>
                <span class="grey">@ <?php echo $comment['Comment']['User']['login']; ?></span>
            </li>
            <?php
			}
			?>
        </ul>