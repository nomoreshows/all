<?php $this->pageTitle = 'Les séries tv de la rentrée 2011'; 
	echo $html->meta('description', "Repérez dès maintenant les nouvelles séries de la rentrée 2011 qui risquent de vous plaîre. ", array('type'=>'description'), false); 
?>

<?php
	echo $javascript->link('jquery.expander', false); 
	echo $javascript->link('perso.eventRentree2011', false); 
?>

<div id="col1">
    <div class="padl15">
    <h1 class="title">La rentrée 2011 en séries</h1><br />
    <span class="subtitle">Repérez dès maintenant les nouvelles séries de la rentrée 2011 qui risquent de vous plaîre. Utilisez les catégories de droite pour filter les séries.</span>
    <br /><br /><br />
    
    <div id="listeSerieRentree">
    	<?php echo $this->element('event-rentree2011'); ?>
    </div>
    
    </div>
</div>

<div id="col2">
	<ul class="path">
        <li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
        <li><?php echo $html->link('Rentrée 2011', '/series-rentres-2011', array('class' => 'nodeco')); ?></li>
    </ul>
    <br /><br />
    <!-- Informations -->
    <div id="colright-informations">
        <div class="colrinfos-header"></div>
        <div class="colr-content">
            <h3 class="dblue">Les catégories Série-All :</h3> <br /><br />
            <ul class="play lblue">
            	<li><?php echo $ajax->link('Les blockbusters', array('controller' => 'shows', 'action' => 'eventRentree2011', 'popular'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les séries qui vont conquérir les critiques', array('controller' => 'shows', 'action' => 'eventRentree2011', 'press'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les séries à regarder (ou subir) avec votre moitié', array('controller' => 'shows', 'action' => 'eventRentree2011', 'girls'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les séries dont on a très peur', array('controller' => 'shows', 'action' => 'eventRentree2011', 'fear'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les séries des anciens de Lost', array('controller' => 'shows', 'action' => 'eventRentree2011', 'lost'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les séries à regarder alcoolisé', array('controller' => 'shows', 'action' => 'eventRentree2011', 'lol'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
            </ul>
            <br />
            <h3 class="dblue">Par genre :</h3> <br /><br />
            <ul class="play lblue">
             	<li><?php echo $ajax->link('Les nouveaux drama', array('controller' => 'shows', 'action' => 'eventRentree2011', 'drama'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
            	<li><?php echo $ajax->link('Les nouvelles comédies', array('controller' => 'shows', 'action' => 'eventRentree2011', 'comic'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les nouvelles séries policières', array('controller' => 'shows', 'action' => 'eventRentree2011', 'police'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
                <li><?php echo $ajax->link('Les nouvelles séries fantastiques', array('controller' => 'shows', 'action' => 'eventRentree2011', 'fantas'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
            </ul>
            <br />
            <h3 class="dblue">Par nationalité :</h3> <br /><br />
            <ul class="play lblue">
                <li><?php echo $ajax->link('Les nouvelles séries de chez nous', array('controller' => 'shows', 'action' => 'eventRentree2011', 'fr'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les nouvelles séries british', array('controller' => 'shows', 'action' => 'eventRentree2011', 'uk'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
            </ul>
            <br />
            <h3 class="dblue">Par chaîne :</h3> <br /><br />
            <ul class="play lblue">
                <li><?php echo $ajax->link('Les séries d\'ABC (Lost, Desperate H., Grey\'s...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'abc'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les séries de HBO (Six Feet Under, True Blood...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'hbo'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les séries de NBC (Scrubs, Chuck, Community...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'nbc'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les séries de CW (Gossip Girl, Vampire Diaries...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'cw'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les séries de Showtime (Dexter, Californication...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'showtime'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les séries de CBS (NCIS, Mentalist, HIMYM...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'cbs'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
                <li><?php echo $ajax->link('Les séries de FOX (Fringe, Bones...)', array('controller' => 'shows', 'action' => 'eventRentree2011', 'fox'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
            </ul>

            <br /><br />
            <ul class="play lblue">
                <li><?php echo $ajax->link('Afficher toutes les séries', array('controller' => 'shows', 'action' => 'eventRentree2011', 'all'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
            </ul>
            <br />
        </div>
        <div class="colr-footer"></div>
    </div>
</div>

