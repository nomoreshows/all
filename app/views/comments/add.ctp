	<?php $this->pageTitle = 'Avis sur ' . $show['Show']['name']; ?>	
    
    <div id="col1">
    	<!-- Série -->
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
			// Si il est logué
			if($session->read('Auth.User.role') > 0) {
				
				// Si il a pas déjà mis d'avis
				if (empty($alreadycomment)) {
					echo '<h3 class="red">Ajouter un avis</h3> <br /><br />';
					echo '<div id="resultcomment">';
					echo $ajax->form('addSerie', 'post', array('model' => 'Comment', 'action' => 'addSerie', 'update' => 'resultcomment'));
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
        	<li><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link(substr($show['Show']['name'],0,25), '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link('Avis', '/avis/serie/' . $show['Show']['menu'] . '/all', array('class' => 'nodeco')); ?></li>
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
                	<!-- Dernières notes -->
                	<h3 class="red">Dernières notes :</h3>
					<?php
                    if (!empty($ratesshow)) {
                        echo '<ul class="play">';
                        foreach($ratesshow as $j => $rate) {
                            if ($j < 3 ) 
                                echo '<li>' . $rate['Rate']['name'] . ' par ' . $rate['User']['login'] . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<br />Pas encore de notes.<br /><br />';
                    }
                    ?>
                    
                    <!-- Notez -->
                    <br />
                    <h3 class="red">Noter cette série :</h3>
                    
                    <?php 
                    if($session->read('Auth.User.role') > 0) {
                        echo $ajax->form('add', 'post', array('model' => 'Rate', 'update' => 'resultrate'));
                        ?>
                        <?php
                        echo $form->input('name', array('label' => false, 'div' => false, 'empty' => '-- note --', 'options' => array(20 => 20,19 => 19, 18 => 18,17 => 17,16 => 16,15 => 15,14 => 14,13 => 13,12 => 12,11 => 11,10 => 10,9 => 9,8 => 8,7 => 7,6 => 6,5 => 5,4 => 4,3 => 3,2 => 2,1 => 1,0 => 0)));
                        echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id']));
                        echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
                        echo $form->end('Valider');
                    } else {
                        echo '<br />Vous devez posséder un compte pour noter cette série.';	
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
                	<td class="up" width="33%"><?php echo $star->thumb('up'); ?> favorables<br />0 avis</td>
                    <td class="neutral" width="33%"><?php echo $star->thumb('neutral'); ?> neutres<br />39 avis</td>
                    <td class="down" width="33%"><?php echo $star->thumb('down'); ?> défavorables<br />23 avis</td>
                </tr>
                </table>
                <br /> <h3 class="red">Derniers avis</h3> <br /><br />
                <p><strong>cad</strong> - <?php echo $star->add(3); ?> <br />
                <span class="greyblack">Cette série est tout simplement géniale, Jack Bauer me ressemble dans sa façon de traiter les problèmes ...</span>
                </p>
                <p><strong>scarch</strong> - <?php echo $star->add(2); ?> <br />
                <span class="greyblack">Cette série est tout simplement géniale, Jack Bauer me ressemble dans sa façon de traiter les problèmes ...</span>
                </p>
    			
                <?php echo $html->link('&raquo; Tous les avis', '/avis/serie/' . $show['Show']['menu'] . '/all' , array('escape' => false, 'class' => 'nodeco')); ?> 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $html->link('&raquo; Donner votre avis', '/avis/add/serie/' .  $show['Show']['menu'] , array('escape' => false, 'class' => 'nodeco')); ?>
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
                    <li><strong>Diffusion US</strong> : <?php $timestamp = strtotime($show['Show']['diffusionus']);	echo strftime("%d %B %Y", $timestamp);?> (<?php echo $show['Show']['chaineus']; ?>)</li>
                    <li><strong>Diffusion FR</strong> : <?php $timestamp = strtotime($show['Show']['diffusionfr']);	echo strftime("%d %B %Y", $timestamp);?> (<?php echo $show['Show']['chainefr']; ?>)</li>
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
