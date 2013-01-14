	 <?php $this->pageTitle = 'Profil de ' . $user['User']['login']; 
	 echo $html->meta('description', $user['User']['login'] . ' utilise Série-All pour créer sa collection de séries, noter les épisodes et être prévenu de la sortie de ses séries favorites.', array('type'=>'description'), false);
     ?>

    <div id="col1">
    	<div class="padl10">
      
        		<h1 class="dblue title"><?php echo $user['User']['login']; ?> &raquo; Notes</h1>
            <?php echo $this->element('profil-menu'); ?>
        	  
            <h2 class="title dblue">Récapitulatif des notes</h2>
            
            <?php
            // Calcul du récapitualtif des notes
            if (!empty($user['Rate'])) {
              
              $recap = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
              foreach($user['Rate'] as $j => $rate) {
                $recap[$rate['name']] += 1;
              }
                    
            require_once "app/vendors/chart/pchart2/class/pData.class.php";
            require_once "app/vendors/chart/pchart2/class/pDraw.class.php";
            require_once "app/vendors/chart/pchart2/class/pImage.class.php";
            
            $myData = new pData();
            $myData->addPoints($recap,"Serie1");
            $myData->setSerieDescription("Serie1","Nombre de notes");
            $myData->setSerieOnAxis("Serie1",0);
            
            // $myData->loadPalette("files/pchart/navy.color", TRUE);
            
            $myData->setAbscissa("Absissa");
            
            $myData->setAxisPosition(0,AXIS_POSITION_LEFT);
            $myData->setAxisName(0,"");
            $myData->setAxisUnit(0,"");
            
            $myPicture = new pImage(690,200,$myData,TRUE);
            $myPicture->setGraphArea(20,20,635,180);
            $myPicture->setFontProperties(array("R"=>168,"G"=>168,"B"=>168,"FontName"=>"Fonts/pchart/pf_arma_five.ttf","FontSize"=>6));
            
            $Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
            , "Mode"=>SCALE_MODE_START0
            , "LabelingMethod"=>LABELING_ALL
            , "GridR"=>255, "GridG"=>255, "GridB"=>255, "GridAlpha"=>50, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50, "LabelRotation"=>0, "CycleBackground"=>1, "DrawXLines"=>1, "DrawSubTicks"=>1, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50, "DrawYLines"=>ALL);
            $myPicture->drawScale($Settings);
            
            $Config = array("DisplayValues"=>1, "Gradient"=>0, "AroundZero"=>0);
            $myPicture->drawBarChart($Config);
            
            $Config = array("FontR"=>0, "FontG"=>0, "FontB"=>0, "FontName"=>"Fonts/pchart/Forgotte.ttf", "FontSize"=>6, "Margin"=>6, "Alpha"=>30, "BoxSize"=>5, "Style"=>LEGEND_NOBORDER
            , "Mode"=>LEGEND_HORIZONTAL
            );
            $myPicture->drawLegend(545,25,$Config);
            
            $myPicture->Render("img/users/notes-" . $user['User']['id'] . ".png");
            echo $html->image('users/notes-' . $user['User']['id'] .'.png');
            
            } else {
            ?>	
              <p>Vous n'avez pas encore noté d'épisodes.</p>
            <?php }?>
            <br  /><br /><br />
            
            <h2 class="title dblue">Moyennes détaillées par série</h2><br />
           	<p class="profil-sort"><?php echo $html->image('v2/sort.png', array('alt' => 'tri', 'class' => 'absmiddle')); ?> 
            Trier par : 
			<?php echo $ajax->link('moyenne', array('controller' => 'users', 'action' => 'sortRates', $user['User']['id'], 'moyenne'), array( 'update' => 'sortnotes')); ?> -
            <?php echo $ajax->link('série', array('controller' => 'users', 'action' => 'sortRates', $user['User']['id'], 'serie'), array( 'update' => 'sortnotes')); ?> -
            <?php echo $ajax->link('nombre de notes', array('controller' => 'users', 'action' => 'sortRates', $user['User']['id'], 'nombre'), array( 'update' => 'sortnotes')); ?>
            
            </p>
            <div id="sortnotes">
                 <ul class="profil-notes">
                      <?php 
                      if(!empty($moyennes)) {
                          foreach ($moyennes as $moyenneshow) {
                              echo '<li><div id="show' . $moyenneshow['Show']['id'] . '">' . 
							  $ajax->link($html->image('icons/folder.png', array('class' => '', 'border' => 0, 'alt'=> 'o')), array('controller' => 'users', 'action' => 'developShow', $user['User']['id'], $moyenneshow['Show']['id'], round($moyenneshow['0']['Moyenne'], 2), $moyenneshow['0']['Somme']), array('update' => 'show' . $moyenneshow['Show']['id'], 'escape' => false)) . ' ' . 
							  $html->link($moyenneshow['Show']['name'], '/serie/' . $moyenneshow['Show']['menu'], array('class' => 'nodeco'));
                              echo ': <span class="lblue">' . round($moyenneshow['0']['Moyenne'], 2) . '</span> de moyenne et '. $moyenneshow['0']['Somme'] . ' notes </div></li>' ;
                          }
                      }
                      ?>
                 </ul>
             </div>
    	</div>
    </div>
    
    <?php echo $this->element('profil-sidebar'); ?>