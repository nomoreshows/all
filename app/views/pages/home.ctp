 <?php 
 $this->pageTitle = 'Critique et actualité des séries TV - Webzine communautaire'; 
 echo $html->meta('description', "Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning personnalisé et organisez votre collection.", array('type'=>'description'), false); 
 ?>
	
 <div id="edit-password" style="display:none;">
 	<?php
	echo $form->create('User', array( 'action' => 'editPassword')); 
	echo '<fieldset><legend>Informations à remplir</legend><br /><br />'; 
	e($form->input('id', array('type' => 'hidden', 'value' => $session->read('Auth.User.id'))));
	e($form->input('password', array('label' => 'Mot de passe :')));
	e($form->input('password_confirm', array('label' => 'Confirmer :', 'type' => 'password')));
	e($form->input('email', array('type' => 'hidden', 'value' => $session->read('Auth.User.email'))));
	e($form->end("Modifier"));
	echo '</fieldset>';
	?>
 </div>   
 <div id="edit-email" style="display:none;">
 	<?php
	echo $form->create('User', array( 'action' => 'editEmail')); 
	echo '<fieldset><legend>Informations à remplir</legend><br /><br />'; 
	e($form->input('id', array('type' => 'hidden', 'value' => $user['User']['id'])));
	e($form->input('email', array('label' => 'Adresse mail :', 'value' => $user['User']['email'])));
	e($form->end("Modifier"));
	echo '</fieldset>';
	?>
 </div>  
 <div id="edit-avatar" style="display:none;">
     <h2 class="red">Ajouter/Changer son avatar</h2>
     <br /><br />
 	 <p class="suite">Série All utilise le systême <?php echo $html->link('Gravatar', 'http://fr.gravatar.com'); ?> pour les avatars de ses utilisateurs. <?php echo $html->link('Gravatar', 'http://fr.gravatar.com'); ?> est un site qui permet d'associer votre avatar à votre adresse mail. <br /><br />Ainsi sur n'importe quel site qui utilise <?php echo $html->link('Gravatar', 'http://fr.gravatar.com'); ?>, il suffira de lui indiquer votre adresse mail afin qu'il affiche votre avatar.</p>
    <br />
    <ul class="play">
    	<li>Rendez-vous sur <?php echo $html->link('cette page', 'http://fr.gravatar.com/site/signup', array('target' => '_blank', 'class' => 'decoblue')); ?> pour créér votre compte Gravatar</li>
        <li>Complétez l'adresse mail associée à votre gravatar dans votre profil</li>
        <li>C'est tout !</li>
    </ul>
 </div>
    
 <div id="critiques-une">
 	<div class="cune-header"></div>
    <div class="cune-content">
    	<div id="photos" class="galleryview">
			<?php 
			// Article double une
			if(!empty($articlesdoubleune)) {
            foreach($articlesdoubleune as $i => $article) { ?>
              <div class="panel">
              	<?php 
              	// Image par défaut ou de la série
              	if (empty($article['Show']['menu'])) { 
					if ($article['Article']['category'] == 'chronique') {
					?>
                    <img src="img/chronique-une.jpg" alt="<?php echo $article['Article']['name']; ?>" /> 
                    <?php } else { ?>
                	<img src="img/default-une.jpg" alt="<?php echo $article['Article']['name']; ?>" /> 
                    <?php }
              	} else { ?>
                	<img src="img/show/<?php echo $article['Show']['menu']; ?>_w.jpg" alt="<?php echo $article['Show']['menu']; ?>" /> 
                <?php } ?>
                <div class="panel-overlay">
                  <h2 class="red">
				  	<?php 
					if (strlen($article['Article']['name']) < 30 and strlen($article['Episode']['name']) < 20) {
				  		echo $html->link($article['Article']['name'] . ' - ' . $article['Episode']['name'], '/article/'. $article['Article']['url'] . '.html'); 
					} else {
						echo $html->link($article['Article']['name'], '/article/'. $article['Article']['url'] . '.html'); 
					}
				 	 ?>
                  </h2>
                  <span class="lblue"><?php echo 'par ' . $article['User']['login']; ?></span>
                  <p><?php echo $text->truncate($article['Article']['chapo'], 190, ' ...', false); ?></p>
                </div>
              </div>
              <?php } ?>
            <?php } 
			
			// Article une
            if(!empty($articlesune)) {
            foreach($articlesune as $i => $article) { ?>
              <div class="panel">
              	<?php 
              	// Image par défaut ou de la série
              	if (empty($article['Show']['menu'])) { 
					if ($article['Article']['category'] == 'chronique') {
					?>
                    <img src="img/chronique-une.jpg" alt="<?php echo $article['Article']['name']; ?>" /> 
                    <?php } else { ?>
                	<img src="img/default-une.jpg" alt="<?php echo $article['Article']['name']; ?>" /> 
                    <?php }
              	} else { ?>
                	<img src="img/show/<?php echo $article['Show']['menu']; ?>_w.jpg" alt="<?php echo $article['Show']['menu']; ?>" /> 
                <?php } ?>
                <div class="panel-overlay">
                  <h2 class="red">
				  	<?php 
					if (strlen($article['Article']['name']) < 30 and strlen($article['Episode']['name']) < 20) {
				  		echo $html->link($article['Article']['name'] . ' - ' . $article['Episode']['name'], '/article/'. $article['Article']['url'] . '.html'); 
					} else {
						echo $html->link($article['Article']['name'], '/article/'. $article['Article']['url'] . '.html'); 
					}
				 	 ?>
                  </h2>
                  <span class="lblue"><?php echo 'par ' . $article['User']['login']; ?></span>
                  <p><?php echo $text->truncate($article['Article']['chapo'], 190, ' ...', false); ?></p>
                </div>
              </div>
              <?php } ?>
              <ul class="filmstrip">
              <?php
			   foreach($articlesdoubleune as $i => $article) {
              	if (empty($article['Show']['menu'])) { ?>
              		<li><img src="img/default-une_t.jpg" title="<?php echo $article['Article']['caption']; ?>" alt="<?php echo $article['Article']['name']; ?>" /></li>
              	<?php } else { ?>
                	<li><img src="img/show/<?php echo $article['Show']['menu']; ?>_t_serie.jpg" title="<?php echo $article['Article']['caption']; ?>" alt="<?php echo $article['Article']['name']; ?>" /></li>
                <?php } 
                
              } 
              foreach($articlesune as $i => $article) {
              	if (empty($article['Show']['menu'])) { ?>
              		<li><img src="img/default-une_t.jpg" title="<?php echo $article['Article']['caption']; ?>" alt="<?php echo $article['Article']['name']; ?>" /></li>
              	<?php } else { ?>
                	<li><img src="img/show/<?php echo $article['Show']['menu']; ?>_t_serie.jpg" title="<?php echo $article['Article']['caption']; ?>" alt="<?php echo $article['Article']['name']; ?>" /></li>
                <?php } 
                
              } ?>
              </ul>
            <?php } ?>
            </div>
    </div>
    <div class="cune-footer"></div>
 </div>
 
 <div id="espace-membre">
 	<div class="emembre-header"></div>
    <div class="emembre-content">
    	<?php 
		if($session->read('Auth.User.role') > 0) { 
		// ESPACE MEMBRE ?>
        <table width="100%">
        <tr>
        <td width="45%">
        	<strong>Bienvenue</strong> <strong class="decoblue"><?php echo $user['User']['login']; ?></strong>. <br />
            <br />
            <?php echo $html->link($gravatar->image($user['User']['email'], 70, array('alt' => $user['User']['login'], 'class' => 'imgleft'), false), '/profil/'. $user['User']['login'], array('class' => 'nodeco', 'escape' => false));  ?> 
            <?php if($session->read('Auth.User.role') < 4) { ?>
            	&raquo; <?php echo $html->link('Administration', '/admin', array('class' => 'nodeco2')); ?> <br /> 
            <?php } ?>
            &raquo; <?php echo $html->link('Profil public', '/profil/' . $user['User']['login'], array('class' => 'nodeco2')); ?>  <br />
            &raquo; <?php echo $html->link('Changer mot passe', '#edit-password', array('class' => 'nodeco2', 'rel' => 'facebox')); ?>  <br />
            &raquo; <?php echo $html->link('Changer email', '#edit-email', array('class' => 'nodeco2', 'rel' => 'facebox')); ?>  <br />
            &raquo; <?php echo $html->link('Changer avatar', '#edit-avatar', array('class' => 'nodeco2', 'rel' => 'facebox')); ?>  <br />
        </td>
        <td width="23%">
        	<strong>Statistiques</strong>
            <br /><br />
            <?php echo $critiquesuser; ?> critiques<br />
            <?php echo $commentsuser; ?> avis<br />
            <?php echo count($ratesuser); ?> notes<br />
            Moyenne : <strong class="red">
            <?php
			if(!empty($ratesuser)) {
				$total = 0;
				foreach($ratesuser as $j => $rat) {
					$total += $rat['Rate']['name'];
				}
				$nb = $j+1;
				$moyenne = $total / $nb;
				echo round($moyenne, 2);
			} else {
				echo '-';	
			}
			?>
            </strong> <br />
            <span class="blue"><?php if(!empty($ratesuser)) echo $star->rang($moyenne, count($ratesuser)); ?></span>
            <br />
        </td>
        <td width="32%">
        	<?php 
			if (!empty($user['Show'])) {
				if (count($user['Show']) < 7) {
					echo '<strong>Raccourcis</strong><br /><br />';
				}
				foreach ($user['Show'] as $i => $show) {
					echo '&raquo; ' . $html->link($show['name'], '/serie/' . $show['menu'], array('escape' => false)) . '<br />'; 
					if($i == 6) break;
				}
			} else { ?>
            	<strong>Raccourcis</strong><br /><br />
				Définissez vos séries préférées sur votre profil public.
			<?php } ?>
        </td>
        </tr>
        </table>
        
        <?php } else { 
		// ESPACE INSCRIPTION?>
		<strong class="lblue">Bienvenue</strong> sur Série-All, cher visiteur ! <br /><br />
        Vous pouvez dès à présent vous <?php echo $html->link('créér un compte', '/inscription', array('class' => 'decoblue')); ?> afin de profiter de tous les avantages du site. <br />Notez les épisodes, laissez des avis, créez votre planning personnalisé, organisez votre collection...<br /><br />
        Découvrez toutes les raisons de vous créer un compte en détails sur <?php echo $html->link('cette page', '/inscription', array('class' => 'decoblue')); ?>.
        <?php } ?>
        <br /> <br />
    </div>
    <div class="emembre-footer"></div>
    
 </div>
 
 <div id="last-critiques">
 	<div class="clast-header"></div>
    <div class="clast-content">
            <?php echo $this->element('planning-home'); ?>
    </div>
    <div class="clast-footer"></div>
    
 </div>
 
 <div id="news-communaute"></div>
 
 <div id="news">
 	<div class="padl20">
 	<?php
	if (!empty($news)) {
	foreach ($news as $i => $new) {
		if($i == 5) break;
	?>
 	<div class="onenews">
        <h2><?php echo $html->link($new['Article']['name'], '/article/' . $new['Article']['url']. '.html'); ?></h2> <br />
        <?php 
		if (empty($new['Article']['show_id'])) {
		echo $html->link($html->image('article/thumb.news.' . $new['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $new['Article']['url'] . '.html', array('escape' => false)); 
		} else {
			echo $html->link($html->image('show/' . $new['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $new['Article']['url'] . '.html', array('escape' => false)); 
		}
		?>
        <div class="textnews">
        	<p class="date"><?php $timestamp = strtotime($new['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($new['Comment']); ?> commentaire<?php if(count($new['Comment']) > 1) echo 's'; ?></p>
        	<p class="text"><?php echo $text->truncate($new['Article']['chapo'], 200, ' ...', false); ?></p>
        </div>
    </div>
    <?php
	}
	}
	if (!empty($news)) {
	foreach ($news as $i => $new) {
		if($i > 4) {
	?>
        <div class="onenews">
            <h2><?php echo $html->link($new['Article']['name'], '/article/' . $new['Article']['url']. '.html'); ?></h2><p class="comments"><?php echo count($new['Comment']); ?></p>
        </div>
   	<?php
		}
	}
	}
	?>
    <p><?php echo $html->link('<span>Toutes les news</span>', '/actualite', array('class' => 'button', 'escape' => false)); ?></p>
    <div class="spacer"></div>
    </div>
    
    <div id="classements"></div>
    
    <table width="100%" class="classement">
    <tr>
    	<td width="50%">
        <strong>Meilleures séries</strong>
        <br /><br />
        <?php
		if(!empty($bestseries)) {
			echo '<ul class="class">';
			$compteur = 0;
			
			foreach($bestseries as $i => $show) {

				/* si la série n'est pas notée par une personne uniquement
				$userid = $show['Rate'][0]['user_id'];
				$continue = false;
				foreach($show['Rate'] as $rate) {
					if ($rate['user_id'] != $userid) {
						$continue = true;
						break;
					} else {
						$userid = $rate['user_id'];
					}
				}
				*/
				$compteur++;
				if ($compteur == 1) echo $html->link($html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false)); 
				?>
				<li>
				<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
				<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
				<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
				<?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
				echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?> - <span class="lblue"><?php echo $show['Show']['moyenne']; ?></span></li> <?php
				if ($compteur == 10) break;
			}
			echo '</ul>';
		} 
		echo $html->link('<span>Classement entier</span>', '/classement-series-tv', array('escape' => false, 'class' => 'button')); ?>
        </td>
        <td width="50%">
        <strong>Meilleurs épisodes</strong>
        <br /><br />
        <?php
		if(!empty($bestepisodes)) {
			echo '<ul class="class">';
			$compteur = 0;
			
			foreach($bestepisodes as $i => $episode) {
					
					/* si l'épisode n'est pas notée par une personne uniquement
					$userid = $episode['Rate'][0]['user_id'];
					$continue = false;
					foreach($episode['Rate'] as $rate) {
						if ($rate['user_id'] != $userid) {
							$continue = true;
							break;
						} else {
							$userid = $rate['user_id'];
						}
					}*/
					$compteur++;
					if ($compteur == 1) echo $html->link($html->image('show/' . $episode['Season']['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $episode['Season']['Show']['menu'], array('escape' => false));
					?>
					<li>
					<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
					<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
					<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
					<?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
					echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco')); ?>
					- <span class="lblue"><?php echo $episode['Episode']['moyenne']; ?></span></li> <?php
				if ($compteur == 10) break;
			}
			echo '</ul>';
		} 
		echo $html->link('<span>Classement entier</span>', '/classement-series-tv', array('escape' => false, 'class' => 'button'));
		?>
        </td>
    </tr>
    <tr>
    	<td>
        <br />
        <strong>Meilleures saisons</strong>
        <br /><br />
        <?php
		if(!empty($bestsaisons)) {
			echo '<ul class="class">';
			$compteur = 0;
			foreach($bestsaisons as $i => $season) {
					
					/* si la saison n'est pas notée par une personne uniquement
					$userid = $season['Rate'][0]['user_id'];
					$continue = false;
					foreach($season['Rate'] as $rate) {
						if ($rate['user_id'] != $userid) {
							$continue = true;
							break;
						} else {
							$userid = $rate['user_id'];
						}
					}*/
					$compteur++;
					if ($compteur == 1) echo $html->link($html->image('show/' . $season['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $season['Show']['menu'], array('escape' => false)); 
					?>
					<li>
					<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
					<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
					<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
					<?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
					echo $html->link($season['Show']['name'] . ' s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $season['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco')); ?>
					- <span class="lblue"><?php echo $season['Season']['moyenne']; ?></span></li> <?php
					
					if ($compteur == 10) break;
			}
			echo '</ul>';
		} 
		echo $html->link('<span>Classement entier</span>', '/classement-series-tv', array('escape' => false, 'class' => 'button'));
		?>
        </td>
        <td>
        <br />
        <strong>Classement de la rédac</strong>
        <br /><br />
        <?php
		if(!empty($topredac)) {
			echo '<ul class="class">';
			$compteur = 0;
			
			foreach($topredac as $i => $show) {
				$compteur++;
				if ($compteur == 1) echo $html->link($html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false)); 
				?>
				<li>
				<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
				<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
				<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
				<?php if ($compteur > 3) echo '&nbsp;&nbsp;'. $compteur . '. ';
				echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?> - <span class="lblue"><?php echo round($show['0']['Moyenne'],2); ?></span></li> <?php
				if ($compteur == 10) break;
			}
			echo '</ul>';
		} 
		echo $html->link('<span>Classement entier</span>', '/classement-series-tv', array('escape' => false, 'class' => 'button'));
		?>
        </td>
    </tr>
    </table>
 </div>
 
 
 
 
 
 

 <div id="communaute">
 	<table>
    <tr>
    	<td class="padl10" width="46%">
        <h3>Notes 
        <?php echo $html->image('icons/membre.png', array('class' => 'absmiddle')); ?>
        <?php echo $ajax->link('Membres', array('controller' => 'rates', 'action' => 'lastRate', 'membres'), array( 'update' => 'lastrates')); ?> - 
        <?php echo $html->image('icons/redacteur.png', array('class' => 'absmiddle')); ?>
		<?php echo $ajax->link('Rédacteurs', array('controller' => 'rates', 'action' => 'lastRate', 'redacteurs'), array( 'update' => 'lastrates')); ?></h3> 		
        <div id="lastrates">
            <ul class="play">
            <?php 
            foreach($rates as $rate) { ?>
                <li>
                <span class="lblue"><?php echo $rate['Rate']['name']; ?></span> 
                par <?php echo $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')); ?> 
                -
                <?php 
                echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
				echo ' ';
				
                // Note d'un épisode
                echo $html->link($rate['Show']['name'] . ' ' . $rate['Season']['name'] . '.' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $rate['Show']['menu'] . '/s' . str_pad($rate['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($rate['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
                ?>
                </li>
            <?php } ?>
            </ul>
        </div>
        </td>
        <td width="54%">
        <h3> 
        <?php echo $html->image('icons/thumb_up.png', array('class' => 'absmiddle')); ?>
        <?php echo $ajax->link('Avis', array('controller' => 'comments', 'action' => 'lastComment', 'avis'), array( 'update' => 'lastcomments')); ?> - 
        <?php echo $html->image('icons/comments.png', array('class' => 'absmiddle')); ?>
		<?php echo $ajax->link('Commentaires', array('controller' => 'comments', 'action' => 'lastComment', 'comments'), array( 'update' => 'lastcomments')); ?>
        <?php echo $html->image('icons/comments.png', array('class' => 'absmiddle')); ?>
		<?php echo $ajax->link('Réactions', array('controller' => 'reactions', 'action' => 'lastReaction'), array( 'update' => 'lastcomments')); ?>
        
        </h3> 
        <div id="lastcomments">
        <ul class="play">
        	<?php 
            foreach($lastcomments as $comment) { ?>
        	<li><span class="lblue"><?php echo $html->link($comment['User']['login'], '/profil/'. $comment['User']['login'], array('class' => 'nodeco')); ?> </span> - 
            <?php 
			echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
			echo ' ';
				if(empty($comment['Article']['id'])) {
					if (empty($comment['Season']['name']) && empty($comment['Episode']['numero'])) {
						// Avis d'une série
						echo $html->link($comment['Show']['name'], '/serie/' . $comment['Show']['menu'], array('class' => 'decoblue'));
					} elseif(empty($comment['Episode']['numero'])) {
						// Avis d'une saison		
						echo $html->link($comment['Show']['name'] . ' saison ' . $comment['Season']['name'], '/saison/' . $comment['Show']['menu'] . '/' . $comment['Season']['name'], array('class' => 'decoblue'));
					} else {
						// Avis d'un épisode
						echo $html->link($comment['Show']['name'] . ' ' . $comment['Season']['name'] . '.' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $comment['Show']['menu'] . '/s' . str_pad($comment['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($comment['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
					}
					echo ' ' .$star->thumb($comment['Comment']['thumb']); ?> 
					<span class="<?php echo $comment['Comment']['thumb']; ?>"> <?php echo $star->avis($comment['Comment']['thumb']); ?></span> 
                    
                    
                   <?php // Si texte dans l'avis on prépare l'avis en facebox 
				  if (!empty($comment['Comment']['text'])) { ?>
				  
				  <?php }
            
            
				} else { 
            		echo $html->link($text->truncate($comment['Article']['name'], 50, '..', false), '/article/' . $comment['Article']['url'] . '.html', array('class' => 'decoblue'));
                } ?>
                </li>
                <?php
			}
			?>
        </ul>
        </div>
        </td>
    </tr>
    </table>
 </div>
 
 <div id="videos-dossiers"></div>
 
 <div id="videos">
 	<table width="100%">
    <tr>
    <td width="49%">
    	<table width="100%">
        <tr>
        <td width="50%" class="alignbottom">
        	<?php if(!empty($videos[0])) { ?>
            <h2><?php echo $html->link($videos[0]['Article']['name'], '/article/'. $videos[0]['Article']['url'] . '.html'); ?></h2> <br />
            <div class="onevideo">
                <p class="date"><?php $timestamp = strtotime($videos[0]['Article']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($videos[0]['Comment']); ?></p>
            </div>
            <?php 
			if (empty($videos[0]['Show']['id'])) {
			echo $html->link($html->image('article/' . $videos[0]['Article']['photo'], array('class' => 'imgvideo')), '/article/' . $videos[0]['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $videos[0]['Show']['menu'] . '_w_serie.jpg', array('class' => 'imgvideo')), '/article/' . $videos[0]['Article']['url'] . '.html', array('escape' => false));
			}
			}
			?>
		</td>
        <td width="50%" class="alignbottom">
        	<?php if(!empty($videos[1])) { ?>
        	<h2><?php echo $html->link($videos[1]['Article']['name'], '/article/'. $videos[1]['Article']['url'] . '.html'); ?></h2> <br />
            <div class="onevideo">
                <p class="date"><?php $timestamp = strtotime($videos[1]['Article']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($videos[1]['Comment']); ?></p>
            </div>
            <?php 
			if (empty($videos[1]['Show']['id'])) {
			echo $html->link($html->image('article/' . $videos[1]['Article']['photo'], array('class' => 'imgvideo')), '/article/' . $videos[1]['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $videos[1]['Show']['menu'] . '_w_serie.jpg', array('class' => 'imgvideo')), '/article/' . $videos[1]['Article']['url'] . '.html', array('escape' => false));
			}
			}
			?>
        </td>
        </tr>
        <tr>
        <td width="50%" class="alignbottom">
        	<?php if(!empty($videos[2])) { ?>
            <h2><?php echo $html->link($videos[2]['Article']['name'], '/article/'. $videos[2]['Article']['url'] . '.html'); ?></h2> <br />
            <div class="onevideo">
                <p class="date"><?php $timestamp = strtotime($videos[2]['Article']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($videos[2]['Comment']); ?></p>
            </div>
            <?php 
			if (empty($videos[2]['Show']['id'])) {
			echo $html->link($html->image('article/' . $videos[2]['Article']['photo'], array('class' => 'imgvideo')), '/article/' . $videos[2]['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $videos[2]['Show']['menu'] . '_w_serie.jpg', array('class' => 'imgvideo')), '/article/' . $videos[2]['Article']['url'] . '.html', array('escape' => false));
			}
			}
			?>
		</td>
        <td width="50%" class="alignbottom">
        	<?php if(!empty($videos[3])) { ?>
        	<h2><?php echo $html->link($videos[3]['Article']['name'], '/article/'. $videos[3]['Article']['url'] . '.html'); ?></h2> <br />
            <div class="onevideo">
                <p class="date"><?php $timestamp = strtotime($videos[3]['Article']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($videos[3]['Comment']); ?></p>
            </div>
            <?php 
			if (empty($videos[3]['Show']['id'])) {
			echo $html->link($html->image('article/' . $videos[3]['Article']['photo'], array('class' => 'imgvideo')), '/article/' . $videos[3]['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $videos[3]['Show']['menu'] . '_w_serie.jpg', array('class' => 'imgvideo')), '/article/' . $videos[3]['Article']['url'] . '.html', array('escape' => false));
			}
			}
			?>
        </td>
        </tr>
        <tr>
        <td width="50%" class="alignbottom">
        	<?php if(!empty($videos[4])) { ?>
        	<h2><?php echo $html->link($videos[4]['Article']['name'], '/article/'. $videos[4]['Article']['url'] . '.html'); ?></h2> <br />
            <div class="onevideo">
                <p class="date"><?php $timestamp = strtotime($videos[4]['Article']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($videos[4]['Comment']); ?></p>
            </div>
            <?php 
			if (empty($videos[4]['Show']['id'])) {
			echo $html->link($html->image('article/' . $videos[4]['Article']['photo'], array('class' => 'imgvideo')), '/article/' . $videos[4]['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $videos[4]['Show']['menu'] . '_w_serie.jpg', array('class' => 'imgvideo')), '/article/' . $videos[4]['Article']['url'] . '.html', array('escape' => false));
			}
			}
			?>
        </td>
        <td width="50%" class="alignbottom">
        	<?php if(!empty($videos[5])) { ?>
        	<h2><?php echo $html->link($videos[5]['Article']['name'], '/article/'. $videos[5]['Article']['url'] . '.html'); ?></h2> <br />
            <div class="onevideo">
                <p class="date"><?php $timestamp = strtotime($videos[5]['Article']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($videos[5]['Comment']); ?></p>
            </div>
            <?php 
			if (empty($videos[5]['Show']['id'])) {
			echo $html->link($html->image('article/' . $videos[5]['Article']['photo'], array('class' => 'imgvideo')), '/article/' . $videos[5]['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $videos[5]['Show']['menu'] . '_w_serie.jpg', array('class' => 'imgvideo')), '/article/' . $videos[5]['Article']['url'] . '.html', array('escape' => false));
			}
			}
			?>
        </td>
        </tr>
        </table>
        <br />
        <p><?php echo $html->link('<span>Toutes les vidéos</span>', '/videos-trailers', array('class' => 'button', 'escape' => false)); ?></p>
    </td>
    
    <td width="51%" class="padl15 aligntop">
    	<?php
		if (!empty($dossiers)) {
		foreach ($dossiers as $i => $dossier) {
		?>
    	<div class="onenews">
            <h2><?php echo $html->link($dossier['Article']['name'], '/article/' . $dossier['Article']['url']. '.html'); ?></h2> <br />
            <?php 
			if (empty($dossier['Article']['show_id'])) {
			echo $html->link($html->image('article/thumb.news.' . $dossier['Article']['photo'], array('class' => 'imgright margr10', 'width' => 78)), '/article/' . $dossier['Article']['url'] . '.html', array('escape' => false)); 
			} else {
				echo $html->link($html->image('show/' . $dossier['Show']['menu'] . '_t.jpg', array('class' => 'imgright margr10', 'width' => 78)), '/article/' . $dossier['Article']['url'] . '.html', array('escape' => false)); 
			}
			?>
            <div class="textnews">
                <p class="date"><?php $timestamp = strtotime($dossier['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
                <p class="comments"><?php echo count($dossier['Comment']); ?> commentaire<?php if(count($dossier['Comment']) > 1) echo 's'; ?></p>
                <p class="text"><?php echo $text->truncate($dossier['Article']['chapo'], 150, ' ...', false); ?></p>
            </div>
        </div>
        <br />
        <?php
		}
		}
		?>
		
        <p><?php echo $html->link('<span>Tous les dossiers</span>', '/dossiers', array('class' => 'button', 'escape' => false)); ?></p>
    </td>
    </tr>
    </table>
 </div>
 
 <br /><br />
 <div id="redacteurs-forum"></div>
 <div id="redac">
 	<br />
 	<table width="100%">
 	<tr>
    <td width="240">
    	<iframe src="http://www.facebook.com/plugins/likebox.php?id=105365559504009&amp;width=242&amp;connections=8&amp;stream=false&amp;header=true&amp;height=287" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:242px; height:287px;" allowTransparency="true"></iframe>
    	<!-- 
    	<div id="randomredacteur">
        <?php echo $html->link($gravatar->image($randomredacteur['User']['email'], 70, array('alt' => $randomredacteur['User']['login'], 'class' => 'imgright'), false), '/profil/'. $randomredacteur['User']['login'], array('class' => 'nodeco', 'escape' => false));  ?> 
        <h3 class="lblue">L'édito de <?php echo $html->link($randomredacteur['User']['login'], '/profil/'. $randomredacteur['User']['login'], array('class' => 'decored')); ?></h3> <br />
        <?php echo $star->role($randomredacteur['User']['role']); ?> <br /><br />
        
        <blockquote><?php if (!empty($randomredacteur['User']['edito'])) echo $text->truncate($randomredacteur['User']['edito'], 150, ' ...', false); else echo $randomredacteur['User']['login'] . ' n\'a pas d\'édito à ce jour. Il sera puni très séverement dans peu de temps.'; ?></blockquote><br /><br />
        </div>
        -->
    </td>
    <td width="313" class="td-rssforum">
    	<h3 class="red">Derniers posts sur le forum : </h3><br /><br />
    	<?php echo $rssforum; ?>
        <br />
        <p><?php echo $html->link('<span>Voir le forum</span>', '/forum', array('class' => 'button', 'escape' => false)); ?></p>
    </td>
 	</table>
 
 </div>
 
 <div id="portraits-bilans-focus"></div>
 
 <div id="portraits">
 	<table width="100%">
    <tr>
    <td width="33%">
    	<div class="polaroid">
        	<?php
			if(!empty($portraits)) {
			?>
				<?php echo $html->link($html->image('actor/picture/' . $portraits[0]['Actor']['picture']), '/article/' . $portraits[0]['Article']['url'] . '.html', array('escape' => false)); ?>
				<p class="polaroid-title">
				<?php echo $html->link($portraits[0]['Role']['name'], '/article/' . $portraits[0]['Article']['url'] . '.html', array('class' => 'nodeco')); ?>
                </p>
			<?php
            } ?>
        </div>
    </td>
    <td width="33%">
    	<div class="polaroid">
          	<?php
			if(!empty($bilans)) {
			?>
				<?php echo $html->link($html->image('show/' . $bilans[0]['Show']['menu'] . '_t.jpg'), '/article/' . $bilans[0]['Article']['url'] . '.html', array('escape' => false)); ?>
				<p class="polaroid-title">
				<?php echo $html->link($bilans[0]['Show']['name'] . ' ' . $bilans[0]['Article']['caption'], '/article/' . $bilans[0]['Article']['url'] . '.html', array('class' => 'nodeco')); ?>
                </p>
			<?php
            } ?>
        </div>
    </td>
    <td width="33%">
    	<div class="polaroid">
        	<?php
			if(!empty($focus)) {
			?>
				<?php echo $html->link($html->image('show/' . $focus[0]['Show']['menu'] . '_t.jpg'), '/article/' . $focus[0]['Article']['url'] . '.html', array('escape' => false)); ?>
				<p class="polaroid-title">
				<?php echo $html->link($focus[0]['Show']['name'], '/article/' . $focus[0]['Article']['url'] . '.html', array('class' => 'nodeco')); ?>
                </p>
			<?php
            } ?>
        </div>
    </td>
    </tr>
    <tr>
    	<td>
        	<?php
			if(!empty($portraits)) {
				echo '<ul class="play">';
				foreach($portraits as $i => $portrait) { if ($i != 0) {?>
        		<li><?php echo $html->link($portrait['Role']['name'], '/article/' . $portrait['Article']['url'] . '.html', array('class' => 'nodeco')); ?></li>
             <?php
				} }
				echo '</ul>';
				?>
				<p class="padl25"><?php echo $html->link('<span>Tous les portraits</span>', '/portraits', array('class' => 'button', 'escape' => false)); ?></p>
                <?php
			} 
			?>
        </td>
        <td>
        	<?php
			if(!empty($bilans)) {
				echo '<ul class="play">';
				foreach($bilans as $i => $bilan) { if ($i != 0) {?>
        		<li><?php echo $html->link($bilan['Show']['name'] . ' ' . $bilan['Article']['caption'], '/article/' . $bilan['Article']['url'] . '.html', array('class' => 'nodeco')); ?></li>
             <?php
				} }
				echo '</ul>';
				?>
				<p class="padl25"><?php echo $html->link('<span>Tous les bilans</span>', '/bilans', array('class' => 'button', 'escape' => false)); ?></p>
                <?php
			} 
			?>
        </td>
        <td>
        	<?php
			if(!empty($focus)) {
				echo '<ul class="play">';
				foreach($focus as $i => $focu) { if ($i != 0) {?>
        		<li><?php echo $html->link($focu['Show']['name'], '/article/' . $focu['Article']['url'] . '.html', array('class' => 'nodeco')); ?></li>
             <?php
				} }
				echo '</ul>';
				?>
				<p class="padl25"><?php echo $html->link('<span>Tous les focus</span>', '/focus', array('class' => 'button', 'escape' => false)); ?></p>
                <?php
			} 
			?>
        </td>
    </tr>
    </table>
 </div>
