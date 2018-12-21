<?php
namespace app\controllers;

use yii\web\Controller;

/**
 * 
 */
class LineCompletionController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		$data = [];
		return $this->render('index', [
			'data' => $data
		]);
	}
}