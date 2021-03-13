<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use app\models\AuditPatrolTbl;

class AuditPatrolMonitoringController extends Controller
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
        	'PATROL_PRESIDR_OPEN' => 'SUM(CASE WHEN CATEGORY = 1 AND STATUS = \'O\' THEN 1 ELSE 0 END)',
        	'PATROL_PRESIDR_CLOSE' => 'SUM(CASE WHEN CATEGORY = 1 AND STATUS = \'C\' THEN 1 ELSE 0 END)',
        	'PATROL_GM_OPEN' => 'SUM(CASE WHEN CATEGORY = 2 AND STATUS = \'O\' THEN 1 ELSE 0 END)',
        	'PATROL_GM_CLOSE' => 'SUM(CASE WHEN CATEGORY = 2 AND STATUS = \'C\' THEN 1 ELSE 0 END)',
        ])
        ->where([
        	'AND',
        	['>=', 'PATROL_DATE', $model->from_date],
        	['<=', 'PATROL_DATE', $model->to_date],
        ])
        ->groupBy('PATROL_DATE')
        ->orderBy('PATROL_DATE')
        ->all();

        $outstanding_data = AuditPatrolTbl::find()
        ->where(['STATUS' => 'O'])
        ->orderBy('PATROL_DATE DESC')
        ->all();

        $tmp_data = $categories = $data = [];
        foreach ($tmp_data_patrol as $value) {
            $post_date = (strtotime($value->PATROL_DATE . " +7 hours") * 1000);
            $categories[] = date('D, d M Y', strtotime($value->PATROL_DATE));

            $tmp_data['presdir_open'][] = [
                //'x' => $post_date,
                'y' => $value->PATROL_PRESIDR_OPEN == 0 ? null : (int)$value->PATROL_PRESIDR_OPEN,
            ];
            $tmp_data['presdir_close'][] = [
                //'x' => $post_date,
                'y' => $value->PATROL_PRESIDR_CLOSE == 0 ? null : (int)$value->PATROL_PRESIDR_CLOSE,
            ];
            $tmp_data['gm_open'][] = [
                //'x' => $post_date,
                'y' => $value->PATROL_GM_OPEN == 0 ? null : (int)$value->PATROL_GM_OPEN,
            ];
            $tmp_data['gm_close'][] = [
                //'x' => $post_date,
                'y' => $value->PATROL_GM_CLOSE == 0 ? null : (int)$value->PATROL_GM_CLOSE,
            ];
        }

        $data = [
            [
                'name' => 'Temuan Presdir Open',
                'data' => $tmp_data['presdir_open'],
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
                'name' => 'Temuan Presdir Close',
                'data' => $tmp_data['presdir_close'],
                'color' => [
                    'pattern' => [
                        'path' => 'M 0 1.5 L 2.5 1.5 L 2.5 0 M 2.5 5 L 2.5 3.5 L 5 3.5',
                        'color' => "#357a38",
                        'width' => 5,
                        'height' => 5
                    ]
                ]
            ],
            [
                'name' => 'Temuan GM Open',
                'data' => $tmp_data['gm_open'],
                'color' => [
                    'pattern' => [
                        'path' => 'M 0 1.5 L 2.5 1.5 L 2.5 0 M 2.5 5 L 2.5 3.5 L 5 3.5',
                        'color' => "#ffea00 ",
                        'width' => 5,
                        'height' => 5
                    ],
                ],
            ],
            [
                'name' => 'Temuan GM Close',
                'data' => $tmp_data['gm_close'],
                'color' => [
                    'pattern' => [
                        'path' => 'M 0 1.5 L 2.5 1.5 L 2.5 0 M 2.5 5 L 2.5 3.5 L 5 3.5',
                        'color' => "#2c387e",
                        'width' => 5,
                        'height' => 5
                    ],
                ],
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