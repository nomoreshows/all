			<script type='text/javascript'>
				$(function(){
					$("a.avis-show-link").hover(
						function(){
							$(this).children("div").fadeIn();
						}, function() {
						$(this).children("div").fadeOut();
						}
					);
					$("#avisshows").easySlider({
						prevId: 'showprev',
						prevText: 'Pr\351c\351dents',
						nextText: 'Suivants',
						nextId: 'shownext'
					});
				});
			 </script>
			
            <?php if(!empty($filtre)) echo '<strong>' . $filtre . '</strong><br /><br />'; ?>
			
			<?php if(!empty($lastavisshow)) {
				echo '<ul><li>';
				foreach($lastavisshow as $i => $comment) {
					if($i==3) echo '<div class="spacer"></div>';
					if((($i%6) == 0) && $i != 0) echo '</li><li>';
					?>
					<div class="avis-show">
                    	<?php 
						echo 
						$html->link($html->image('show/' . $comment['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $comment['Show']['name'], 'class' => 'avis-show-img border-'.  $comment['Comment']['thumb'])) . '<div class="avis-show-title"><div class="text">voir la fiche série<br /><h3>' . $comment['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $comment['Show']['menu'], 																																																																												 										array('class' => 'avis-show-link', 'escape' => false)																																																																																																																																																																																																																		  						); 
						?>
                        <div class="thumb-<?php echo $comment['Comment']['thumb']; ?>"><?php echo $star->thumb($comment['Comment']['thumb']); ?> <?php echo $star->avis($comment['Comment']['thumb']); ?></div>
                        <div class="avis-show-text">
							<?php echo $html->link($text->truncate(ucfirst($comment['Comment']['text']), 150, array('ending'=> '...', 'exact' => false)), '#todo', array('escape' => false, 'class' => 'avis-read-text-link')); ?>  
							<?php echo $html->link("&raquo; Lire l'avis", '#todo', array('escape' => false, 'class' => 'avis-read-link')); ?>
                       </div>
                    </div>  
				<?php
                }
				echo '</li></ul>';
			 }  
			 ?>