<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
 
<html>
<body>
	<?php e($content_for_layout);?> 
    <p>Date : <?php e(date('d/m/Y H:i')); ?></p> 
    <p>Envoyé par : <?php e($data['Contact']['nom'].' '.$data['Contact']['prenom']); ?></p>
    <p>Adresse email : <?php e($data['Contact']['email']); ?></p> 
    <p><?php e($data['Contact']['message']); ?></p>
</body>
</html>