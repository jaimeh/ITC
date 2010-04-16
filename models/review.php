<?php
class Review extends AppModel {
	var $name = 'Review';
	var $order = 'Review.created DESC';
	var $validate = array(
		'name' => array(
			'alphaNumeric' => array(
				'rule' => '/^[\\w\\s]+$/', 
				'message' => 'Alpha-numeric characters only.',
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a name.'
			)
		),
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a description.'
			)
		),
	);
	// Used for populating the droplist on the form
	var $visibilities = array(
		'Public' => 'Public',
		'Private' => 'Private',
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User'
	);
	
	var $hasMany = array(
		'Subscriber' => array(
			'className' => 'Subscription',
			'foreignKey' => 'foreign_id',
			'conditions' => array('Subscription.foreign_model' => 'Review'),
		),
		'Source',
	);

	var $hasAndBelongsToMany = array(
		'Tag',
		'Language',
	);
	
	function beforeSave() {
		$this->owner();
		return true;
	}
	
	function afterSave($created) {
		if (isset($this->data['Source'])) {
			foreach ($this->data['Source'] as $source) {
				$source['review_id'] = $this->id;
				$this->Source->save($source);
			}
		}
		if ($created) {
			$this->User->grantPoints('create-review', $this->data['Review']['user_id'], $this->id);
		}
	}

}
?>