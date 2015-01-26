	<?php $this->pageTitle = 'Série-All Awards - Election des meilleurs séries de 2014'; 
    echo $html->meta('description', 'Participez à l\'élection des meilleurs séries, acteurs, nouveautés de 2014 et des pires...', array('type'=>'description'), false); 
	?>
    

		<div class="padl15 padr15 article">
        	
            <h1 class="title red">Série-All Awards 2014</h1>
			<br />
			<?php echo $this->element('partage-reseau-sociaux'); ?>
			<br />
            <p>
            	Après deux années d'absences, ils sont de retour pour une troisième édition ! Oubliez les Golden Globes et autres Emmy dont on connaît déjà les résultats, revoici les Serieall Awards !
                <br /><br />
                Le principe est simple : les rédacteurs du site se sont concertés pour vous proposer des candidats dans chacune de nos catégories (ce qui a donné lieu à des confrontations assez éclectiques, et tant mieux). 
                <br /><br />Maintenant c'est à vous de voter pour élire le vainqueur de chaque catégorie !
            
            <br /><br />
            <strong>Quelques règles :</strong>
            <ul>
           		<li>il faut <a href="/inscription">être inscrit</a> pour participer <em>(cela ne prend que 30 secondes)</em>.
                <li>les votes sont ouverts jusqu'au 26 janvier, 12h00</li>
                <li>les nominés ont été choisis sur l'année 2014 (toutes les séries ayant au moins un épisode diffusé en 2014)</li>
                <li>vous pouvez changer votre vote à tout moment en choisissant un autre candidat.</li>
                <li>vous pouvez nous faire part de vos remarques sur <a href="http://serieall.fr/article/votez-pour-les-serieall-awards-2014_a3346">cet article</a>, dans les commentaires.</li>
            </ul><br />
             <strong>Les votes sont clos, les résultats seront bientôt diffusés.</strong>
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
            
            <?php debug($polls); ?>
        </div>



