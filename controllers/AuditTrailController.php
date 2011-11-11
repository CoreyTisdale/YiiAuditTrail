<?php

/**
 * AuditTrailController class file.
 * 
 * All controller classes for this module should extend from this base class. This class inherits from Controller,
 * the default class created by the Yiic scaffolding. This is so any RBAC or other access control you have in place
 * will automatically work with this module
 *
 * @author Corey Tisdale <corey[at]eyewantmedia[dot]com>
 * @link http://www.yiiframework.com/extension/audittrail/
 * @copyright Copyright &copy; 2010-2011 Eye Want Media, LLC
 * @package auditTrail
 */
 
class AuditTrailController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'. You can set
	 * this value in your config file under the auditTrail section by using 'layout' => myfile
	 */
	public $layout = isset(Yii::app()->modules['auditTrail']['layout']) ? Yii::app()->modules['auditTrail']['layout'] : '//layouts/column1';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.You can set
	 * this value in your config file under the auditTrail section by using 'menu' => myArray( … )
	 */
	public $menu = isset(Yii::app()->modules['auditTrail']['menu']) ? Yii::app()->modules['auditTrail']['menu'] : array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.You can set
	 * this value in your config file under the auditTrail section by using 'breadcrumbs' => myArray( … )
	 */
	public $breadcrumbs = isset(Yii::app()->modules['auditTrail']['breadcrumbs']) ? Yii::app()->modules['auditTrail']['breadcrumbs'] : array();
}