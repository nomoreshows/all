<?php
class Rate extends AppModel {
	
	var $name = "Rate";
	
	var $belongsTo = array('Show','Season','Episode','User');
	
	var $order = "Rate.id DESC";

}
?>
