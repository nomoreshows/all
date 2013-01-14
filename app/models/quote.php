<?php

class Quote extends AppModel {
	
    var $name = 'Quote';   
    var $belongsTo = array('Role','Episode', 'User');
	
	var $order = "Quote.timer ASC";
	
}
?>