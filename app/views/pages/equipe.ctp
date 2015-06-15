<?php $this->pageTitle = 'Notre équipe'; 
	echo $html->meta('description', "Le but premier de Série-All est de vous donner la parole, et de vous permettre de noter les épisodes que vous regardez, de donner votre avis sur ces derniers, de commenter tous les articles du site, et enfin de venir discuter de vos séries préférées sur notre forum.", array('type'=>'description'), false); 
?>

<div id="col1">
    <div class="padl15">
    <h1 class="red title">Notre équipe</h1><br /><br />
    
    <div class="col1 equipe">
    	Composée de personnes d'horizons plus ou moins variés l'équipe de serieall s'est donnée pour mission de vous offrir le contenu seriel le plus pertinent du web. Oui, rien que ça.
        Dans la mesure du possible, on essaye de rester objectif mais bon, il faut bien avouer que face à Joséphine Ange Gardien, c'est difficile (mais on fait des efforts).
        <br /><br />
		
		
		<h2 class="title dblue">Les chefs</h2>
		<br /><br />
		<p>
			Omniscients et omnipotents, ils dirigent d’une main de fer le site : développement, rédaction, modération, rien ne leur échappe. Ils sont
			toutefois accessibles et bienveillants et acceptent aussi bien les règlements par chèques que les espèces. 
		</p>
		<br />
		
		
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Elpiolito', '/profil/'. 'elpiolito', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('jojo.jumper@hotmail.fr', 53, array('alt' => 'elpiolito', 'class' => 'ppic'), false), '/profil/'. 'elpiolito', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Webmaster à temps partiel
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Le saviez-vous ? C'est une marmotte qui est aux commandes du site. Et une marmotte succeptible en plus, surtout quand on critique le brushing de <strong>MacGyver</strong>.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Koss', '/profil/'. 'Koss', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('costheboss_007@hotmail.com', 53, array('alt' => 'Koss', 'class' => 'ppic'), false), '/profil/'. 'Koss', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur en chef
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Koss a deux passions dans la vie : écrire des trucs sur le web et troller. Surtout troller en fait. Mais personne n'est dupe : on sait bien qu'il aime
				         <strong>Breaking Bad</strong>.
					</blockquote>
				</div>
			</div>
		</div>
		
		<h2 class="title dblue">La rédaction</h2>
		<br /><br />
		<p>
			Ils distillent avec intelligence et savoir faire leur analyse des séries et des actualités : plus leur critique est pertinente et plus leur
			rémunération en pépito est importante. Autant dire qu’ils font plutôt du bon travail !  
		</p>
		<br />
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Alanparish', '/profil/'. 'alanparish', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('alanparish45@hotmail.com', 53, array('alt' => 'alanparish', 'class' => 'ppic'), false), '/profil/'. 'alanparish', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Il est le recordman du nombre de critiques publiées à la bourre, à deux doigts d'être homologué par le Guinness World Records. Sinon, il a aimé la fin de
						<strong>Lost</strong> et de <strong>How I Met Your Mother</strong> : surprenant, n'est-il pas ?
					</blockquote>
				</div>
			</div>
		</div>
		


		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Antofisherb', '/profil/'. 'antofisherb', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('antoninbonneau@hotmail.fr', 53, array('alt' => 'antofisherb', 'class' => 'ppic'), false), '/profil/'. 'antofisherb', array('escape' => false));   ?>
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
					    Il aime des mauvaises séries, mais il en regarde tellement que personne ne le voit. Il est également notre reporter de l'extrême,
					    capable de prouesses de ninja pour nous récupérer un scoop !
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Arnoglas', '/profil/'. 'Arnoglas', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('arnoglas@hotmail.com', 53, array('alt' => 'Arnoglas', 'class' => 'ppic'), false), '/profil/'. 'Arnoglas', array('escape' => false));   ?>
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Challenger d'Alanparish pour le record du nombre de critiques publiées à la bourre, il aime aussi se lancer des défis de l'impossible comme regarder l'intégrale Doctor Who en un mois. Oui, on est des fous à Serieall.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Cail1', '/profil/'. 'Cail1', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('cail1@hotmail.fr', 53, array('alt' => 'Cail1', 'class' => 'ppic'), false), '/profil/'. 'cail1', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur - Gestionnaire
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Le sang et les luttes acharnées, c'est sa passion. C'est donc sans surprise qu'il critique <strong>The Walking Dead</strong> et 
						se bat avec le site pour ajouter des séries dans la base de données. On ne sait toujours pas ce qui est le pire.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Dewey', '/profil/'. 'dewey', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('thedarkpheonix@hotmail.fr', 53, array('alt' => 'Dewey', 'class' => 'ppic'), false), '/profil/'. 'dewey', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Le petit frère de Malcolm a bien grandit ! Maintenant il regarde Star Trek et Game of Thrones et n'hésite pas à critiquer ouvertement tout ce qui ne va pas. Parce que oui, en grandissant, Dewey a aussi perdu sa naïveté...
					</blockquote>
				</div>
			</div>
		</div>

		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Galax', '/profil/'. 'Galax', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('rikki-tikki@hotmail.fr', 53, array('alt' => 'Galax', 'class' => 'ppic'), false), '/profil/'. 'Galax', array('escape' => false));   ?>
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Vous aimez <strong>Doctor Who</strong> ? Ne le dites pas à Galax, sinon il va vous en parler pendant des heures. Remarquez, quoique vous fassiez, il va vous en parler pendant des heures.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Jojo76', '/profil/'. 'jojo76', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>

			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('jojoenforce@hotmail.fr', 53, array('alt' => 'Jojo76', 'class' => 'ppic'), false), '/profil/'. 'jojo76', array('escape' => false));   ?>
				</div>

				<div class="block-role">
					<p class="role">
						Gestionnaire de la base
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Sa capacité à troller est devenue légendaire sur les internets. Chez nous, il se charge en plus de mettre à jour la base de données et les images de séries avec Cail1.
					</blockquote>
				</div>
			</div>
		</div>


		<div class="redacteur">

			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Nicknackpadiwak', '/profil/'. 'nicknackpadiwak', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>

			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('cedricbutstraen@aol.com', 53, array('alt' => 'Nicknackpadiwak', 'class' => 'ppic'), false), '/profil/'. 'nicknackpadiwak', array('escape' => false));   ?>
				</div>

				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>

				<div class="status">
					<blockquote>
						Critique de l'extrême, il est aussi l'inventeur du VrickAVrack. Et non, nous non plus nous n'arrivons toujours pas à prononcer son nom.
					</blockquote>
				</div>
			</div>
		</div>
		
		
		<h2 class="title dblue">Les anciens</h2>
		<br /><br />
		<p>
			Il fut un temps où eux ausi participaient activement au site. Malheuresement, ayant réussi à briser leurs chaînes, ils ont fui
			la cave des chinois. Certains restent toutefois présents sur le forum pour soutenir leurs compagnons.  
		</p>
		<br />
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Scarch', '/profil/'. 'scarch', array('escape' => false, 'class' => 'nodeco'))?></span> - David Scarchili
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('jango@aliceadsl.fr', 53, array('alt' => 'scarch', 'class' => 'ppic'), false), '/profil/'. 'scarch', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Fondateur (à la retraite)
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Créateur de la première version du site en 2009, il a eu l’honneur de critiquer
						<strong>Breaking Bad</strong>. Incapable se remettre de la fin de série, il a décidé de s'exiler dans un monastère au tibet pour retrouver un semblant de spiritualité.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Cad', '/profil/'. 'cad', array('escape' => false, 'class' => 'nodeco'))?></span> - Gaetan Rochel
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('cadeuh@gmail.com', 53, array('alt' => 'cad', 'class' => 'ppic'), false), '/profil/'. 'cad', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Webmaster
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Capable de pirater les serveurs du FBI avec une gameboy, il a créer le site actuel avant d'en devenir le responsable officiel. Depuis, il a délégué tout le boulot et passe
						la journée assis dans son fauteuil en cuir à regarder son empire.
					</blockquote>
				</div>
			</div>
		</div>
		
		
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Aureylien', '/profil/'. 'aureylien', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('aurelien.biedermann33@gmail.com', 53, array('alt' => 'aureylien', 'class' => 'ppic'), false), '/profil/'. 'aureylien', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Critique sur les pilots et chinois à temps partiel, il rêvait de monter un harem réunissant les actrices 
						les plus physiquement intelligentes. Le monde l'a rattrapé depuis.
					</blockquote>
				</div>
			</div>
		</div>

		<div class="redacteur">

			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Altair', '/profil/'. 'altair', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>

			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('aurelie_bm@yahoo.fr', 53, array('alt' => 'altair', 'class' => 'ppic'), false), '/profil/'. 'altair', array('escape' => false));   ?>
				</div>

				<div class="block-role">
					<p class="role">
						Rédactrice
					</p>
					<div class="dot">
					</div>
				</div>

				<div class="status">
					<blockquote>
						Avec sa collègue Puck, elle se bat chaque jour pour que Série-All devienne une terre d'égalité entre hommes et femmes. Mais comme on dit "on en reparlera quand il faudra porter des choses lourdes" (non, pas taper, désolé).
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Bleak', '/profil/'. 'bleak', array('escape' => false, 'class' => 'nodeco'))?></span> - Thomas Lewin
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('hatworld89@gmail.com', 53, array('alt' => 'bleak', 'class' => 'ppic'), false), '/profil/'. 'bleak', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Sheriff
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Ancien critique et sheriff du site (on raconte qu'il avait inspiré Morris pour Lucky Luke), il a été muté dans une autre province que celle de Serieall.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('CaptainFreeFrag', '/profil/'. 'CaptainFreeFrag', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('rob.zen@hotmail.fr', 53, array('alt' => 'CaptainFreeFrag', 'class' => 'ppic'), false), '/profil/'. 'CaptainFreeFrag', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Sur le forum, il était de toutes les discussions. Tant et si bien qu'on a eu l'impression qu'il est un rédacteur prolifique. En fait, il n'a
						critiqué que <strong>The Playboy Club</strong> et <strong>Boss</strong>.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Chuck44', '/profil/'. 'Chuck44', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('ferry.antoine@gmail.com', 53, array('alt' => 'Chuck44', 'class' => 'ppic'), false), '/profil/'. 'Chuck44', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Grand fan de <strong>Chuck</strong> et d'Yvonne Strahovski, il a critiqué avec grand enthousiasme sa série préférée. Et quand celle-ci a quitté la grille des programmes
						de NBC, il a décidé de partir consoler Yvonne.						
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Fafa', '/profil/'. 'Fafa', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('stephane.blin10@wanadoo.fr', 53, array('alt' => 'Fafa', 'class' => 'ppic'), false), '/profil/'. 'Fafa', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Plus gros noteur du site, il aimait achever les séries minables à coup d'avis destructeurs. On soupçonne Mimie Mathy de lui avoir tendu une embuscade, ce qui expliquerait son absence.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Funradiz', '/profil/'. 'funradiz', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('ludo_ajl@hotmail.fr', 53, array('alt' => 'funradiz', 'class' => 'ppic'), false), '/profil/'. 'funradiz', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						50 % homme, 50% femme, 100% radis, le créateur de <em>Fringe, histoires parallèles</em> nous a proposé ces services de temps à autre, 
						notamment sur <strong>Dexter</strong> et <strong>True Blood</strong>.
					</blockquote>
				</div>
			</div>
		</div>		
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Gouloudrouioul', '/profil/'. 'Gouloudrouioul', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('glounz@hotmail.fr', 53, array('alt' => 'Gouloudrouioul', 'class' => 'ppic'), false), '/profil/'. 'Gouloudrouioul', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Son pseudo improbable nous faisait penser à un animal sauvage. On ne doit pas être les seuls puisqu'on ne le voit que très rarement depuis l'ouverture de la chasse.
					</blockquote>
				</div>
			</div>
		</div>
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Hayiana', '/profil/'. 'Hayiana', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('hayiana@hotmail.fr', 53, array('alt' => 'Hayiana', 'class' => 'ppic'), false), '/profil/'. 'Hayiana', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédactrice
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Fans des beaux gosses vampires de <strong>The Vampire Diaries</strong>, elle a finalement succombé à leur charme et est parti les rejoindre.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Leif', '/profil/'. 'Leif', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('002lp@wanadoo.fr', 53, array('alt' => 'Leif', 'class' => 'ppic'), false), '/profil/'. 'Leif', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Ami de 
					</p>
					<div class="dot">
					</div>
					<p class="role-sub">
						Google
					</p>
				</div>
		
				<div class="status">
					<blockquote>
						Il s'occupait de nous référencer sur Google. Mais un jour, il a rencontré Desireless et est partie la suivre en tournée.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Louna69', '/profil/'. 'louna69', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('elisabethbetty965@msn.com', 53, array('alt' => 'louna69', 'class' => 'ppic'), false), '/profil/'. 'louna69', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédactrice
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Critique de <strong>Gossip Girl</strong> et de <strong>The Vampire Diaries</strong>, elle n'a pas résisté à l'overdose de potins, ragots et autres
						réjouissances adolescentes de ces deux séries.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Marckoleptik', '/profil/'. 'Marckoleptik', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('marckoleptik@gmail.com', 53, array('alt' => 'Marckoleptik', 'class' => 'ppic'), false), '/profil/'. 'Marckoleptik', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
					<p class="role-sub">
						actualités
					</p>
				</div>
		
				<div class="status">
					<blockquote>
						Ancien chinois en chef, il gérait les ajouts de nouvelles séries au site ainsi que la rédaction des actualités. Trop de pressions auront eu raison de lui.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('MoolFreet', '/profil/'. 'MoolFreet', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>

			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('gregoiredufour@neuf.fr', 53, array('alt' => 'MoolFreet', 'class' => 'ppic'), false), '/profil/'. 'MoolFreet', array('escape' => false));   ?>
				</div>

				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>

				<div class="status">
					<blockquote>
						Notre ancien homme à tout faire : il a critiqué plusieurs séries quand il était dans la rédaction
						dont <strong>Community</strong>, <strong>Castle</strong> ou encore <strong>Glee</strong>. On raconte qu'il s'est reconvertit dans le football depuis.
					</blockquote>
				</div>
			</div>
		</div>

		<div class="redacteur">

			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Nero93140', '/profil/'. 'Nero93140', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('nero93140@live.fr', 53, array('alt' => 'Nero93140', 'class' => 'ppic'), false), '/profil/'. 'Nero93140', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						 Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Grand fan des comics <strong>The Walking Dead</strong>, il a critiqué un temps la série d'AMC. Et puis les zombies l'ont finalement rattrapé et on le l'a plus revu...
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Poliis0n', '/profil/'. 'Poliis0n', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('julien.agar@live.fr', 53, array('alt' => 'Poliis0n', 'class' => 'ppic'), false), '/profil/'. 'Poliis0n', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Gestion du
					</p>
					<div class="dot">
					</div>
					<p class="role-sub">
						planning
					</p>
				</div>
		
				<div class="status">
					<blockquote>
						Egalement surnommé <em>le ninja du planning</em>, son action était aussi discrète qu'efficace, le planning était à jour toutes les semaines. Et un jour, on l'a remplacé par un robot : saloperie de capitalisme.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Puck', '/profil/'. 'Puck', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('absinthe5@free.fr', 53, array('alt' => 'Puck', 'class' => 'ppic'), false), '/profil/'. 'Puck', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Correctrice
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Chevalier de l'ordre du Larousse et gardienne du Petit Robert, elle traquait sans relâche les fautes d'ortographe et de grammaire. Elle critiquait aussi quelques
						séries, pour peu que John Simm soit au casting.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('OSS', '/profil/'. 'OSS', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('dexter.morgan.om@hotmail.fr', 53, array('alt' => 'OSS', 'class' => 'ppic'), false), '/profil/'. 'OSS', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Comme son homonyme, il aime se beurrer la biscotte et qu'on l'enduise d'huile. Actuellement, on pense qu'il doit être de nouveau en mission secrète au proche-Orient.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Sanschiffre', '/profil/'. 'sanschiffre', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('sanschiffre@hotmail.fr', 53, array('alt' => 'sanschiffre', 'class' => 'ppic'), false), '/profil/'. 'sanschiffre', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Gestion des
					</p>
					<div class="dot">
					</div>
					<p class="role-sub">
						séries
					</p>
				</div>
		
				<div class="status">
					<blockquote>
						Amateur de grand n'importe quoi, il rajoute discrètement toutes sortes de nanars sur le site en tentant de convertir les rédacteurs à sa cause. 
						Il possède aussi un &oelig;il bionique capable de détecter les faux raccords.  
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Sephja', '/profil/'. 'sephja', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('madameerini@gmail.com', 53, array('alt' => 'sephja', 'class' => 'ppic'), false), '/profil/'. 'sephja', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Quand il ne s'occupait pas de ses alpagas, sa passion était la découverte de nanars australiens ou du dernier
						thriller suédois à la mode, qu'il s'empressait de faire découvrir à tout le monde.
					</blockquote>
				</div>
			</div>
		</div>

		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Spoon', '/profil/'. 'spoon', array('escape' => false, 'class' => 'nodeco'))?></span> - Nicolas Tassone
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('nicolas.tassone@gmail.com', 53, array('alt' => 'spoon', 'class' => 'ppic'), false), '/profil/'. 'spoon', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Il fut un temps où il a critiqué <strong>Sons of Anarchy</strong> et <strong>Gossip Girl</strong>, soit disant une preuve d'ouverture d'esprit.
						Depuis, il s'est rendu compte de son erreur et s'est exilé dans un monastère.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Tan', '/profil/'. 'Tan', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('morlak_ncr@hotmail.com', 53, array('alt' => 'Tan', 'class' => 'ppic'), false), '/profil/'. 'Tan', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Son rêve absolu est de se transformer en Pinkie Pie, l'un des poneys de <strong>My Little Pony : Friendship is Magic</strong>. En dehors de ça, c'est un garçon
						normal.
					</blockquote>
				</div>
			</div>
		</div>
		
		<div class="redacteur">
		
			<div class="block-name">
				<p class="name">
					<span class="pseudo"><?php echo $html->link('Taoby', '/profil/'. 'Taoby', array('escape' => false, 'class' => 'nodeco'))?></span>
				</p>
				<div class="name-separator">
				</div>
			</div>
	
			<div class="profil">
				<div class="bg-avatar">
					<?php  echo $html->link($gravatar->image('taoby1@hotmail.com', 53, array('alt' => 'Taoby', 'class' => 'ppic'), false), '/profil/'. 'Taoby', array('escape' => false));   ?> 
				</div>
				
				<div class="block-role">
					<p class="role">
						Rédacteur
					</p>
					<div class="dot">
					</div>
				</div>
		
				<div class="status">
					<blockquote>
						Son intérêt pour les critiques ayant diminué de concert avec la qualité des épisodes de <strong>Dexter</strong>, cet expert de <em>Paint</em> a préféré arrêter.
						Il tient néanmoins une chronique sur des actrices méconnues du circuit traditionnel, à découvrir sur le forum.
					</blockquote>
				</div>
			</div>
		</div>
		
	</div>
    </div>
</div>

<div id="col2">
	<div id="colright-informations">
        <div class="colrinfos-header"></div>
        <div class="colr-content">
            <fb:like-box profile_id="105365559504009" width="295" connections="12" stream="false"></fb:like-box>
        </div>
        <div class="colr-footer"></div>
    </div>
        
	<div id="colright-informations">
        <div class="colrinfos-header"></div>
        <div class="colr-content">
        	<h3 class="red">Pourquoi créer un compte ?</h3> <br /><br />
            <ul class="play">
            	<li><strong>Noter</strong> vos séries préférées par épisode</li>
                <li>Laisser des <strong>avis</strong> sur des séries en général</li>
                <li><strong>Commenter</strong> les critiques et dossiers des rédacteurs</li>
                <li>Ajouter vos séries <strong>préférées</strong> sur votre profil</li>
                <li>Nous faire <strong>partager</strong> vos découvertes sur votre édito</li>
                <li>Participer à la vie du <strong>forum</strong></li>
            </ul>
            <br />
            <?php echo $html->link('&raquo; Créér votre compte', '/inscription', array('escape' => false, 'class' => 'decoblue')); ?>
        </div>
        <div class="colr-footer"></div>
    </div>
    
    <div>
        <div ></div>
        <div class="colr-content">
        </div>
        <div></div>
    </div>
    
</div>

