	<div id="col2">
    	<ul class="path">
        	<li class="start"><?php echo $html->link('Liste des membres', '/membres', array('class' => 'nodeco')); ?></li>
            <li><?php echo $html->link($user['User']['login'], '/profil/' . $user['User']['login'], array('class' => 'nodeco')); ?></li>
        </ul>
        <br /><br />
        <div id="colright-moyennes">
            <div class="colrmoyennes-header"></div>
            <div class="colr-content">
            	<table width="100%">
                <tr>
                <td width="40%">
            	<div class="bg-star">
                    <h3 class="white">Moyenne</h3> <br />
                    <span class="white staring">
                    <?php
										// Calcul de la moyenne
										if (!empty($user['Rate'])) {
											$total = 0;
											foreach($user['Rate'] as $j => $rate) {
												$total += $rate['name'];
											}
											$nb = $j+1;
											$moyenne = $total / $nb;
										}
						
										if (!empty($user['Rate'])) {
											echo round($moyenne, 2);
                        echo '<br /></span>';
                        echo $star->convert($moyenne);
                        echo '<br /><span class="white">';
                        echo count($user['Rate']); ?>
                        note<?php if (count($user['Rate']) > 1) echo 's'; ?></span>
                        <?php
                     } else {
                         echo ' - </span> <span class="white"><br /> Aucune note</span>';
                     } ?> 
                </div>
                </td>
                <td width="60%">
                	<div class="resume-avis">
										<?php   
                     $pourcentages_avis = array(0, 0, 0);
                     foreach($aviscount as $avis) {
                      switch($avis['Comment']['thumb']) {
                      case 'up':
                        $pourcentages_avis[0] = $avis['0']['Somme'];
                        break;
                      case 'neutral':
                        $pourcentages_avis[2] = $avis['0']['Somme'];
                        break;
                      case 'down':
                        $pourcentages_avis[1] = $avis['0']['Somme'];
                        break;
                      }
                     }
                    $total_comments = $pourcentages_avis[0] + $pourcentages_avis[1] + $pourcentages_avis[2]; ?>
                      <p><?php  echo $total_comments; ?> avis au total :</p>
                    <table width="100%" class="avis">
                      <tr>
                          <td class="up" width="100%"><?php echo $star->thumb('up'); ?> favorables<br /><?php echo $pourcentages_avis[0]; ?> avis</td>
                      </tr>
                      <tr>
                          <td class="neutral" width="100%"><?php echo $star->thumb('neutral'); ?> neutres<br /><?php echo $pourcentages_avis[2];?> avis</td>
                      </tr>
                      <tr>
                          <td class="down" width="100"><?php echo $star->thumb('down'); ?> défavorables<br /><?php echo $pourcentages_avis[1]; ?> avis</td>
                      </tr>
                      </table>
                  </div>
               </div>
                </td>
                </tr>
                </table>
            </div>
            <div class="colr-footer"></div>
        </div>
       
       <br />
       <?php /* if($cat != 'avis') { ?>
    	<iframe src="http://www.facebook.com/plugins/likebox.php?id=105365559504009&amp;width=305&amp;connections=15&amp;stream=false&amp;header=true&amp;height=375" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:305px; height:375px; padding-left:5px;" allowTransparency="true"></iframe>
      <?php } */?>
        
    </div>
