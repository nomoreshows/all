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
<!DOCTYPE html>
<html lang="fr">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
        <?php __('| Série-All'); ?>
	</title>
	<meta name="google-site-verification" content="Uv2dNiTiCqRRP1vgIEQGhv-NYFCryN9C1ZSeFQxvCbc" />
    <link rel="apple-touch-icon" href="/favicons/touch-icon-iphone.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="/favicons/touch-icon-ipad.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="/favicons/touch-icon-iphone4.png" />
    <link rel="canonical" href="https://serieall.fr/<?php echo $this->params['url']['url']; ?>" />
    
	<?php
		echo $html->meta('rss', 'https://feeds.feedburner.com/SerieAllArticles', array('title' => "Série-All"));
		echo $html->meta('icon');
		//echo $html->css('jquery-ui-1.7.2');
		echo $html->css('general');
		//echo $html->css('chosen');
		//echo $html->css('facebox');
		//echo $html->css('jquery.jgrowl');
		//echo $html->css('nivo-slider');
		echo $html->css('common');
		
		echo $javascript->link('jquery-1.3.2.min', true);	
	?>
        
		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="https://serieall.fr/js/jquery.cookies.js"></script>
<script type="application/x-social-share-privacy-settings">{"path_prefix":"https://panzi.github.io/SocialSharePrivacy/","layout":"line","services":{"buffer":{"status":false},"delicious":{"status":false},"disqus":{"status":false},"fbshare":{"status":false},"flattr":{"status":false},"hackernews":{"status":false},"linkedin":{"status":false},"mail":{"status":false},"pinterest":{"status":false},"reddit":{"status":false},"stumbleupon":{"status":false},"tumblr":{"status":false},"xing":{"status":false}}}</script>
</head>

<body>
	<div id="header">
    	<div id="menu">
            <div class="width">
                <ul class="menu">
                    <li class="nobleft"><?php echo $html->link('<span>Accueil</span>', '/', array('escape' => false)); ?></li>
                    <li><?php echo $html->link('<span>Séries TV</span>', '/series-tv', array('escape' => false)); ?></li>
                    <li><?php echo $html->link('<span>Planning US</span>', '/planning-series-tv', array('escape' => false)); ?></li>
                    <li><?php echo $html->link('<span>Classements</span>', '/classement-series-tv', array('escape' => false)); ?></li>
                    <li><?php echo $html->link('<span>Articles ▼</span>', '#', array('escape' => false)); ?>
                    	<ul class="dropdown">
                        	<li><?php echo $html->link('Critiques', '/critiques', array('escape' => false)); ?></li>
                            <li><?php echo $html->link('Actualité', '/actualite', array('escape' => false)); ?></li>
                            <li><?php echo $html->link('Vidéos', '/videos-trailers', array('escape' => false)); ?></li>
                            <li><?php echo $html->link('Dossiers', '/dossiers', array('escape' => false)); ?></li>
                            <li><?php echo $html->link('Focus', '/focus', array('escape' => false)); ?></li>
                            <li><?php echo $html->link('Bilans', '/bilans', array('escape' => false)); ?></li>
                            <li><?php echo $html->link('Portraits', '/portraits', array('escape' => false)); ?></li>
							<li><?php echo $html->link('Podcasts', '/podcast', array('escape' => false)); ?></li>
                        </ul>                    
                    </li>
		    <li class="notif-new"><?php echo $html->link('<span>Nouveautés 2017-2018</span>', '/nouvelles-series-2017-2018', array('escape' => false)); ?></li>
		<li class="notif"><?php echo $html->link('<span>Awards 2016</span>', '/awards-2016', array('escape' => false)); ?></li>
		
		</ul>
                
                <cake:nocache>
                <ul class="right menu">
					<?php if ($session->read('Auth.User.role') > 0) { ?><li class="<?php if($nbnotifications > 0) echo 'notif-new'; ?>"><?php echo $html->link('<span class="notif-badge">' .  $nbnotifications . '</span>', '/profil/'. $session->read('Auth.User.login') . '/notifications', array('escape' => false, 'title' => $nbnotifications . ' notification(s)')); ?></li><?php } ?>
                    <li><?php echo $html->link('<span>Forum</span>', '/forum', array('escape' => false)); ?></li>
                    <li><?php if($session->read('Auth.User.role') > 0) echo $html->link('<span>Profil</span>', '/profil/' . $session->read('Auth.User.login'), array('escape' => false)); else echo $html->link('<span>Connexion</span>', '#connexion', array('rel' => 'facebox','escape' => false)); ?></li>
                    <li class="current nobright"><?php if($session->read('Auth.User.role') > 0) echo $html->link('<span>Déconnexion</span>', '/users/logout', array('escape' => false)); else echo $html->link('<span>Inscription</span>', '/inscription', array('escape' => false)); ?></li>
                </ul>
                </cake:nocache>
            </div>
        </div>
    </div>
	
            
	<div id="toolbar">
    	<table width="100%">
        <tr>
            <td class="td-logo" rowspan="2">
                <div id="logo"><?php echo $html->link($html->image('logo_v2.png', array('alt' => 'actualite series tv - serieall')), '/', array('escape'=> false)); ?></div>
            </td>
            <td class="td-twitter" rowspan="2">
                <?php
				echo '&laquo; ' . $slogan['Slogan']['name'] . ' &raquo; ';
				if(!empty($slogan['Slogan']['url'])) {
					echo '<span class="slogan-source">'. $html->link($slogan['Slogan']['source'], $slogan['Slogan']['url']) . '</span>';
				} else {
					echo '<span class="slogan-source">'. $slogan['Slogan']['source'] . '</span>';
				}
                ?>
            </td>
            <td colspan="2">&nbsp;
            	
            </td>
        <tr>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td width="150">
            	<?php echo $this->element('quickaccess'); ?>
            </td>
            <td class="td-right">
                <?php 
				echo '&nbsp;&nbsp;';
				echo $html->link($html->image('icons/facebook.png', array('alt' => 'facebook', 'title' => 'Compte Facebook', 'border' => 0, 'align' => 'absmiddle')), 'http://www.facebook.com/SerieAll', array('escape' => false));
				echo '&nbsp;&nbsp;';
				echo $html->link($html->image('icons/twitter.png', array('alt' => 'twitter', 'title' => 'Compte Twitter', 'border' => 0, 'align' => 'absmiddle')), 'http://twitter.com/serieall', array('escape' => false));
				echo '&nbsp;&nbsp;';
				echo $html->link($html->image('icons/googlePlus.png', array('alt' => 'google plus', 'title' => 'Compte Google +', 'border' => 0, 'align' => 'absmiddle')), 'https://plus.google.com/u/0/104705584593645730861', array('escape' => false));
				echo '&nbsp;&nbsp;';
                echo $html->link($html->image('icons/spotify.png', array('alt' => 'playlist bo series spotify', 'title' => 'Profil Spotify', 'border' => 0, 'align' => 'absmiddle')), 'http://serieall.fr/article/playlist-bo-series-tv-spotify_a435.html', array('escape' => false));
                echo '&nbsp;&nbsp;';
                echo $html->link($html->image('icons/rss.png', array('alt' => 'rss', 'title' => 'Flux RSS', 'border' => 0, 'align' => 'absmiddle')), 'http://feeds.feedburner.com/SerieAllArticles', array('escape' => false));
                echo '&nbsp;&nbsp;';
                ?>
                <?php // echo $form->text('Show.name', array('id' => 'autoComplete', 'value' => 'Bientôt disponible ...')); ?>
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
                <li><?php echo $html->link('CGU', '/cgu'); ?></li>
		<li><?php echo $html->link('Nous contacter', '/contacts/index'); ?></li>
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
        	<strong>Réseaux sociaux</strong> <br /><br />
            <ul style="list-style-type:none">
                <li><?php echo $html->link('Facebook', 'http://www.facebook.com/SerieAll'); ?></li>
                <li><?php echo $html->link('Twitter', 'http://twitter.com/serieall'); ?></li>
                <li><?php echo $html->link('Google +', 'http://plus.google.com/u/0/104705584593645730861'); ?></li>
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
            	<li><?php echo $html->link('Vodd', 'https://vodd.co', array('title' => 'Vodd')); ?></li>
            </ul>
        </td>
        <td width="30%">
        </td>
    </tr>
    </table>
    </div>
            

