		<div id="topbar" class="transparent">
        	<div id="title"><?php echo substr($season['Show']['name'], 0, 10); ?></div>
            <div id="leftnav"><a href="/iphoneShow/<?php echo $season['Show']['id']; ?>"><?php echo $season['Show']['name']; ?></a> </div>
            <div id="bluerightbutton"><a href="/iphone">Accueil</a> </div>
        </div>
		<div id="duobutton">
        <div class="links"><a id="pressed" href="A.html">Noter</a><a href="B.html">News</a></div></div>

        <div id="content">
        	<span class="graytitle">Saison <?php echo $season['Season']['name']; ?> </span>
                <ul class="pageitem">
                <?php foreach ($season['Episode'] as $episode) {
					echo '<li class="menu">';
					echo '<a href="/iphoneEpisode/'. $episode['id'] . '">';
					echo '<span class="name">' . $episode['numero'] . '. ' . $episode['name'] . '</span>';
					echo '<span class="arrow"> </span>';
					echo '</a></li>';
				} // echo '<pre>'; print_r($show); echo '</pre>';?>
            </ul>
        </div>
        <div id="footer">
        
        </div>
        
        
	  
