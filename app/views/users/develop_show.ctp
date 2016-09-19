							<script>
								$('#folder<?php echo $moyennes['0']['Show']['id']; ?>').click(function() {
									if ($('#seasons<?php echo $moyennes['0']['Show']['id']; ?>').is(":hidden")) {
										$('#seasons<?php echo $moyennes['0']['Show']['id']; ?>').slideDown();
									} else {
										$('#seasons<?php echo $moyennes['0']['Show']['id']; ?>').slideUp();
									}
								});
							 </script>
							
							<?php
							// folder
							  echo $html->image('icons/folder_open.png', array('id' => 'folder'.$moyennes['0']['Show']['id'], 'border' => 0, 'alt'=> 'x')) . ' ' .
							
							// Moyenne série
							  $html->link($moyennes['0']['Show']['name'], '/serie/' . $moyennes['0']['Show']['menu'], array('class' => 'nodeco'));
                              echo ': <span class="lblue">' . $moyenneshow . '</span> de moyenne et '. $nbnotes . ' notes </div></li>' ;	
							
							// Moyenne saison
							  echo '<ul id="seasons' . $moyennes['0']['Show']['id'] . '">';
							  foreach($moyennes as $moyenneseason) {
								  echo '<li>' . $html->link('Saison ' . $moyenneseason['Season']['name'], '/saison/' . $moyenneseason['Show']['menu'] . '/' . $moyenneseason['Season']['name'], array('class' => 'nodeco')); 
								  echo ': <span class="lblue">' . round($moyenneseason['0']['Moyenne'], 2) . '</span> de moyenne et '. $moyenneseason['0']['Somme'] . ' notes </div></li>' ;	
								  echo '</li>';
							  }
							  echo '</ul><br />';
                          ?>