<?php
class Vote extends AppModel {
	
	var $name = 'Vote';
	var $belongsTo = array('User', 'Answer', 'Question', 'Poll');

	var $order = 'Vote.id ASC';
}