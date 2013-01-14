<?php
class User extends AppModel {
	
	var $name = 'User';
	var $hasMany = array('Rate','Article', 'Comment', 'Notification', 'Reaction', 'Quote');
	/* var $hasAndBelongsToMany = array(
        'Show' =>
            array(
                'className'              => 'Show',
                'joinTable'              => 'shows_users',
                'foreignKey'             => 'show_id',
                'associationForeignKey'  => 'user_id'
            ),
		'Show' =>
            array(
                'className'              => 'Show',
                'joinTable'              => 'shows_liste',
                'foreignKey'             => 'show_id',
                'associationForeignKey'  => 'user_id'
            )
    ); */
	var $hasAndBelongsToMany = array('Show' => array('with' => 'Followedshows'));

	
	var $actsAs = array('ExtendAssociations', 'Containable'); 
	var $displayField = 'login';
	
	var $order = 'User.id DESC';
	
	var $validate = array(
						  
		'login' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => 'Ne doit contenir que des chiffres et/ou des lettres et être unique à chaque utilisateur.',
			'on' => 'create'
		),
		'email' => array(
			'rule' => 'email',
			'required' => true,
			'allowEmpty' => false,
			'message' => 'Entrez une adresse mail valide.',
			'on' => 'create'
		)
	);

	
}