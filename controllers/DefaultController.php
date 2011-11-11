<?php

/**
 * DefaultController class file.
 * 
 * This controller simply shows an index file by default
 *
 * @author Corey Tisdale <corey[at]eyewantmedia[dot]com>
 * @link http://www.yiiframework.com/extension/audittrail/
 * @copyright Copyright &copy; 2010-2011 Eye Want Media, LLC
 * @package auditTrail
 */
 
class DefaultController extends AuditTrailController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}