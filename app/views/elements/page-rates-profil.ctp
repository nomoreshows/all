    	
	<?php
    $paginator->options(array('url' => $this->passedArgs)); 
    $paginator->options(array('update' => 'rates', 'indicator' => 'spinner'));
    ?>
        
        
    <td width="35%">
    	<div id="dernieresnotes"></div>
        <br /><br /><br /><br />
        
        <?php if (!empty($rates)) { ?>
        <ul class="play">
            <?php 
            foreach($rates as $rate) { ?>
                <li>
                <span class="red"><?php echo $rate['Rate']['name']; ?></span>
                <?php 
                if (empty($rate['Season']['name']) && empty($rate['Episode']['name'])) {
                    // Note d'une série
                    echo '- ' . $html->link($rate['Show']['name'], '/serie/' . $rate['Show']['menu'], array('class' => 'nodeco'));
                } elseif(empty($rate['Episode']['numero'])) {
                    // Note d'une saison		
                    echo '- ' . $html->link($rate['Show']['name'] . ' saison ' . $rate['Season']['name'], '/saison/' . $rate['Show']['menu'] . '/' . $rate['Season']['name'], array('class' => 'nodeco'));
                } else {
                    // Note d'un épisode
                    echo '- ' . $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
                }
                ?>
                </li>
            <?php } ?>
        </ul>
        <?php } ?> 
        <br />
       
        <div class="pagination">
        <!-- Affiche le nombre de pages -->
		<?php echo $paginator->numbers(); ?>
        <br /><br />
         <!-- Affiche les liens des pages précédentes et suivantes -->
        <?php
            echo $paginator->prev('« Plus récentes ', null, null, array('class' => 'disabled'));
        ?> 
        
        &nbsp;&nbsp;&nbsp;&nbsp;
        <!-- Affiche les liens des pages précédentes et suivantes -->
        <?php
            echo $paginator->next(' Plus anciennes »', null, null, array('class' => 'disabled'));
        ?> 
        </div>
    </td>
    <td width="65%">
    	<div id="derniersavis"></div>
        <br /><br /><br /><br />
        
        <?php if (!empty($comments)) { ?>
        <ul class="play">
        <?php 
            foreach($comments as $comment) { ?>
        	<li>
            <?php 
			if (empty($comment['Season']['name']) && empty($comment['Episode']['name'])) {
				// Avis d'une série
				$com = 'serie';
				echo $html->link($comment['Show']['name'], '/serie/' . $comment['Show']['menu'], array('class' => 'nodeco'));
			} elseif(empty($comment['Episode']['numero'])) {
				// Avis d'une saison		
				$com = 'saison';
				echo $html->link($comment['Show']['name'] . ' saison ' . $comment['Season']['name'], '/saison/' . $comment['Show']['menu'] . '/' . $comment['Season']['name'], array('class' => 'nodeco'));
			} else {
				// Avis d'un épisode
				$com = 'episode';
				echo $html->link($comment['Show']['name'] . ' ' . $comment['Season']['name'] . '.' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $comment['Show']['menu'] . '/s' . str_pad($comment['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
			}
			echo ' ' .$star->thumb($comment['Comment']['thumb']); ?> 
			<span class="<?php echo $comment['Comment']['thumb']; ?>"> <?php echo $star->avis($comment['Comment']['thumb']); ?></span>
            <span class="grey">&nbsp;<?php echo $html->link($text->truncate($comment['Comment']['text'], 45, ' ...', true), '#avis' . $comment['Comment']['id'], array('class' => 'nodecogrey', 'rel' => 'facebox')); ?></span>
            <div id="avis<?php echo $comment['Comment']['id']; ?>" style="display:none">
            	<h2 class="red">Avis sur <?php echo $comment['Show']['name']; 
				if ($com == 'saison') { echo ' saison ' . $comment['Season']['name']; } 
				elseif($com == 'episode') { echo ' ' . $comment['Season']['name'] . '.' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT); } ?>
                </h2>
                <br /><br />
                <?php echo $comment['Comment']['text']; ?>
            </div>
			</li>
			<?php
		}
		?>
        </ul>
        <script type="text/javascript">
		  $(document).ready(function(){		
			  $('a[rel*=facebox]').facebox({
				loading_image : 'loading.gif',
				close_image   : 'closelabel.gif'
			  })
		  });
	   </script>
        <?php } ?> 
    </td>