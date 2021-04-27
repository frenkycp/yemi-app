<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use app\models\AuditPatrolTbl;

class CovidPatrolMonitoringController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01', strtotime(' -3 months'));
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_data_patrol = AuditPatrolTbl::find()
        ->select([
        	'PATROL_DATE',
        	'total_open' => 'SUM(CASE WHEN STATUS = \'O\' THEN 1 ELSE 0 END)',
        	'total_close' => 'SUM(CASE WHEN STATUS = \'C\' THEN 1 ELSE 0 END)',
        ])
        ->where([
        	'AND',
        	['>=', 'PATROL_DATE', $model->from_date],
        	['<=', 'PATROL_DATE', $model->to_date],
        ])
        ->andWhere([
            'FLAG' => 1,
            'CATEGORY' => 3
        ])
        ->groupBy('PATROL_DATE')
        ->orderBy('PATROL_DATE')
        ->all();

        $outstanding_data = AuditPatrolTbl::find()
        ->where([
            'STATUS' => 'O',
            'FLAG' => 1,
            'CATEGORY' => 3,
        ])
        ->orderBy('PATROL_DATE DESC')
        ->all();

        $tmp_data = $categories = $data = [];
        foreach ($tmp_data_patrol as $value) {
            $post_date = (strtotime($value->PATROL_DATE . " +7 hours") * 1000);
            $categories[] = date('D, d M Y', strtotime($value->PATROL_DATE));

            $tmp_data['total_open'][] = [
                //'x' => $post_date,
                'y' => $value->total_open == 0 ? null : (int)$value->total_open,
            ];
            $tmp_data['total_close'][] = [
                //'x' => $post_date,
                'y' => $value->total_close == 0 ? null : (int)$value->total_close,
            ];
        }

        $data = [
            [
                'name' => 'Temuan Open',
                'data' => $tmp_data['total_open'],
                'color' => [
                    'pattern' => [
                        'path' => 'M 0 1.5 L 2.5 1.5 L 2.5 0 M 2.5 5 L 2.5 3.5 L 5 3.5',
                        'color' => "#b22a00",
                        'width' => 5,
                        'height' => 5
                    ]
                ],
            ],
            [
                'name' => 'Temuan Close',
                'data' => $tmp_data['total_close'],
                'color' => [
                    'pattern' => [
                        'path' => 'M 0 1.5 L 2.5 1.5 L 2.5 0 M 2.5 5 L 2.5 3.5 L 5 3.5',
                        'color' => "#357a38",
                        'width' => 5,
                        'height' => 5
                    ]
                ]
            ],
        ];

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
            'categories' => $categories,
            'outstanding_data' => $outstanding_data,
		]);
	}
}