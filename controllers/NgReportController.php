<?php

namespace app\controllers;

use app\models\search\MesinCheckNgSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class NgReportController extends Controller
{
	function actionIndex()
	{
		return $this->render('index');
	}
}