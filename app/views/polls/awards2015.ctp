	<?php $this->pageTitle = 'Série-All Awards - Election des meilleurs séries de 2015'; 
    echo $html->meta('description', 'Participez à l\'élection des meilleurs séries, acteurs, nouveautés de 2014 et des pires...', array('type'=>'description'), false); 
	?>
    

		<div class="padl15 padr15 article">
        	
            <h1 class="title red">Série-All Awards 2015</h1>
			<br />
			<?php echo $this->element('partage-reseau-sociaux'); ?>
			<br />
            <p>
            	Pour contrer les taux d'abstention indécents du premier tour des dernières régionales, l’équipe de Série-All a décidé de réitérer en 2015 votre moment préféré de l’année&nbsp;: les Série-All Awards !
                <br /><br />
                Pour cette quatrième édition, le principe est resté le même (on ne change pas une équipe qui… euh… qui ne perd pas trop) : les rédacteurs du site se sont <del>battus comme des chiens</del> concertés de manière civilisée et courtoise pour vous proposer des candidats dans chacune des catégories.
            
            <br /><br />
		Maintenant que la liste est établie, c’est à vous de voter pour vos chouchous. Quelques rappels des règles :
            <ul>
           		<li>il faut <a href="/inscription">être inscrit</a> pour participer <em>(environ 30 secondes si on est Steve Jobs, environ 1h30 si on est ma Mamie Paulette),</em>
                <li>les votes sont ouverts jusqu’au 31 janvier 2016, 20h00,</li>
                <li>les nominés ont été choisis sur l’année 2015 (toutes les séries ayant eu au moins un épisode diffusé en 2015),</li>
                <li>vous pouvez changer vos votes à tout moment en choisissant un autre candidat,</li>
                <li>vous pouvez nous faire part de vos remarques (ou nous faire des bisous sur le cul) sur <a href="http://serieall.fr/article/votez-pour-les-serie-all-awards-2015_a3557.html">cet article</a>, dans les commentaires.</li>
            </ul><br />
            </p>
            <p>
            	<b>Les votes sont clos, les résultats seront annoncés prochainement.</b>
            </p>
            <br /><br />
            
			<?php 			
			foreach($polls['Question'] as $i => $question): ?>
                <div class="poll">
                    <h3 class="red"><?php echo $question['name']; ?></h3><br /><br />
                    
                    <?php foreach($question['Answer'] as $j => $answer):
                    // images
					if (!empty($answer['img'])) {
						//echo $ajax->link($html->image($answer['img'], array('class' => 'answer-img')), array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false));
						echo $html->image($answer['img'], array('class' => 'answer-img'));
					}
                    endforeach; 
					?>   
					
                    <br /><br />
                    
                    <ul class="answers-poll">
                    <?php foreach($question['Answer'] as $j => $answer): ?>
                    	<li>
                        <?php echo $html->image('icons/checkbox.png', array('class' => 'absmiddle')); ?>
                        <?php if($answer['winner'] == 1) echo '<strong>' . $answer['name'] . '</strong>'; else echo $answer['name'];
												echo '<span class="grey"> (' . $answer['porcent'] . '%)</span>';
												
												//echo $ajax->link($answer['name'], array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false, 'class' => 'nodeco')); ?>
						
                        <div id="answer<?php echo $answer['id']; ?>" class="answers-vote"></div>
						</li>
                    <?php endforeach; 
					if(!empty($votes)){
						if(count($votes)>0){
							if($votes[0]['Question']['id']==$question[id]){
								echo "<p>Mon vote : ".$votes[0]['Answer']['name']."</p>";
								$votes = array_splice($votes,1);
							}
						}
					}?>    
                    </ul>
                    <br /><br />
                </div>
            <?php endforeach; ?>    
            
        </div>



