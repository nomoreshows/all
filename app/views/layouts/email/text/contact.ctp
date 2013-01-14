Merci de nous avoir contacté. Voici la copie de ce que nous allons recevoir :
 
Date : <?php e(date('d/m/Y H:i')); ?>
Envoyé par : <?php e($data['Contact']['nom'].' '.$data['Contact']['prenom']); ?>
Adresse email : <?php e($data['Contact']['email']); ?>
<?php e($data['Contact']['message']); ?>