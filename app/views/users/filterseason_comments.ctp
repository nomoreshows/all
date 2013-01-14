			<script type='text/javascript'>
				$(function(){
					$("#avisseasons").easySlider({
						prevId: 'seasonprev',
						prevText: 'Pr\351c\351dents',
						nextText: 'Suivants',
						nextId: 'seasonnext'
					});
					$("a.avis-season-link").hover(
						function(){
							$(this).children("div").fadeIn();
						}, function() {
						$(this).children("div").fadeOut();
						}
					);
				});
			 </script>
			
			<?php if(!empty($filtre)) echo '<strong>' . $filtre . '</strong><br /><br />'; ?>
			
			<?php if(!empty($lastavisseason)) {
				echo '<ul><li>';
				foreach($lastavisseason as $i => $comment) {
					if($i==3) echo '<div class="spacer"></div>';
					if((($i%6) == 0) && $i != 0) echo '</li><li>';
					?>
					<div class="avis-season">
                    	<?php 
						echo 
						$html->link($html->image('show/' . $comment['Show']['menu'] . '_t.jpg', array('width' => 100, 'height' => 100, 'alt' => $comment['Show']['name'], 'class' => 'avis-season-img border-'.  $comment['Comment']['thumb'])) . '<div class="avis-season-title"><h4>' . $comment['Show']['name'] . '</h4></div>', 																																																																						 										'/serie/'. $comment['Show']['menu'], 																																																																												 										array('class' => 'avis-season-link', 'escape' => false)																																																																																																																																																																																																																		  						); 
						?>
                        <div class="thumb-<?php echo $comment['Comment']['thumb']; ?>"><?php echo $star->thumb($comment['Comment']['thumb']); ?></div>
                        <span class="avis-season-name-<?php echo $comment['Comment']['thumb']; ?>">Saison <?php echo $comment['Season']['name']; ?></span>
                        <div class="avis-season-text"><?php echo $text->truncate($comment['Comment']['text'], 80, array('ending'=> '...', 'exact' => false)); ?> </div>
                    </div>  
				<?php
                }	
				echo '</li></ul>';		 
			 } ?>