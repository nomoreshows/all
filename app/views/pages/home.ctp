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
 	 <p class="suite">Série All utilise le systême <?php echo $html->link('Gravatar', 'https://fr.gravatar.com'); ?> pour les avatars de ses utilisateurs. <?php echo $html->link('Gravatar', 'https://fr.gravatar.com'); ?> est un site qui permet d'associer votre avatar à votre adresse mail. <br /><br />Ainsi sur n'importe quel site qui utilise <?php echo $html->link('Gravatar', 'https://fr.gravatar.com'); ?>, il suffira de lui indiquer votre adresse mail afin qu'il affiche votre avatar.</p>
    <br />
    <ul class="play">
    	<li>Rendez-vous sur <?php echo $html->link('cette page', 'https://fr.gravatar.com/site/signup', array('target' => '_blank', 'class' => 'decoblue')); ?> pour créér votre compte Gravatar</li>
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
					<?php 
						//Test si l'image pour la serie existe 
						$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
						if(file_exists(APP.'webroot/img/show/'.$article['Show']['menu'].'_w.jpg')){
							//image de la serie existe
							$nomImgSerie = $article['Show']['menu'];
						}
						echo $html->image(('show/' . $nomImgSerie . '_w.jpg'), array('alt' => $article['Show']['menu'])); 
					?>
                <?php } ?>
                <div class="panel-overlay">
                  <h2 class="red">
				  	<?php 
					if (strlen($article['Article']['name']) < 30 and strlen($article['Episode']['name']) < 20) {
				  		echo $html->link($article['Article']['name'] . ' - ' . $article['Episode']['name'], '/article/'. $article['Article']['url'] . '.html',array('onClick'=>"_gaq.push(['_trackEvent', 'Carrousel', 'Link', '".$article['Article']['name']."'])")); 
					} else {
						echo $html->link($article['Article']['name'], '/article/'. $article['Article']['url'] . '.html',array('onClick'=>"_gaq.push(['_trackEvent', 'Carrousel', 'Link', '".$article['Article']['name']."'])")); 
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
                	<?php 
						//Test si l'image pour la serie existe 
						$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
						if(file_exists(APP.'webroot/img/show/'.$article['Show']['menu'].'_w.jpg')){
							//image de la serie existe
							$nomImgSerie = $article['Show']['menu'];
						}
						echo $html->image(('show/' . $nomImgSerie . '_w.jpg'), array('alt' => $article['Show']['menu'])); 
					?>
                <?php } ?>
                <div class="panel-overlay">
                  <h2 class="red">
				  	<?php 
					if (strlen($article['Article']['name']) < 30 and strlen($article['Episode']['name']) < 20) {
				  		echo $html->link($article['Article']['name'] . ' - ' . $article['Episode']['name'], '/article/'. $article['Article']['url'] . '.html', array('onClick'=>"_gaq.push(['_trackEvent', 'Videos', 'Play', 'Baby\'s First Birthday'])")); 
					} else {
						echo $html->link($article['Article']['name'], '/article/'. $article['Article']['url'] . '.html',array('onClick'=>"_gaq.push(['_trackEvent', 'Carrousel', 'Link', '".$article['Article']['name']."'])")); 
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
              	<?php } else {

						//Test si l'image pour la serie existe 
						$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
						if(file_exists(APP.'webroot/img/show/'.$article['Show']['menu'].'_t_serie.jpg')){
							//image de la serie existe
							$nomImgSerie = $article['Show']['menu'];
						}
						echo '<li>';
						echo $html->image(('show/' . $nomImgSerie . '_t_serie.jpg'), array('alt' => $article['Show']['menu'], 'title'=>$article['Article']['caption']));
						echo '</li>'; 
					} 
                
              } 
              foreach($articlesune as $i => $article) {
              	if (empty($article['Show']['menu'])) { ?>
              		<li><img src="img/default-une_t.jpg" title="<?php echo $article['Article']['caption']; ?>" alt="<?php echo $article['Article']['name']; ?>" /></li>
              	<?php } else { 
						//Test si l'image pour la serie existe 
						$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
						if(file_exists(APP.'webroot/img/show/'.$article['Show']['menu'].'_t_serie.jpg')){
							//image de la serie existe
							$nomImgSerie = $article['Show']['menu'];
						}
						echo '<li>';
						echo $html->image(('show/' . $nomImgSerie . '_t_serie.jpg'), array('alt' => $article['Show']['menu'], 'title'=>$article['Article']['caption']));
						echo '</li>'; 
					}
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
				$i = 0;
				foreach ($user['Show'] as $show) {
					if($show['Followedshows']['etat']==1){
						echo '&raquo; ' . $html->link($show['name'], '/serie/' . $show['menu'], array('escape' => false)) . '<br />'; 
						if($i == 6) break;
						$i++;
					}
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
 
 <div id="homeContentLeft">
	 <div id="commuNewHome">
		<h3> 
		<?php echo $html->image('icons/rates.png', array('class' => 'absmiddle')); ?>
        <?php echo $ajax->link('Notes', array('controller' => 'rates', 'action' => 'lastRate'), array( 'update' => 'commuItems')); ?> - 
        <?php echo $html->image('icons/thumb_up.png', array('class' => 'absmiddle')); ?>
        <?php echo $ajax->link('Avis', array('controller' => 'comments', 'action' => 'lastComment', 'avis'), array( 'update' => 'commuItems')); ?> - 
        <?php echo $html->image('icons/comments.png', array('class' => 'absmiddle')); ?>
		<?php echo $ajax->link('Réactions', array('controller' => 'reactions', 'action' => 'lastReaction'), array( 'update' => 'commuItems')); ?>
        
        </h3> 
	
        <div id="commuItems">
            <ul class="play">
            <?php	
            foreach($commuDataToShow as $i => $commu) { 
				if(isset($commu['Rate'])){
				?>
				<li>
					<span class="lblue"><?php echo $commu['Rate']['name']; ?></span> 
					par <?php echo $html->link($commu['User']['login'], '/profil/'. $commu['User']['login'], array('class' => 'nodeco')); ?> 
					-
					<?php 
					echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
					echo ' ';

					// Note d'un épisode
					echo $html->link($commu['Show']['name'] . ' ' . $commu['Season']['name'] . '.' . str_pad($commu['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $commu['Show']['menu'] . '/s' . str_pad($commu['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($commu['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
					?>
				</li>
				<?php
				}else if(isset($commu['Comment'])){

					if(empty($commu['Article']['id'])) {
					?>
						<li class="avisHome">
					
						<div class="imgAvisHome">
							<?php
							//Test si l'image pour la serie existe 
							$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
							if(file_exists(APP.'webroot/img/show/'.$commu['Show']['menu'].'_t_serie.jpg')){
								//image de la serie existe
								$nomImgSerie = $commu['Show']['menu'];
							}
							echo $html->image(('show/' . $nomImgSerie . '_t_serie.jpg'), array('alt' => $commu['Show']['menu'],'class' => 'imgAvisHome')); 
							?>
						</div>
					
						<div>
						<?php echo $html->link($commu['User']['login'], '/profil/'. $commu['User']['login'], array('class' => 'nodeco')); ?> </span> - 
						<?php 
						echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
						echo ' ';
							if (empty($commu['Season']['name']) && empty($commu['Episode']['numero'])) {
								// Avis d'une série
								echo $html->link($commu['Show']['name'], '/serie/' . $commu['Show']['menu'], array('class' => 'decoblue'));
							} elseif(empty($commu['Episode']['numero'])) {
								// Avis d'une saison		
								echo $html->link($commu['Show']['name'] . ' saison ' . $commu['Season']['name'], '/saison/' . $commu['Show']['menu'] . '/' . $commu['Season']['name'], array('class' => 'decoblue'));
							} else {
								// Avis d'un épisode
								echo $html->link($commu['Show']['name'] . ' ' . $commu['Season']['name'] . '.' . str_pad($commu['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $commu['Show']['menu'] . '/s' . str_pad($commu['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($commu['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
							}
							echo ' ' .$star->thumb($commu['Comment']['thumb']); ?> 
							<span class="<?php echo $commu['Comment']['thumb']; ?>"> <?php echo $star->avis($commu['Comment']['thumb']); ?></span> 
							</div>
							
							
						   <?php // Si texte dans l'avis on prépare l'avis en facebox 
						  if (!empty($commu['Comment']['text'])) {
								echo '<div class="txtAvisHome">';
								if($commu['Comment']['spoiler']){
									//Spoiler
									echo "Cet avis contient des spoilers, rendez-vous sur la fiche pour le voir.";
								}else{
									echo $text->truncate(strip_tags($commu['Comment']['text']), '95','...',false);
								}
								
								echo '</div>';
						  }
					
					
					} else { 
					?>
						<li>
							<?php echo $html->link($commu['User']['login'], '/profil/'. $commu['User']['login'], array('class' => 'nodeco')); ?> </span> - 
							<?php 
							echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
							echo ' ';
							//Commentaire
							echo $html->link($text->truncate($commu['Article']['name'], 50, '..', false), '/article/' . $commu['Article']['url'] . '.html', array('class' => 'decoblue'));
					} ?>

                </li>
				<?php
				}else{
						
				?>
				
				<li>
					<span class="red"><?php echo $html->link($commu['User']['login'], '/profil/'. $commu['User']['login'], array('class' => 'nodeco')); ?> </span> - 
					<?php 
					echo $html->image('icons/link.png', array('class' => 'absmiddle', 'alt' => ''));
					echo ' ';
					if (empty($commu['Season']['name']) && empty($commu['Episode']['numero'])) {
							// Avis d'une série
							echo $html->link($commu['Sh']['name'], '/serie/' . $commu['Sh']['menu'], array('class' => 'decoblue'));
						} elseif(empty($commu['Episode']['numero'])) {
							// Avis d'une saison		
							echo $html->link($commu['Sh']['name'] . ' saison ' . $commu['Season']['name'], '/saison/' . $commu['Sh']['menu'] . '/' . $commu['Season']['name'], array('class' => 'decoblue'));
						} else {
							// Avis d'un épisode
							echo $html->link($commu['Sh']['name'] . ' ' . $commu['Season']['name'] . '.' . str_pad($commu['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $commu['Sh']['menu'] . '/s' . str_pad($commu['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($commu['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'decoblue'));
						}
					?>
					<span class="grey">@ <?php echo $commu['User2']['login']; ?></span>
				</li>
				
				<?php
				}
			}?>
            </ul>
        </div>
		
	 </div>
	 
	 <div id="newsVideos">
		<?php
			if (!empty($news)) {
		?>
			<?php
				foreach ($news as $i => $new){
			?>
				<div>
					<h2><?php echo $html->link($new['Article']['name'], '/article/' . $new['Article']['url']. '.html', array('onClick'=>"_gaq.push(['_trackEvent', 'News', 'Link', '".$article['Article']['name']."'])")); ?></h2> <br />
					<div class="textnewsvideos">
						<p class="date"><?php $timestamp = strtotime($new['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> 
						<p class="comments"><?php echo count($new['Comment']); ?> commentaire<?php if(count($new['Comment']) > 1) echo 's'; ?></p>
					</div>
					<?php 
					if (empty($new['Article']['show_id'])) {
						//TODO : corriger miniature 
						echo $html->link($html->image('article/thumb.news.' . $new['Article']['photo'], array('class' => 'imgNewsVideo')), '/article/' . $new['Article']['url'] . '.html', array('escape' => false, 'onClick'=>"_gaq.push(['_trackEvent', 'News', 'Img', '".$article['Article']['name']."'])")); 
					} else {
						//Test si l'image pour la serie existe 
						$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
						if(file_exists(APP.'webroot/img/show/'.$new['Show']['menu'].'_w.jpg')){
							//image de la serie existe
							$nomImgSerie = $new['Show']['menu'];
						}
						echo $html->link($html->image('show/' . $nomImgSerie . '_w.jpg', array('class' => 'imgNewsVideo','alt' => $new['Show']['menu'])), '/article/' . $new['Article']['url'] . '.html', array('escape' => false,'onClick'=>"_gaq.push(['_trackEvent', 'News', 'Img', '".$article['Article']['name']."'])")); 
					}
					?>
				</div>
				<br />
			<?php
				}
			?>
		<?php
			}
			echo '<div class="buttonAllNewsVideos">';
			echo $html->link('<span>Toutes les news</span>', '/actualite', array('escape' => false, 'class' => 'button'));
			echo $html->link('<span>Toutes les vidéos</span>', '/videos-trailers', array('escape' => false, 'class' => 'button'));
			echo "</div>";
		?>
	 </div>
	  
		<div id="classements"></div>
		
		<table width="100%" class="classement">
		<tr>
			<td>
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
					if ($compteur == 1){
						//Test si l'image pour la serie existe 
						$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
						if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w_serie.jpg')){
							//image de la serie existe
							$nomImgSerie = $show['Show']['menu'];
						}
						echo $html->link($html->image('show/' . $nomImgSerie . '_w_serie.jpg', array('class' => 'img-class','alt' => $article['Show']['menu'], 'border' => 0)),
							'/serie/' . $show['Show']['menu'], array('escape' => false)); 
					}
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
			<td>
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
						if ($compteur == 1){
							//Test si l'image pour la serie existe 
							$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
							if(file_exists(APP.'webroot/img/show/'.$season['Show']['menu'].'_w_serie.jpg')){
								//image de la serie existe
								$nomImgSerie = $season['Show']['menu'];
							}
							echo $html->link($html->image('show/' . $nomImgSerie . '_w_serie.jpg', array('class' => 'img-class','alt' => $season['Show']['menu'], 'border' => 0)),
								'/serie/' . $season['Show']['menu'], array('escape' => false)); 
						}
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
						if ($compteur == 1){
							//Test si l'image pour la serie existe 
							$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
							if(file_exists(APP.'webroot/img/show/'.$episode['Season']['Show']['menu'].'_w_serie.jpg')){
								//image de la serie existe
								$nomImgSerie = $episode['Season']['Show']['menu'];
							}
							echo $html->link($html->image('show/' . $nomImgSerie . '_w_serie.jpg', array('class' => 'img-class','alt' => $episode['Season']['Show']['menu'], 'border' => 0)),
								'/serie/' . $episode['Season']['Show']['menu'], array('escape' => false)); 
						}
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
		</table>
	</div>
  <div id="articles">
	<?php
		if (!empty($articles)) {
			foreach ($articles as $i => $article) {
		?>
			<div class="onenews">
				<h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html',array('onClick'=>"_gaq.push(['_trackEvent', 'Articles', 'Link', '".$article['Article']['name']."'])")); ?></h2> <br />
				<?php 
				if (empty($article['Article']['show_id'])) {
					echo $html->link($html->image('article/thumb.news.' . $article['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false,'onClick'=>"_gaq.push(['_trackEvent', 'Articles', 'Img', '".$article['Article']['name']."'])")); 
				} else {
					//Test si l'image pour la serie existe 
					$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
					if(file_exists(APP.'webroot/img/show/'.$article['Show']['menu'].'_t.jpg')){
						//image de la serie existe
						$nomImgSerie = $article['Show']['menu'];
					}
					echo $html->link($html->image('show/' . $nomImgSerie . '_t.jpg', array('class' => 'imgleft imgnews','alt' => $article['Show']['menu'])), '/article/' . $article['Article']['url'] . '.html', array('escape' => false, 'onClick'=>"_gaq.push(['_trackEvent', 'Articles', 'Img', '".$article['Article']['name']."'])")); 
				}
				?>
				<div class="textnews">
					<p class="date"><?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($article['Comment']); ?> commentaire<?php if(count($article['Comment']) > 1) echo 's'; ?></p>
					<p class="text"><?php echo $text->truncate($article['Article']['chapo'], 200, ' ...', false); ?></p>
				</div>
			</div>
			
		<?php
			}
		}
		?>
		<br class="spacer"/>
		<br class="spacer"/>
		<table class="buttonAllArticle">
			<tr>
				<td><?php echo $html->link('<span>Toutes les critiques</span>', '/critiques', array('escape' => false, 'class' => 'button'));?></td>
				<td><?php echo $html->link('<span>Tous les focus</span>', '/focus', array('escape' => false, 'class' => 'button'));?></td>
			</tr>
			<tr>
				<td><?php echo $html->link('<span>Tous les dossiers</span>', '/dossiers', array('escape' => false, 'class' => 'button'));?></td>
				<td><?php echo $html->link('<span>Tous les bilans</span>', '/bilans', array('escape' => false, 'class' => 'button'));?></td>
			</tr>
		</table>
 </div>