<?php if ($session->check('Message.flash')) {	$session->flash();} 

		
		//echo $javascript->link('jquery-ui-1.7.2.custom.min', true);
		//echo $javascript->link('jquery.jgrowl', true);
		//echo $javascript->link('jquery.easing.1.3', true);
		//echo $javascript->link('jquery.chosen', true);
		//echo $javascript->link('facebox', true);
		echo $javascript->link('jquery.galleryview-2.0-pack', true);
		//echo $javascript->link('jquery.timers-1.1.2', true);
		//echo $javascript->link('jquery.sexy-combo-2.1.2.pack', true);
		//echo $javascript->link('jquery.jeditable', true);
		//echo $javascript->link('jquery.form', true);
		//echo $javascript->link('swfobject', true);
		//echo $javascript->link('jquery.tools.min', true);
		//echo $javascript->link('perso.cnil', true);
		
		echo $javascript->link('common', true);
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
			  $("select.combo").chosen();
			  $("select.sexycombo").sexyCombo();
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
				 cssclass  : 'editoForm',
				 type      : 'textarea',
				 cols 	   : '57',
				 cancel    : 'Annuler',
				 submit    : 'Valider',
				 tooltip   : 'Cliquer pour éditer votre édito'
			});
		});
		</script>
        <?php } ?>
		
		
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-11059857-1']);
	  _gaq.push(['_trackPageview']);
	  _gaq.push(['_setAllowAnchor', true]);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script> 
	
	<script type="text/javascript">(function () {var s = document.createElement('script');var t = document.getElementsByTagName('script')[0];s.type = 'text/javascript';s.async = true;s.src = 'https://panzi.github.io/SocialSharePrivacy/javascripts/jquery.socialshareprivacy.min.autoload.js';t.parentNode.insertBefore(s, t);})();</script></body>
</html>

