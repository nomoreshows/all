			
			<?php 
			$paginator->options(array('url' => $this->passedArgs)); 
			$paginator->options(array('update' => 'allavis', 'indicator' => 'spinner'));
			
				echo $avis->display($allcomments, $session->read('Auth.User.id'), $session->read('Auth.User.role', 0), false, false);
			?>
            <div class="pagination">
            <!-- Affiche le nombre de pages -->
            <?php echo $paginator->numbers(); ?>
            <br /><br />
             <!-- Affiche les liens des pages précédentes et suivantes -->
            <?php
                echo $paginator->prev('« Plus récents ', null, null, array('class' => 'disabled'));
            ?> 
            
            &nbsp;&nbsp;&nbsp;&nbsp;
            <!-- Affiche les liens des pages précédentes et suivantes -->
            <?php
                echo $paginator->next(' Plus anciens »', null, null, array('class' => 'disabled'));
            ?> 
            </div>