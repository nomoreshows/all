	<?php $this->pageTitle = 'Avis sur ' . $show['Show']['name']; ?>	
    
    <div id="col1">
    	<!-- Srie -->
    	<h1 class="red title padl5"><?php echo $show['Show']['name']; ?></h1> <span class="grey"> - <h3>(<?php echo $show['Show']['titrefr']; ?>)</h3></span>
        <br /><br />
        <div class="bg-serie">
        	<?php echo $html->image(('show/' . $show['Show']['menu'] . '_w.jpg'), array('alt' => $show['Show']['name'], 'align' => 'left')); ?>
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
        	<br /><br />
        	
            <?php 
			// Si il est logu
			if($session->read('Auth.User.role') > 0) {
				
				// Si il a pas dj mis d'avis
				if (empty($alreadycomment)) {
					echo '<h3 class="red">Ajouter un avis</h3> <br /><br />';
					echo '<div id="resultcomment">';
					echo $ajax->form('addSerie', 'post', array('model' => 'Comment', 'action' => 'addOk', 'update' => 'resultcomment'));
					echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
					echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id']));
					echo $form->input('thumb', array(
						'type' => 'select',
						'options' => array('up' => 'Favorable', 'neutral' => 'Neutre', 'down' => 'Défavorable') 
					));
					echo '<br />';
					echo $form->input('text', array('label' => false, 'cols' => 100));
					echo '<br />Avant de valider, assurez-vous de corriger les éventuelles fautes d\'orthographe. <br /><br />';
					echo $form->end('Valider');
					echo '</div>';  
				} else {
					$thumb = $alreadycomment['Comment']['thumb'];
					echo '<h3 class="red">Votre avis</h3> <br /><br />';
					echo $star->thumb($thumb); echo ' <span class="'. $thumb .'">'. $star->avis($thumb) . '</span>'; 
					echo '<br /><br />';
					echo $alreadycomment['Comment']['text'];
				}
                
			} else {
				echo '<h3 class="red">Ajouter un avis</h3> <br /><br /> Vous devez vous ' . $html->link('créér un compte', '/inscription') . ' afin de pouvoir soumettre votre avis.';
			}
			?>
        </div>
    </div>
    
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link(substr($show['Show']['name'],0,25), '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></li>
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
                        <h3 class="gold">Moyenne</h3> <br />
                        <span class="gold staring">
                        <?php
                        if (!empty($ratesshow)) {
                            $total = 0;
                            foreach($ratesshow as $j => $rate) {
                                $total += $rate['Rate']['name'];
                            }
                            $nb = $j+1;
                            $moyenne = $total / $nb;
                            echo round($moyenne, 2);
							echo '<br /></span>';
							echo $star->convert($moyenne);
							echo '<br /><span class="gold">';
							echo count($ratesshow); ?>
                            note<?php if (count($ratesshow) > 1) echo 's'; ?></span>
                            <?php
                         } else {
                             echo ' - </span> <span class="gold"><br /> Aucune note</span>';
                         } ?> 
                	</div>
                </td>
                <td width="180">
                	<!-- Dernires notes -->
                	<h3 class="red">Dernières notes :</h3>
					<?php
                    if (!empty($ratesshow)) {
                        echo '<ul class="play">';
                        foreach($ratesshow as $j => $rate) {
                            if ($j < 5 ) 
                                echo '<li>' . $rate['Rate']['name'] . ' par ' . $rate['User']['login'] . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<br />Pas encore de notes.<br /><br />';
                    }
                    ?>
                </td>
                </tr>
                </table>
                
                
                
                </div>
                
        	</div>
            <div class="colr-footer"></div>
        </div>
        
        
        <!-- Avis -->
    	<div id="colright-avis">
            <div class="colravis-header"></div>
            <div class="colr-content">
            	<table width="100%" class="avis">
                <tr>
                	<td class="up" width="33%"><?php echo $star->thumb('up'); ?> favorables<br /><?php if (!empty($comments)) echo $commentsup; else echo 0; ?> avis</td>
                    <td class="neutral" width="33%"><?php echo $star->thumb('neutral'); ?> neutres<br /><?php if (!empty($comments)) echo $commentsneutral; else echo 0; ?> avis</td>
                    <td class="down" width="33%"><?php echo $star->thumb('down'); ?> défavorables<br /><?php if (!empty($comments)) echo $commentsdown; else echo 0; ?> avis</td>
                </tr>
                </table>
                <br /> 
                <?php 
				if (!empty($comments)) {
					echo '<h3 class="red">Derniers avis</h3> <br /><br />';
					
					foreach ($comments as $comment) {
					?>
                    <p><strong><?php echo $comment['User']['login']; ?></strong> - <?php echo $star->thumb($comment['Comment']['thumb']); ?> 
                    <span class="<?php echo $comment['Comment']['thumb']; ?>"><?php echo $star->avis($comment['Comment']['thumb']); ?></span>
                    <br />
                    <span class="greyblack"><?php echo $text->truncate($comment['Comment']['text'], 120, ' ...', false); ?></span>
                    </p>
                    <?php
					}
					?>
                <?php echo $html->link('&raquo; Tous les avis', '/avis/serie/' . $show['Show']['menu'] . '/all' , array('escape' => false, 'class' => 'nodeco')); ?> 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php
					if ($alreadycomment == 0) {
						echo $html->link('&raquo; Donner votre avis', '/avis/add/serie/' .  $show['Show']['menu'] , array('escape' => false, 'class' => 'nodeco')); 
					} else {
						echo $html->link('&raquo; Voir votre avis', '/avis/add/serie/' .  $show['Show']['menu'] , array('escape' => false, 'class' => 'nodeco')); 
					} 
				} else {
					echo '<h3 class="red">Pas encore d\'avis</h3> <br /><br />';
					echo $html->link('&raquo; Donner votre avis', '/avis/add/serie/' .  $show['Show']['menu'] , array('escape' => false, 'class' => 'nodeco')); 
				}?>
                <br /><br />
            </div>
            <div class="colr-footer"></div>
        </div>
        
        
        <!-- Informations -->
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
                <strong>Créateurs</strong> : <?php echo $show['Show']['createurs']; ?>
                <br /><br />
                <strong>Réalisateurs</strong> : <?php echo $show['Show']['realisateurs']; ?>
                <br /><br />
                <strong>Scénaristes</strong> : <?php echo $show['Show']['scenaristes']; ?>
                <br /><br />
                <strong>Générique</strong> : <a href="#" class="nodeco">voir</a>
                <br /><br />
                <?php // echo $show['Show']['generique']; ?>
        	</div>
            <div class="colr-footer"></div>
        </div>
        
        
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
