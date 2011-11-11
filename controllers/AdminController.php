<?php

/**
 * AdminController class file.
 * 
 * The admin controller allows for easy viewing of your audit trail.
 *
 * @author Corey Tisdale <corey[at]eyewantmedia[dot]com>
 * @link http://www.yiiframework.com/extension/audittrail/
 * @copyright Copyright &copy; 2010-2011 Eye Want Media, LLC
 * @package auditTrail
 */

class AdminController extends AuditTrailController
{
	public $defaultAction = "admin";
	public $layout='//layouts/column1';

	public function actionAdmin()
	{
		$model=new AuditTrail('search');
		$model->unsetAttributes();	// clear any default values
		if(isset($_GET['AuditTrail'])) {
			$model->attributes=$_GET['AuditTrail'];
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}
}