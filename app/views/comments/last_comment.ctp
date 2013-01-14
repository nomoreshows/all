<ul class="play">
        	<?php 
            foreach($comments as $comment) { ?>
        	<li><?php echo $html->link($comment['User']['login'], '/profil/'. $comment['User']['login'], array('class' => 'nodeco')); ?> - 
            <?php 
			echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
			echo ' ';
				if(empty($comment['Article']['id'])) {
					if (empty($comment['Season']['name']) && empty($comment['Episode']['numero'])) {
						// Avis d'une série
						echo $html->link($comment['Show']['name'], '/serie/' . $comment['Show']['menu'], array('class' => 'decoblue'));
					} elseif(empty($comment['Episode']['numero'])) {
						// Avis d'une saison		
						echo $html->link($comment['Show']['name'] . ' saison ' . $comment['Season']['name'], '/saison/' . $comment['Show']['menu'] . '/' . $comment['Season']['name'], array('class' => 'decoblue'));
					} else {
						// Avis d'un épisode
						echo $html->link($comment['Show']['name'] . ' ' . $comment['Season']['name'] . '.' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $comment['Show']['menu'] . '/s' . str_pad($comment['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
					}
					echo ' ' .$star->thumb($comment['Comment']['thumb']); ?> 
					<span class="<?php echo $comment['Comment']['thumb']; ?>"> <?php echo $star->avis($comment['Comment']['thumb']); ?></span> 
                    
                    
                   <?php // Si texte dans l'avis on prépare l'avis en facebox 
				  if (!empty($comment['Comment']['text'])) { ?>
				  
				  <?php }
            
            
				} else { 
            		echo $html->link($text->truncate($comment['Article']['name'], 50, '..', false), '/article/' . $comment['Article']['url'] . '.html', array('class' => 'decoblue'));
                } ?>
                </li>
                <?php
			}
			?>
        </ul>