<div data-role="page" id="mobile-page" data-theme="b">
	<div data-role="header" data-theme="b">
    	<h1><?php echo $episode['Season']['Show']['name']; ?></h1>
    </div>
    
    <div data-role="content">
    
    	<?php debug($episode); ?>
    	
        <?php echo $html->image('show/' . $episode['Season']['Show']['menu'] . '_w.jpg', array('align' => 'center', 'style' => 'width:320px; border:2px solid white;')); ?>
        <div align="center">
        	<p>Episode <?php echo str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT); ?>. <?php echo $episode['Episode']['name']; ?> <br /></p></div>
        
        <div data-role="collapsible">
        	<h3>Moyenne : <?php echo $episode['Episode']['moyenne']; ?></strong> <?php echo $star->convert($episode['Episode']['moyenne']); ?></h3>
            
            <?php if (!empty($alreadyrate)) { ?>
            	<strong>Votre note actuelle : <?php echo $alreadyrate['Rate']['name']; ?></strong><br /><br />
            <?php } ?>
			
			<?php echo $form->create('Rate', array('action' => 'mobileAddrate')); ?>
            
            <label for="RateName">Noter : </label>
            <input type="range" name="data[Rate][name]" value="10" min="1" max="20" id="RateName" >
            <?php
            echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
            echo $form->input('season_id', array('type' => 'hidden', 'value' => $episode['Season']['id']));
            echo $form->input('show_id', array('type' => 'hidden', 'value' => $episode['Season']['Show']['id']));
            echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
			?>
            <button type="submit" data-theme="d">Valider</button>
            </form>
            
        </div>
        
        <div data-role="collapsible" data-collapsed="true">
            <h3>Laisser un avis</h3>
             <?php
			  echo $form->create('Comment', array('action' => 'mobileAddcomment')); 
			  echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
              echo $form->input('season_id', array('type' => 'hidden', 'value' => $episode['Season']['id']));
              echo $form->input('show_id', array('type' => 'hidden', 'value' => $episode['Season']['Show']['id']));
              echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
			  echo $form->input('thumb', array(
				  'type' => 'select',
				  'options' => array('up' => 'Favorable', 'neutral' => 'Neutre', 'down' => 'Défavorable'),
				  'default' => $alreadycomment['Comment']['thumb'],
				  'label' => false,
				  'data-theme' => 'e'
			  ));
			  if (empty($alreadycomment))
				  echo $form->input('text', array('label' => false, 'cols' => 45));
			  else 
				  echo $form->input('text', array('label' => false, 'cols' => 45, 'value' => $alreadycomment['Comment']['text']));
			  ?>
              <button type="submit" data-theme="d">Valider</button></form>
			  
        </div>
        
        <div data-role="collapsible">
            <h3>Avis sur l'épisode (<?php echo count($allcomments); ?>)</h3>
            <?php echo $avis->displayMobile($allcomments, $session->read('Auth.User.id'), $session->read('Auth.User.role', 0), false); ?>
        </div>


    </div>
    
</div>
        
	  
