	 <?php 
	 $this->pageTitle = 'Classement des séries TV par séries, saisons et épisodes'; 
	 echo $html->meta('description', "Classement des séries TV : les meilleures séries, meilleurs saisons, meilleurs épisodes... ainsi que les pires séries, pires saisons, pires épisodes.", array('type'=>'description'), false); 
	 ?>
     
     <script type="text/javascript">
		$(function() {
			$(".tabs").tabs();
		});
	</script>
    
    <div id="col1">
      <div class="padl10">
          <h1 class="red title">Classements des séries TV</h1>
          <br /><br />
          
          <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Meilleures séries</a></li>
                <li><a href="#tabs-2">Par la rédac</a></li>
                <li><a href="#tabs-3">Par pays</a></li>
                <li><a href="#tabs-4">Par catégorie</a></li>
                <li><a href="#tabs-5">Meilleures chaines</a></li>
            </ul>
            
            <div id="tabs-1">
            <table width="100%" class="profil classements">
                <tr>
                    <td width="45%">
                    <br />
                    <div id="topseries"></div>
                    <?php
                     if(!empty($bestseries)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestseries as $i => $show) {
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo $show['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
								$up = 0; $neutral = 0; $down = 0;
								foreach($show['Comment'] as $comment) {
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                     <td width="55%">
                     <br />
                     <div id="flopseries"></div>
                      <?php
                     if(!empty($flopseries)) {
                        echo '<ul class="class">';
						$compteur = 0;
                        foreach($flopseries as $i => $serie) {
                                    
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$serie['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $serie['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							
							if ($compteur > 3)
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-top'));
								
							?>
							- <span class="red"><?php echo $serie['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
							$up = 0; $neutral = 0; $down = 0;
							foreach($serie['Comment'] as $comment) {
								if ($comment['thumb'] == 'up') {
									$up += 1;
								} elseif ($comment['thumb'] == 'neutral') {
									$neutral += 1;
								} elseif ($comment['thumb'] == 'down') {
									$down += 1;
								}
							}
							if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
							if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
							if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
							?></span></li> <?php
                        }
                        echo '</ul>';
                    }
                    ?>
                     </td>
                  </tr>
                                  <tr>
                    <td width="45%">
                    <br />
                    <div id="topsaisons"></div>
                    <br /><br /><br /><br />
                    <?php
                     if(!empty($bestsaisons)) {
                        echo '<ul class="class">';
                       	$compteur = 0;
						foreach($bestsaisons as $i => $season) {

								$compteur++;
								if ($compteur == 1) {
									//Test si l'image pour la serie existe 
									$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
									if(file_exists(APP.'webroot/img/show/'.$season['Show']['menu'].'_w.jpg')){
										//image de la serie existe
										$nomImgSerie = $season['Show']['menu'];
									}
									echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
								}
								?>
								<li>
								<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
								
								if ($compteur > 3)
									echo $html->link($season['Show']['name'] . ' s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $season['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco classement-mid'));
								elseif ($compteur > 10)
									echo $html->link($season['Show']['name'] . ' s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $season['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco classement-bot'));
								else 
									echo $html->link($season['Show']['name'] . ' s' . str_pad($season['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $season['Show']['menu'] . '/' . $season['Season']['name'], array('class' => 'nodeco classement-top'));
									
								 ?>
								- <span class="red"><?php echo $season['Season']['moyenne'] . '</span>&nbsp;&nbsp;'; 
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                     <td width="55%">
                     <br />
                     <div id="flopsaisons"></div>
                    <br /><br /><br /><br />
                     <?php
                     if(!empty($flopsaisons)) {
                        echo '<ul class="class">';
                        $compteur = 0;
                        
                        foreach($flopsaisons as $i => $saison) {
                                
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$saison['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $saison['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							
							if ($compteur > 3)
									echo $html->link($saison['Show']['name'] . ' s' . str_pad($saison['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $saison['Show']['menu'] . '/' . $saison['Season']['name'], array('class' => 'nodeco classement-mid'));
								elseif ($compteur > 10)
									echo $html->link($saison['Show']['name'] . ' s' . str_pad($saison['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $saison['Show']['menu'] . '/' . $saison['Season']['name'], array('class' => 'nodeco classement-bot'));
								else 
									echo $html->link($saison['Show']['name'] . ' s' . str_pad($saison['Season']['name'], 2, 0, STR_PAD_LEFT), '/saison/' . $saison['Show']['menu'] . '/' . $saison['Season']['name'], array('class' => 'nodeco classement-top'));
									
							?>
							- <span class="red"><?php echo $saison['Season']['moyenne'] . '</span>&nbsp;&nbsp;'; 
							$up = 0; $neutral = 0; $down = 0;
							foreach($saison['Comment'] as $comment) {
								if ($comment['thumb'] == 'up') {
									$up += 1;
								} elseif ($comment['thumb'] == 'neutral') {
									$neutral += 1;
								} elseif ($comment['thumb'] == 'down') {
									$down += 1;
								}
							}
							if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
							if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
							if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
							?></span></li> <?php
                        }
                        echo '</ul>';
                    }
                    ?>
                     </td>
                </tr>
                 <tr>
                    <td width="45%">
                    <br />
                    <div id="topepisodes"></div>
                    <br /><br /><br /><br />
                    <?php
                    if(!empty($bestepisodes)) {
                        echo '<ul class="class">';
                        $compteur = 0;
						foreach($bestepisodes as $i => $episode) {
								$compteur++;
								
								if ($compteur == 1) {
									//Test si l'image pour la serie existe 
									$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
									if(file_exists(APP.'webroot/img/show/'.$episode['Season']['Show']['menu'].'_w.jpg')){
										//image de la serie existe
										$nomImgSerie = $episode['Season']['Show']['menu'];
									}
									echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
								}
								?>
								<li>
								<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
								
								if ($compteur > 3)
									echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco classement-mid'));
								elseif ($compteur > 10)
									echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco classement-bot'));
								else 
									echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco classement-top'));
								
								?>
								- <span class="red"><?php echo $episode['Episode']['moyenne'] . '</span>&nbsp;&nbsp;'; 
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
								if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
								if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    } 
                    ?>
                    </td>
                    <td width="55%">
                    <br />
                     <div id="flopepisodes"></div>
                    <br /><br /><br /><br />
                    <?php
                    if(!empty($flopepisodes)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($flopepisodes as $i => $episode) {
								$compteur++;
								if ($compteur == 1) {
									//Test si l'image pour la serie existe 
									$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
									if(file_exists(APP.'webroot/img/show/'.$episode['Season']['Show']['menu'].'_w.jpg')){
										//image de la serie existe
										$nomImgSerie = $episode['Season']['Show']['menu'];
									}
									echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
								}
								
								?>
								<li>
								<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
								<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
								
								if ($compteur > 3)
									echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco classement-mid'));
								elseif ($compteur > 10)
									echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco classement-bot'));
								else 
									echo $html->link($episode['Season']['Show']['name'] . ' ' . $episode['Season']['name'] . '.' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), '/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT), array('class' => 'nodeco classement-top'));
									?>
								- <span class="red"><?php echo $episode['Episode']['moyenne'] . '</span>&nbsp;&nbsp;'; 
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
								if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
								if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
								?></span></li> <?php
						}
                        echo '</ul>';
                    } 
                    ?>
                    </td>
                </tr>
                </table>
           	</div>
            
            <div id="tabs-2">
            <table width="100%" class="profil classements">
                <tr>
                    <td width="45%">
                    <br />
                    <div id="topseries"></div>
                    <?php
                     if(!empty($topredac)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($topredac as $i => $show) {
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo round($show['0']['Moyenne'], 2) . '</span>'; 
							?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                     <td width="55%">
                     <br />
                     <div id="flopseries"></div>
                      <?php
                     if(!empty($flopredac)) {
                        echo '<ul class="class">';
						$compteur = 0;
                        foreach($flopredac as $i => $show) {
                                    
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top'));
								
							?>
							- <span class="red"><?php echo round($show['0']['Moyenne'], 2) . '</span>';
							?></span></li> <?php
                        }
                        echo '</ul>';
                    }
                    ?>
                     </td>
                  </tr>
                </table>
           	</div>
            
            <div id="tabs-3">
            <table width="100%" class="profil classements">
                <tr>
                    <td width="45%">
                    <br />
                    <div id="topseriesus"></div>
                    <?php
                     if(!empty($bestseriesus)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestseriesus as $i => $show) {
							$compteur++;
							
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo $show['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
								$up = 0; $neutral = 0; $down = 0;
								foreach($show['Comment'] as $comment) {
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                     <td width="55%">
                     <br />
                     <div id="topseriesfr"></div>
                      <?php
                     if(!empty($bestseriesfr)) {
                        echo '<ul class="class">';
						$compteur = 0;
                        foreach($bestseriesfr as $i => $serie) {
                                    
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$serie['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $serie['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							
							if ($compteur > 3)
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-top'));
								
							?>
							- <span class="red"><?php echo $serie['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
							$up = 0; $neutral = 0; $down = 0;
							foreach($serie['Comment'] as $comment) {
								if ($comment['thumb'] == 'up') {
									$up += 1;
								} elseif ($comment['thumb'] == 'neutral') {
									$neutral += 1;
								} elseif ($comment['thumb'] == 'down') {
									$down += 1;
								}
							}
							if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
							if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
							if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
							?></span></li> <?php
                        }
                        echo '</ul>';
                    }
                    ?>
                     </td>
                  </tr>
                <tr>
                    <td width="45%">
                    <br />
                    <div id="topseriesuk"></div>
                    <?php
                     if(!empty($bestseriesuk)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestseriesuk as $i => $show) {
							$compteur++;
							
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo $show['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
								$up = 0; $neutral = 0; $down = 0;
								foreach($show['Comment'] as $comment) {
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                    <td width="55%">
                    </td>
                </tr>
                </table>
            </div>
            
            <div id="tabs-4">
            <table width="100%" class="profil classements">
                <tr>
                    <td width="45%">
                    <br />
                    <div id="topseriesdrama"></div>
                    <?php
                     if(!empty($bestseriesdrama)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestseriesdrama as $i => $show) {
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo $show['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
								$up = 0; $neutral = 0; $down = 0;
								foreach($show['Comment'] as $comment) {
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                     <td width="55%">
                     <br />
                     <div id="topseriescomedie"></div>
                      <?php
                     if(!empty($bestseriescomedie)) {
                        echo '<ul class="class">';
						$compteur = 0;
                        foreach($bestseriescomedie as $i => $serie) {
                                    
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$serie['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $serie['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							
							if ($compteur > 3)
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco classement-top'));
								
							?>
							- <span class="red"><?php echo $serie['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
							$up = 0; $neutral = 0; $down = 0;
							foreach($serie['Comment'] as $comment) {
								if ($comment['thumb'] == 'up') {
									$up += 1;
								} elseif ($comment['thumb'] == 'neutral') {
									$neutral += 1;
								} elseif ($comment['thumb'] == 'down') {
									$down += 1;
								}
							}
							if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>&nbsp;';
							if ($neutral != 0) echo $star->thumb('neutral') . '<span class="neutral" style="padding:0 3px;">x' . $neutral . '</span>&nbsp;';
							if ($up != 0) echo $star->thumb('up') . '<span class="up" style="padding:0 3px;">x' . $up . '</span>&nbsp;';
							?></span></li> <?php
                        }
                        echo '</ul>';
                    }
                    ?>
                     </td>
                  </tr>
                <tr>
                    <td width="45%">
                    <br />
                    <div id="topseriessf"></div>
                    <?php
                     if(!empty($bestseriessf)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestseriessf as $i => $show) {
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo $show['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
								$up = 0; $neutral = 0; $down = 0;
								foreach($show['Comment'] as $comment) {
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                    <td width="55%">
                    <br />
                    <div id="topseriespolice"></div>
                    <?php
                     if(!empty($bestseriespolice)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestseriespolice as $i => $show) {
							$compteur++;
							if ($compteur == 1) {
								//Test si l'image pour la serie existe 
								$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
								if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
									//image de la serie existe
									$nomImgSerie = $show['Show']['menu'];
								}
								echo $html->link($html->image('show/' . $nomImgSerie  . '_w.jpg', array('class' => 'img-class classement-img', 'border' => 0)), '/serie/' . $show['Show']['menu'], array('escape' => false, 'width' => 250)); 
							}
							
							?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-mid'));
							elseif ($compteur > 10)
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-bot'));
							else 
								echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco classement-top')); ?>
                            
                            - <span class="red"><?php echo $show['Show']['moyenne'] . '</span>&nbsp;&nbsp;'; 
								$up = 0; $neutral = 0; $down = 0;
								foreach($show['Comment'] as $comment) {
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
								if ($down != 0) echo $star->thumb('down') . '<span class="down" style="padding:0 3px;">x' . $down . '</span>';
								?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                </tr>
                </table>
            </div>
            
            <div id="tabs-5">
           	<table>
            	<tr>
                    <td width="45%">
                    <br />
                    <div id="topchannels"></div>
                    <?php
                     if(!empty($bestchannels)) {
                        echo '<ul class="class">';
                        $compteur = 0;
			
						foreach($bestchannels as $i => $channel) {
							$compteur++;
							if ($compteur == 1) echo $html->image('channels/' . strtolower($channel['Show']['chaineus']) . '.jpg', array('class' => 'img-class classement-img', 'border' => 0));	?>
							<li>
							<?php if ($compteur == 1) echo $html->image('icons/medal_gold.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 2) echo $html->image('icons/medal_silver.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur == 3) echo $html->image('icons/medal_bronze.png', array('class' => 'absmiddle')) . ' '; ?>
							<?php if ($compteur > 3) echo '&nbsp;&nbsp;<span class="grey">'. $compteur . '.</span> ';
							if ($compteur > 3)
								echo '<span class="classement-mid">' . $channel['Show']['chaineus'] . '</span>';
							elseif ($compteur > 10)
								echo '<span class="classement-bot">' . $channel['Show']['chaineus'] . '</span>';
							else 
								echo '<span class="classement-top">' . $channel['Show']['chaineus'] . '</span>'; ?>
                            
                            - <span class="red"><?php echo round($channel['0']['Moyenne'], 2) . '</span>&nbsp;&nbsp;'; 
							?></span></li> <?php
						}
                        echo '</ul>';
                    }
                    ?>
                    </td>
                    <td width="55%">
                   </td>
                </tr>
                </table>
            </div>
         </div>
         
           
     </div>
    </div>
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
        <!-- Informations -->
    	<div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
                <br />
                <h3 class="red">Séries les plus populaires</h3> <br /><br />
                <ul class="play">
                	<?php foreach($popularseries as $show) {
						echo '<li>'. $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')) . ' <span class="grey">(' . $show['Show']['annee'] . ')</span></li>';
					}
					?>
                </ul>
                <br /> 
                <h3 class="red">Dernières séries ajoutées</h3> <br /><br />
                <ul class="play">
                	<?php foreach($lastseries as $show) {
						echo '<li>'. $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')) . ' <span class="grey">(' . $show['Show']['annee'] . ')</span></li>';
					}
					?>
                </ul>
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
