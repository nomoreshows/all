				<ul class="profil-notes">
                      <?php 
                      if(!empty($moyennes)) {
                          foreach ($moyennes as $moyenneshow) {
                              echo '<li><div id="show' . $moyenneshow['Show']['id'] . '">' . 
							  $ajax->link($html->image('icons/folder.png', array('class' => '', 'border' => 0, 'alt'=> 'o')), array('controller' => 'users', 'action' => 'developShow', $user['User']['id'], $moyenneshow['Show']['id'], round($moyenneshow['0']['Moyenne'], 2), $moyenneshow['0']['Somme']), array('update' => 'show' . $moyenneshow['Show']['id'], 'escape' => false)) . ' ' . 
							  $html->link($moyenneshow['Show']['name'], '/serie/' . $moyenneshow['Show']['menu'], array('class' => 'nodeco'));
                              echo ': <span class="lblue">' . round($moyenneshow['0']['Moyenne'], 2) . '</span> de moyenne et '. $moyenneshow['0']['Somme'] . ' notes </div></li>' ;
                          }
                      }
                      ?>
                 </ul>