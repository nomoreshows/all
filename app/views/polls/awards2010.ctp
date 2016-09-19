	<?php $this->pageTitle = 'Série-All Awards - Election des meilleurs séries de 2010'; 
    echo $html->meta('description', 'Participez à l\'élection des meilleurs séries, acteurs, nouveautés de 2010 et des pires...', array('type'=>'description'), false); 
	?>
    
	<div id="col1">  
		<div class="padl20 article">
        	<br />
            <h1 class="title red">Série-All Awards 2010</h1>
            <br /><br />
            <p>Sans prétention aucune, nous faisons aussi nos propres awards sur Série-All. Le principe est simple, les nominés ont été selectionnés par nos rédacteurs au cours d'une immense bataille sur un Google Docs. Il ne reste plus qu'à élire le vainqueur pour chaque catégorie, et c'est à vous d'y participer !
            
            <br /><br />
            <!-- <strong>Quelques règles :</strong>
            <ul>
           		<li>il faut <a href="/inscription">être inscrit</a> pour participer <em>(cela ne prend que 30 secondes, même pas de confirmation par mail)</em>.
                <li>les votes sont ouverts jusqu'au 23 janvier</li>
                <li>vous pouvez changer votre vote à tout moment en choisissant un autre nominé.</li>
                <li>les nominés ont été choisi sur l'année 2010 (toutes saisons ayant commencées après le 1er janvier 2010)</li>
                <li>vous pouvez nous faire part de vos remarques sur <a href="http://serieall.fr/article/votez-serieall-awards_a932.html">cet article</a>, dans les commentaires.</li>
                <li>...</li>
                <li>ah et dernière chose, il faut cliquer sur les vignettes pour voter.</li>
            </ul>
            -->
            <strong>Les votes sont clos.</strong>
            </p>
            <br /><br />
            
			<?php foreach($polls['Question'] as $i => $question): ?>
                <div class="poll">
                    <h3 class="red"><?php echo $question['name']; ?></h3><br /><br />
                    
                    <?php foreach($question['Answer'] as $j => $answer):
                    // images
					if (!empty($answer['img'])) {
						// echo $ajax->link($html->image($answer['img'], array('class' => 'answer-img')), array('controller' => 'votes','action' => 'add', $answer['id'], $question['id'], $polls['Poll']['id'], $session->read('Auth.User.id')), array('update' => 'answer' . $answer['id'], 'escape' => false));
						 echo $html->image($answer['img'], array('class' => 'answer-img'));
					}
                    endforeach; ?>    
                    <br /><br />
                    
                    <ul class="answers-poll">
                    <?php foreach($question['Answer'] as $j => $answer): ?>
                    	<li>
                        <?php echo $html->image('icons/checkbox.png', array('class' => 'absmiddle')); ?>
                        <?php if($answer['winner'] == 1) echo '<strong>' . $answer['name'] . '</strong>'; else echo $answer['name']; ?>
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

