	 <?php $this->pageTitle = 'Classements - Profil de ' . $user['User']['login']; 
	 echo $html->meta('description', $user['User']['login'] . ' utilise Série-All pour créer sa collection de séries, noter les épisodes et être prévenu de la sortie de ses séries favorites.', array('type'=>'description'), false);
     ?>
     
   <?php 
	 echo $javascript->link('perso.profil.classements', false); 
	 ?> 
     
    <div id="col1">
    	<div class="padl10">
      
        		<h1 class="red title"><?php echo $user['User']['login']; ?> &raquo; Classements</h1>
            <?php echo $this->element('profil-menu'); ?>
        	  
            <div id="profil-classement">     
            <table width="100%" class="profil-classement">
            <tr>
                <!-- Top séries -->
                <td width="33%">
                <h2 class="title dblue">Top séries</h2>
                <br /><br />
                <?php
                 if(!empty($topseries)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    $noter_plus = false;
                    
                    foreach($topseries as $i => $serie) {
                            
                            // Plus de x notes dans la saison et moyenne supérieure a 12
                            if($serie['0']['Somme'] > 11 and $serie['0']['Moyenne'] > 11) {
                                
                            $compteur++;
                            if ($compteur == 1) {
															echo '<div class="classement-show">';
															echo 
															$html->link($html->image('show/' . $serie['Show']['menu'] . '_w.jpg', array('width' => 192, 'height' => 92, 'alt' => $serie['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $serie['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $serie['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
															echo '</div><div class="spacer"></div>';
														}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            
                            echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco'));
                            ?> -
                            <span class="lblue"><?php echo round($serie['0']['Moyenne'], 2); ?></span></li> <?php
                            }
                            if ($compteur == 10) { $noter_plus = true; break; }
                    }
                    echo '</ul>';
                    if (!$noter_plus) { echo "<span class='grey'>Vous n'avez pas noté assez d'épisodes par série pour continuer le top.</span>"; }
                }
                ?>
                </td>
                <!-- Top saisons -->
                <td width="33%">
                <h2 class="title dblue">Top saisons</h2>
                <br /><br />
                <?php
                 if(!empty($topsaisons)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    $noter_plus = false;
                    
                    foreach($topsaisons as $i => $saison) {
                            
                            // Plus de x notes dans la saison et moyenne supérieure a 11
                            if($saison['0']['Somme'] > 5 and $saison['0']['Moyenne'] > 11) {
                                
                            $compteur++;
                            if ($compteur == 1) {
															echo '<div class="classement-show">';
															echo 
															$html->link($html->image('show/' . $saison['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $saison['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $saison['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $saison['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
															echo '</div><div class="spacer"></div>';
														}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            
                            echo $html->link($saison['Show']['name'] . ' saison ' . $saison['Season']['name'], '/saison/' . $saison['Show']['menu'] . '/' . $saison['Season']['name'], array('class' => 'nodeco'));
                            ?> -
                            <span class="lblue"><?php echo round($saison['0']['Moyenne'], 2); ?></span></li> <?php
                            }
                            if ($compteur == 10) { $noter_plus = true; break; }
                    }
                    echo '</ul>';
                    if (!$noter_plus) { echo "<span class='grey'>Vous n'avez pas noté assez d'épisodes par saison pour continuer le top.</span>"; }
                }
                ?>
                </td>
                <!-- Top épisode -->
                <td width="33%">
                <h2 class="title dblue">Top épisodes</h2>
                <br /><br />
                <?php
                if(!empty($topepisodes)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    
                    foreach($topepisodes as $i => $rate) {
                            
                            $compteur++;
                           if ($compteur == 1) {
															echo '<div class="classement-show">';
															echo 
															$html->link($html->image('show/' . $rate['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $rate['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $rate['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $rate['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
															echo '</div><div class="spacer"></div>';
														}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            
                            echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
                            ?>
                            - <span class="lblue"><?php echo $rate['Rate']['name']; ?></span></li> <?php
                        if ($compteur == 10) break;
                    }
                    echo '</ul>';
                } 
                ?>
                </td>
                </tr>
                
                
                <tr>
                <!-- Flop séries -->
                <td width="33%">
                <h2 class="title dblue">Flop séries</h2>
                <br /><br />
                  <?php
                 if(!empty($flopseries)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    $noter_plus = false;
                    
                    foreach($flopseries as $i => $serie) {
                            
                            // Plus de x notes dans la saison et moyenne inférieure a 11
                            if($serie['0']['Somme'] > 3 and $serie['0']['Moyenne'] < 11) {
                                
                            $compteur++;
                            if ($compteur == 1) {
															echo '<div class="classement-show">';
															echo 
															$html->link($html->image('show/' . $serie['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $serie['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $serie['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $serie['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
															echo '</div><div class="spacer"></div>';
														}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            
                            echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco'));
                            ?> -
                            <span class="lblue"><?php echo round($serie['0']['Moyenne'], 2); ?></span></li> <?php
                            }
                            if ($compteur == 10) { $noter_plus = true; break; }
                    }
                    echo '</ul>';
                    if (!$noter_plus) { echo "<span class='grey'>Vous n'avez pas noté assez d'épisodes par série pour continuer le flop.</span>"; }
                }
                ?>
                </td>
                
                 <!-- Flop saisons -->
                <td width="33%">
                <h2 class="title dblue">Flop saisons</h2>
                <br /><br />
                 <?php
                 if(!empty($flopsaisons)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    $noter_plus = false;
                    
                    foreach($flopsaisons as $i => $saison) {
                            
                            // Plus de x notes dans la saison et moyenne inférieur a 12
                            if($saison['0']['Somme'] > 3 and $saison['0']['Moyenne'] < 11) {
                                
                            $compteur++;
                           if ($compteur == 1) {
														echo '<div class="classement-show">';
														echo 
														$html->link($html->image('show/' . $saison['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $saison['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $saison['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $saison['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
														echo '</div><div class="spacer"></div>';
													}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            
                            echo $html->link($saison['Show']['name'] . ' saison ' . $saison['Season']['name'], '/saison/' . $saison['Show']['menu'] . '/' . $saison['Season']['name'], array('class' => 'nodeco'));
                            ?> -
                            <span class="lblue"><?php echo round($saison['0']['Moyenne'], 2); ?></span></li> <?php
                            }
                            if ($compteur == 10) { $noter_plus = true; break; }
                    }
                    echo '</ul>';
                    if (!$noter_plus) { echo "<span class='grey'>Vous n'avez pas noté assez d'épisodes par saison pour continuer le flop.</span>"; }
                }
                ?>
                 </td>
                 
                <!-- Flop épisodes -->
                <td width="33%">
                <h2 class="title dblue">Flop épisodes</h2>
                <br /><br />
                <?php
                if(!empty($flopepisodes)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    
                    foreach($flopepisodes as $i => $rate) {
                            
                            $compteur++;
                            if ($compteur == 1) {
								echo '<div class="classement-show">';
								echo 
								$html->link($html->image('show/' . $rate['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $rate['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $rate['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $rate['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
								echo '</div><div class="spacer"></div>';
							}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
                            ?>
                            - <span class="lblue"><?php echo $rate['Rate']['name']; ?></span></li> <?php
                        if ($compteur == 10) break;
                    }
                    echo '</ul>';
                } 
                ?>
                </td>
            </tr>
            <tr>
            	 <!-- Top pilots -->
                <td width="33%">
                <h2 class="title dblue">Top pilots</h2>
                <br /><br />
                <?php
                if(!empty($toppilots)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    
                    foreach($toppilots as $i => $rate) {
                            
                            $compteur++;
                            if ($compteur == 1) {
								echo '<div class="classement-show">';
								echo 
								$html->link($html->image('show/' . $rate['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $rate['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $rate['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $rate['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
								echo '</div><div class="spacer"></div>';
							}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
                            ?>
                            - <span class="lblue"><?php echo $rate['Rate']['name']; ?></span></li> <?php
                        if ($compteur == 10) break;
                    }
                    echo '</ul>';
                } 
                ?>
                </td>
                <!-- Top finals
                <td width="33%">
                <?php //debug($episodesfinals); ?>
                <h2 class="title dblue">Top finals</h2>
                <br /><br />
                <?php
                if(!empty($topfinals)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    
                    foreach($topfinals as $i => $rate) {
                            
                            $compteur++;
                            if ($compteur == 1) {
								echo '<div class="classement-show">';
								echo 
								$html->link($html->image('show/' . $rate['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $rate['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $rate['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $rate['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
								echo '</div><div class="spacer"></div>';
							}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
                            ?>
                            - <span class="lblue"><?php echo $rate['Rate']['name']; ?></span></li> <?php
                        if ($compteur == 10) break;
                    }
                    echo '</ul>';
                } 
                ?>
                </td>
                -->
            </tr>
            <tr>
            	 <!-- Flop pilots -->
                <td width="33%">
                <h2 class="title dblue">Flop pilots</h2>
                <br /><br />
                <?php
                if(!empty($floppilots)) {
                    echo '<ul class="class">';
                    $compteur = 0;
                    
                    foreach($floppilots as $i => $rate) {
                            
                            $compteur++;
                            if ($compteur == 1) {
								echo '<div class="classement-show">';
								echo 
								$html->link($html->image('show/' . $rate['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $rate['Show']['name'])) . '<div class="classement-show-title"><div class="text">voir la fiche série<br /><h3>' . $rate['Show']['name'] . '</h3></div></div>', 																																																																						 										'/serie/'. $rate['Show']['menu'], 																																																																												 										array('class' => 'classement-show-link', 'escape' => false)																																																																																																																																																																																																																		  								); 
								echo '</div><div class="spacer"></div>';
							}
                            ?>
                            <li>
                            <?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
                            <?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
                            echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco'));
                            ?>
                            - <span class="lblue"><?php echo $rate['Rate']['name']; ?></span></li> <?php
                        if ($compteur == 10) break;
                    }
                    echo '</ul>';
                } 
                ?>
                </td>
            </tr>
            </table>
            
            </div>
    	</div>
    </div>
    
    <?php echo $this->element('profil-sidebar'); ?>