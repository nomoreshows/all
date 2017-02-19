	<?php $this->pageTitle = 'Série-All Awards - Election des meilleurs séries de 2016';
    echo $html->meta('description', 'Participez à l\'élection des meilleurs séries, acteurs, nouveautés de 2016 et des pires...', array('type'=>'description'), false);
	?>
    

		<div class="padl15 padr15 article">
        	
            <h1 class="title red">Série-All Awards 2016</h1>
			<br />
			<?php echo $this->element('partage-reseau-sociaux'); ?>
			<br />
            <p>

                En 2017, un vote important a lieu. Celui qui déterminera l'avenir de notre communauté. J'ai nommé, bien évidemment, les Série-All Awards, édition 2016.<br /><br />

                Comme d'habitude, nos rédacteurs ont débattu des heures durant, du sang a coulé et des amitiés se sont brisées afin de ne retenir que les meilleurs des meilleurs. C'est maintenant à vous de départager les candidats retenus ! <br /><br />

                Rappel de la démarche à suivre :<br />
                <ul>
                    <li>
                        S'inscrire sur le site. Promis, aucun numéro de carte bleue ne sera demandé.
                    </li>
                    <li>
                        Sélectionner vos préférés sur cette page. Vous pouvez changer de vote à tout moment. Les votes seront clos le samedi 18 février, à 23h59. Les résultats seront annoncés peu après.
                    </li>
                </ul>
            <br />

            Nouveauté de cette année : si vous le souhaitez, pour pouvoir gagner un véritable paquet de Pépitos envoyé chez vous, rendez-vous sur le forum pour faire vos pronostics sur les gagnants des Awards.<br/><br />



                Pour toute question ou remarque, rendez-vous en commentaires de <a href="http://serieall.fr/article/votez-pour-les-serie-all-awards-2016-_a3857.html">cet article</a>.<br />
            </p>
            <p>
            </p>
            <br /><br />
            
			<?php 			
			foreach($polls['Question'] as $i => $question): ?>
                <div class="poll">
                    <h3 class="red"><?php echo $question['name']; ?></h3><br /><br />
                    
                    <?php foreach($question['Answer'] as $j => $answer):
                    // images
					if (!empty($answer['img'])) {
						#echo $ajax->link($html->image($answer['img'], array('class' => 'answer-img')), array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false));
						echo $html->image($answer['img'], array('class' => 'answer-img'));
					}
                    endforeach; 
					?>   
					
                    <br /><br />
                    
                    <ul class="answers-poll">
                    <?php foreach($question['Answer'] as $j => $answer): ?>
                    	<li>
                        <?php echo $html->image('icons/checkbox.png', array('class' => 'absmiddle')); ?>
                          <?php #if($answer['winner'] == 1) echo '<strong>' . $answer['name'] . '</strong>'; else echo $answer['name'];
												#echo '<span class="grey"> (' . $answer['porcent'] . '%)</span>';
                                                echo $answer['name'];
												#echo $ajax->link($answer['name'], array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false, 'class' => 'nodeco')); ?>
						
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



