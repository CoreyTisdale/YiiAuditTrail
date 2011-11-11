<?php

class DefaultController extends AuditTrailController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}