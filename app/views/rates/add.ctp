	
    <table width="100%">
    <tr>
    <td>
        <!-- Moyenne -->
        <div class="bg-star">
            <h3 class="white">Moyenne</h3> <br />
            <span class="white staring">
            <?php
               if (!empty($episode['Episode']['moyenne'])) {
				  echo $episode['Episode']['moyenne'];
				  echo '<br /></span>';
				  echo $star->convert($episode['Episode']['moyenne']);
				  echo '<br /><span class="white">';
				  echo count($rates); ?>
				  note<?php if (count($rates) > 1) echo 's'; ?></span>
				  <?php
			   } else {
				   echo ' - </span> <span class="white"><br /> Aucune note</span>';
			   } ?> 
        </div>
    </td>
    <td width="180">
        <!-- Dernières notes -->
        <h3 class="red">Dernières notes :</h3>
        <?php
        if (!empty($rates)) {
            echo '<ul class="play">';
            foreach($rates as $j => $rate) {
                if ($j < 3 ) 
                    echo '<li>' . $rate['Rate']['name'] . ' par ' . $html->link($rate['User']['login'], '/profil/'. $rate['User']['login'], array('class' => 'nodeco')) . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<br />Pas encore de notes.<br /><br />';
        }
        ?>
        
        <br /><br />
        <!-- Votre note -->
		<?php
        if(!empty($result))
                echo '<strong>' . $result . '</strong>';
            else
                echo '<strong>Aucune note choisie.</strong>';
        ?>
    </td>
    </tr>
    </table>
    
    
    
