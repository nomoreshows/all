	<?php $this->pageTitle = 'Série-All Awards - Election des meilleurs séries de 2010'; 
    echo $html->meta('description', 'Participez à l\'élection des meilleurs séries, acteurs, nouveautés de 2010 et des pires...', array('type'=>'description'), false); 
	?>
    
	<div id="col1">  
		<div class="padl20 article">
        	<br />
            <h1 class="title red">Série-All Awards 2011</h1>
            <br /><br />
            <p>
            	L'heure de la deuxième édition des Série-All Awards est arrivée ! Oubliez les Golden Globes et autres Emmy dont on connaît déjà les résultats. 
                <br /><br />
                Le principe reste le même : tous les rédacteurs du site se sont réunis pour choisir 5 nominés dans chacune des catégories.  Ce qui donne lieu à des confrontations assez éclectiques, et tant mieux. 
                <br /><br />Maintenant c'est à vous de voter pour élire le vainqueur de chaque catégorie.
            
            <br /><br />
            <strong>Quelques règles :</strong>
            <ul>
           		<li>il faut <a href="/inscription">être inscrit</a> pour participer <em>(cela ne prend que 30 secondes, même pas de confirmation par mail)</em>.
                <li>les votes sont ouverts jusqu'au 22 janvier</li>
                <li>les nominés ont été choisis sur l'année 2011 (toutes les séries ayant au moins un épisode diffusé en 2011)</li>
                <li>vous pouvez changer votre vote à tout moment en choisissant un autre nominé.</li>
                <!-- <li>vous pouvez nous faire part de vos remarques sur <a href="http://serieall.fr/article/votez-serieall-awards_a932.html">cet article</a>, dans les commentaires.</li> -->
            </ul><br />
             <strong>Les résultats sont disponibles ci-dessous.</strong>
            </p>
            <br /><br />
            
			<?php foreach($polls['Question'] as $i => $question): ?>
                <div class="poll">
                    <h3 class="red"><?php echo $question['name']; ?></h3><br /><br />
                    
                    <?php foreach($question['Answer'] as $j => $answer):
                    // images
					if (!empty($answer['img'])) {
						//echo $ajax->link($html->image($answer['img'], array('class' => 'answer-img')), array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false));
						echo $html->image($answer['img'], array('class' => 'answer-img'));
					}
                    endforeach; ?>    
                    <br /><br />
                    
                    <ul class="answers-poll">
                    <?php foreach($question['Answer'] as $j => $answer): ?>
                    	<li>
                        <?php echo $html->image('icons/checkbox.png', array('class' => 'absmiddle')); ?>
                        <?php if($answer['winner'] == 1) echo '<strong>' . $answer['name'] . '</strong>'; else echo $answer['name'];
		echo '<span class="grey"> (' . $answer['porcent'] . '%)</span>';
												
											//	echo $ajax->link($answer['name'], array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false, 'class' => 'nodeco')); ?>
						
                        <div id="answer<?php echo $answer['id']; ?>" class="answers-vote"></div>
						</li>
                    <?php endforeach; ?>    
                    </ul>
                    <br /><br />
                </div>
            <?php endforeach; ?>    
            
            <?php debug($polls); ?>
        </div>
    </div>
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
    	
		<div id="colright-bup">
            <div class="colrbup-header"></div>
            <div class="colr-content">
            	<?php echo $this->element('pub-sidebar'); ?>
            </div>
            <div class="colr-footer"></div>
        </div>
    </div>

