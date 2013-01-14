<p>Merci de nous avoir contacté. Voici la copie de ce que nous allons recevoir :</p>
<p>Date : <?php e(date('d/m/Y H:i')); ?></p> 
<p>Envoyé par : <?php e($data['Contact']['nom'].' '.$data['Contact']['prenom']); ?></p>
<p>Adresse email : <?php e($data['Contact']['email']); ?></p> 
<p><?php e($data['Contact']['message']); ?></p>