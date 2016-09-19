<script type="text/javascript">
$('p.synopsis').expander({
  slicePoint:       200,  // default is 100
  expandText:         '&raquo; Lire la suite', // default is 'read more...'
  expandPrefix:		'... ',
  collapseTimer:    0, // re-collapses after 5 seconds; default is 0, so no re-collapsing
  userCollapseText: '&laquo; Fermer'  // default is '[collapse expanded text]'
});
</script>

<h2 class="title dblue"><?php echo $filterTitle; ?></h2>
<br /><br />

<?php foreach($shows as $i => $show): 
	if ($i % 2 == 0) echo '<div class="spacer"></div>';	?>
	<div class="serie-rentree <?php if ($i % 2 != 0) echo 'serie-rentree-last'; ?>">
		<div class="imgrentree">
			<?php echo $html->link($html->image(('show/' . $show['Show']['menu'] . '_w.jpg'), array('alt' => '', 'width' => 290)), '/serie/' .$show['Show']['menu'], array('class' => 'nodeco', 'escape' => false)); ?>
			<h2><span><?php echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></span></h2>
            <p class="chanel"><span><?php echo $show['Show']['chaineus']; ?></span></p>
		</div>
		<p class="synopsis"><strong>Synopsis :</strong> <?php echo $show['Show']['synopsis']; ?></p>
        <?php 
		if ($show['Show']['diffusionus'] != '2000-01-01') {
			if ($show['Show']['diffusionus'] == '2012-01-01') { 
				$date = 'A partir de courant 2012'; 
			} elseif($show['Show']['diffusionus'] == '2012-06-01') {
				$date = 'A partir d\'été 2012'; 
			} else {
				$timestamp = strtotime($show['Show']['diffusionus']); 
				$date = 'A partir du ' . strftime("%d %B %Y", $timestamp); 
			} ?>
            <table width="100%">
            <tr>
            <td><?php echo $date; //print_r($show); ?>.</td>
            <td><?php if(!empty($show['Season'][0]['ba'])) { ?> <?php echo $html->link('<span>Trailer</span>', '/serie/' . $show['Show']['menu'] . '#trailer', array('escape' => false, 'class' => 'button')); ?> <?php } ?>
            <?php if(!empty($show['Role'][0]['id'])) { ?> <?php echo $html->link('<span>Acteurs</span>', '/serie/' . $show['Show']['menu'] . '#acteurs', array('escape' => false, 'class' => 'button')); } ?>
			</td>
            </tr>
            </table>
		<?php }
		if(!empty($show['Show']['particularite2011'])) echo '<p><strong>Particularité : </strong>' . $show['Show']['particularite2011'] . '</p>';
        if(!empty($show['User']['login'])) { ?>
        <p class="redacteur">
        	Critique par <?php echo $gravatar->image($show['User']['email'], 15, array('width' => 15, 'alt'=>'gravatar', 'class' => 'imgleft'), false); ?>
            <?php echo $html->link($show['User']['login'], '/profil/'. $show['User']['login'], array('class' => 'decoblue')); ?>
        </p>
        <?php } ?>
        
		<br /><br />
	</div>

<?php endforeach; ?>