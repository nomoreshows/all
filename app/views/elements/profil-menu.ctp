						
            <ul class="profile-menu">
            	<li><?php if($cat == 'accueil') 
					echo $html->link('<span>Accueil</span>', '/profil/' . $user['User']['login'], array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Accueil</span>', '/profil/' . $user['User']['login'], array('escape' => false)); ?>
                </li>
                <li><?php if($cat == 'avis') 
					echo $html->link('<span>Avis</span>', '/profil/' . $user['User']['login'] . '/avis', array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Avis</span>', '/profil/' . $user['User']['login'] . '/avis', array('escape' => false)); ?>
                </li>
                <li><?php if($cat == 'notes') 
					echo $html->link('<span>Notes</span>', '/profil/' . $user['User']['login'] . '/notes', array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Notes</span>', '/profil/' . $user['User']['login'] . '/notes', array('escape' => false)); ?>
                </li>
                <li><?php if($cat == 'series') 
					echo $html->link('<span>Séries</span>', '/profil/' . $user['User']['login'] . '/series', array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Séries</span>', '/profil/' . $user['User']['login'] . '/series', array('escape' => false)); ?>
                </li>
                <li><?php if($cat == 'classements') 
					echo $html->link('<span>Classements</span>', '/profil/' . $user['User']['login'] . '/classements', array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Classements</span>', '/profil/' . $user['User']['login'] . '/classements', array('escape' => false)); ?>
                </li>
                <?php 
				// uniquement pour l'user logged
				if($session->read('Auth.User.id') == $user['User']['id']) { ?>
                <li><?php if($cat == 'notifications') 
					echo $html->link('<span>Notifications</span>', '/profil/' . $user['User']['login'] . '/notifications', array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Notifications</span>', '/profil/' . $user['User']['login'] . '/notifications', array('escape' => false)); ?>
                </li>
                <li><?php if($cat == 'parametres') 
					echo $html->link('<span>Paramètres</span>', '/profil/' . $user['User']['login'] . '/parametres', array('escape' => false, 'class' => 'current')); else
					echo $html->link('<span>Paramètres</span>', '/profil/' . $user['User']['login'] . '/parametres', array('escape' => false)); ?>
                </li>
                <?php }?>
            </ul><br /><br />
            
            
            <?php $profil = true; ?>
            
            <table class="presentation">
                    <tr>
                    <td rowspan="2" class="avatar-td">
                        <div class="bg-avatar">
                            <?php echo $html->link($gravatar->image($user['User']['email'], 53, array('alt' => $user['User']['login'], 'class' => 'ppic'), false), '/profil/'. $user['User']['login'], array('escape' => false));  ?> 
                        </div>
                    </td>
                    <td class="dotted">
                    	<?php
												if($profil) {
													if (!empty($user['User']['sex'])) echo ucfirst($user['User']['sex']);
													if (!empty($user['User']['birthdate']) && $user['User']['birthdate'] != '0000-00-00' && $user['User']['birthdate'] != '2012-01-01') echo '<br />' . getAge($user['User']['birthdate']) . ' ans';
												} else {
													?>
                        	<h2 class="dblue title"><?php echo $html->link($user['User']['login'], '/profil/' . $user['User']['login']); ?></h2> <?php 
                        } ?>
                    </td>
                    <td rowspan="2" class="status-td">
                        <div class="status">
                        	<?php 
													if ($session->read('Auth.User.id') == $user['User']['id']) {
														 if ($session->read('Auth.User.suspended') == 1) {
															echo '<span class="red">'. $session->read('Auth.User.message') . '</span><br /><br />';
														}
														?>
														<blockquote class="edito" id="<?php echo $user['User']['id']; ?>"><?php if (!empty($user['User']['edito'])) echo $text->truncate($user['User']['edito'], 200, '...', false); else echo 'Votre édito est vide, cliquez sur ce texte pour le modifier. Parlez de vous, de vos dernières découvertes ou du dernier épisode de Plus Belle La Vie. Ou changez le rien que pour ne plus voir cet horrible message.'; ?></blockquote>
													<?php } else { ?>
														<blockquote><?php if (!empty($user['User']['edito'])) echo $text->truncate($user['User']['edito'], 200, '...', false); else echo $user['User']['login'] . ' n\'a pas encore rempli son édito, mais il/elle va bientôt le faire, c\'est promis.'; ?></blockquote>
													 <?php } ?>
                           <!-- <p class="edito-date">il y a 23 jours</p> -->
                        </div>
                        
                        <?php
												if($profil) { ?>
                            <br /><div class="contact-user">
                            
                            <?php 
														/* regarde si l'utilisateur follow déjà ce profil
														$following = false;
														foreach($followers as $follower) {
															if($follower['User']['id'] == $this->Session->read('Auth.User.id')) {
																$following = true;
																break;
															}
														}
														
														if($this->Session->read('Auth.User.id') != $user['User']['id'] and !($following) ) { ?>
                                <div id="updatefollow">
                                    <?php echo $this->Ajax->link($html->image('icons/abonnement.png', array('class' => 'absmiddle', 'alt' => 'follow')) .' s\'abonner', array( 'controller' => 'users', 'action' => 'addFriend', $user['User']['id']), array('escape' => false, 'class' => 'follow-link', 'update' => 'updatefollow')); ?>
                                </div>
                            <?php } elseif ($following) { ?>
                            	<div id="updatefollow">
                                    <?php echo $this->Ajax->link($html->image('icons/unfollow.png', array('class' => 'absmiddle', 'alt' => 'unfollow')) .' se désabonner', array( 'controller' => 'users', 'action' => 'removeFriend', $user['User']['id']), array('escape' => false, 'class' => 'follow-link', 'update' => 'updatefollow')); ?>
                                </div>
                             <?php } ?>
                             
                                
                            <?php if($this->Session->read('Auth.User.id') != $user['User']['id']) {
                            	echo $html->link($html->image('icons/message.png', array('class' => 'absmiddle', 'alt' => 'msg')) . ' envoyer un message', '#', array('class' => 'msg-link', 'escape' => false)); ?>
                            <?php } 
														*/
							
														if (!empty($user['User']['twitter'])) echo $html->link($html->image('icons/twitter_small.png', array('class' => 'absmiddle', 'alt' => 'twitter')) . ' twitter', 'http://twitter.com/' . $user['User']['twitter'], array('class' => 'twitter-link', 'escape' => false)); ?>
                            
                            <?php if (!empty($user['User']['facebook'])) echo $html->link($html->image('icons/facebook_small.png', array('class' => 'absmiddle', 'alt' => 'fb')) . ' facebook', 'http://facebook.com/' . $user['User']['facebook'], array('class' => 'fb-link', 'escape' => false)); ?>
                            
                             <?php if (!empty($user['User']['website']) && strlen($user['User']['website']) > 7 ) echo $html->link($html->image('icons/website.png', array('class' => 'absmiddle', 'alt' => 'fb')) . ' site', $user['User']['website'], array('class' => 'msg-link', 'escape' => false)); ?>
                            </p>
                            <?php
													} ?>
                    </td>
                    </tr>
                    <tr>
                    <td class="dotted2">
                    	<?php 
											if($profil) {
												if (!empty($user['User']['city'])) echo $user['User']['city'];
											} else {
												echo $star->role($user['User']['role']); 
											} ?>
            				</td>
            		</tr>
            </table>
            
            <!--
            <br /><br /><br />
        		<table class="profil" width="100%">
            <tr>
            <td width="30%">
            <?php echo $gravatar->image($user['User']['email'], 70, array('alt'=>'gravatar', 'class' => 'imgleft'), false); ?>
            <?php if(!empty($user['name'])) echo $user['name'] . ' aka'; ?> <?php echo $user['User']['login']; ?> <br />
            <strong><?php echo $star->role($user['User']['role']); ?></strong><br />
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
						?>
            <span class="blue"><?php if(!empty($user['Rate'])) echo $star->rang($moyenne, count($user['Rate']) ); ?></span>
            </td>
            <td width="70%">
            
            
             <br /><br />
             <?php 
						 if (!empty($moyennes)) { 
								$minutes = 0;
								$nbepi = 0;
								foreach ($moyennes as $dureeshow) {
									$minutes += $dureeshow['Show']['format'] * $dureeshow['0']['Somme'];
									$nbepi += $dureeshow['0']['Somme'];
							}
						}
            ?>
            
            </td>
            </tr>
            </table>
            -->
            
            <div class="spacer"></div>
            <br /><br />
