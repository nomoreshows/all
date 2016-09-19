<?php
/* SVN FILE: $Id: default.ctp 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
 
if($_SERVER['HTTP_HOST'] == 'serieall.easy-hebergement.info') {
	header("Status: 301 Moved Permanently", false, 301);
	header("Location: http://serieall.fr" . $_SERVER['REQUEST_URI']);
	exit(); 
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
        <?php __('| Serie-All'); ?>
	</title>
	<meta name="google-site-verification" content="Uv2dNiTiCqRRP1vgIEQGhv-NYFCryN9C1ZSeFQxvCbc" />
	<meta name="google-site-verification" content="bev14HcuGF0I8zUqpebM7tf24oPDfDY3oeV9PGhYI5A" />
	<?php
		echo $html->meta('rss', 'http://feeds.feedburner.com/SerieAllArticles', array('title' => "Série-All"));
		echo $html->meta('icon');
		echo $html->css('jquery-ui-1.7.2');
		echo $html->css('general');
		echo $html->css('facebox');
		echo $html->css('jquery.jgrowl');
		
		echo $javascript->link('jquery-1.3.2.min', true);
		echo $javascript->link('jquery-ui-1.7.2.custom.min', true);
		echo $javascript->link('jquery.jgrowl', true);
		echo $javascript->link('jquery.easing.1.3', true);
		echo $javascript->link('facebox', true);
		echo $javascript->link('jquery.galleryview-2.0-pack', true);
		echo $javascript->link('jquery.timers-1.1.2', true);
		echo $javascript->link('jquery.sexy-combo-2.1.2.pack', true);
		echo $javascript->link('jquery.jeditable', true);
		echo $javascript->link('jquery.form', true);
		echo $javascript->link('swfobject', true);
		echo $javascript->link('jquery.tools.min', true);
		echo $scripts_for_layout;
	?>
        <script type="text/javascript">
		  $(document).ready(function(){		
			  $('#photos').galleryView({
				  panel_width: 490,
				  panel_height: 235,
				  frame_width: 38,
				  frame_height: 38,
				  pause_on_hover: true
			  });
			  $("select.combo").sexyCombo();
			  $('a[rel*=facebox]').facebox({
				loading_image : 'loading.gif',
				close_image   : 'closelabel.gif'
			  })
			  $("#toolbar select").change(function() {
				if ($("#toolbar select").val() != 0) {
					document.location.href="/serie/" + $("#toolbar select").val();
				}
			  });
			  $(".resume[title]").tooltip();
		  });
	   </script>
       
       <?php if($session->read('Auth.User.role') > 0) { ?>
       <script type="text/javascript">
       $(function() {
			$('.edito').editable('/users/editEdito', {
				 id        : 'data[User][id]',
				 name      : 'data[User][edito]',
				 type      : 'textarea',
				 cancel    : 'Annuler',
				 submit    : 'Valider',
				 tooltip   : 'Cliquer pour éditer votre édito'
			});
		});
		</script>
        <?php } ?>
        
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<div id="header">
    	<div class="width">
        	<div id="logo"><h2 class="white">serie-all : serie tv, actualite series tv</h2></div>
            <div id="bup">
            <!-- COMCLICK France : 728 x 90 -->
				<iframe src="http://fl01.ct2.comclick.com/aff_frame.ct2?id_regie=1&num_editeur=19988&num_site=1&num_emplacement=7" WIDTH="728" HEIGHT="90" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" bordercolor="#000000"></iframe>
			<!-- FIN TAG --></div>
        	</div>
    </div>
    <div id="menu">
        <div class="width">
            <ul class="left">
            	<li class="nobleft"><?php echo $html->link('Accueil', '/'); ?></li>
                <li><?php echo $html->link('Séries TV', '/series-tv'); ?></li>
                <li><?php echo $html->link('Planning US', '/planning-series-tv'); ?></li>
                <li><?php echo $html->link('Classement', '/classement-series-tv'); ?></li>
                <li class="red"><?php echo $html->link('Awards 2010', '/awards-2010'); ?></li>
                <li><?php echo $html->link('Critiques', '/critiques'); ?></li>
                <li><?php echo $html->link('News', '/actualite'); ?></li>
                <li class="nobright"><?php echo $html->link('Dossiers', '/dossiers'); ?></li>
            </ul>
            
            <cake:nocache>
            <ul class="right">
            	<li class="nobleft"><?php echo $html->link('Forum', '/forum'); ?></li>
                <li><?php if($session->read('Auth.User.role') > 0) echo $html->link('Profil', '/profil/' . $session->read('Auth.User.login')); else echo $html->link('Connexion', '#connexion', array('rel' => 'facebox')); ?></li>
                <li class="nobright"><?php if($session->read('Auth.User.role') > 0) echo $html->link('Déconnexion', '/users/logout'); else echo $html->link('Inscription', '/inscription'); ?></li>
            </ul>
            </cake:nocache>
        </div>
    </div>
	
            
	<div id="toolbar">
    	<table width="100%">
        <tr>
        <td class="td-twitter" width="60%">
        	<?php
        	echo $html->link($html->image('icons/twitter.png', array('alt' => 'twitter', 'title' => 'Compte Twitter', 'border' => 0, 'align' => 'absmiddle')), 'http://twitter.com/serieall', array('escape' => false));
			function parse($text)
			{
			 $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $text);
			 $text = preg_replace('#@([a-z0-9_]+)#i', '@<a href="http://twitter.com/$1">$1</a>', $text);
			 //$text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a href="http://search.twitter.com/search?q=%23$1">$1</a>', $text);
			 return $text;
			}
			
			$user = "serieall"; /* Nom d'utilisateur sur Twitter */
			$count = 1; /* Nombre de message à afficher */
			$url = 'http://twitter.com/statuses/user_timeline/'.$user.'.xml';
			$oXML = simplexml_load_file( $url );
			$trouve = false;
			
			foreach( $oXML->status as $oStatus ) {
				if ($oStatus->source != '<a href="http://twitterfeed.com" rel="nofollow">twitterfeed</a>') {
					echo parse($oStatus->text);
					$trouve = true;
			 	}
				if ($trouve == true) break;
			}
			?>
        </td>
        <td>
        	<?php echo $this->element('quickaccess'); ?>
        </td>
        <td class="td-right">
        	<!--<span id="follow-twitterapi"></span>
			<script type="text/javascript">
              twttr.anywhere(function (T) {
                T('#follow-twitterapi').followButton("serieall");
              });
            </script>
			-->
        	<?php 
			echo $html->link($html->image('icons/spotify.png', array('alt' => 'playlist bo series spotify', 'title' => 'Profil Spotify', 'border' => 0, 'align' => 'absmiddle')), 'http://serieall.fr/article/playlist-bo-series-tv-spotify_a435.html', array('escape' => false));
			echo '&nbsp;&nbsp;';
			echo $html->link($html->image('icons/rss.png', array('alt' => 'rss', 'title' => 'Flux RSS', 'border' => 0, 'align' => 'absmiddle')), 'http://feeds.feedburner.com/SerieAllArticles', array('escape' => false));
			echo '&nbsp;&nbsp;';
			?>
        	<?php echo $form->text('Show.name', array('id' => 'autoComplete', 'value' => 'Bientôt disponible ...')); ?>
        </td>
        </tr>
        </table>
                
        <div id="connexion" style="display:none">
        <?php
		echo $form->create('User', array( 'action' => 'login')); 
		echo '<fieldset><legend>Informations à remplir</legend><br /><br />'; 
		e($form->input('login', array('label' => 'Identifiant :')));
		e($form->input('password', array('label' => 'Mot de passe :')));
		e($form->end("Connexion"));
		echo '</fieldset>';
		?>
        </div>
    </div>
    
    <div id="contentTop"></div>
    <div id="content">
    
		<?php echo $content_for_layout; ?>
        
        <div class="spacer"></div>
 		<br /><br /><br />
    </div>
    
    <div id="contentBottom"></div>
    <div id="footer">
    <table class="footer" width="100%">
    <tr>
        <td width="15%" class="td-borderright">
        	<strong>Serie All</strong> <br /><br />
            <ul style="list-style-type:none">
            	<li><?php echo $html->link('A propos', '/a-propos'); ?></li>
                <li><?php echo $html->link('Notre équipe', '/notre-equipe'); ?></li>
                <li><?php echo $html->link('Mentions légales', '/mentions-legales'); ?></li>
            </ul>
        </td>
        <td width="15%" class="td-borders">
        	<strong>Communauté</strong> <br /><br />
            <ul style="list-style-type:none">
            	<li><?php echo $html->link('Liste des membres', '/membres'); ?></li>
                <li><?php echo $html->link('Forum', '/forum'); ?></li>
                <li><?php echo $html->link('Devenir rédacteur', '/contacts/index'); ?></li>
            </ul>
        </td>
        <td width="15%" class="td-borders">
        	<strong>Aide</strong> <br /><br />
            <ul style="list-style-type:none">
            	<li><?php echo $html->link('FAQ', '#'); ?></li>
                <li><?php echo $html->link('Nous contacter', '/contacts/index'); ?></li>
                <li><?php echo $html->link('Proposer un article', '/contacts/index'); ?></li>
            </ul>
        </td>
        <td width="15%" class="td-borders">
        	<strong>Rubriques</strong> <br /><br />
            <ul style="list-style-type:none">
            	<li><?php echo $html->link('Critiques', '/critiques'); ?></li>
                <li><?php echo $html->link('News', '/actualite'); ?></li>
                <li><?php echo $html->link('Vidéos', '/videos-trailers'); ?></li>
                <li><?php echo $html->link('Dossiers', '/dossiers'); ?></li>
                <li><?php echo $html->link('Bilans', '/bilans'); ?></li>
                <li><?php echo $html->link('Focus', '/focus'); ?></li>
                <li><?php echo $html->link('Portraits', '/portraits'); ?></li>
            </ul>
        </td>
        <td width="15%" class="td-borders">
        	<strong>Votre compte</strong> <br /><br />
            <ul style="list-style-type:none">
            	<li><?php echo $html->link('Inscription', '/inscription'); ?></li>
                <li><?php echo $html->link('Connexion', '#connexion'); ?></li>
            </ul>
        </td>
        <td width="15%" class="td-borderleft">
        	<strong>Partenaires</strong> <br /><br />
            <ul style="list-style-type:none">
            	<li><?php echo $html->link('Bande annonce', 'http://trailerhd.tv', array('title' => 'Bande annonce')); ?></li>
            	<li><?php echo $html->link('Dzik', 'http://dzik.fr', array('title' => 'Dzik')); ?></li>
                <li><?php echo $html->link('Mes Webséries', 'http://www.meswebseries.fr/', array('title' => 'Mes Webséries')); ?></li>
            </ul>
        </td>
        <td width="30%">
        </td>
    </tr>
    </table>
    </div>
    
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11059857-1");
pageTracker._trackPageview();
} catch(err) {}</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11059857-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>                  

<?php if ($session->check('Message.flash')) {	$session->flash();} ?>
</body>
</html>

