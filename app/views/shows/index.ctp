	<?php $this->pageTitle = 'Toutes les séries TV - US / Américaines, Anglaises, Francaises ...'; 
    echo $html->meta('description', 'Liste de toutes les séries TV classées par date, genre, nationalité, format ...', array('type'=>'description'), false); 
	?>
    
	<div id="col1">
    	<div id="all-series"><h1>Toutes les séries TV</h1></div>
		<div id="lettres" class="padl20">
			<h3 class="red">Afficher les séries commençant par :</h3><br /><br />
        <?php
			echo $ajax->link($html->image('lettres/9.png'), array('controller' => 'shows','action' => 'sortLetters', '2'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/a.png'), array('controller' => 'shows','action' => 'sortLetters', 'a'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/b.png'), array('controller' => 'shows','action' => 'sortLetters', 'b'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/c.png'), array('controller' => 'shows','action' => 'sortLetters', 'c'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/d.png'), array('controller' => 'shows','action' => 'sortLetters', 'd'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/e.png'), array('controller' => 'shows','action' => 'sortLetters', 'e'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/f.png'), array('controller' => 'shows','action' => 'sortLetters', 'f'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/g.png'), array('controller' => 'shows','action' => 'sortLetters', 'g'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/h.png'), array('controller' => 'shows','action' => 'sortLetters', 'h'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/i.png'), array('controller' => 'shows','action' => 'sortLetters', 'i'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/j.png'), array('controller' => 'shows','action' => 'sortLetters', 'j'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/k.png'), array('controller' => 'shows','action' => 'sortLetters', 'k'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/l.png'), array('controller' => 'shows','action' => 'sortLetters', 'l'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/m.png'), array('controller' => 'shows','action' => 'sortLetters', 'm'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/n.png'), array('controller' => 'shows','action' => 'sortLetters', 'n'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/o.png'), array('controller' => 'shows','action' => 'sortLetters', 'o'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/p.png'), array('controller' => 'shows','action' => 'sortLetters', 'p'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/q.png'), array('controller' => 'shows','action' => 'sortLetters', 'q'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/r.png'), array('controller' => 'shows','action' => 'sortLetters', 'r'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/s.png'), array('controller' => 'shows','action' => 'sortLetters', 's'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/t.png'), array('controller' => 'shows','action' => 'sortLetters', 't'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/u.png'), array('controller' => 'shows','action' => 'sortLetters', 'u'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/v.png'), array('controller' => 'shows','action' => 'sortLetters', 'v'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/w.png'), array('controller' => 'shows','action' => 'sortLetters', 'w'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/x.png'), array('controller' => 'shows','action' => 'sortLetters', 'x'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/y.png'), array('controller' => 'shows','action' => 'sortLetters', 'y'), array('update' => 'liste-serie', 'escape' => false));
			echo $ajax->link($html->image('lettres/z.png'), array('controller' => 'shows','action' => 'sortLetters', 'z'), array('update' => 'liste-serie', 'escape' => false));
				?>
		</div>
        <div id="liste-serie">
			<?php foreach($series as $i => $serie): ?>
            <div class="serie">
                <div class="serie-infos">
                    <h2><?php echo $html->link($serie['Show']['name'], '/serie/' . $serie['Show']['menu'], array('class' => 'nodeco')); ?></h2> 
                    <?php if (strlen($serie['Show']['name']) < 23) echo '<br />'; else echo '-'; ?>
                    <span class="grey">
                    <?php echo count($serie['Season']);
                    if (count($serie['Season']) == 1) {
                        echo ' saison'; 
                    } else { 
                        echo ' saisons'; 
                    } ?>
                    </span>
                </div>
                <?php echo $html->link($html->image(('show/' . $serie['Show']['menu'] . '_w_serie.jpg'), array('alt' => '', 'width' => '139')), '/serie/' .$serie['Show']['menu'], array('class' => 'nodeco', 'escape' => false)); ?>
            </div>
            <?php endforeach; ?>
        </div>    

    </div>
    
    <div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des séries', '/series-tv', array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
    	<!-- Informations -->
    	<div id="colright-informations">
            <div class="colrinfos-header"></div>
            <div class="colr-content">
            	<h3 class="red">Trier par</h3> 
    			<?php echo $ajax->form('sortCat', 'post', array('model' => 'Show', 'action' => 'sortCat', 'update' => 'liste-serie')); ?>
                <table width="100%">
                <tr>
                <td width="150">
				<?php echo $form->input('cat', array('type' => 'select', 'class' => 'combo', 'empty' => '-- choisir --', 'div' => false, 'label' => false, 'options' => array('genre' => 'Genre', 'annee' => 'Année', 'nationalite' => 'Nationalité', 'chaineus' => 'Chaîne étrangère (US, UK...)', 'chainefr' => 'Chaîne française', 'format' => 'Format'))); 
				?>
				</td>
				<td><?php echo $form->end('Valider'); ?>
                </td>
                </tr>
                </table>
                <br />
                <h3 class="red">Séries les plus populaires</h3> <br /><br />
                <ul class="play">
                	<?php foreach($popularseries as $show) {
						echo '<li>'. $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')) . ' <span class="grey">(' . $show['Show']['annee'] . ')</span></li>';
					}
					?>
                </ul>
                 
                <h3 class="red">Dernières séries ajoutées</h3> <br /><br />
                <ul class="play">
                	<?php foreach($lastseries as $show) {
						echo '<li>'. $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')) . ' <span class="grey">(' . $show['Show']['annee'] . ')</span></li>';
					}
					?>
                </ul>
        	</div>
            <div class="colr-footer"></div>
        </div>
		
		
    </div>

