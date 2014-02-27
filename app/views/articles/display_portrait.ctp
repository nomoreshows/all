    <?php $this->pageTitle = $article['Article']['name']; 
	echo $html->meta('description', $article['Article']['chapo'], array('type'=>'description'), false); 
	?>
    
    <div id="col1">
    <div class="padl5">
    	<?php echo $this->element('partage-reseau-sociaux'); ?>

    	<h1 class="red title"><?php echo $article['Article']['name']; ?></h1><br /><br />
        <span class="chapo"><?php echo $article['Article']['chapo']; ?></span>
        <br /><br /><br />
        <div class="bg-serie">
        	<?php echo $html->image(('show/' . $role['Show']['menu'] . '_w.jpg'), array('alt' => $role['Show']['name'], 'align' => 'left')); ?>
            <table>
            <tr>
            	<td class="td-genres" colspan="2"><strong>Série associée </strong>: <br /><?php echo $role['Show']['name']; ?></td>
            </tr>
            <tr>
            	<td class="td-nat" colspan="2"><?php echo $role['Role']['name']; ?></td>
            </tr>
            <tr>
            	<td class="td-annee" colspan="2"><?php echo $role['Actor']['name']; ?></td>
            </tr>
            <tr>
            	<td class="td-format" colspan="2">Né le <?php $timestamp = strtotime($role['Actor']['datenaiss']); e(strftime("%d %B %Y", $timestamp)); ?></td>
            </tr>
            <tr>
            	<td class="td-portrait" colspan="2">à <?php echo $role['Actor']['lieunaiss']; ?></td>
            </tr>
            </table>
        </div>
        <br />
        <div class="article">
        	<?php echo $article['Article']['text']; ?>
        </div>
        <br />
        
        <fb:like show_faces="false" width="450" font="tahoma"></fb:like>
        
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
                    <?php if( 1<= $session->read('Auth.User.role') && $session->read('Auth.User.role') < 4 ): ?>
                    <?php echo $html->link('Supprimer le commentaire', '/admin/comments/delete/'. $comment['Comment']['id']); ?>
                    <?php endif; ?>    
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
    	
        <!-- Acteur -->
    	<div id="colright-acteur">
            <div class="colracteur-header"></div>
            <div class="colr-content">
            	<br />
            	<?php echo $html->image('actor/picture/' . $role['Actor']['picture'], array('class' => 'imgleft')); ?>
            	<h3 class="red"><?php echo $role['Actor']['name']; ?></h3> <br />
                dans le rôle de <strong><?php echo $role['Role']['name']; ?></strong> <br /><br />
                <ul class="playe">
                	<li>Né le <?php $timestamp = strtotime($role['Actor']['datenaiss']); e(strftime("%d %B %Y", $timestamp)); ?> </li>
                    <li>à <?php echo $role['Actor']['lieunaiss']; ?></li>
                </ul>
                <br /><br />
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
                <table width="100%">
                <tr>
                <td>
                	<!-- Moyenne -->
                    <div class="bg-star">
                        <h3 class="gold">Moyenne</h3> <br />
                        <span class="gold staring">
                        <?php
                        if (!empty($show['Show']['moyenne'])) {
                            echo $show['Show']['moyenne'];
							echo '<br /></span>';
							echo $star->convert($show['Show']['moyenne']);
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
                	<h3 class="red">Dernières notes :</h3><br /><br />
					<?php
                    if (!empty($ratesshow)) {
                        echo '<ul class="play">';
                        foreach($ratesshow as $j => $rate) {
                            if ($j == 5 ) break;
                                echo '<li>' . $rate['Rate']['name'] . ' par ' . $rate['User']['login'] . ' - ' . $html->link($rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue')) . '</li>';
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
            <div class="colr-footer"></div>
        </div>
        
        
    	<div id="colright-bup">
            <div class="colrbup-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('pub-sidebar'); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
        
        <!-- Dernieres articles -->
        <div id="colright-lastarticles">
            <div class="colrlastart-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('last-articles', array('cache' => "+1 day")); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
    </div>
