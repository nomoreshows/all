		<div id="topbar" class="transparent">
        	<div id="title"><?php echo substr($episode['Season']['Show']['name'], 0, 10); ?></div>
            <div id="leftnav"><a href="/iphoneSeason/<?php echo $episode['Season']['id']; ?>">Saison <?php echo $episode['Season']['name']; ?></a> </div>
             <div id="bluerightbutton"><a href="/iphone">Accueil</a> </div>
        </div>

        <div id="content">
        	<span class="graytitle"><?php echo $episode['Episode']['numero']; ?>. <?php echo $episode['Episode']['name']; ?> </span>
            	
                
            	<ul class="pageitem">
                	<li class="textbox">
                		<span class="header">Noter l'épisode</span>
                   
					<?php 
                    if($session->read('Auth.User.role') > 0) {
						echo '</li>';
                        echo $form->create('Rate', array('action' => 'iphoneAddrate')); 
                        echo '<li class="select">';
						if (empty($alreadycomment)) {
                       		echo $form->input('name', array('label' => false, 'div' => false, 'default' => '-- choisir --', 'options' => array(20 => 20,19 => 19, 18 => 18,17 => 17,16 => 16,15 => 15,14 => 14,13 => 13,12 => 12,11 => 11,10 => 10,9 => 9,8 => 8,7 => 7,6 => 6,5 => 5,4 => 4,3 => 3,2 => 2,1 => 1,0 => 0)));
						} else {
							echo $form->input('name', array('label' => false, 'div' => false, 'default' => 'ma note', 'options' => array(20 => 20,19 => 19, 18 => 18,17 => 17,16 => 16,15 => 15,14 => 14,13 => 13,12 => 12,11 => 11,10 => 10,9 => 9,8 => 8,7 => 7,6 => 6,5 => 5,4 => 4,3 => 3,2 => 2,1 => 1,0 => 0)));	
						}
                        echo '<span class="arrow"></span></li>';
                        echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
                        echo $form->input('season_id', array('type' => 'hidden', 'value' => $episode['Season']['id']));
                        echo $form->input('show_id', array('type' => 'hidden', 'value' => $episode['Season']['Show']['id']));
                        echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
                        echo '<li class="button"><input name="name" type="submit" value="Noter !"/></li></form>';
                    } else {
                        echo '<p>Vous devez posséder un compte pour noter cet épisode.</p>';	
						echo '</li>';
                    }
                    ?>
                </ul>
                
                <ul class="pageitem">
                    <li class="textbox">
                		<span class="header">Ecrire un avis</span>
                    </li>
                        <?php
                        echo $form->create('Comment', array('action' => 'iphoneAddcomment')); 
						echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
						echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id']));
						echo $form->input('season_id', array('type' => 'hidden', 'value' => $season['Season']['id']));
						echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
						echo '<li class="select">';
						echo $form->input('thumb', array(
							'type' => 'select',
							'options' => array('up' => 'Favorable', 'neutral' => 'Neutre', 'down' => 'Défavorable'),
							'default' => $alreadycomment['Comment']['thumb'],
							'label' => false
						));
						echo '<span class="arrow"></span></li>';
						echo '<li class="textbox">';
						if (empty($alreadycomment))
							echo $form->input('text', array('label' => false, 'cols' => 45));
						else 
							echo $form->input('text', array('label' => false, 'cols' => 45, 'value' => $alreadycomment['Comment']['text']));
						echo '</textarea></li>';
						echo '<li class="button"><input name="name" type="submit" value="Laisser un avis !"/></li></form>';
						?>
                    </li>
                </ul>
                
                
                <ul class="pageitem">
                <li class="textbox">
                    <span class="header">Résumé</span>
                    <p><?php echo $episode['Episode']['resume']; ?></p>
                </li>
                <?php foreach ($season['Episode'] as $episode) {
					echo '<li class="menu">';
					echo '<a href="/iphoneEpisode/'. $episode['id'] . '">';
					echo '<span class="name">' . $episode['numero'] . '. ' . $episode['name'] . '</span>';
					echo '<span class="arrow"> </span>';
					echo '</a></li>';
				} // echo '<pre>'; print_r($show); echo '</pre>';?>
            </ul>
        </div>
        <div id="footer">
        
        </div>
        
        
	  
