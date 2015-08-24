<h2>Administration de Série-All</h2>
<br />

<table class="administration">
	<tr>
    	<?php if ($role < 4) { ?>
    	<td width="68"><?php echo $html->link($html->image('icons/admin_infos.png'), '#', array('escape' => false)); ; ?></td>
        <td width="200"><h3 class="green"><?php echo $html->link('Wiki', '/wiki'); ?></h3> Guide d'utilisation de l'interface de rédaction, conseils, ...<br /><br /></td>
        <?php } else { ?>
        <td width="68"></td>
        <td width="200"></td>
        <?php } ?>
        
        <?php if ($role < 4) { ?>
        <td width="68" class="padleft"><?php echo $html->link($html->image('icons/admin_serie.png'), '/admin/shows', array('escape' => false)); ; ?></td>
        <td width="200"><h3 class="green"><?php echo $html->link('Gérer les séries', '/admin/shows'); ?></h3>Ajouter &amp; modifier les séries, saisons, épisodes, acteurs, BO ...<br /><br /></td>
        <?php } else { ?>
        <td width="68"></td>
        <td width="200"></td>
        <?php } ?>
    </tr>
	<tr>
    	<?php if ($role < 3) { ?>
    	<td width="68"><?php echo $html->image('icons/admin_contenu.png'); ?> </td>
        <td width="200"><h3 class="green"><?php echo $html->link('Ajout de contenu', '/admin/articles/index/all'); ?></h3>Ajouter des news, critiques, bilans, portaits ...<br /><br /></td>
        <?php } else { ?>
        <td width="68"></td>
        <td width="200"></td>
        <?php } ?>
        
        <?php if ($role < 2) { ?>
        <td width="68" class="padleft"><?php echo $html->link($html->image('icons/admin_users.png'), '/admin/users', array('escape' => false)); ; ?></td>
        <td width="200"><h3 class="green"><?php echo $html->link('Gérer les utilisateurs', '/admin/users'); ?></h3>Vérifier les utilisateurs, modération des commentaires ...<br /><br />
        </td>
        <?php } else { ?>
        <td width="68"></td>
        <td width="200"></td>
        <?php } ?>
    </tr>
    <tr>
    	<?php if ($role < 2) { ?>
    	<td><?php echo $html->image('icons/admin_pref.png'); ?></td>
        <td><h3 class="green"><?php echo $html->link('Préférences', '/admin/slogans'); ?></h3>Réglages généraux du site.<br /><br /><br /></td>
        <?php } else { ?>
        <td width="68"></td>
        <td width="200"></td>
        <?php } ?>
        
        <td class="padleft"></td>
        <td></td>
    </tr>
</table>
