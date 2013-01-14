	<?php 
	if (!empty($episode['Episode']['titrefr'])) {
		$this->pageTitle = $show['Show']['name'] . ' - ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT) . ' - ' . $episode['Episode']['name'] . ' ('. $episode['Episode']['titrefr'] . ')';
	} else {
		$this->pageTitle = $show['Show']['name'] . ' - ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT) . ' - ' . $episode['Episode']['name'];
	}
	if (!empty($episode['Episode']['resume']))
		echo $html->meta('description', $episode['Episode']['name'] . ' - ' . $episode['Episode']['resume'], array('type'=>'description'), false); 
	else
		echo $html->meta('description', $episode['Episode']['name'] . ' - Aucun résumé n\'a encore été rédigé pour cet épisode de ' . $show['Show']['name'], array('type'=>'description'), false); 
		

	echo $javascript->link('jquery.expander', false); 
	echo $javascript->link('jquery.elastic', false);
	echo $javascript->link('perso.episode', false); 
	?>	
    
        
    <script type="text/javascript">
		$(function() {
			$(".tabs").tabs();
		});
	</script>
    
    <div id="col1">
        <!-- Série -->
    	<h1 class="red title padl5"><?php echo $show['Show']['name'] . ' - ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT) . ' - ' . 	$episode['Episode']['name']; ?></h1>
        <?php if (!empty($episode['Episode']['titrefr'])) { ?>
        &nbsp;&nbsp;<h2 class="grey">(<?php echo $episode['Episode']['titrefr']; ?>)</h2>
        <?php } ?>
        <br /><br />
        <?php 
		$nbepisodes = count($season['Episode']); 
		$currentepisode = $episode['Episode']['numero'];
		
		// Lien épisode suivant
		if ($currentepisode != $nbepisodes) { ?>
        	<p class="right padr5 greyblack"><?php echo $html->link('Episode suivant &raquo;', '/episode/' . $show['Show']['menu'] . '/s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'] +1, 2, 0, STR_PAD_LEFT), array('class' => 'decoblue', 'escape' => false)); ?></p>
        	<?php } 
		
		// Lien épisode précédent
		if ($currentepisode != 1) { ?> 
        	<p class="left padl5 greyblack"><?php echo $html->link('&laquo; Episode précédent', '/episode/' . $show['Show']['menu'] . '/s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'] -1, 2, 0, STR_PAD_LEFT), array('class' => 'decoblue', 'escape' => false)); ?></p>
        	<?php } ?>
            
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

        <br /><br />
        
        <div class="padl10">
        	
            <table class="profil" width="100%">
            <tr>
            <td width="60%">
                <!-- Résumé -->
                <h2 class="red">Résumé</h2>
                <br />
                <?php if (!empty($episode['Episode']['resume'])) echo '<span class="resume-episode">' . $episode['Episode']['resume'] .'</span><br /><br />'; 
                else echo 'Il n\'y a pas encore de résumé. Peut-être voudriez vous proposer votre propre résumé ? Oui ? Alors <a href="#" class="decoblue">cliquez ici</a>.<br /><br />'; ?>
                <?php if (!empty($episode['Episode']['particularite'])) { echo '<strong>Particularité : </strong>' . $episode['Episode']['particularite'] . '<br /><br />'; }?>
                <?php if (!empty($episode['Episode']['guests'])) { echo '<strong>Guests : </strong>' . $episode['Episode']['guests'] . '<br /><br />'; }?>
            </td>
            <td class="padl25" width="40%">
            	<h2 class="red">Dates diffusion</h2>
                <br />
                <strong>Diffusion VO : </strong> 
				<?php if($episode['Episode']['diffusionus'] != '2000-01-01') {
					$timestamp = strtotime($episode['Episode']['diffusionus']);	
					echo strftime("%d %B %Y", $timestamp);
                } else {
                    echo 'Pas de date';
                } ?>
                <br />
                <strong>Diffusion FR : </strong> 
                <?php if($episode['Episode']['diffusionfr'] != '2000-01-01') {
					$timestamp = strtotime($episode['Episode']['diffusionfr']);	
					echo strftime("%d %B %Y", $timestamp);
                } else {
                    echo 'Pas de date';
                } ?>
            </td>
            </tr>
            </table>
            
        	<br />
            <div class="tabs tabs-show">
                <ul>
                    <li><a href="#avis">Avis</a></li>
                    <?php if (!empty($episode['Episode']['bo'])) { ?><li><a href="#video">Trailer / Vidéo</a></li><?php } ?>
                    <?php if (!empty($episode['Quote'])) { ?><li><a href="#citations">Citations</a></li><?php } ?>
                </ul>
                
                <div id="avis">
                    <!-- Critiques -->
                    <?php 
					if (!empty($critiques)) {
						echo '<h2 class="dblue">Les critiques</h2><br /><br />'; 
						foreach($critiques as $critique) { ?>
                            <strong>Critique par <?php echo $html->link($critique['User']['login'], '/profil/' . $critique['User']['login'], array('class' => 'decoblue')); ?></strong> 
                            <br /><br />
                            <?php echo $html->image('show/'. $show['Show']['menu'] . '_t.jpg', array('class' => 'imgleft', 'width' => 78, 'height' => 78)); ?>
                            <div class="critique-episode">
                                <span class="greyblack"><?php echo $critique['Article']['chapo']; ?></span>
                                <br /><br />
                                <?php echo $html->link('<span>Lire la critique</span>', '/article/' . $critique['Article']['url'] . '.html', array('escape' => false, 'class' => 'button')); ?>
                                <?php if (count($critique) > 1) echo '<br /><br />'; ?>
                            </div>
						<?php 
						}
						echo '<br /><br />';
          } 
					
					?>
                	
                	<!-- Avis -->
					<?php if (!empty($allcomments)) { 
										$nbcomments = $commentsup + $commentsneutral + $commentsdown; ?>
                    <h2 name="avis" class="red">Tous les avis sur cet épisode (<?php echo $nbcomments ;?>)</h2><br /><br />
                    <div id="allavis">
                    <?php echo $this->element('page-avis'); ?>
                    </div>
                    <div id="spinner"><?php echo $html->image('spinner.gif', array('class' => 'absmiddle')); ?></div>
                    <?php } ?>
                </div>
                
                <?php if(!empty($episode['Episode']['bo'])) { ?>
            	<div id="video">
                	<!-- Vidéos -->
                    <h2 class="red">Trailer - Vidéo</h2><br /><br />
                        <?php echo $episode['Episode']['bo']; ?>
                        <br />
                </div>
                <?php } ?>
                
                <?php if(!empty($episode['Quote'])) { ?>
            	<div id="citations">
                	<!-- Citations -->
                    <h2 class="red">Les citations de l'épisode</h2><br /><br />
                    	<div class="quotes">
                        <?php 
                        foreach($episode['Quote'] as $quote) {
                        	echo '<strong>' . $quote['timer'] . '</strong> - ';
                        	if(!empty($quote['Role']['name'])) {
                        		echo $quote['Role']['name'] . ' a dit : ';
                        	}
                        	echo '<br /><br /><blockquote>' . $quote['text'] . '</blockquote><br />';
                        	echo '<span class="grey">ajouté par ' . $quote['User']['login'] . '</span>';
                        	echo '<br /><br />';
                        }
                         ?>
                        </div>
                </div>
                <?php } ?>
            </div>
            
		</div>
    </div>
    
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link(substr($show['Show']['name'],0,18), '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link('S' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $show['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link('E' .str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $show['Show']['menu'] . '/s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco')); ?></li>
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
                        if (!empty($episode['Episode']['moyenne'])) {
                            echo $episode['Episode']['moyenne'];
														echo '<br /></span>';
														echo $star->convert($episode['Episode']['moyenne']);
														echo '<br /><span class="white">';
														echo count($rates); ?>
                            note<?php if (count($rates) > 1) echo 's'; ?></span>
                            <?php
                         } else {
                             echo ' - </span> <span class="white"><br /> Aucune note</span>';
                         } ?> 
                	</div>
                </td>
                <td width="180">
                	<!-- Dernires notes -->
                	<h3 class="red">Dernières notes :</h3>
					<?php
                    if (!empty($rates)) {
                        echo '<ul class="play">';
                        foreach($rates as $j => $rate) {
                            if ($j == 3 ) break;
                            echo '<li>' . $rate['Rate']['name'] . ' par ' . $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')) . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<br />Pas encore de notes.<br /><br />';
                    }
                    ?>
                    
                    <!-- Notez -->
                    <br />
                    <h3 class="red">Noter cet épisode :</h3>
                    
                    <?php 
                   	if($session->read('Auth.User.role') > 0) { 
											if ($session->read('Auth.User.suspended') == 0) {
												echo $ajax->form('add', 'post', array('model' => 'Rate', 'update' => 'resultrate'));
												?>
												<?php
												echo $form->input('name', array('label' => false, 'div' => false, 'class' => 'sexycombo', 'empty' => '-- note --', 'options' => array(20 => 20,19 => 19, 18 => 18,17 => 17,16 => 16,15 => 15,14 => 14,13 => 13,12 => 12,11 => 11,10 => 10,9 => 9,8 => 8,7 => 7,6 => 6,5 => 5,4 => 4,3 => 3,2 => 2,1 => 1,0 => 0)));
												echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
												echo $form->input('season_id', array('type' => 'hidden', 'value' => $episode['Season']['id']));
												echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id']));
												echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
												echo '<button type="submit">Valider</button></form>';
											} else {
												echo '<br />Votre compte a été suspendu, allez dans votre profil pour en conaître la raison.';	
											}
                    } else {
                        echo '<br />Vous devez posséder un compte pour noter cet épisode.';	
                    }
                    ?>
                </td>
                </tr>
                </table>
                </div>
                <br />
                
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
								
								echo $html->link('<span>Tous les avis</span>', '#avis', array('escape' => false, 'class' => 'button')); 
												
								echo '<div id="avisuser" style="display:none">';
								echo '<br /><br /><br />';
								if($session->read('Auth.User.role') > 0) { 
									if ($session->read('Auth.User.suspended') == 0) {
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
										echo $form->input('season_id', array('type' => 'hidden', 'value' => $season['Season']['id']));
										echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
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
										echo '<br />Avant de valider, assurez-vous de corriger les éventuelles fautes d\'orthographe. 100 caractères minimum. <br /><br />';
										echo '<button type="submit"><span>Valider</span></button></form>';
									} else {
										echo '<br />Votre compte a été suspendu, allez dans votre profil pour en connaître la raison.';	
									}
								} else {
									echo '<strong>Vous devez posséder un compte pour laisser un avis sur cet épisode.</strong>';	
								}
								echo '</div>';  
                ?>
                <br /><br />
								<?php 
								if ($show['Show']['menu'] == 'how-i-met-your-mother')
									echo $html->link($html->image('offre-himym.png'), 'http://track.effiliation.com/servlet/effi.redir?id_compteur=12448608&url=http://www.priceminister.com/offer?action=desc&aid=596726894', array('escape' => false, 'target' => 'blank')); ?>
                
        	</div>
            <div class="colr-footer"></div>
        </div>
    
        
        <?php if(!empty($episode['Episode']['ba'])) { ?>
        <div id="colright-bo">
            <div class="colrbo-header"></div>
            <div class="colr-content">
       			<?php echo $episode['Episode']['ba']; ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        <?php } ?>
        
        
        <?php if (!empty($rates)) { ?>
        <div id="colright-allnotes">
            <div class="colrallnotes-header"></div>
            <div class="colr-content">
            	<br />
            	<?php
				echo '<ul class="play">';
				foreach($rates as $j => $rate) {
					echo '<li><span class="lblue">' . $rate['Rate']['name'] . '</span> par ' . $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')) . ' <span class="grey">- ' . $star->role($rate['User']['role']) . '</span></li>';
				}
				echo '</ul>';
				?>
            </div>
            <div class="colr-footer"></div>
        </div>
		<?php } ?>
        
        
    </div>
    
	
