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
		echo $html->css('jquery.jgrowl');
		echo $javascript->link('jquery-1.3.2.min', true);
		echo $javascript->link('jquery.jeditable', true);
		echo $javascript->link('jquery.form', true);
		echo $javascript->link('jquery.jgrowl', true);
		echo $scripts_for_layout;
	?>
	
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
                	
                    <li><a href="/serieall/admin/"><?php echo $html->image('menu/accueil.png', array('class' => 'absmiddle')); ?> &nbsp;Accueil</a></li>
                    <!-- <li><a href="#"><?php echo $html->image('menu/stats.png', array('class' => 'absmiddle')); ?> Statistiques</a></li>
                    <li><a href="#"><?php echo $html->image('menu/reglages.png', array('class' => 'absmiddle')); ?> Réglages</a></li> -->
                    <li><a href="/serieall/users/logout"><?php echo $html->image('menu/deco.png', array('class' => 'absmiddle')); ?> Déconnexion</a></li>
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

