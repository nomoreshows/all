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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('Serie All -'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('admin');
		echo $html->css('jquery-ui-1.7.2');
		echo $html->css('jquery.jgrowl');
		echo $html->css('jqtransform');

		echo $javascript->link('jquery-1.3.2.min', true);
		echo $javascript->link('jquery-ui-1.7.2.custom.min', true);
		echo $javascript->link('jquery.sexy-combo-2.1.2.pack', true);
		echo $javascript->link('jquery.jeditable', true);
		echo $javascript->link('jquery.form', true);
		echo $javascript->link('jquery.jgrowl', true);
		echo $javascript->link('tiny_mce/tiny_mce', true);
		
		echo $javascript->link('jqtransformplugin/jquery.jqtransform', true);		

		// echo $scripts_for_layout;
	?>
        <script type="text/javascript">
			  $("select").sexyCombo();
		</script>
		<script language="javascript">
			$(function(){
				$('form.jqTransform').jqTransform({imgPath:'js/jqtransformplugin/img/'});
			});
		</script>
			
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id="header">
    	<div id="header-left"></div>
        <div id="header-center">
            <table width="100%">
            <tr>
            	<td><div id="logo"></div></td>
                <td class="path"><h1><?php echo $html->image('icons/logo.png'); ?> Administration <?php echo $html->image('icons/next.png'); ?> <?php echo $title_for_layout; ?></h1>
                	<br />
            		<span class="notes">Revenir à la <strong class="green"><?php echo $html->link("page d'accueil", 'http://www.serieall.fr', array('class' => 'decogreen')); ?></strong>.</span></td>
           		</tr>
            </table>
            <div id="path">
            </div>
            <div id="menu">
                <ul>
                	
                    <li><?php echo $html->link($html->image("menu/accueil.png", array("class" => "absmiddle")) . ' &nbsp;Accueil', '/admin/', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/serie.png", array("class" => "absmiddle")) . ' Séries', '/admin/shows', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/saison.png", array("class" => "absmiddle")) . ' Saisons', '/admin/seasons', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/episode.png", array("class" => "absmiddle")) . ' Episodes', '/admin/episodes', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/acteurs.png", array("class" => "absmiddle")) . ' Acteurs', '/admin/actors', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/acteurs.png", array("class" => "absmiddle")) . ' Rôles', '/admin/roles', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/saison.png", array("class" => "absmiddle")) .' Genres', '/admin/genres', array('escape' => false)); ?></li>
                    <li><?php echo $html->link($html->image("menu/saison.png", array("class" => "absmiddle")) .' Citations', '/admin/quotes', array('escape' => false)); ?></li>
                </ul>
            </div>
        </div>
        <div id="header-right"></div>
    
    </div>
    
    <div id="page">
        <div id="content">
        
            <?php
            if ($session->check('Message.auth')) {$session->flash('auth');}
            ?>

            <?php echo $content_for_layout; ?>
            <div class="spacer"> </div>
        </div>
    </div>
    
    <div id="footer"></div>
        
    
    <br /><br />
    <?php echo $cakeDebug; ?>
    <?php if ($session->check('Message.flash')) {	$session->flash();} ?>
</body>
</html>

