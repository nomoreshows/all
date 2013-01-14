<?php
class Question extends AppModel {
	
	var $name = 'Question';
	var $belongsTo = array('Poll');
	var $hasMany = array('Answer', 'Vote');

	var $order = 'Question.id ASC';
}