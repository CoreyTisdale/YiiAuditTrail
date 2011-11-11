<?php

/**
 * LoggableBehavior class file.
 * 
 * LoggableBehavior allows logging of audit trails automatically
 *
 * This class was adapted from a Yii Wiki article on leaving an audit trail
 * the {@link http://www.yiiframework.com/wiki/9/how-to-log-changes-of-activerecords How To Log Changes of Active Records}.
 *
 * The idea is that we can tie into events raised by CActiveRecord to automatically record the creation,
 * modification, and deletion of our models.
 *
 * CONTRIBUTIONS
 * The original article was written by yiiframework.com user pfth. yiiframework.com forum user 'Van Damm' has also
 * contributed a very large code refactoring as well as recommendations for improvement.
 * 
 * @author Corey Tisdale <corey[at]eyewantmedia[dot]com>
 * @link http://www.yiiframework.com/extension/audittrail/
 * @copyright Copyright &copy; 2010-2011 Eye Want Media, LLC
 * @package auditTrail
 */

class LoggableBehavior extends CActiveRecordBehavior
{

	private $_oldattributes = array();

	public function afterSave($event)
	{
		try {
			$username = Yii::app()->user->Name;
			$userid = Yii::app()->user->id;
		} catch(Exception $e) { //If we have no user object, this must be a command line program
			$username = "NO_USER";
			$userid = null;
		}
		
		if(empty($username)) {
			$username = "NO_USER";
		}
		
		if(empty($userid)) {
			$userid = null;
		}
	
		$newattributes = $this->Owner->getAttributes();
		$oldattributes = $this->getOldAttributes();
		
		if (!$this->Owner->isNewRecord) {
			// compare old and new
			foreach ($newattributes as $name => $value) {
				if (!empty($oldattributes)) {
					$old = $oldattributes[$name];
				} else {
					$old = '';
				}

				if ($value != $old) {
					$log=new AuditTrail();
					$log->old_value = $old;
					$log->new_value = $value;
					$log->action = 'CHANGE';
					$log->model = get_class($this->Owner);
					$log->model_id = $this->Owner->getPrimaryKey();
					$log->field = $name;
					$log->stamp = date('Y-m-d H:i:s');
					$log->user_id = $userid;
					
					$log->save();
				}
			}
		} else {
			$log=new AuditTrail();
			$log->old_value = '';
			$log->new_value = '';
			$log->action=		'CREATE';
			$log->model=		get_class($this->Owner);
			$log->model_id=		 $this->Owner->getPrimaryKey();
			$log->field=		'N/A';
			$log->stamp= date('Y-m-d H:i:s');
			$log->user_id=		 $userid;
			
			$log->save();
			
			
			foreach ($newattributes as $name => $value) {
				$log=new AuditTrail();
				$log->old_value = '';
				$log->new_value = $value;
				$log->action=		'SET';
				$log->model=		get_class($this->Owner);
				$log->model_id=		 $this->Owner->getPrimaryKey();
				$log->field=		$name;
				$log->stamp= date('Y-m-d H:i:s');
				$log->user_id=		 $userid;
				$log->save();
			}
			
			
			
		}
		return parent::afterSave($event);
	}

	public function afterDelete($event)
	{
	
		try {
			$username = Yii::app()->user->Name;
			$userid = Yii::app()->user->id;
		} catch(Exception $e) {
			$username = "NO_USER";
			$userid = null;
		}

		if(empty($username)) {
			$username = "NO_USER";
		}
		
		if(empty($userid)) {
			$userid = null;
		}
		
		$log=new AuditTrail();
		$log->old_value = '';
		$log->new_value = '';
		$log->action=		'DELETE';
		$log->model=		get_class($this->Owner);
		$log->model_id=		 $this->Owner->getPrimaryKey();
		$log->field=		'N/A';
		$log->stamp= date('Y-m-d H:i:s');
		$log->user_id=		 $userid;
		$log->save();
		return parent::afterDelete($event);
	}

	public function afterFind($event)
	{
		// Save old values
		$this->setOldAttributes($this->Owner->getAttributes());
		
		return parent::afterFind($event);
	}

	public function getOldAttributes()
	{
		return $this->_oldattributes;
	}

	public function setOldAttributes($value)
	{
		$this->_oldattributes=$value;
	}
	
	
	/**
	* @return string Table's primary key as plain string.
	* Encodes complex keys using JSON.
	*/
	protected function getNormalizedPk()
	{
		$pk = $this->getOwner()->getPrimaryKey();
		return is_array($pk) ? json_encode($pk) : $pk;
	}

	
	
}
?>