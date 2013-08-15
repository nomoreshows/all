<?php $this->pageTitle = 'Les nouvelles séries tv de la rentrée 2013'; 
	echo $html->meta('description', "Repérez dès maintenant les nouvelles séries de la rentrée 2013 qui risquent de vous plaîre. ", array('type'=>'description'), false); 
?>

<?php
	echo $javascript->link('jquery.expander', false); 
	echo $javascript->link('perso.rentree2013', false); 
?>

<div id="event">
    <div class="padl15">
    <h1 class="title">Les nouvelles séries de 2013</h1><br /><br />
    <span class="chapo">L'été arrive, et avec lui arrive les nouvelles séries pour la rentrée prochaine. Comme d'habitude l'été et le mois de septembre sont un moment fort pour les séries, c'est pour cela que l'on a répertorié une soixantaine de nouveautés sur cette page. Repérez les prochaines perles et navets grâce à notre indice infaillible (le taux érectile) ainsi que nos avis sur les séries.</span>
    <br /><br /><br />
    
    <h2 class="title dblue">Filtrer les nouveautés</h2><br /><br />
    <table width="100%" style="" class="event-tab">
    <tr>
    <td width="30%">
      <h3 class="dblue">Les catégories Série-All :</h3> <br /><br />
      <ul class="playe lblue">
        <li><?php echo $ajax->link('Les séries les plus prometteuses', array('controller' => 'shows', 'action' => 'rentree2013', 'te'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
        <li><?php echo $ajax->link('Les séries dont on attend pas grand chose', array('controller' => 'shows', 'action' => 'rentree2013', 'te-'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
        <li><?php echo $ajax->link('On vous conseille vivement d\'éviter de les croiser', array('controller' => 'shows', 'action' => 'rentree2013', 'te--'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
        <li><?php echo $ajax->link('Toutes les séries par ordre de diffusion', array('controller' => 'shows', 'action' => 'rentree2013', 'all'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>

      </ul>
    </td>
    <td width="20%">
      <h3 class="dblue">Par genre :</h3> <br /><br />
      <ul class="playe lblue">
        <li><?php echo $ajax->link('Les nouveaux drama', array('controller' => 'shows', 'action' => 'rentree2013', 'drama'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
        <li><?php echo $ajax->link('Les nouvelles comédies', array('controller' => 'shows', 'action' => 'rentree2013', 'comic'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
          <li><?php echo $ajax->link('Les nouvelles séries policières', array('controller' => 'shows', 'action' => 'rentree2013', 'police'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
          <li><?php echo $ajax->link('Les nouvelles séries fantastiques', array('controller' => 'shows', 'action' => 'rentree2013', 'fantas'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
        <ul>
    </td>
    <td width="17%">
      <h3 class="dblue">Par nationalité :</h3> <br /><br />
      <ul class="playe lblue">
        <li><?php echo $ajax->link('Les séries américaines', array('controller' => 'shows', 'action' => 'rentree2013', 'us'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries françaises', array('controller' => 'shows', 'action' => 'rentree2013', 'fr'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries anglaises', array('controller' => 'shows', 'action' => 'rentree2013', 'uk'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries canadiennes', array('controller' => 'shows', 'action' => 'rentree2013', 'ca'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
      </ul>
    </td>
    <td width="33%">
      <h3 class="dblue">Par chaîne :</h3> <br /><br />
      <ul class="playe lblue">
        <li><?php echo $ajax->link('Les séries d\'ABC (Lost, Desperate H., Grey\'s)', array('controller' => 'shows', 'action' => 'rentree2013', 'abc'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries de HBO (Six Feet Under, True Blood)', array('controller' => 'shows', 'action' => 'rentree2013', 'hbo'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries de NBC (Scrubs, Chuck, Community)', array('controller' => 'shows', 'action' => 'rentree2013', 'nbc'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries de CW (Gossip Girl, Vampire Diaries)', array('controller' => 'shows', 'action' => 'rentree2013', 'cw'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries de CBS (NCIS, Mentalist, HIMYM)', array('controller' => 'shows', 'action' => 'rentree2013', 'cbs'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
        <li><?php echo $ajax->link('Les séries de FOX (Fringe, Bones)', array('controller' => 'shows', 'action' => 'rentree2013', 'fox'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li> 
      </ul>
    </td>
    </tr>
    </table>
    
    <div id="listeSerieRentree">
    	<?php echo $this->element('event-rentree2012'); ?>
    </div>
    
    </div>


<!--
<div id="col2">
	<ul class="path">
        <li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
        <li><?php echo $html->link('Rentrée 2012', '/series-rentres-2012-2013', array('class' => 'nodeco')); ?></li>
    </ul>
    <br /><br />

    <div id="colright-informations">
        <div class="colrinfos-header"></div>
        <div class="colr-content">
            <h3 class="dblue">Les catégories Série-All :</h3> <br /><br />
            
            <br />
            <h3 class="dblue">Par genre :</h3> <br /><br />
            
            <br />
            <h3 class="dblue">Par nationalité :</h3> <br /><br />
            
            <h3 class="dblue">Par chaîne :</h3> <br /><br />
            

            <br /><br />
            <ul class="play lblue">
                <li><?php echo $ajax->link('Afficher toutes les séries', array('controller' => 'shows', 'action' => 'rentree2013', 'all'), array('class' => 'decoblue', 'update' => 'listeSerieRentree')); ?></li>
            </ul>
            <br />
        </div>
        <div class="colr-footer"></div>
    </div>
</div>
-->
</div>
