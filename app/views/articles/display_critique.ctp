    <?php $this->pageTitle = $article['Article']['name'] . ' - ' . $episode['Episode']['name']; 
	echo $html->meta('description', $article['Article']['chapo'], array('type'=>'description'), false); 
	?>
    
    <div id="col1">
    <div class="padl5">
    	<?php echo $this->element('partage-reseau-sociaux'); ?>

    	<h1 class="red title"><?php echo $article['Article']['name']; ?> - <?php echo $episode['Episode']['name']; ?></h1><br /><br />
        <span class="chapo"><?php echo $article['Article']['chapo']; ?></span>
        <br /><br /><br />
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
        <br />
        
        <div class="article">
        	<br /><br />
        	<?php echo $article['Article']['text']; ?>
        </div>
        <br />
                
        <br /><br />
        <!-- Autre article -->
        <table width="100%" class="profil">
        <tr>
        <td width="50%">
            <h3 class="blue">Autres articles sur cette série :</h3><br /><br />
            <?php if(!empty($articlesserie)) { 
            echo '<ul class="play">';
            foreach ($articlesserie as $articl) {
                echo '<li>' . $html->link($articl['Article']['name'], '/article/' . $articl['Article']['url'] . '.html', array('class' => 'nodeco')) . '</li>';
            }
            echo '</ul>';
            } else { echo 'Aucun article pour le moment.'; } ?>
        </td>
        <td width="50%">
            <h3 class="blue">Dernières critiques de cette série :</h3><br /><br />
			<?php if(!empty($critiquesserie)) { 
            echo '<ul class="play">';
            foreach ($critiquesserie as $articl) {
                echo '<li>' . $html->link($articl['Article']['name'], '/article/' . $articl['Article']['url'] . '.html', array('class' => 'nodeco')) . '</li>';
            }
            echo '</ul>';
            } else { echo 'Aucune critique pour le moment.'; } ?>
        </td>
        </tr>
        </table>
        <br /><br />
        
        <!-- Rédacteur -->
        <table class="redacteur">
        <tr>
        	<th colspan="2">A propos du rédacteur</th>
        </tr>
        <tr>
        <td width="28%" class="td-redac">
        	<p class="padl10">
            <?php echo $html->link($gravatar->image($article['User']['email'], 55, array('alt' => $article['User']['login'], 'class' => 'imgleft'), false), '/profil/'. $article['User']['login'], array('class' => 'nodeco', 'escape' => false));  ?> 
			<strong><?php echo $html->link($article['User']['login'], '/profil/'. $article['User']['login'], array('class' => 'nodeco')); ?></strong><br />
            <?php echo $avisredac; ?> avis<br />
            <?php echo count($ratesredac); ?> notes<br />
            Moyenne : <strong class="red">
            <?php
			if(!empty($ratesredac)) {
				$total = 0;
				foreach($ratesredac as $j => $rat) {
					$total += $rat['Rate']['name'];
				}
				$nb = $j+1;
				$moyenne = $total / $nb;
				echo round($moyenne, 2);
			} else {
				echo '-';	
			}
			?>
            </strong>
            <br /><br />
            <span class="blue"><?php echo $html->image('icons/vcard.png', array('class' => 'absmiddle')) . ' &nbsp;'; if(!empty($ratesredac)) echo $star->rang($moyenne, count($ratesredac)); ?></span>
            </p>
        </td>
        <td width="72%">
        	<blockquote><?php if (!empty($article['User']['edito'])) echo $text->truncate($article['User']['edito'], 200, ' ...', false); else echo $article['User']['login']. ' n\'a pas encore rempli son édito, mais il va bientôt le faire, c\'est promis.'; ?></blockquote>
        </td>
        </tr>
        </table> 
        
        <!-- Commentaires -->
        <br />
        <h2 class="red padl5"><?php echo $html->image('icons/comments.png', array('class' => 'absmiddle')); ?>
		<?php echo count($article['Comment']); ?> commentaire<?php if (count($article['Comment']) > 1) echo 's'; ?> sur cet article</h2>
        <?php if (count($article['Comment']) > 0) { ?>
        <div class="comments"><?php ?>
        <br />
        <table>
        	<?php foreach($comments as $i => $comment) { ?>
            <tr>
            	<td class="td-com-user">
					<?php echo $html->link($gravatar->image($comment['User']['email'], 60, array('alt'=>'gravatar', 'class' => 'imgcom'), false), '/profil/'. $comment['User']['login'], array('class' => 'nodeco', 'escape' => false));  ?>
					<br /><strong>#<?php echo $i + 1; ?></strong>
                    
                    
                </td>
                <td class="td-com-text<?php if ($i&1) echo '2'; ?>">
					<?php echo $html->link($comment['User']['login'], '/profil/'. $comment['User']['login'], array('class' => 'decocom')); ?> 
                    <span class="grey">a écrit le 
                    <?php $timestamp = strtotime($comment['Comment']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?> à 
                    <?php e(strftime("%Hh%M", $timestamp)); ?>
                    </span>
                    <?php /*if( 1== $session->read('Auth.User.role') ){
                       echo $html->link('Supprimer le commentaire', '/admin/comments/delete/'. $comment['Comment']['id']);
                    } */?> 
                    <div class="spacer-com"></div>
					<?php echo nl2br($comment['Comment']['text']); ?>
                    
                </td>
            </tr>
            <?php } ?>
        </table>
        </div>
        <?php } ?>
        
        <br /><br /><br />
        <h2 class="red padl5"><?php echo $html->image('icons/comment_add.png', array('class' => 'absmiddle')); ?> Laissez un commentaire</h2><br /><br />
        <div class="comments-add">
        <?php if($session->read('Auth.User.role') > 0) { 
			echo 'Connecté en tant que <strong>' . $session->read('Auth.User.login') . '</strong>.<br /><br />';
			echo $form->create('Comment', array( 'action' => 'addNews'));
			echo $form->input('text', array('label' => false, 'cols' => 116));
			echo $form->input('article_id', array('type' => 'hidden', 'value' => $article['Article']['id']));
			echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
			echo '<br />';
			echo $form->end("Ajouter");
		} else {
			echo '<p class="suite">Vous devez vous ' . $html->link('créér un compte', '/inscription') . ' ou ' . $html->link('vous connecter', '#connexion', array('rel' => 'facebox')) . ' afin de pouvoir laisser un commentaire. <br />C\'est rapide et gratuit !</p>';
		}
        ?>
        </div>
    </div>
    </div>
    
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link(substr($show['Show']['name'],0,20), '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></li>
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
                            echo '<li>' . $rate['Rate']['name'] . ' par ' . $rate['User']['login'] . '</li>';
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
                        echo $ajax->form('add', 'post', array('model' => 'Rate', 'update' => 'resultrate'));
                        ?>
                        <?php
                        echo $form->input('name', array('label' => false, 'div' => false, 'class' => 'sexycombo', 'empty' => '-- note --', 'options' => array(20 => 20,19 => 19, 18 => 18,17 => 17,16 => 16,15 => 15,14 => 14,13 => 13,12 => 12,11 => 11,10 => 10,9 => 9,8 => 8,7 => 7,6 => 6,5 => 5,4 => 4,3 => 3,2 => 2,1 => 1,0 => 0)));
                        echo $form->input('episode_id', array('type' => 'hidden', 'value' => $episode['Episode']['id']));
												echo $form->input('season_id', array('type' => 'hidden', 'value' => $episode['Season']['id']));
												echo $form->input('show_id', array('type' => 'hidden', 'value' => $show['Show']['id']));
												echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id')));
                        echo '<button type="submit"><span>Valider</span></button></form>';
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
                	<td class="up" width="33%"><?php echo $star->thumb('up'); ?> favorables<br /><?php if (!empty($avisserie)) echo $commentsup; else echo 0; ?> avis</td>
                    <td class="neutral" width="33%"><?php echo $star->thumb('neutral'); ?> neutres<br /><?php if (!empty($avisserie)) echo $commentsneutral; else echo 0; ?> avis</td>
                    <td class="down" width="33%"><?php echo $star->thumb('down'); ?> défavorables<br /><?php if (!empty($avisserie)) echo $commentsdown; else echo 0; ?> avis</td>
                </tr>
                </table>
                <br /> 
                <?php 
				if (!empty($avisserie)) {
					echo '<h3 class="red">Derniers avis sur cet épisode</h3> <br /><br />';
					
					foreach ($avisserie as $x => $comment) {
						if ($x == 2) break;
					?>
                    <p><strong><?php echo $html->link($comment['User']['login'], '/profil/'. $comment['User']['login'], array('class' => 'nodeco')); ?></strong> - <?php echo $star->thumb($comment['Comment']['thumb']); ?> 
                    <span class="<?php echo $comment['Comment']['thumb']; ?>"><?php echo $star->avis($comment['Comment']['thumb']); ?></span>
                    <br />
                    <span class="greyblack"><?php echo $text->truncate($comment['Comment']['text'], 120, ' ...', false); ?></span>
                    </p>
                    <?php
					}
					if (!empty($alreadycomment)) {
						echo $html->link('<span>Modifier votre avis</span>', '#', array('escape' => false, 'class' => 'button', 'onClick' => '$(\'#avisuser\').slideDown(); return false;')); 
						echo $html->link('<span>Tous les avis</span>', '/episode/' . $show['Show']['menu'] . '/s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('escape' => false, 'class' => 'button'));
					} else {
						echo $html->link('<span>Donner votre avis</span>', '#', array('escape' => false, 'class' => 'button', 'onClick' => '$(\'#avisuser\').slideDown(); return false;')); 
						echo $html->link('<span>Tous les avis</span>', '/episode/' . $show['Show']['menu'] . '/s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('escape' => false, 'class' => 'button'));
					} 
				} else {
					echo '<h3 class="red">Pas encore d\'avis</h3> <br /><br />';
					echo $html->link('<span>Donner votre avis</span>', '#', array('escape' => false, 'class' => 'button', 'onClick' => '$(\'#avisuser\').slideDown(); return false;')); 
				} 
                
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
						
					echo '<br />Avant de valider, assurez-vous de corriger les éventuelles fautes d\'orthographe. <br /><br />';
					echo '<button type="submit"><span>Valider</span></button></form>';
				} else {
					echo '<strong>Vous devez posséder un compte pour laisser un avis sur cet épisode.</strong>';	
				}
				echo '</div>';  
                ?>
                <br /><br />
            </div>
            <div class="colr-footer"></div>
        </div>
        
         <div id="colright-allnotes">
            <div class="colrallnotes-header"></div>
            <div class="colr-content">
            	<br />
            	<?php
				if (!empty($rates)) {
					echo '<ul class="play">';
					foreach($rates as $j => $rate) {
						echo '<li><span class="red">' . $rate['Rate']['name'] . '</span> par ' . $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')) . ' <span class="grey">- ' . $star->role($rate['User']['role']) . '</span></li>';
					}
					echo '</ul>';
				} else {
					echo '<br />Pas encore de notes.<br /><br />';
				}
				?>
            </div>
            <div class="colr-footer"></div>
        </div>

        <!-- Infos série -->
        <div id="colright-infosserie">
            <div class="colrinfosserie-header"></div>
            <div class="colr-content">
            	<table>
                <tr>
                <td width="137">
       			<div class="serie">
                    <div class="serie-infos">
                        <h2><?php echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></h2> 
                        <?php if (strlen($show['Show']['name']) < 23) echo '<br />'; else echo '-'; ?>
                        <span class="grey">
                        <?php echo count($show['Season']);
                        if (count($show['Season']) == 1) {
                            echo ' saison'; 
                        } else { 
                            echo ' saisons'; 
                        } ?>
                        </span>
                    </div>
                    <?php echo $html->link($html->image(('show/' . $show['Show']['menu'] . '_w_serie.jpg'), array('alt' => '', 'width' => '139')), '/serie/' .$show['Show']['menu'], array('class' => 'nodeco', 'escape' => false)); ?>
                </div>
                </td>
                <td width="260" class="padl20">
                	<?php 
					foreach( $show['Season'] as $season) {
						echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
						echo '&nbsp;&nbsp;';
						echo $html->link('Saison ' . $season['name'], '/saison/' . $show['Show']['menu'] . '/' . $season['name'], array('class' => 'nodeco'));
						echo '<br />';
					}
					?>
                </td>
                </tr>
                </table>
                <h3 class="red">Autres articles sur cette série :</h3><br /><br />
                <?php if(!empty($articlesserie)) { 
				echo '<ul class="play">';
				foreach ($articlesserie as $article) {
					echo '<li>' . $html->link($article['Article']['name'], '/article/' . $article['Article']['url'] . '.html', array('class' => 'nodeco')) . '</li>';
				}
				echo '</ul>';
				} ?>
                
                <h3 class="red">Dernières critiques de cette série :</h3><br /><br />
                <?php if(!empty($critiquesserie)) { 
				echo '<ul class="play">';
				foreach ($critiquesserie as $article) {
					echo '<li>' . $html->link($article['Article']['name'], '/article/' . $article['Article']['url'] . '.html', array('class' => 'nodeco')) . '</li>';
				}
				echo '</ul>';
				} ?>
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
    	
         <div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
                <?php echo $this->element('facebook-page', array('cache' => "+1 day")); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        
        <div id="colright-bup">
            <div class="colrbup-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('pub-sidebar'); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        
    </div>
