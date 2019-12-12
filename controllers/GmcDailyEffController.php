<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SernoInputAll;

class GmcDailyEffController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		//gmc = VAE8860
		$data = $tmp_data = [];
		$model = new \yii\base\DynamicModel([
            'gmc', 'from_date', 'to_date'
        ]);
        $model->addRule(['gmc', 'from_date', 'to_date'], 'required');
        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

		if ($model->load($_GET)) {
            $tmp_si_all = SernoInputAll::find()
            ->select([
            	'proddate', 'gmc',
            	'qty_time' => 'ROUND(SUM(qty_time), 2)',
            	'mp_time' => 'ROUND(SUM(mp_time), 2)',
            ])
			->where(['gmc' => $model->gmc])
			->andWhere([
	            'AND',
	            ['>=', 'proddate', $model->from_date],
	            ['<=', 'proddate', $model->to_date]
	        ])
			->groupBy('proddate, gmc')
			->orderBy('proddate')
			->all();

			foreach ($tmp_si_all as $key => $value) {
				$proddate = (strtotime($value->proddate . " +7 hours") * 1000);
				$tmp_eff = 0;
				if ($value->mp_time > 0) {
					$tmp_eff = round(($value->qty_time / $value->mp_time) * 100, 1);
				}
				$tmp_data[] = [
	                'x' => $proddate,
	                'y' => (float)$tmp_eff,
	            ];
			}
        }

        $data[] = [
        	'name' => 'GMC Efficiency',
        	'data' => $tmp_data
        ];

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}
}