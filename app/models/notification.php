<?php
class Notification extends AppModel {
	
	var $name = 'Notification';
	
	var $belongsTo = array(
		'User'
    );

	var $order = 'Notification.created DESC';

}