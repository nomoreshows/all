		<div id="planning-home">

                <table width="100%">
                	<tr>
                    <td width="35%">
                    <?php
					if (!empty($programme)) { 
						foreach($programme as $i => $episode) { 
							if ($i == 0) {
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$episode['Season']['Show']['menu'].'_w_serie.jpg')){
									//image de la serie existe
									$nomImgSerie = $episode['Season']['Show']['menu'];
								}
								echo $html->image('show/' . $nomImgSerie . '_w_serie.jpg', array('class' => 'planning-une', 'alt' => $episode['Season']['Show']['name']));
								echo '<br />';
							} else {
								if ($i < 4) {
									$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
									if(file_exists(APP.'webroot/img/show/'.$episode['Season']['Show']['menu'].'_t_serie.jpg')){
										//image de la serie existe
										$nomImgSerie = $episode['Season']['Show']['menu'];
									}
									echo $html->image('show/' . $nomImgSerie . '_t_serie.jpg', array('class' => 'planning-others', 'width' => 38, 'alt' => $episode['Season']['Show']['name']));	
									echo ' ';
								}
							}
						}
					}
					?>
                    </td>
                    <td width="65%">
                    
                     <span class="planning-titles"> 
                        <?php echo $html->image('icons/calendar.png', array('class' => 'absmiddle')); ?>
                        <?php echo $ajax->link('Aujourd\'hui', array('controller' => 'episodes', 'action' => 'planningToday'), array( 'update' => 'planning-home')); ?> - 
                        <?php echo $html->image('icons/calendar_right.png', array('class' => 'absmiddle')); ?>
                        <?php echo $ajax->link('Demain', array('controller' => 'episodes', 'action' => 'planningTomorrow'), array( 'update' => 'planning-home')); ?> - 
                        <?php echo $html->image('icons/calendar_left.png', array('class' => 'absmiddle')); ?>
                        <?php echo $ajax->link('Hier', array('controller' => 'episodes', 'action' => 'planningYesterday'), array( 'update' => 'planning-home')); ?>
                    </span>
                    
                    <?php
			if (!empty($programme)) { 

					$limit = 0;
					if (count($programme) < 5) $limit = count($programme);
					
						foreach($programme as $i => $episode) { 
						
							if ($i > 4) {echo $html->link('&raquo; Planning complet', '/planning-series-tv', array('class' => 'decoblue', 'escape' => false)); break; }
							
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
							
							echo '<br />';
							
							if ($limit != 0 and $i == ($limit-1)) echo $html->link('&raquo; Planning complet', '/planning-series-tv', array('class' => 'decoblue', 'escape' => false));
						} }
					?>
                    </td>
                    </tr>
                </table>
            </div>