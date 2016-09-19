	 <?php $this->pageTitle = 'Séries - Profil de ' . $user['User']['login']; 
	 echo $html->meta('description', $user['User']['login'] . ' utilise Série-All pour créer sa collection de séries, noter les épisodes et être prévenu de la sortie de ses séries favorites.', array('type'=>'description'), false);
     ?>
     
     <script type="text/javascript">
		$(function() {
			$("a.delfollow").bind("click", function() {
				$(this).parent().parent().parent().parent().fadeOut("slow");			 
			});

		});
		</script>
     
    <div id="col1">
    	<div class="padl10">
      
        		<h1 class="red title"><?php echo $user['User']['login']; ?> &raquo; Séries</h1>
            <?php echo $this->element('profil-menu'); ?>
        	  
            <div id="profil-series">     
              <!-- Séries en cours -->
              <h2 class="title dblue">Séries en cours <span class="counter">(<?php echo count($followedshows); ?>)</span></h2><br />
              <span class="grey">Ce sont les séries en cours de visionnage, qu'elles soient terminées ou non. Elles apparaissent dans votre planning personnalisé.</span><br /><br />
              <div id="result-follow">
              <?php if(!empty($followedshows)) {
								
              foreach($followedshows as $show) {
                echo '<div class="listeshows">';
                echo '<div class="imageshow">';
                echo $html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)); 
                echo '<h5><span>' . $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco2')) . ' ';
                
                if($session->read('Auth.User.id') == $user['User']['id']) {
                echo $ajax->link('[x]', array('controller' => 'users', 'action' => 'delfollow', $show['Show']['id']), array('class' => 'nodeco2 delfollow')); }
                echo '</span></h5></div></div>';
              }
              ?>
            <?php	 
            } else {
              echo '<strong>Aucunes.</strong>';
              if ($session->read('Auth.User.id') == $user['User']['id']) {
                echo ' Pour supprimer une série, cliquez sur le [x] de sa vignette.';
              }
            }	?>
           </div>
           <div class="spacer"></div>
           <?php if($session->read('Auth.User.id') == $user['User']['id']) { ?>
               <br />
               <table><tr><td>Ajouter une série : </td><td>
               <?php 
                $ajout = array('0' => '-- Choisir --');
                $quickshows = $ajout + $quickshows;
                
                echo $ajax->form(array('type' => 'post',
                    'options' => array(
                        'model' => 'User',
                        'update' => 'result-follow',
                        'url' => array(
                            'controller' => 'users',
                            'action' => 'addfollow'
                        )
                    )
                ));
                echo $form->input('show_id', array('div' => false, 'label' => false, 'class' => 'sexycombo', 'options' => $quickshows));
                echo $form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
                echo $form->input('etat', array('type' => 'hidden', 'value' => 1));
                
                ?>
                </td><td>
                <?php echo $form->end('Valider'); ?>
                </td>
                </tr></table>
                <br /><br /><br /><br />
           <?php } else { ?>
              <br /><br />
           <?php } ?>
                     
                     
                     
             <!-- Séries en pause -->
             <h2 class="title dblue">Séries en pause <span class="counter">(<?php echo count($pausedshows); ?>)</span></h2><br />
             <span class="grey">Ce sont les séries que vous suivez et qui vont reprendre prochainement.</span><br /><br />
              <div id="result-pause">
              <?php if(!empty($pausedshows)) {
            	?>
                          <?php 
              foreach($pausedshows as $show) {
                echo '<div class="listeshows">';
                echo '<div class="imageshow">';
                echo $html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)); 
                echo '<h5><span>' . $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco2')) . ' ';
                
                if($session->read('Auth.User.id') == $user['User']['id']) {
                echo $ajax->link('[x]', array('controller' => 'users', 'action' => 'delfollow', $show['Show']['id']), array('class' => 'nodeco2 delfollow')); }
                echo '</span></h5></div></div>';
              }
              ?>
            <?php	 
            } else {
              echo ' <strong>Aucunes.</strong>';
            }	?>
                     </div>
                     <div class="spacer"></div>
                     <?php if($session->read('Auth.User.id') == $user['User']['id']) { ?>
                     <br />
  
                     <table><tr><td>Ajouter une série : </td><td>
             <?php 
            $ajout = array('0' => '-- Choisir --');
            $quickshows = $ajout + $quickshows;
            
            echo $ajax->form(array('type' => 'post',
              'options' => array(
                'model'=>'User',
                'update'=>'result-pause',
                'url' => array(
                  'controller' => 'users',
                  'action' => 'addfollow'
                )
              )
            ));
            echo $form->input('show_id', array('div' => false, 'label' => false, 'class' => 'sexycombo', 'options' => $quickshows));
            echo $form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
            echo $form->input('etat', array('type' => 'hidden', 'value' => 2));
            
            ?>
            </td><td>
            <?php echo $form->end('Valider'); ?>
            </td>
            </tr></table>
           <br /><br /><br /><br />
           <?php } else { ?>
              <br /><br />
           <?php } ?>
           
           
           
           <!-- Séries terminées -->
           <h2 class="title dblue">Séries terminées <span class="counter">(<?php echo count($finishedshows); ?>)</span></h2><br />
            <span class="grey">Ce sont les séries terminées que vous avez regardées entièrement.</span><br /><br />
            <div id="result-finish">
            <?php if(!empty($finishedshows)) {
            ?>
                          <?php 
              foreach($finishedshows as $show) {
                echo '<div class="listeshows">';
                echo '<div class="imageshow">';
                echo $html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)); 
                echo '<h5><span>' . $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco2')) . ' ';
                
                if($session->read('Auth.User.id') == $user['User']['id']) {
                echo $ajax->link('[x]', array('controller' => 'users', 'action' => 'delfollow', $show['Show']['id']), array('class' => 'nodeco2 delfollow')); }
                echo '</span></h5></div></div>';
              }
              ?>
            <?php	 
            } else {
              echo ' <strong>Aucunes.</strong>';
            }	?>
                     </div>
                     <div class="spacer"></div>
                     <?php if($session->read('Auth.User.id') == $user['User']['id']) { ?>
                     <br />
                     <table><tr><td>Ajouter une série : </td><td>
             <?php 
            $ajout = array('0' => '-- Choisir --');
            $quickshows = $ajout + $quickshows;
            
            echo $ajax->form(array('type' => 'post',
              'options' => array(
                'model'=>'User',
                'update'=>'result-finish',
                'url' => array(
                  'controller' => 'users',
                  'action' => 'addfollow'
                )
              )
            ));
            echo $form->input('show_id', array('div' => false, 'label' => false, 'class' => 'sexycombo', 'options' => $quickshowsf));
            echo $form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
            echo $form->input('etat', array('type' => 'hidden', 'value' => 3));
            
            ?>
            </td><td>
            <?php echo $form->end('Valider'); ?>
            </td>
            </tr></table>
           <br /><br /><br /><br />
           <?php } else { ?>
              <br /><br />
           <?php } ?>
           
           
           
           <!-- Séries à voir -->
           <h2 class="title dblue">Séries à voir <span class="counter">(<?php echo count($toseeshows); ?>)</span></h2><br />
            <span class="grey">Ce sont les séries que vous avez prévu de regarder prochainement.</span><br /><br />
            <div id="result-tosee">
            <?php if(!empty($toseeshows)) {
            ?>
                          <?php 
              foreach($toseeshows as $show) {
                echo '<div class="listeshows">';
                echo '<div class="imageshow">';
                echo $html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)); 
                echo '<h5><span>' . $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco2')) . ' ';
                
                if($session->read('Auth.User.id') == $user['User']['id']) {
                echo $ajax->link('[x]', array('controller' => 'users', 'action' => 'delfollow', $show['Show']['id']), array('class' => 'nodeco2 delfollow')); }
                echo '</span></h5></div></div>';
              }
              ?>
            <?php	 
            } else {
              echo ' <strong>Aucunes.</strong>';
            }	?>
           </div>
           <div class="spacer"></div>
           <?php if($session->read('Auth.User.id') == $user['User']['id']) { ?>
           <br />
           <table><tr><td>Ajouter une série : </td><td>
            <?php 
            $ajout = array('0' => '-- Choisir --');
            $quickshows = $ajout + $quickshows;
            
            echo $ajax->form(array('type' => 'post',
              'options' => array(
                'model'=>'User',
                'update'=>'result-tosee',
                'url' => array(
                  'controller' => 'users',
                  'action' => 'addfollow'
                )
              )
            ));
            echo $form->input('show_id', array('div' => false, 'label' => false, 'class' => 'sexycombo', 'options' => $quickshows));
            echo $form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
            echo $form->input('etat', array('type' => 'hidden', 'value' => 5));
            
            ?>
            </td><td>
            <?php echo $form->end('Valider'); ?>
            </td>
            </tr></table>
           <br /><br /><br /><br />
           <?php } else { ?>
              <br /><br />
           <?php } ?>
           
           
           
           <!-- Séries abandonnées -->
           <h2 class="title dblue">Séries abandonnées <span class="counter">(<?php echo count($abortedshows); ?>)</span></h2><br />
           <span class="grey">Ce sont les séries que vous avez abandonnées avant la fin. Expliquez-nous la raison.</span><br /><br />
           <div id="result-abort">
					 <?php if(!empty($abortedshows)) {

              foreach($abortedshows as $show) {
                echo '<div class="listeshows">';
                echo '<div class="imageshow">';
                echo $html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)); 
                echo '<h5><span>' . $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco2')) . ' ';
                
                if($session->read('Auth.User.id') == $user['User']['id']) {
                echo $ajax->link('[x]', array('controller' => 'users', 'action' => 'delfollow', $show['Show']['id']), array('class' => 'nodeco2 delfollow')); }
                echo '</span></h5></div>';
                echo '<div class="textshow">' . $show['Followedshows']['text'] . '</div></div><div class="spacer"></div>';
              }

            } else {
              echo ' <strong>Aucunes.</strong>';
            }	?>
           </div>
           <div class="spacer"></div>
           <?php if($session->read('Auth.User.id') == $user['User']['id']) { ?>
           <br />
           <table><tr><td>Ajouter une série : </td><td>
            <?php 
            $ajout = array('0' => '-- Choisir --');
            $quickshows = $ajout + $quickshows;
            
            echo $ajax->form(array('type' => 'post',
              'options' => array(
                'model'=>'User',
                'update'=>'result-abort',
                'url' => array(
                  'controller' => 'users',
                  'action' => 'addfollow'
                )
              )
            ));
            echo $form->input('show_id', array('div' => false, 'label' => false, 'class' => 'sexycombo', 'options' => $quickshows));
            echo $form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
            echo $form->input('etat', array('type' => 'hidden', 'value' => 4));
            ?>
            </td><td>
            <?php echo $form->input('text', array('type' => 'textarea', 'cols' => 45, 'value' => 'La raison de votre abandon ?', 'rows' => 2, 'label' => false)); ?>
            </td><td>
            <?php echo $form->end('Valider'); ?>
            </td>
            </tr></table>
            <br /><br /><br /><br />
            <?php } else { ?>
              <br /><br />
           <?php } ?>
           <div class="spacer"></div>
           </div>
        </div>
    </div>
    
    
    <?php echo $this->element('profil-sidebar'); ?>