	 <?php $this->pageTitle = 'Profil de ' . $user['User']['login']; 
	 echo $html->meta('description', $user['User']['login'] . ' utilise Série-All pour créer sa collection de séries, noter les épisodes et être prévenu de la sortie de ses séries favorites.', array('type'=>'description'), false);
     ?>
    
     
    <div id="col1">
    	<div class="padl10">
        		
            <h1 class="red title">Profil de <?php echo $user['User']['login']; ?></h1>
            <?php echo $this->element('profil-menu');

						// Calcul de la moyenne
						if (!empty($user['Rate'])) {
							$total = 0;
							foreach($user['Rate'] as $j => $rate) {
								$total += $rate['name'];
							}
							$nb = $j+1;
							$moyenne = $total / $nb;
						}
            
						// durée devant les séries
						if (!empty($moyennes)) { 
							$minutes = 0;
							$nbepi = 0;
							foreach ($moyennes as $dureeshow) {
								$minutes += $dureeshow['Show']['format'] * $dureeshow['0']['Somme'];
								$nbepi += $dureeshow['0']['Somme'];
							}
						}
						
						// pourcentage de séries finies / abandon / suivies
						$total_shows = $finishedshows + $followedshows + $pausedshows + $abortedshows;
						if($total_shows != 0) {
							$porcent_aborted = round(($abortedshows / $total_shows)*100);
							$porcent_finished = round(($finishedshows / $total_shows)*100);
							$porcent_actual = round((($followedshows + $pausedshows) / $total_shows)*100);
						} else {
							$porcent_aborted = 0;
							$porcent_finished = 0;
							$porcent_actual = 0;
						}
						
						// nombre d'avis
						// $total_comments = $aviscount['0']['0']['Somme'] + $aviscount['1']['0']['Somme'] + $aviscount['2']['0']['Somme'];
						?>
            
            
            <h2 class="title dblue">Statistiques</h2>
            <ul class="statistiques">
            		<!-- <li><strong><?php echo $user['User']['points']; ?> points <span class="lblue mark">(?)</span></strong> <?php echo $total_shows; ?> séries dans le profil, <?php echo count($user['Rate']); ?> notes, <?php echo $total_comments; ?> avis, <?php echo $articlescount; ?> articles, <?php // echo count($abonnes); ?> abonnés</li> -->
                <li><strong><?php echo displayDuration($minutes*60); ?></strong> de passés devant des séries tv</li>
                <li><strong><?php echo $total_shows; ?> séries renseignées </strong> <span class="red"><?php echo $porcent_aborted; ?>%</span> de séries abandonnées, <span class="green"><?php echo $porcent_finished; ?>%</span> de séries finies</span>, <span class="lblue"><?php echo $porcent_actual; ?>%</span> de séries en cours</span></li>
                <li><strong><?php echo count($moyennes); ?> séries différentes notées</strong></li>
                <li><strong><?php echo count($user['Rate']); ?> notes</strong> au total</li>
                <li><strong class="lblue"><?php if(!empty($user['Rate'])) echo $star->rang($moyenne, count($user['Rate']) ); ?></strong></li>
            </ul>
            
            <br />

            
           
        </div>
    </div>
    
    
    <?php echo $this->element('profil-sidebar'); ?>