	<?php $this->pageTitle = $show['Show']['name'] . ' - Saison ' . $season['Season']['name']; 
	echo $html->meta('description', 'Saison ' . $season['Season']['name'] . ' - ' . $show['Show']['synopsis'], array('type'=>'description'), false); 
	
	echo $javascript->link('jquery.expander', false); 
	echo $javascript->link('jquery.elastic', false);
	echo $javascript->link('perso.episode', false); 
	?>	


    
    <div id="col1">
        <!-- Série -->
    	<h1 class="red title padl5"><?php echo $show['Show']['name'] . ' - Saison ' .$season['Season']['name']; ?></h1>
        <br /><br />
        <?php 
		$nbsaisons = count($show['Season']); 
		$currentsaison = $season['Season']['name'];
		
		// Lien saison suivante
		if ($currentsaison != $nbsaisons) { ?>
        	<p class="right padr5 greyblack"><?php echo $html->link('Saison suivante &raquo;', '/saison/' . $show['Show']['menu'] . '/' . ($season['Season']['name'] + 1), array('class' => 'decoblue', 'escape' => false)); ?></p> <?php } 
		
		// Lien saison précédente
		if ($currentsaison != 1) { ?> 
        	<p class="left padr5 greyblack"><?php echo $html->link('&laquo; Saison précédente', '/saison/' . $show['Show']['menu'] . '/' . ($season['Season']['name'] - 1), array('class' => 'decoblue', 'escape' => false)); ?></p> <?php } ?>
            
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
            <!-- Episodes -->
            <h2 class="red">Liste des épisodes</h2>
            <table width="100%" class="data">
            <tr>
            	<th>Episode</th>
                <th>Titre</th>
                <th>Note</th>
                <th>Avis</th>
                <th>+</th>
                <th>Diffusion VO</th>
                <th>Diffusion FR</th>
            </tr>
            <?php 
			$notes = array();
			$total = 0;
			foreach($episodes as $i => $episode): 
				// Préparation pour le graph
				$j = $i + 1;
				$notes[$j] = $episode['Episode']['moyenne'];
				$total += $episode['Episode']['moyenne'];
			?>
            
            <tr>
                <td width="80"><?php echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => '')); ?> &nbsp;<?php echo $html->link('Episode ' . $episode['Episode']['numero'], '/episode/' . $show['Show']['menu'] . '/s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco')); ?></td>
                <td><?php echo $episode['Episode']['name']; ?></td>
                <td class="red bold">
                <?php if (!empty($episode['Episode']['moyenne'])) echo $episode['Episode']['moyenne']; else echo '-'; ?>
                </td>
                <td>
                <?php 
                	$up = 0; $neutral = 0; $down = 0;
					foreach($episode['Comment'] as $comment) {
						if ($comment['thumb'] == 'up') {
							$up += 1;
						} elseif ($comment['thumb'] == 'neutral') {
							$neutral += 1;
						} elseif ($comment['thumb'] == 'down') {
							$down += 1;
						}
					}
					if ($up != 0) echo '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
					if ($neutral != 0) echo '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
					if ($down != 0) echo '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
                ?>
                </td>
                <td class="center">
				<?php if (!empty($episode['Episode']['resume'])) echo $html->link($html->image('icons/news.png', array('class' => 'absmiddle resume', 'border' => 0, 'alt' => '', 'title' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Résumé de l\'épisode :</strong> <br /><br /> '. $text->truncate($episode['Episode']['resume'], 400, '...', false, true))), '#', array('escape' => false)); ?>
                <?php if (!empty($episode['Article'])) echo $html->link($html->image('icons/critique.png', array('class' => 'absmiddle', 'border' => 0, 'alt' => '', 'title' => $episode['Article'][0]['name'])), '/article/' . $episode['Article'][0]['url'] . '.html', array('escape' => false)); ?>
                <?php if (!empty($episode['Episode']['bo'])) echo $html->image('menu/video.png', array('class' => 'absmiddle', 'border' => 0, 'alt' => '', 'title' => 'Vidéo ou trailer disponible')); ?>
                </td>
                <td width="95"><?php 
                if($episode['Episode']['diffusionus'] != '2000-01-01') {
                    $timestamp = strtotime($episode['Episode']['diffusionus']);	
                    echo strftime("%d %B %Y", $timestamp);
                } else {
                    echo 'Pas de date';
                } ?>
                </td>
                <td width="95"><?php 
                if($episode['Episode']['diffusionfr'] != '2000-01-01') {
                    $timestamp = strtotime($episode['Episode']['diffusionfr']);	
                    echo strftime("%d %B %Y", $timestamp);
                } else {
                    echo 'Pas de date';
                } ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table>
            <span class="greyblack">
            &nbsp;&nbsp;<strong>Légende :</strong> &nbsp;&nbsp;
            <?php echo $html->image('icons/news.png', array('class' => 'absmiddle', 'border' => 0, 'alt' => '')); ?> Résumé &nbsp;&nbsp;&nbsp;
            <?php echo $html->image('icons/critique.png', array('class' => 'absmiddle', 'border' => 0, 'alt' => '')); ?> Critique &nbsp;&nbsp;&nbsp;
            <?php echo $html->image('menu/video.png', array('class' => 'absmiddle', 'border' => 0, 'alt' => '')); ?> Vidéo ou trailer
            </span>
            <br /><br /><br />
        </div>
          
            <?php
			
			// Graphique
			if ($total != 0 && count($episodes) < 40) {
				echo '<h2 class="red padl10">Notes des épisodes</h2><br /><br />';
				require_once "app/vendors/chart/pChart/pData.class.php";
				require_once "app/vendors/chart/pChart/pChart.class.php";
				// Dataset definition 
				$DataSet = new pData;
				
				foreach ($notes as $i => $note) {
					$DataSet->AddPoint($note,"Serie1",$i);  
				}
				$DataSet->SetXAxisName("Numéro des épisodes");
				$DataSet->AddAllSeries();
				$DataSet->SetAbsciseLabelSerie();
				$DataSet->SetSerieName("Notes","Serie1");
				
				
				// Initialise the graph
				$Test = new pChart(658,240);
				$Test->setFontProperties("Fonts/tahoma.ttf",8);
				$Test->setGraphArea(38,20,638,200);
				$Test->drawGraphArea(255,255,255,TRUE);
				$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);
				$Test->drawGrid(4,TRUE,230,230,230,50);
				
				// Draw the 0 line
				$Test->setFontProperties("Fonts/tahoma.ttf",6);
				$Test->drawTreshold(0,143,55,72,TRUE,TRUE);
				
				// Draw the filled line graph
				$Test->drawFilledLineGraph($DataSet->GetData(),$DataSet->GetDataDescription(),30,TRUE);
				
				// Set labels  
				if (count($episodes) < 30) {
					$Test->setFontProperties("Fonts/tahoma.ttf",8);  
					foreach ($notes as $i => $note) {
						if ($note != 0)
						$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1",$i,$note,221,230,174);  
					}
				}
				
				// Finish the graph
				$Test->setFontProperties("Fonts/tahoma.ttf",8);
				$Test->drawLegend(65,35,$DataSet->GetDataDescription(),255,255,255);
				$Test->setFontProperties("Fonts/tahoma.ttf",10);
				$Test->drawTitle(60,22,false,50,50,50,585);
				$Test->Render("img/charts/season-" . $season['Season']['id'] .".png");
				 
				 
				echo $html->image('charts/season-' . $season['Season']['id'] .'.png');
			}
            ?>
            
            <?php if (!empty($allcomments)) { ?>
            <div class="padl15">
                <!-- Avis -->
                <br /><br /><br /><h2 name="avis" class="red">Tous les avis sur cette saison</h2><br /><br />
                <div id="allavis">
                <?php echo $this->element('page-avis'); ?>
                </div>
                <div id="spinner"><?php echo $html->image('spinner.gif', array('class' => 'absmiddle')); ?></div>
            </div>
            <?php } ?>
            
            <?php if (!empty($season['Season']['ba'])) { ?>
            <div class="padl15">
                <!-- Avis -->
                <br /><br /><br /><h2 class="red">Trailer</h2><br /><br />
				<?php echo $season['Season']['ba']; ?>
            </div>
            <?php } elseif(!empty($episodes[0]['Episode']['bo'])) {
				?>
                <div class="padl15">
                <br /><br /><br /><h2 class="red">Trailer</h2><br /><br />
                <?php
			 	echo $episodes[0]['Episode']['bo'];
				echo '</div>';
			} ?>
        <br /><br />
    </div>
    
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link(substr($show['Show']['name'],0,20), '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link('Saison ' . $season['Season']['name'], '/saison/' . $show['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco')); ?></li>
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
                        if (!empty($season['Season']['moyenne'])) {
                            echo $season['Season']['moyenne'];
							echo '<br /></span>';
							echo $star->convert($season['Season']['moyenne']);
							echo '<br /><span class="white">';
							echo $rates; ?>
                            note<?php if ($rates > 1) echo 's'; ?></span>
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
                    if (!empty($lastrates)) {
                        echo '<ul class="play">';
                        foreach($lastrates as $j => $rate) {
                            if ($j < 5 ) 
                                echo '<li>' . $rate['Rate']['name'] . ' par ' . $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')) . ' - ' . $html->link($rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<br />Aucun épisode de cette saison n\'a encore été noté.<br /><br />';
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
                <?php if (!empty($alreadycomment)) { ?>
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
									
									echo '<br />';
									//Goret : a voir avec cakephp normal
									if($alreadycomment['Comment']['spoiler']){
										echo $form->input('spoiler',array('label' => 'Mon avis contient des spoilers', "checked"=>true));
									}else{
										echo $form->input('spoiler',array('label' => 'Mon avis contient des spoilers', "checked"=>false));
									}
									echo '<br />';
									echo '<br /><span id="charCount">0 caractères</span><br />';
									echo '<br />Avant de valider, assurez-vous de corriger les éventuelles fautes d\'orthographe. <br /><br />';
									echo '<button type="submit"><span>Valider</span></button></form>';
								} else {
									echo '<strong>Vous devez posséder un compte pour laisser un avis sur cette saison.</strong>';	
								}
								echo '</div>';  
                ?>
                <br />
				<br/>
        	</div>
            <div class="colr-footer"></div>
        </div>
        
        <!-- Bilans -->
        <div id="colright-bilan">
            <div class="colrbilan-header"></div>
            <div class="colr-content">
            <br />
            <?php
            if (!empty($bilans)) {
                foreach($bilans as $bilan) { ?>
                    <strong>Bilan de toute cette saison par <?php echo $html->link($bilan['User']['login'], '/profil/' . $bilan['User']['login'], array('class' => 'decoblue')); ?></strong> 
                    <br /><br />
                    <?php echo $html->image('show/'. $show['Show']['menu'] . '_t.jpg', array('class' => 'imgleft', 'width' => 78, 'height' => 78)); ?>
                    <span class="greyblack"><?php echo $bilan['Article']['chapo']; ?></span>
                    <br /><br />
                    <?php echo $html->link('<span>Lire le bilan</span>', '/article/' . $bilan['Article']['url'] . '.html', array('escape' => false, 'class' => 'button')); ?>
                    <?php if (count($bilans) > 1) echo '<br /><br /><br />'; ?>
                <?php }
            } else {
                echo 'Aucun bilan n\'a encore été réalisé sur cette saison de ' . $show['Show']['name'] . '. <br /><br /><a href="#" class="decoblue">&raquo; Proposer le votre</a>.';	
            }
            ?>
            <br /><br />
       		</div>
            <div class="colr-footer"></div>
        </div>
        
        <?php if(!empty($season['Season']['bo'])) { ?>
        <div id="colright-bo">
            <div class="colrbo-header"></div>
            <div class="colr-content">
       			<?php echo $season['Season']['bo']; ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        <?php } ?>
        
    </div>
    
	
