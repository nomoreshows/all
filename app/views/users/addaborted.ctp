		<script type="text/javascript">
		$(function() {
			$("a.delfollow").bind("click", function() {
				$(this).parent().parent().parent().parent().fadeOut("slow");			 
			});

		});
		</script>
 <?php 
	foreach($followedshows as $show) {
		echo '<div class="listeshows">';
		echo '<div class="imageshow">';
		echo $html->image('show/' . $show['Show']['menu'] . '_w_serie.jpg', array('class' => 'img-class', 'border' => 0)); 
		echo '<h5><span>' . $html->link($show['Show']['name'], '/serie/' . $show['Show']['menu'], array('class' => 'nodeco2')) . ' ';
		
		echo $ajax->link('[x]', array('controller' => 'users', 'action' => 'delfollow', $show['Show']['id']), array('class' => 'nodeco2 delfollow')); 
		echo '</span></h5></div>';
		echo '<div class="textshow">' . $show['Followedshows']['text'] . '</div></div><div class="spacer"></div>';
		
	}
	?>

						