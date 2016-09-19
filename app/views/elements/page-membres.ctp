			<?php 
			$paginator->options(array('url' => $this->passedArgs)); 
			$paginator->options(array('update' => 'membres-table', 'indicator' => 'spinner'));
			?>
            
            <?php
			if (!empty($users)) {
			?>
			<table class="data">
            <tr>
            	<th width="20%">Membre</th>
                <th width="15%">Statut</th>
                <th width="18%">Rang</th>
                <th width="7%">Moyenne</th>
                <th width="5%">Notes</th>
                <th width="5%">Avis</th>
                <th width="20%">Inscrit le</th>
            </tr>
            <?php
            foreach ($users as $user) { 
			?>
            <tr>
            	<td><?php if($user['User']['role'] < 4) echo '<strong class="blue">' . $html->link($user['User']['login'], '/profil/' . $user['User']['login'], array('class' => 'decoblue')) . '</strong>'; else echo $html->link($user['User']['login'], '/profil/' . $user['User']['login'], array('class' => 'nodeco')); ?></td>
                <td><?php if($user['User']['role'] < 4) echo '<span class="blue">' . $star->role($user['User']['role']) . '</span>'; else echo $star->role($user['User']['role']); ?></td>
                <?php
				// Calcul de la moyenne
				$moyenne = 0;
                if(!empty($user['Rate'])) {
					$total = 0;
					foreach($user['Rate'] as $j => $rat) {
						$total += $rat['name'];
					}
					$nb = $j+1;
					$moyenne = $total / $nb;
				} 
				?>
                <td><?php if(!empty($user['Rate'])) echo $star->rang($moyenne, count($user['Rate'])); else echo '<span class="grey">Aucun</span>'; ?></td>
                <td><strong class="red"><?php echo round($moyenne,2); ?></strong></td>
                <td><?php echo count($user['Rate']); ?></td>
                <td><?php echo count($user['Comment']); ?></td>
                <td><?php $timestamp = strtotime($user['User']['created']);	e(strftime("%d %B %Y", $timestamp)); ?></td>
            </tr>
            <?php
			} 
			?>
            </table>
            <?php
			} 
			?>

            <div class="pagination">
            <br />
            <?php echo $paginator->prev('« Plus récents ', null, null, array('class' => 'disabled')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $paginator->numbers(); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $paginator->next(' Plus anciens »', null, null, array('class' => 'disabled')); ?> 
            <br /><br />
            <?php echo $paginator->counter(array('format' => '%current% membres affichés sur %count% membres au total')); ?>
            </div>