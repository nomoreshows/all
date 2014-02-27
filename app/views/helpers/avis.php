<?php

class AvisHelper extends AppHelper {
	
	var $helpers = array('Html', 'Javascript', 'Form', 'Gravatar', 'Star');
	
	
	function displayMobile($allcomments, $userId, $userRole, $limit, $reverse) {
		if (!empty($allcomments)) {
			if($reverse) $allcomments = array_reverse($allcomments);
			foreach ($allcomments as $i => $comment) {
				if ($limit > 0) { if($i == $limit) break; }
				echo $this->Html->link($comment['User']['login'], '#') . ' ';
				echo $this->Star->thumb($comment['Comment']['thumb']); ?>
				<span class="<?php echo $comment['Comment']['thumb']; ?>"><?php echo $this->Star->avis($comment['Comment']['thumb']); ?></span><br />
                <?php echo nl2br($comment['Comment']['text']); ?>
                <br /><br />
			<?php	
			}
		}
				
	}
	
	function display($allcomments, $userId, $userRole, $limit, $reverse) {
		?>
    <script type="text/javascript">
			$('a[rel*=facebox]').facebox();
		</script>
		<?php
		if (!empty($allcomments)) {
			echo '<div class="comments-serie">';
			if($reverse) $allcomments = array_reverse($allcomments);
			foreach ($allcomments as $i => $comment) {
					if ($limit > 0) { if($i == $limit) break; }
                
					echo '<div id="comment' .  $comment['Comment']['id'] . '" style="display:none">';
					
					echo '<fieldset><legend>Répondre à ' . $comment['User']['login'] . ' :</legend><br />'; 
					echo $this->Form->create('Reaction', array( 'action' => 'add'));
					echo $this->Form->input('text', array('label' => false, 'cols' => 48));
					echo $this->Form->input('comment_id', array('type' => 'hidden', 'value' => $comment['Comment']['id']));
					echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $userId));
					echo '<br />';
					echo '<button type="submit">Valider</button></form>';
					echo '</fieldset>';
					?>
				</div>
				<table>
				<tr>
				<td class="td-com-user">
				<?php echo $this->Html->link($this->Gravatar->image($comment['User']['email'], 40, array('alt' => $comment['User']['login'], 'width' => '60', 'height' => 60, 'class' => 'imgcom'), false), '/profil/'. $comment['User']['login'], array('class' => 'nodeco', 'escape' => false));  ?> 
				</td>
				<td class="td-com-text">
        <div class="avis-infos-<?php echo $comment['Comment']['thumb']; ?>">
          <strong><?php echo $this->Html->link($comment['User']['login'], '/profil/'. $comment['User']['login'], array('class' => 'decoreaction')); ?></strong> - 
          <?php echo $this->Star->thumb($comment['Comment']['thumb']); ?> 
          <span class="<?php echo $comment['Comment']['thumb']; ?>"><?php echo $this->Star->avis($comment['Comment']['thumb']); ?></span>
          <span class="grey">le 
          <?php $timestamp = strtotime($comment['Comment']['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?> à 
          <?php e(strftime("%Hh%M", $timestamp)); ?>
          </span>
          <?php if( 1 <= $userRole && $userRole < 4 ): ?>
          <?php echo $this->Html->link('Supprimer le commentaire', '/admin/comments/delete/'. $comment['Comment']['id']); ?>
          <?php endif; ?>    
        </div><div class="spacer"></div>
				<?php if(strlen($comment['Comment']['text']) < 900) {
					echo trim(nl2br($comment['Comment']['text']));
				}  else {
					echo nl2br(substr($comment['Comment']['text'], 0, 900));
					echo $this->Html->link('...&nbsp; &raquo; Lire la suite', '#', array('escape' => false, 'class' => 'decoblue', 'onClick' => '$(\'#suite' . $comment['Comment']['id'] . '\').show(); $(this).hide(); return false;')); 
					echo '<span id="suite' . $comment['Comment']['id'] . '" style="display:none">';
					echo nl2br(substr($comment['Comment']['text'], 900));
					echo '</span>';
				}?>
				</p>
				<?php if (!empty($comment['Reaction'])) { ?>
					<br /><div class="reaction-header"></div>
					<table class="reactions" align="left">
						<?php
						foreach ($comment['Reaction'] as $reaction) {
							?>
							<tr>
							<td class="td-com-user">
							<?php
							echo $this->Html->link($this->Gravatar->image($reaction['User']['email'], 30, array('alt' => $reaction['User']['login'], 'width' => '30', 'height' => 30, 'class' => 'imgreaction'), false), '/profil/'. $reaction['User']['login'], array('class' => 'nodeco', 'escape' => false)); 
							?>
							</td>
							<td class="td-com-text">
							<?php
								echo $this->Html->link($reaction['User']['login'], '/profil/'. $reaction['User']['login'], array('class' => 'decoblue')); ?>
								<span class="grey">le 
								<?php $timestamp = strtotime($reaction['created']);	e(strftime("%d/%m/%Y", $timestamp)); ?> à 
								<?php e(strftime("%Hh%M", $timestamp)); ?>
								</span><br />
								<?php echo nl2br($reaction['text']);
							?>
							</td>
							</tr>
							<?php
						}
						?>
					</table>
					<?php if ($userRole > 0) { ?> <p class="reply"><?php echo $this->Html->link('<span>Répondre</span>', '#comment' . $comment['Comment']['id'], array('class' => 'button', 'escape' => false, 'rel' => 'facebox')); ?></p> <?php }
					} else { 
						if ($userRole > 0) { ?> <p class="reply2"><?php echo $this->Html->link('<span>Répondre</span>', '#comment' . $comment['Comment']['id'], array('class' => 'button', 'escape' => false, 'rel' => 'facebox')); ?></p> <?php }
					} ?>
				</td>
				</tr>
				</table>
			<?php
			}
			echo '</div>';
		} 
	
	}

}

?>
