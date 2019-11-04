<?php
namespace app\controllers;
use yii\rest\Controller;
use app\models\WipEffTbl;

class ProductionPlanRestController extends Controller
{
	public function actionIndex($child_analyst = '', $line = '')
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$tmp_condition = [
			'plan_run' => 'R'
		];
		if ($child_analyst != '') {
			$tmp_condition['child_analyst'] = $child_analyst;
		}
		if ($line != '') {
			$tmp_condition['LINE'] = $line;
		}

		$tmp_plan = WipEffTbl::find()
		->select([
			'lot_id', 'child_analyst', 'child_analyst_desc', 'LINE', 'child_all', 'child_desc_all', 'qty_all', 'model_group', 'parent', 'parent_desc'
		])
		->where($tmp_condition)
		->asArray()->all();

		return $tmp_plan;
	}
}