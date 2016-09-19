	 <?php $this->pageTitle = 'Avis - Profil de ' . $user['User']['login']; 
	 echo $html->meta('description', $user['User']['login'] . ' utilise Série-All pour créer sa collection de séries, noter les épisodes et être prévenu de la sortie de ses séries favorites.', array('type'=>'description'), false);
     ?>
     
     <?php 
	 		echo $javascript->link('easySlider1.7', false); 
	 		echo $javascript->link('perso.profil.avis', false); 
	 		?> 

    <div id="col1">
    	<div class="padl10">
      
        		<h1 class="dblue title"><?php echo $user['User']['login']; ?> &raquo; Avis</h1>
            <?php echo $this->element('profil-menu'); ?>
        	  
            <h2 class="title dblue">Récapitulatif des avis</h2>
            <br />
            <?php   
						$pourcentages = array(0, 0, 0);
						$realpourcentages = array(0,0,0);
						foreach($aviscount as $avis) {
						switch($avis['Comment']['thumb']) {
						case 'up':
							$pourcentages[0] = $avis['0']['Somme'];
							break;
						case 'neutral':
							$pourcentages[2] = $avis['0']['Somme'];
							break;
						case 'down':
							$pourcentages[1] = $avis['0']['Somme'];
							break;
						}
						}
						
						
						require_once "app/vendors/chart/pchart2/class/pData.class.php";
						require_once "app/vendors/chart/pchart2/class/pDraw.class.php";
						require_once "app/vendors/chart/pchart2/class/pPie.class.php";
						require_once "app/vendors/chart/pchart2/class/pImage.class.php";
						
						/* Create and populate the pData object */
						$MyData = new pData();   
						$MyData->addPoints($pourcentages,"ScoreA");  
						$MyData->setSerieDescription("ScoreA","Application A");
						
						/* Define the absissa serie */
						$MyData->addPoints(array("Favorables","Neutres","Défavorables"),"Labels");
						$MyData->setAbscissa("Labels");
						
						/* Create the pChart object */
						$myPicture = new pImage(240,180,$MyData,TRUE);
						
						/* Set the default font properties */ 
						$myPicture->setFontProperties(array("FontName"=>"Fonts/pchart/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
						
						/* Create the pPie object */ 
						$PieChart = new pPie($myPicture,$MyData);
						
						/* Enable shadow computing */ 
						$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
						
						/* Draw a splitted pie chart */ 
						$PieChart->draw3DPie(120,90,array("Radius"=>100,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));
						
						/* Write the legend box */ 
						$myPicture->setFontProperties(array("FontName"=>"Fonts/pchart/Silkscreen.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
						//$PieChart->drawPieLegend(140,160,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
						
						/* Render the picture (choose the best way) */
						//$myPicture->autoOutput("pictures/example.draw3DPie.transparent.png");
						$myPicture->Render("img/users/avis-" . $user['User']['id'] . ".png");
						echo $html->image('users/avis-' . $user['User']['id'] .'.png', array('alt' => 'graphique avis', 'class' => 'graph-avis'));
						
						$totalavis = $pourcentages[0] + $pourcentages[1] + $pourcentages[2];
						$realpourcentages[0] = round($pourcentages[0]/$totalavis *100);
						$realpourcentages[1] = round($pourcentages[1]/$totalavis *100);
						$realpourcentages[2] = round($pourcentages[2]/$totalavis *100);
						?>
            
            <ul class="recap-avis">
            	<li><?php echo $html->image('v2/legend_avis_up.png', array('alt' => '', 'class' => 'absmiddle')) . ' ' . $realpourcentages[0]; ?>% d'avis <?php echo $star->thumb('up'); ?> <span class="up"><?php echo $star->avis('up'); ?></span></li>
                <li><?php echo $html->image('v2/legend_avis_neutral.png', array('alt' => '', 'class' => 'absmiddle')). ' ' . $realpourcentages[2]; ?>% d'avis <?php echo $star->thumb('neutral'); ?> <span class="neutral"><?php echo $star->avis('neutral'); ?> </span></li>
                <li><?php echo $html->image('v2/legend_avis_down.png', array('alt' => '', 'class' => 'absmiddle')). ' ' . $realpourcentages[1]; ?>% d'avis <?php echo $star->thumb('down'); ?> <span class="down"><?php echo $star->avis('down'); ?></span></li>
            </ul>
						<div class="spacer"></div>
            
            
            
            
            <!-- avis séries --> 
            <h2 class="title dblue">Avis sur des séries <span class="grey">(<?php echo $avisshowcount; ?>)</span></h2><br />
            <table class="avis-sort-shows avis-sort"> 
            <tr>
            <td class="avis-sort-title lblue"><?php echo $html->image('v2/sort.png', array('alt' => 'Trier par', 'class' => 'absmiddle')); ?>  Filtre :</td>
            <td>
            <ul id="filter-menu">
            <li><a href="#">par avis <?php echo $html->image('icons/menu_avis_down.png', array('alt' => 'v', 'class' => 'absmiddle')); ?></a>
                <ul>
                    <li><?php echo $ajax->link('favorables', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'fav'), array('class' => 'up', 'escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('neutres', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'neu'), array('class' => 'neutral', 'escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('défavorables', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'def'), array('class' => 'down', 'escape' => false, 'update' => 'avisshows')); ?></li>
                      <li class="bottom"></li>
                </ul>
              </li>
              <li><a href="#">par date <?php echo $html->image('icons/menu_avis_down.png', array('alt' => 'v', 'class' => 'absmiddle')); ?></a> 
                <ul>
                    <li><?php echo $ajax->link('les + récentes', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'new'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('les + anciennes', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'old'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li class="bottom"></li>
                  </ul>
              </li>
              <li class="solo"><?php echo $ajax->link('moyenne globale', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'moy'), array('escape' => false, 'update' => 'avisshows')); ?></li>
              <!--
              <li><a href="#">nationalité <?php echo $html->image('icons/menu_avis_down.png', array('alt' => 'v', 'class' => 'absmiddle')); ?></a> 
                <ul>
                    <li><?php echo $ajax->link('américaine', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('française', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('anglaise', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li class="bottom"></li>
                  </ul>
              </li>
              
              <li><a href="#">chaîne US <?php echo $html->image('icons/menu_avis_down.png', array('alt' => 'v', 'class' => 'absmiddle')); ?></a>
                <ul>
                    <li><?php echo $ajax->link('HBO', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('Showtime', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('ABC', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('NBC', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('Fox', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('AMC', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('FX', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('CW', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li class="bottom"></li>
                      </ul>
              </li>
              <li><a href="#">chaîne FR <?php echo $html->image('icons/menu_avis_down.png', array('alt' => 'v', 'class' => 'absmiddle')); ?></a>
                <ul>        
                      <li><?php echo $ajax->link('Canal+', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('TF1', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('M6', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('France TV', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li><?php echo $ajax->link('Arte', array('controller' => 'users', 'action' => 'filtershowComments'), array('escape' => false, 'update' => 'avisshows')); ?></li>
                      <li class="bottom"></li>
                  </ul>
              </li>
              -->
              <li class="solo"><?php echo $ajax->link('derniers', array('controller' => 'users', 'action' => 'filtershowComments', $user['User']['id'], 'last'), array('escape' => false, 'update' => 'avisshows')); ?></li>
            </ul>
            </td>
            </tr>
            </table>
            <br />
            <div id="spinner"></div>
            
            <?php if(!empty($lastavisshow)) { ?>
            <div id="avisshows" class="<?php if(count($lastavisshow) < 4) echo 'avisshows-half'; else echo 'avisshows-full'; ?>">
            <?php } ?>
            
            <strong>Derniers avis</strong><br /><br />
            
            <?php 
						if (!empty($lastavisshow)) {
						echo '<ul><li>';
						foreach($lastavisshow as $i => $comment) {
							if ($i==3) echo '<div class="spacer"></div>';
							if ((($i%6) == 0) && $i != 0) echo '</li><li>';
							?>
							<div class="avis-show">
							<?php echo $html->link($html->image('show/' . $comment['Show']['menu'] . '_w.jpg', array('width' => 210, 'height' => 101, 'alt' => $comment['Show']['name'], 'class' => 'avis-show-img border-'.  $comment['Comment']['thumb'])) . '<div class="avis-show-title"><div class="text">voir la fiche série<br /><h3>' . $comment['Show']['name'] . '</h3></div></div>', '/serie/'. $comment['Show']['menu'], array('class' => 'avis-show-link', 'escape' => false)); ?>
              <div class="thumb-<?php echo $comment['Comment']['thumb']; ?>"><?php echo $star->thumb($comment['Comment']['thumb']); ?> <?php echo $star->avis($comment['Comment']['thumb']); ?></div>
              <div class="avis-show-text">
								<?php echo $html->link($text->truncate(ucfirst($comment['Comment']['text']), 150, array('ending'=> '...', 'exact' => false)), '/serie/' . $comment['Show']['menu'] . '#avis-serie', array('escape' => false, 'class' => 'avis-read-text-link')); ?>  

								<div id="avis-<?php echo $user['User']['login'].'-'.$comment['Comment']['id']; ?>" style="display:none;">
								  		<fieldset><legend>L'avis de <?php echo $user['User']['login'] ?></legend>
								  		
								  		<div class="article">
								  		  <?php echo nl2br($comment['Comment']['text']); ?>
								  		</div>
								  		</fieldset>
								</div>

								
								<?php /* echo $html->link("&raquo; Lire l'avis", '/avis/' . $user['User']['login'] . '/' . $comment['Comment']['id'], array('escape' => false, 'class' => 'avis-read-link')); */ ?>
								<?php echo $html->link("&raquo; Lire l'avis", '#avis-' . $user['User']['login'].'-'.$comment['Comment']['id'], array('class' => 'avis-read-link', 'escape' => false, 'rel' => 'facebox')); ?>
								</div>
							</div>  
							<?php
							}
							echo '</li></ul>';
					 	}  
					 	?>
             </ul>
             </div>
             <div class="spacer"></div>
             <br /><br />
             
             <!-- avis saisons --> 
             <h2 class="title dblue">Avis sur des saisons <span class="grey">(<?php echo $avisseasoncount; ?>)</span></h2>
             <table class="avis-sort-seasons avis-sort">
             <tr>
             <td class="avis-sort-title lblue"><?php echo $html->image('v2/sort.png', array('alt' => 'Trier par', 'class' => 'absmiddle')); ?>  Filtre :</td>
             <td>
             <ul id="filter-menu">
             	 <li><a href="#">par avis <?php echo $html->image('icons/menu_avis_down.png', array('alt' => 'v', 'class' => 'absmiddle')); ?></a>
                	<ul>
                    	<li><?php echo $ajax->link('favorables', array('controller' => 'users', 'action' => 'filterseasonComments', $user['User']['id'], 'fav'), array('class' => 'up', 'escape' => false, 'update' => 'avisseasons')); ?></li>
                        <li><?php echo $ajax->link('neutres', array('controller' => 'users', 'action' => 'filterseasonComments', $user['User']['id'], 'neu'), array('class' => 'neutral', 'escape' => false, 'update' => 'avisseasons')); ?></li>
                        <li><?php echo $ajax->link('défavorables', array('controller' => 'users', 'action' => 'filterseasonComments', $user['User']['id'], 'def'), array('class' => 'down', 'escape' => false, 'update' => 'avisseasons')); ?></li>
                        <li class="bottom"></li>
                	</ul>
                </li>
                <li class="solo"><?php echo $ajax->link('derniers', array('controller' => 'users', 'action' => 'filterseasonComments', $user['User']['id'], 'last'), array('escape' => false, 'update' => 'avisseasons')); ?></li>
             </ul>
             </td>
             </tr>
             </table>
             <br />
             <div id="avisseasons">
             <strong>Derniers avis</strong><br /><br />
             <?php if(!empty($lastavisseason)) {
							echo '<ul><li>';
							foreach($lastavisseason as $i => $comment) {
								if($i==3) echo '<div class="spacer"></div>';
								if((($i%6) == 0) && $i != 0) echo '</li><li>';
								?>
								<div class="avis-season">
								<?php echo $html->link($html->image('show/' . $comment['Show']['menu'] . '_t.jpg', array('width' => 100, 'height' => 100, 'alt' => $comment['Show']['name'], 'class' => 'avis-season-img border-'.  $comment['Comment']['thumb'])) . '<div class="avis-season-title"><h4>' . $comment['Show']['name'] . '</h4></div>', '/serie/'. $comment['Show']['menu'], array('class' => 'avis-season-link', 'escape' => false)); ?>
                    <div class="thumb-<?php echo $comment['Comment']['thumb']; ?>"><?php echo $star->thumb($comment['Comment']['thumb']); ?></div>
                    <span class="avis-season-name-<?php echo $comment['Comment']['thumb']; ?>"><?php echo $html->link('Saison ' . $comment['Season']['name'], '/saison/' . $comment['Show']['menu'] . '/' . $comment['Season']['name']); ?></span>
                    <div class="avis-season-text"><?php echo $text->truncate(ucfirst($comment['Comment']['text']), 80, array('ending'=> '...', 'exact' => false)); ?> </div>

					<div id="avis-<?php echo $user['User']['login'].'-'.$comment['Comment']['id']; ?>" style="display:none;">
								  		<fieldset><legend>L'avis de <?php echo $user['User']['login'] ?></legend>
								  		
								  		<div class="article">
								  		  <?php echo nl2br($comment['Comment']['text']); ?>
								  		</div>
								  		</fieldset>
								</div>

								<?php echo $html->link("&raquo; Lire l'avis", '#avis-' . $user['User']['login'].'-'.$comment['Comment']['id'], array('class' => 'avis-read-link', 'escape' => false, 'rel' => 'facebox')); ?>

                </div>  
								<?php
                }	
								echo '</li></ul>';		 
			 				} ?>
             </div>
             <div class="spacer"></div>
             <br /><br />
             
             <!-- avis épisodes --> 
             <h2 class="title dblue">Avis sur des épisodes <span class="grey">(<?php echo $avisepisodecount; ?>)</span></h2>
             
             <br /> 
				<p style="color: #cccccc;">Coming soon...</p>
			<br /> <br />
            
            
    	</div>
    </div>
    
    <?php echo $this->element('profil-sidebar'); ?>
