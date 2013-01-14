	<?php 
	$this->pageTitle = $show['Show']['name'] . ' (' . $show['Show']['annee'] . ')'; 
	echo $html->meta('description', $show['Show']['synopsis'], array('type'=>'description'), false); 
	
	echo $javascript->link('jquery.expander', false); 
	echo $javascript->link('jquery.elastic', false);
	echo $javascript->link('perso.show', false); 
	?>	
    
    <div id="col1">
    	<!-- Série -->
    	<h1 class="red title padl5"><?php echo $show['Show']['name']; ?></h1> <?php if (!empty($show['Show']['titrefr'])) { ?> <span class="grey"> - <h3>(<?php echo $show['Show']['titrefr']; ?>)</h3></span> <?php } ?>
        <br /><br />
        <div class="bg-serie">
        	<?php 
				//Test si l'image pour la serie existe 
				$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
				if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
					//image de la serie existe
					$nomImgSerie = $show['Show']['menu'];
				}
				echo $html->image(('show/' . $nomImgSerie . '_w.jpg'), array('alt' => $show['Show']['name'], 'align' => 'left')); 
        	?>
        	<table>
            <tr>
            	<td class="td-genres" colspan="2"><strong>Genre<?php if (count($show['Genre']) > 1) echo 's'; ?></strong> : <br />
                <?php
								foreach($show['Genre'] as $j => $genre) {
									if ($j != 0) 
										echo ', ' . $genre['name'];
									else
										echo $genre['name'];
								}
								?>
                </td>
            </tr>
            <tr>
            	<td class="td-nat" colspan="2">Série <?php echo strtolower($show['Show']['nationalite']); ?></td>
            </tr>
            <tr>
            	<td class="td-annee" colspan="2">Année : <?php echo $show['Show']['annee']; ?></td>
            </tr>
            <tr>
            	<td class="td-format" colspan="2">Format : <?php echo $show['Show']['format']; ?> min</td>
            </tr>
            <tr>
            	<td class="td-chaineus" width="30"><?php echo $show['Show']['chaineus']; ?></td>
                <td class="td-chainefr" width="70"><?php echo $show['Show']['chainefr']; ?></td>
            </tr>
            </table>
        </div>
        <div class="padl10">
            <br />
            <?php if (!empty($show['Show']['synopsis'])) echo $show['Show']['synopsis'] . '<br /><br />'; ?>
            
            <!-- En cours -->
            <?php if ($show['Show']['encours'] == 1) { 
                echo '<strong>En cours - ' . count($show['Season']); ?> saison<?php if (count($show['Season']) > 1) echo 's'; ?> </strong> <?php
            } else { 
							 echo '<strong>Terminée - ' . count($show['Season']); ?> saison<?php if (count($show['Season']) > 1) echo 's'; ?> </strong> <?php
						} ?>
            
            <?php if (!empty($show['Show']['createurs'])) echo '<br /><br /><strong>Créée par</strong> : '. $show['Show']['createurs'] .' '. $html->link('&raquo; tout le casting', '#casting', array('id' => 'btnCasting', 'class' => 'decoblue', 'escape' => false)); ?>
            
            
            <!-- Particularité -->
            <?php if (!empty($show['Show']['particularite'])) { 
                echo '<br /><br /><em>Particularité : ' . $show['Show']['particularite'] . '</em>'; 
            } ?>
            
           
            <br /><br /><br />
            <div class="tabs tabs-show">
                <ul>
                    <li><a href="#saisons">Saisons</a></li>
                    <li><a href="#avis-serie">Avis série (<?php echo count($allcomments) ;?>)</a></li>
                    <li><a href="#avis-saison-1">Avis saison 1 (<?php echo count($avissaison1) ;?>)</a></li>
                    <li><a href="#avis-pilot">Avis pilot (<?php echo count($avispilot) ;?>)</a></li>
                    <li><a href="#casting">Casting</a></li>
                    <?php if (!empty($seasons[0]['Season']['ba'])) { ?><li><a href="#trailer">Trailer</a></li><?php } ?>
                    <!--<?php if (!empty($show['Show']['generique'])) { ?><li><a href="#generique">Générique</a></li><?php } ?>-->
                </ul>
                
                <div id="saisons">
                	<!-- Saisons -->
                    <h2 class="red">Saisons</h2>
                    <table width="100%" class="data">
                    <tr>
                        <th>Saisons</th>
                        <th>Episodes</th>
                        <th>Note</th>
                        <th>Avis</th>
                        <th>Diffusion VO</th>
                        <th>Diffusion FR</th>
                    </tr>
                    <?php foreach($seasons as $i => $season): ?>
                    <tr>
                        <td><?php echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => '')); ?> &nbsp;<?php echo $html->link('Saison ' . $season['Season']['name'], '/saison/' . $season['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco')); ?></td>
                        <td><?php if(count($season['Episode']) == 0) { echo 'à venir'; } else { echo count($season['Episode']); }?></td>
                        <td class="red bold"><?php if (!empty($season['Season']['moyenne'])) echo $season['Season']['moyenne']; else echo '-'; ?></td>
                        <td>
                        <?php 
                            $up = 0; $neutral = 0; $down = 0;
                            foreach($season['Comment'] as $comment) {
                                if ($comment['thumb'] == 'up') {
                                    $up += 1;
                                } elseif ($comment['thumb'] == 'neutral') {
                                    $neutral += 1;
                                } elseif ($comment['thumb'] == 'down') {
                                    $down += 1;
                                }
                            }
                            if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
                            if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
                            if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
                        ?>
                        </td>
                        <td><?php $timestamp = strtotime($season['Episode'][0]['diffusionus']);	$diffusionus = strftime("%d %B %Y", $timestamp); 
                            if ($diffusionus != '01 janvier 2000' and $diffusionus != '01 janvier 1970') {
                                echo 'à partir du ' . $diffusionus; 
                            } else { 
                                echo '-';	
                            }?>
                        </td>
                        <td><?php $timestamp = strtotime($season['Episode'][0]['diffusionfr']);	$diffusionfr = strftime("%d %B %Y", $timestamp); 
                            if ($diffusionfr != '01 janvier 2000' and $diffusionus != '01 janvier 1970') {
                                echo 'à partir du ' . $diffusionfr; 
                            } else { 
                                echo '-';	
                            }?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </table>
                    
                    <br /><br /><br /><br /><br /><br /><br />
                    <?php 
										if($show['Show']['name'] == 'Glee') {
											echo '<h2 class="title red">' . $focus['Article']['name'] . '</h2>'; ?>
											<br /><br />
											<?php echo $html->image('show/'. $show['Show']['menu'] . '_t.jpg', array('class' => 'imgleft', 'width' => 78, 'height' => 78)); ?>
                        <div class="critique-episode">
                            <span class="greyblack"><?php echo $focus['Article']['chapo']; ?></span>
                            <br /><br />
                            <?php echo $text->truncate($focus['Article']['text'], 1600, '...', false); ?>
                            <?php echo $html->link('&raquo; Lire la suite de la critique', '/article/' . $focus['Article']['url'] . '.html', array('escape' => false, 'class' => 'decoblue')); ?>
                        </div>
                        <?php
										}
										?>
                    
                </div>
                
                <div id="avis-serie">
                	<!-- Avis -->
                    <cake:nocache>
                    <h2 class="red"><?php echo count($allcomments) ;?> avis sur <?php echo $show['Show']['name']; ?></h2><br /><br />
                    <?php if (!empty($allcomments)) { ?>
                    <div id="allavis">
                    <?php echo $this->element('page-avis'); ?>
                    </div>
                    <div id="spinner"><?php echo $html->image('spinner.gif', array('class' => 'absmiddle')); ?></div>
                    <?php } ?>
                    </cake:nocache>
                </div>
                
                <div id="avis-saison-1">
                	<!-- Avis pilot -->
                	<?php if (!empty($avissaison1)) { ?>
                    <h2 class="red"><?php echo count($avissaison1) ;?> avis sur la saison 1 de <?php echo $show['Show']['name']; ?></h2><br /><br />
                    <?php
                    echo '<ul class="play">';
					echo '<li>' . $html->link('Fiche de la saison 1', '/episode/' . $show['Show']['menu'] . '/s01e01', array('class' => 'decoblue')) . '</li>';
                    echo '</ul>';
                	echo $avis->display($avissaison1, $session->read('Auth.User.id'), $session->read('Auth.User.role'), 5, true); 
					if(count($avispilot) > 4) {
						echo '<br /><br /><ul class="play">';
						echo '<li>Retrouvez tous les avis sur la ' . $html->link('fiche de la saison 1', '/saison/' . $show['Show']['menu'] . '/1', array('class' => 'decoblue')) . '</li>';
                   	 	echo '</ul>';	
					}
					?>
                    <?php } ?>
                </div>
                
                <div id="avis-pilot">
                	<!-- Avis pilot -->
                	<?php if (!empty($avispilot)) { ?>
                    <h2 class="red"><?php echo count($avispilot) ;?> avis sur le pilot de <?php echo $show['Show']['name']; ?></h2><br /><br />
                    <?php
                    echo '<ul class="play">';
										echo '<li>' . $html->link('Fiche du pilot', '/episode/' . $show['Show']['menu'] . '/s01e01', array('class' => 'decoblue')) . '</li>';
                    echo '</ul>';
                		echo $avis->display($avispilot, $session->read('Auth.User.id'), $session->read('Auth.User.role'), 5, true); 
										if(count($avispilot) > 4) {
											echo '<br /><br /><ul class="play">';
											echo '<li>Retrouvez tous les avis sur la ' . $html->link('fiche du pilot', '/episode/' . $show['Show']['menu'] . '/s01e01', array('class' => 'decoblue')) . '</li>';
                   	 	echo '</ul>';	
										}
										?>
                    <?php } ?>
                </div>
                
                <div id="casting">
                	<!-- Acteurs -->
                  	<h2 class="dblue">Détails</h2><br /><br />
										<?php if(!empty($show['Show']['createurs'])) echo '<strong>Créateur(s)</strong> : ' . $show['Show']['createurs'] . '<br /><br />'; ?>
                    <?php if(!empty($show['Show']['realisateurs'])) echo '<strong>Réalisateur(s)</strong> : ' . $show['Show']['realisateurs'] . '<br /><br />'; ?>
                    <?php if(!empty($show['Show']['scenaristes'])) echo '<strong>Scénariste(s)</strong> : ' . $show['Show']['scenaristes'] . '<br /><br />'; ?>
                    <?php if(!empty($show['Show']['location'])) { ?><strong>Lieu </strong> : <?php echo $show['Show']['location']; ?><br /><br /><?php } ?>
                		<?php if(!empty($show['Show']['location_film'])) { ?><strong>Lieu de tournage</strong> : <?php echo $show['Show']['location_film']; ?><br /><br /><?php } ?>
										<br />
      
                    <h2 class="dblue">Les acteurs </h2> <br /> <br /> 
                    <?php foreach($roles as $role): ?>
                        <div class="actor">
                            <?php echo $html->image('actor/picture/' . $role['Actor']['picture'], array('height' => '100', 'class' => 'imgleft', 'alt' => $role['Actor']['name'])); ?>
                            <strong><?php echo $role['Actor']['name']; ?></strong> <br />
                            <?php echo $role['Role']['name']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (!empty($seasons[0]['Season']['ba'])) { ?>
                <div id="trailer">
                     <h2 class="red">Trailer</h2><br /><br />
                     <?php echo $seasons[0]['Season']['ba']; ?>
                </div>
                <?php } ?>
                
                <!--
                <?php if (!empty($show['Show']['generique'])) { ?>
                 <div id="generique">
                     <h2 class="dblue">Générique</h2><br /><br />
                     <?php echo $show['Show']['generique']; ?>
                </div>
                <?php } ?>
                -->
                
            </div>
            <br /><br /><br />
            
        </div>
        <br /><br /><br />
		<?php  ?>
    </div>
    
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link(substr($show['Show']['name'],0,30), '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
        
    	<!-- Notes -->
        <div id="colright-notes">
            <div class="colrnotes-header"></div>
            <div class="colr-content">
            	<div id="resultrate">
            	<table width="100%">
                <tr>
                <td>
                	<!-- Moyenne -->
                    <div class="bg-star">
                        <h3 class="white">Moyenne</h3> <br />
                        <span class="white staring">
                        <?php
                        if (!empty($show['Show']['moyenne'])) {
                            echo $show['Show']['moyenne'];
														echo '<br /></span>';
														echo $star->convert($show['Show']['moyenne']);
														echo '<br /><span class="white">';
														echo count($ratesshow); ?>
                            note<?php if (count($ratesshow) > 1) echo 's'; ?></span>
                            <?php
                         } else {
                             echo ' - </span> <span class="white"><br /> Aucune note</span>';
                         } ?> 
                	</div>
                </td>
                <td width="180">
                	<!-- Dernières notes -->
                	<h3 class="red">Dernières notes :</h3><br /><br />
					<?php
                    if (!empty($ratesshow)) {
                        echo '<ul class="play">';
                        foreach($ratesshow as $j => $rate) {
                            if ($j == 5 ) break;
                                echo '<li>' . $rate['Rate']['name'] . ' par ' . $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')). ' - ' . $html->link($rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<br />Pas encore de notes.<br /><br />';
                    }
                    ?>
                </td>
                </tr>
                </table><br />
                <h2 class="dblue">Avis spectateurs</h2>
                
                <table width="100%" class="avis">
                  <tr>
                    <td class="up" width="33%"><?php echo $star->thumb('up'); ?> favorables<br /><?php if (!empty($comments)) echo $commentsup; else echo 0; ?> avis</td>
                      <td class="neutral" width="33%"><?php echo $star->thumb('neutral'); ?> neutres<br /><?php if (!empty($comments)) echo $commentsneutral; else echo 0; ?> avis</td>
                      <td class="down" width="33%"><?php echo $star->thumb('down'); ?> défavorables<br /><?php if (!empty($comments)) echo $commentsdown; else echo 0; ?> avis</td>
                  </tr>
                  </table>
                  <br /> 
									<?php
									if (!empty($alreadycomment)) {?>
										<p><strong>Votre avis</strong> - <?php echo $star->thumb($alreadycomment['Comment']['thumb']); ?> 
										<span class="<?php echo $alreadycomment['Comment']['thumb']; ?>"><?php echo $star->avis($alreadycomment['Comment']['thumb']); ?></span>
										<br />
										<span class="greyblack"><?php echo $text->truncate($alreadycomment['Comment']['text'], 120, ' ...', false); ?></span>
										</p>
										<?php
									}
									if (!empty($alreadycomment)) {
										echo $html->link('<span>Modifier votre avis</span>', '#', array('escape' => false, 'class' => 'button', 'onClick' => '$(\'#avisuser\').slideDown(); return false;')); 
									} else {
										echo $html->link('<span>Donner votre avis</span>', '#', array('escape' => false, 'class' => 'button', 'onClick' => '$(\'#avisuser\').slideDown(); return false;')); 
									} 
									echo $html->link('<span>Tous les avis</span>', '#', array('escape' => false, 'id' => 'btnAllAvis', 'class' => 'button')); 
													
									echo '<div id="avisuser" style="display:none">';
									echo '<br /><br /><br />';
									if($session->read('Auth.User.role') > 0) { 
										if (!empty($alreadycomment)) {
											echo '<h3 class="red">Votre ancien avis</h3> '; ?> &nbsp;
											<?php echo $star->thumb($alreadycomment['Comment']['thumb']); ?> <span class="<?php echo $alreadycomment['Comment']['thumb']; ?>"><?php echo $star->avis($alreadycomment['Comment']['thumb']); ?></span><br /><br />
											<?php
											echo '<span class="greyblack">' . $alreadycomment['Comment']['text'] . '</span><br /><br />';
										}
										
										echo '<h3 class="red">Votre avis</h3> <br /><br />';
										echo $ajax->form('addSerie', 'post', array('model' => 'Comment', 'action' => 'addOk', 'update' => 'avisuser'));
										echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
										echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id']));
										echo $form->input('thumb', array(
											'type' => 'select',
											'options' => array('up' => 'Favorable', 'neutral' => 'Neutre', 'down' => 'Défavorable'),
											'label' => false
										));
										echo '<br />';
										if (!empty($alreadycomment))
											echo $form->input('text', array('label' => false, 'cols' => 45));
										else 
											echo $form->input('text', array('label' => false, 'cols' => 45, 'value' => $alreadycomment['Comment']['text']));
										
										echo '<br /><span id="charCount">0 caractères</span><br />';
										echo '<br />Avant de valider, assurez-vous de corriger les éventuelles fautes d\'orthographe. <br /><br />';
										echo '<button type="submit"><span>Valider</span></button></form>';
									} else {
										echo '<strong>Vous devez posséder un compte pour laisser un avis sur cette série.</strong>';	
									}
									echo '</div>';  
                  ?>
                <br /><br /><br />
                
                <div class="watching-stats">
                <h2 class="dblue">Statistiques</h2>
                <?php 
                 $totalwatched = $followedshow + $abortedshow; 
								  
                 $porcentfollowed = round(($followedshow / $totalwatched) * 100, 0);
                 $porcentaborted = round(($abortedshow / $totalwatched) * 100, 0);
                                  
                 if ($show['Show']['encours']) {
                  echo $totalwatched . ' membres regardent ' .  $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'decoblue')); ?> :<br />
                  <ul class="abandon">
                    <li>&raquo; <span class="green"><?php echo $porcentfollowed; ?>%</span> la continuent</li>
                    <li>&raquo; <span class="red"><?php echo $porcentaborted; ?>%</span> l'ont abandonnée</li>
                   </ul>
                   <?php
                 } else {
                  echo $totalwatched . ' membres ont vu ' .  $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'decoblue')); ?> :<br />
                  <ul class="abandon">
                    <li>&raquo; <span class="green"><?php echo $porcentfollowed; ?>%</span> l'ont terminée</li>
                    <li>&raquo; <span class="red"><?php echo $porcentaborted; ?>%</span> l'ont abandonnée</li>
                   </ul>
                   <?php 
                 }
                 ?>
								<br />
								<?php echo $html->link($html->image('offre-himym.png'), 'http://track.effiliation.com/servlet/effi.redir?id_compteur=12448608&url=http://www.priceminister.com/offer?action=desc&aid=596726894', array('escape' => false, 'target' => 'blank')); ?>
                <br /></div>
                
                </div>
                
        	</div>
            <div class="colr-footer"></div>
        </div>
        
        <!-- Informations 
    	<div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
    			
                <br />
                <ul class="play">
                    <?php $timestamp = strtotime($show['Show']['diffusionus']);	$diffusionus = strftime("%d %B %Y", $timestamp); 
                    if ($diffusionus != '01 janvier 2000') { ?>
                    <li><strong>Diffusion US</strong> : <?php echo $diffusionus; ?> (<?php echo $show['Show']['chaineus']; ?>)</li>
                    <?php } ?>
                    <?php $timestamp = strtotime($show['Show']['diffusionfr']);	$diffusionfr = strftime("%d %B %Y", $timestamp); 
                    if ($diffusionfr != '01 janvier 2000') { ?>
                    <li><strong>Diffusion FR</strong> : <?php echo $diffusionfr; ?> (<?php echo $show['Show']['chainefr']; ?>)</li>
                    <?php } ?>
                </ul>
                <br />
                <?php if(!empty($show['Show']['createurs'])) { ?>
                	<strong>Créateurs</strong> : <?php echo $show['Show']['createurs']; ?>
                	<br /><br />
                <?php } ?>
                <?php if(!empty($show['Show']['realisateurs'])) { ?>
                	<strong>Réalisateurs</strong> : <?php echo $show['Show']['realisateurs']; ?>
                	<br /><br />
                <?php } ?>
                <?php if(!empty($show['Show']['scenaristes'])) { ?>
                	<strong>Scénaristes</strong> : <?php echo $show['Show']['scenaristes']; ?>
                	<br /><br />
                <?php } ?>
                <?php if(!empty($show['Show']['location'])) { ?>
                	<strong>Lieu </strong> : <?php echo $show['Show']['location']; ?>
                	<br /><br />
                <?php } ?>
                <?php if(!empty($show['Show']['location_film'])) { ?>
                	<strong>Lieu de tournage</strong> : <?php echo $show['Show']['location_film']; ?>
                	<br /><br />
                <?php } ?>
        	</div>
            <div class="colr-footer"></div>
        </div>
        -->
        
        <?php if(!empty($articles)) { ?>
         <!-- Derniers articles -->
    		 <div id="colright-lastarticles">
            <div class="colrlastart-header"></div>
            <div class="colr-content"><br />
                <ul class="play">
                <?php foreach($articles as $article) { ?>
                    <li><?php echo $html->link($article['Article']['name'], '/article/'. $article['Article']['url'] . '.html', array('class' => 'decoblue')); ?></li>
                <?php } ?>
                </ul><br />
            </div>
             <div class="colr-footer"></div>
        </div>
        <?php } ?>
        
        <?php if(!empty($critiques)) { ?>
         <!-- Derniers articles -->
    		 <div id="colright-lastarticles">
            <div class="colrlastart-header"></div>
            <div class="colr-content"><br />
                <ul class="play">
                <?php foreach($critiques as $critique) { ?>
                    <li><?php echo $html->link($critique['Article']['name'], '/article/'. $critique['Article']['url'] . '.html', array('class' => 'decoblue')); ?></li>
                <?php } ?>
                </ul>
            </div>
             <div class="colr-footer"></div>
        </div>
        <?php } ?>
        
        
        <!-- Meilleurs épisodes -->
        <?php if(!empty($bestepisodes)) { ?>
        <div id="colright-stats">
            <div class="colrstats-header"></div>
            <div class="colr-content">
            <h3 class="dblue">Meilleurs épisodes :</h3><br /><br />
            <ul class="play">
              <?php foreach($bestepisodes as $episode) { ?>
              <li><?php echo $html->link('Episode ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $show['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')); ?> <span class="grey">- <?php if(!empty($episode['Episode']['name'])) echo $episode['Episode']['name']; ?></span> <span class="dblue"><?php echo $episode['Episode']['moyenne']; ?></span></li>
             <?php } ?>
            </ul>
            </div>
            <div class="colr-footer"></div>
        </div>
        <?php } ?>
        
        
        <?php if(!empty($show['Show']['bo'])) { ?>
        <div id="colright-bo">
            <div class="colrbo-header"></div>
            <div class="colr-content">
       			<?php echo $show['Show']['bo']; ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        <?php } ?>
        

    </div>
