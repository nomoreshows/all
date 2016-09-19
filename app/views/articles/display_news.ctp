<?php $this->pageTitle = $article['Article']['name']; 
	echo $html->meta('description', $article['Article']['chapo'], array('type'=>'description'), false); 
	?>
    <?php 
	if (!empty($article['Article']['video'])) {
	echo $javascript->codeBlock('
	var flashvars = {
	  vidWidth: "590",
	  vidHeight: "300",
	  vidPath: "/videos/'. $article['Article']['video'] .'",
	  thumbPath: "http://serieall.fr/img/video.jpg",
	  autoPlay: "false",
	  autoLoop: "false",
	  watermark: "hide",
	  seekbar: "show",
	  vidAspectRatio: "'. $article['Article']['ratio'] .'"
	};
	var params = {
	  menu: "true",
	  allowfullscreen: "true",
	  allowscriptaccess: "always"
	};
	var attributes = {
	  id: "playerLite",
	  name: "playerLite"
	};
	
	swfobject.embedSWF("/swf/playerLite.swf", "playerLite", flashvars.vidWidth, flashvars.vidHeight, "9.0.0","/swf/expressInstall.swf", flashvars, params, attributes);', array('inline' => false)); 
	} ?>
    
    <div id="col1">
    <div class="padl5">
        
    	<h1 class="red title"><?php echo $article['Article']['name']; ?></h1><br />
    	<?php echo $this->element('partage-reseau-sociaux'); ?>
        <span class="grey font12">publié par <?php echo $html->link($article['User']['login'], '/profil/'. $article['User']['login'], array('class' => 'decoblue', 'escape' => false));  ?> 
        le <?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?>
        </span>
        <br /><br />
        
        <span class="chapo"><?php echo $article['Article']['chapo']; ?></span>
        <br /><br /><br />
        <div class="article">
        	<?php 
			if (!empty($article['Article']['video'])) { ?>
            <!-- Lecteur vidéo -->
        	<div id="playerLite">
              <p>Flash est nécéssaire pour afficher cette vidéo.</p>
            </div>
            <div id="embed">
            	<?php $embed = '<embed width="590" height="300" flashvars="&amp;vidWidth=590&vidHeight=300&vidPath=http://serieall.fr/videos/'. $article['Article']['video'] . '&thumbPath=http://www.flvplayerlite.com/lab/jpg/playerlite.jpg&autoPlay=false&watermark=hide&seekbar=show&autoLoop=false&vidAspectRation=' . $article['Article']['ratio'] . '" wmode="opaque" quality="high" name="playerEmbed" id="playerEmbed" allowfullscreen="true" allowscriptaccess="always" src="http://serieall.easy-hebergement.info/swf/playerLite.swf"/>'; ?>
            	<span class="font11">Intégrer la vidéo sur votre site : </span><?php echo $form->input('embedcode', array('label' => false, 'div' => false, 'value' => $embed)); ?>
            </div>
        	<br /><br />
            <?php } ?>
            
        	<?php echo $article['Article']['text']; ?>
        </div>
        <?php 
		// Source
		if (!empty($article['Article']['source']) and $article['Article']['source'] != 'http://') { ?>
        <p class="suite"><?php echo $html->link('&raquo; Source', $article['Article']['source'], array('rel' => 'nofollow', 'escape' => false)); ?></p>
        <?php } ?>
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
		<?php echo count($article['Comment']); ?> commentaire<?php if (count($article['Comment']) > 1) echo 's'; ?></h2>
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
			echo $form->input('text', array('label' => false, 'cols' => 100));
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
    	
        <!-- Infos série -->
        <?php if ($article['Article']['show_id'] != 0) { ?>
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
            </div>
            <div class="colr-footer"></div>
        </div>
        <?php } ?>
        
    	<!-- Derniers articles -->
        <div id="colright-lastarticles">
            <div class="colrlastart-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('last-articles', array('cache' => "+1 day")); ?>
            </div>
            <div class="colr-footer"></div>
        </div>

    
    </div>
