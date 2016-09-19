<script type="text/javascript">
$('p.synopsis').expander({
  slicePoint:       200,  // default is 100
  expandText:         '&raquo; Lire la suite', // default is 'read more...'
  expandPrefix:		'... ',
  collapseTimer:    0, // re-collapses after 5 seconds; default is 0, so no re-collapsing
  userCollapseText: '&laquo; Fermer'  // default is '[collapse expanded text]'
});
$('a[rel*=facebox]').facebox();
</script>

<h2 class="title dblue"><?php echo $filterTitle; ?></h2>
<br /><br />

<?php foreach($shows as $i => $show): 

  $te = $show['Show']['te_rentree'];
  if ($te > 49) $te_color = 'up'; 
  if ($te > 19 && $te < 50) $te_color = 'neutral';
  if ($te < 20) $te_color = 'down';
  
	if ($i % 3 == 0) echo '<div class="spacer"></div>';	?>
	
	<div class="serie-rentree <?php if ($i % 3 != 0) echo 'serie-rentree-last'; ?>">
		<div class="imgrentree">
			<?php 
				//Test si l'image pour la serie existe 
				$nomImgSerie = 'no-image'; //nom du fichier de l'image par defaut
				if(file_exists(APP.'webroot/img/show/'.$show['Show']['menu'].'_w.jpg')){
					//image de la serie existe
					$nomImgSerie = $show['Show']['menu'];
				}
				echo $html->link($html->image(('show/' . $nomImgSerie . '_w.jpg'), array('alt' => '', 'width' => 290, 'height' => 139)), '/serie/' .$show['Show']['menu'], array('class' => 'nodeco', 'escape' => false)); 
			?>
			<h2><span><?php echo $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco')); ?></span></h2>
      <p class="chanel"><span><?php echo $show['Show']['chaineus']; ?></span></p>
	  <?php if($te){?>
      <p class="teshow teshow<?php echo $te_color; ?>">Taux érectile : <span><?php echo $te; ?>%</span></p>
	  <?php  }?>
		</div>
		
		<?php 
		// Avis rédac
		if (!empty($show['Show']['avis_rentree'])) { ?>
		<div id="avisredac<?php echo $show['Show']['id']; ?>" style="display:none;">
  		<fieldset><legend>L'avis de <?php echo $html->image('logo_v2.png', array('alt'=>'Série-All', 'width' => 100, 'class' => 'logoavis')); ?></legend>
  		
		<?php if($te){?>
			<div id="te"><span class="expand <?php echo $te_color; ?>">
			  Taux érectile : <strong><?php echo $te; ?>%</strong>
			</span></div><br /><br />
  		<?php  }?>
		
  		<div class="article">
  		  <?php echo nl2br($show['Show']['avis_rentree']); ?>
  		</div>
  		</fieldset>
		</div>
		<?php } ?>
		
		<?php 
		// Trailer
		if(!empty($show['Season'][0]['ba'])) { ?> 
		  <div id="trailer<?php echo $show['Show']['id']; ?>" style="display:none;">
		    <fieldset><legend>Trailer de <?php echo $show['Show']['name']; ?></legend><br />
		    <?php echo $show['Season'][0]['ba']; ?>
		  </div>
		<?php } ?>
		
		<p class="synopsis"><strong>Synopsis :</strong> <?php echo $show['Show']['synopsis']; ?></p>
        <?php 
  			if ($show['Show']['diffusionus'] == '2013-09-01') { 
  				$date = 'A partir de septembre 2013'; 
  			} elseif($show['Show']['diffusionus'] == '2014-01-01') {
  				$date = 'A partir de janvier 2014'; 
			} elseif($show['Show']['diffusionus'] == '2015-01-01') {
  				$date = 'A partir du printemps 2015'; 
			} elseif($show['Show']['diffusionus'] == '2014-09-01' && $show['Show']['id'] != 1157) {
  				$date = 'A partir de l\'automne 2014'; 
			}elseif($show['Show']['diffusionus'] == '2015-12-01') {
  				$date = 'A partir de l\'automne 2015';
			}elseif($show['Show']['diffusionus'] == '2016-06-01') {
				$date = 'A partir du printemps 2016';
			}elseif($show['Show']['diffusionus'] == '2016-12-01') {
				$date = 'Automne-Hiver 2016-2017';
			}elseif($show['Show']['diffusionus'] == '2017-06-01') {
				$date = 'Printemps-Été 2017';
			}else {
  				$timestamp = strtotime($show['Show']['diffusionus']); 
  				$date = 'A partir du ' . strftime("%d %B %Y", $timestamp); 
  			} ?>
        <table width="100%">
        <tr>
        <td><?php echo $date;  ?>.</td>
        <td>
        <?php if (!empty($show['Show']['avis_rentree'])) echo $html->link('<span>Notre pronostic</span>', '#avisredac' . $show['Show']['id'], array('class' => 'button current', 'escape' => false, 'rel' => 'facebox')); ?>
        <?php if(!empty($show['Season'][0]['ba'])) {  echo $html->link('<span>Trailer</span>', '#trailer' . $show['Show']['id'], array('escape' => false, 'class' => 'button', 'rel' => 'facebox[.fbcontent]')); } ?>
		<?php 
			foreach ($show['Article'] as $article){
				if($article['caption']=="1.01"){
					echo $html->link('<span>Critique</span>', '/article/' . $article['url'], array('escape' => false, 'class' => 'button')); 
					break;
				}
			}
		?>

        </td>
        </tr>
        </table>
        
        
		<br /><br />
	</div>

<?php endforeach; ?>
