	 <?php $this->pageTitle = 'Planning et calendrier des séries US'; 
	 echo $html->meta('description', 'Consulter le calendrier des séries US et personnaliser le planning selon les séries que vous regardez.', array('type'=>'description'), false);
     ?>
     
      <script type="text/javascript">
		$(function() {
			$(".tabs").tabs();
		});
		</script>
     
    <div id="col1">
    	<div class="padl10">
       		<h1 class="red title">Planning des séries US</h1>
            <br /><br /><br />
            
            <div class="tabs">
                <ul>
                    <li><a href="#tabs-1">Cette semaine</a></li>
                    <li><a href="#tabs-2">Semaine prochaine</a></li>
                    <li><a href="#tabs-3">Mon planning</a></li>
                </ul>
                <div id="tabs-1">
           		<table class="planning">
           		<?php 
				$continue = false;
				// $priority2 = false;
				$compteur = 7;
				foreach ($episodes as $episode) {
					
					// récupération du jour de l'épisode
					$timestamp = strtotime($episode['Episode']['diffusionus']); 
					$jour_courant = strftime("%w", $timestamp);
					// $priority_courant = $episode['Season']['Show']['priority'];
					
					// si c'est un lundi, on ouvre l'acces
					if($jour_courant == 1) {
						$continue = true;
					}
					
					if ($continue and $compteur >= 0) {
						
						// echo 'courant:'. $jour_courant . ' prec:' . $jour_prec;
						// changement de jour => nouveau tr
						if($jour_courant != $jour_prec) {
							
							$compteur --;
							if ($compteur >= 0) {
								
								/* si il y avait des priority2, refermer le div
								if ($priority2) {
									echo '<strong>fin</strong></div>';	
									$priority2 = false;
								} */
								
								echo '</td></tr>';
								echo '<tr><td width="30%">' . $html->link($html->image('show/' . $episode['Season']['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false)) . '</td><td width="70%"><h4>' . ucfirst(strftime("%A %d %B", $timestamp)) . '</h4><br />';	
								// Image
								
								echo '<br />';
								// Episode
								echo $html->link($episode['Season']['Show']['name'], '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false, 'class' => 'nodeco'));
								echo' <span class="red">' . $html->link($episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</span>'; 
								echo ' - ';
								
								// TBA
								if (!empty($episode['Episode']['name'])) {
									echo $html->link($episode['Episode']['name'], '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
								} else {
									echo $html->link('TBA', '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
								}
							}
							
							
						} else {
							
							/* si changement de priorité : nouvelle div, sinon retour ligne
							if ($priority_courant != $priority_prec) {
								echo '<div class="priority2">';
								$priority2 = true;
								echo '<strong>debut</strong>';
							} else {
								echo '<br />';
							} */
							echo '<br />';
							// Episode
							echo $html->link($episode['Season']['Show']['name'], '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false, 'class' => 'nodeco'));
							echo' <span class="lblue">' . $html->link($episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</span>'; 
							echo ' - ';
							
							// TBA
							if (!empty($episode['Episode']['name'])) {
								echo $html->link($episode['Episode']['name'], '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							} else {
								echo $html->link('TBA', '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							}
							
						}
						// debug($episode);
					}
					
					$jour_prec = $jour_courant;
					// $priority_prec = $priority_courant;
				
		   		}
             ?>
           </table>
           </div>
           <div id="tabs-2">
           	<table class="planning">
           		<?php 
				$continue = false;
				// $priority2 = false;
				$compteur = 7;
				foreach ($episodesnext as $episode) {
					
					// récupération du jour de l'épisode
					$timestamp = strtotime($episode['Episode']['diffusionus']); 
					$jour_courant = strftime("%w", $timestamp);
					// $priority_courant = $episode['Season']['Show']['priority'];
					
					// si c'est un lundi, on ouvre l'acces
					if($jour_courant == 1) {
						$continue = true;
					}
					
					if ($continue and $compteur >= 0) {
						
						// echo 'courant:'. $jour_courant . ' prec:' . $jour_prec;
						// changement de jour => nouveau tr
						if($jour_courant != $jour_prec) {
							
							$compteur --;
							if ($compteur >= 0) {
								
								/* si il y avait des priority2, refermer le div
								if ($priority2) {
									echo '<strong>fin</strong></div>';	
									$priority2 = false;
								} */
								
								echo '</td></tr>';
								echo '<tr><td width="30%">' . $html->link($html->image('show/' . $episode['Season']['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false)) . '</td><td width="70%"><h4>' . ucfirst(strftime("%A %d %B", $timestamp)) . '</h4><br />';	
								// Image
								
								echo '<br />';
								// Episode
								echo $html->link($episode['Season']['Show']['name'], '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false, 'class' => 'nodeco'));
								echo' <span class="lblue">' . $html->link($episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</span>'; 
								echo ' - ';
								
								// TBA
								if (!empty($episode['Episode']['name'])) {
									echo $html->link($episode['Episode']['name'], '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
								} else {
									echo $html->link('TBA', '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
								}
							}
							
							
						} else {
							
							/* si changement de priorité : nouvelle div, sinon retour ligne
							if ($priority_courant != $priority_prec) {
								echo '<div class="priority2">';
								$priority2 = true;
								echo '<strong>debut</strong>';
							} else {
								echo '<br />';
							} */
							echo '<br />';
							// Episode
							echo $html->link($episode['Season']['Show']['name'], '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false, 'class' => 'nodeco'));
							echo' <span class="red">' . $html->link($episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</span>'; 
							echo ' - ';
							
							// TBA
							if (!empty($episode['Episode']['name'])) {
								echo $html->link($episode['Episode']['name'], '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							} else {
								echo $html->link('TBA', '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							}
							
						}
						// debug($episode);
					}
					
					$jour_prec = $jour_courant;
					// $priority_prec = $priority_courant;
				
		   		}
             ?>
           </table>
           </div>
           <div id="tabs-3">
           		<table class="planning">
           		<?php 
				if(!empty($mesepisodes)) {
				$continue = false;
				$timestamp_prec = 1;
				$compteur = 10;
				
				foreach ($mesepisodes as $i => $episode) {
					
					// récupération du jour de l'épisode
					$timestamp = strtotime($episode['Episode']['diffusionus']); 
					$timestamp_courant = $timestamp;
					//echo 'courant:'. $jour_courant . ' prec:' . $jour_prec;
					
					if ($compteur > 0) {
						
						// changement de jour => nouveau tr
						if($timestamp_courant != $timestamp_prec || $i == 0) {
							
							$compteur--;
							
							if ($i != 0) echo '</td></tr>';
							echo '<tr><td width="30%">' . $html->link($html->image('show/' . $episode['Season']['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false)) . '</td><td width="70%"><h4>' . ucfirst(strftime("%A %d %B", $timestamp)) . '</h4><br />';	
							// Image
							
							echo '<br />';
							// Episode
							echo $html->link($episode['Season']['Show']['name'], '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false, 'class' => 'nodeco'));
							echo' <span class="red">' . $html->link($episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</span>'; 
							echo ' - ';
							
							// TBA
							if (!empty($episode['Episode']['name'])) {
								echo $html->link($episode['Episode']['name'], '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							} else {
								echo $html->link('TBA', '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							}
							
						} else {
							echo '<br />';
							// Episode
							echo $html->link($episode['Season']['Show']['name'], '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false, 'class' => 'nodeco'));
							echo' <span class="red">' . $html->link($episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</span>'; 
							echo ' - ';
							
							// TBA
							if (!empty($episode['Episode']['name'])) {
								echo $html->link($episode['Episode']['name'], '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							} else {
								echo $html->link('TBA', '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodecogrey'));
							}
							
						}
						// debug($episode);
					}
					
					$timestamp_prec = $timestamp_courant;
				
		   		}
			} else {
				echo "Vous pouvez bénéficier d'un planning personnalisé ne comprenant que les séries que vous regardez. Pour cela vous devez vous créér un compte
				et renseigner vos séries dans votre profil";
			}?>
           </table>
           </div>
        </div>
        </div>
    </div>
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Planning', '/planning-series-tv', array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
       
        <div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
                <fb:like-box profile_id="105365559504009" width="295" connections="12" stream="false"></fb:like-box>
            </div>
            <div class="colr-footer"></div>
        </div>
        
        
    	<div id="colright-bup">
            
        </div>
        
    </div>
