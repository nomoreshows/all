<?php
class Poll extends AppModel {
	
	var $name = 'Poll';
	var $hasMany = array('Question');

	var $order = 'Poll.id ASC';
}