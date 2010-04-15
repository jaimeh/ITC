<?php
class ReviewsController extends AppController {

	var $name = 'Reviews';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny(array('mine'));
	}

	function index() {
		$this->Review->recursive = 0;
		$this->set('reviews', $this->paginate());
	}
	
	function mine() {
		$this->Review->recursive = 0;
		// This approach is only used for paginate(), not Model->find()
		$this->paginate['conditions']['Review.user_id'] = $this->Auth->user('id');
		$this->set('reviews', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'review'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Review->recursive = 0;
		$this->set('review', $this->Review->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Review->create();
			$this->data['Review']['user_id'] = $this->Auth->user('id');
			if ($this->Review->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'review'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'review'));
			}
		}
		$visibilities = $this->Review->visibilities;
		$languages = $this->Review->Language->find('list');
		$this->set(compact('visibilities', 'languages'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'review'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->data['Review']['user_id'] = $this->Auth->user('id');
			if ($this->Review->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'review'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'review'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Review->read(null, $id);
		}
		$visibilities = $this->Review->visibilities;
		$languages = $this->Review->Language->find('list');
		$this->set(compact('visibilities', 'languages'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'review'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Review->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Review'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Review'));
		$this->redirect(array('action' => 'index'));
	}
}
?>