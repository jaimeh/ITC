<?php
class User extends AppModel {
	var $name = 'User';
	var $validate = array(
		'username'   => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Alpha-numeric names only."'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Username already taken. Try again.'
			)
		),
		
		'email' => array(
			'email' => array(
				'rule' => 'email', 
				'message' => 'Invalid e-mail.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Email already in use. Try again.'
			)
		),
		
		'date_of_birth' => array(
			'rule' => 'date',
			'message' => 'Enter a valid date',
		),
		
		'role' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Rank' => array(
			'className' => 'Rank',
			'foreignKey' => 'rank_id',
		)
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Point' => array(
			'className' => 'Point',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Vote' => array(
			'className' => 'Vote',
			'foreignKey' => 'user_id',
			'dependent' => false,
		)
	);

	var $actsAs = array(
		'UploadPack.Upload' => array(
			'avatar' => array(
				'styles' => array(
					'small' => '40x40',
					'medium' => '120x120',
				)
			)
		),
		'Welcome.Membership',
	);
	
	function afterSave($created) {
		if ($created) {
			$this->grantPoints('user-register', $this->id);
		}
	}

	/**
	 * Function for granting a user points via a point event
	 * Requires that you pass a string id key for the point event and the target user's id. Foreign_id optional
	 *
	 * @param $event string The PointEvent.id key that the user is being given points for
	 * @param $userId int The currently logged-in user's id to be associated with the record
	 * @param $foreignId int The primary id of the related model-record that earned the points
	 */
	function grantPoints($event, $userId, $foreignId = null) {
		//@TODO Should point event use the key as the primary key?
		$data['Point']['user_id'] = $userId;
		$data['Point']['point_event_id'] = $event;
		if ($foreignId)
			$data['Point']['foreign_id'] = $foreignId;
		return $this->Point->save($data);
	}
	
}
?>