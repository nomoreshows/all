	 <?php $this->pageTitle = 'Notifications - Profil de ' . $user['User']['login']; ?>
     
    <div id="col1">
    	<div class="padl10">
        	<h1 class="dblue title"><?php echo $user['User']['login']; ?> &raquo; Notifications</h1>
            <?php echo $this->element('profil-menu'); ?>
        	  
            <h2 class="title dblue">Notifications</h2>
            
            <div class="profil-notifications">
						<?php 
            if(!empty($notifications)) { 
							$tmptimestamp = 0;
				
              foreach($notifications as $notification) {
						
								$timestamp = strtotime($notification['Notification']['created']);
								if (strftime("%d", $tmptimestamp) != strftime("%d", $timestamp)) { // si changement de jour 
									echo '<br /><h4>' . strftime("%d %B %Y", $timestamp) . '</h4><br /><br />';	
								}
								echo '<span class="grey">' . strftime("%Hh%M", $timestamp). ' : </span>';
						
								if ($notification['Notification']['read'] == 1) {
										echo '<span class="grey">';
										echo $notification['Notification']['text'];
										echo $html->link(' &raquo; voir', $notification['Notification']['url'], array('escape' => false));
										echo '<br /><br />';
										echo '</span>';
										
								} else {
										echo $notification['Notification']['text'];
										echo $html->link(' &raquo; voir', $notification['Notification']['url'], array('class' => 'see', 'escape' => false));
										echo '<br /><br />';
								}
						
								$tmptimestamp = strtotime($notification['Notification']['created']);
            	}
            } else {
               echo 'Aucune notification.';	
						} ?>
            </div>
            
           
        </div>
    </div>
    
    
    <?php echo $this->element('profil-sidebar'); ?>