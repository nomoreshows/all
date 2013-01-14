<?php 
$ajout = array('0' => '-- Accès rapide aux séries --');
$quickshows = $ajout + $quickshows;
echo $form->input('show_id', array('div' => false, 'label' => false, 'class' => 'combo', 'options' => $quickshows));
?>