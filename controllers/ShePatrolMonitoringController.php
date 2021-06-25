<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use app\models\AuditPatrolTbl;

class ShePatrolMonitoringController extends \app\controllers\base\AuditPatrolController
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
            'CATEGORY' => 4
        ])
        ->groupBy('PATROL_DATE')
        ->orderBy('PATROL_DATE')
        ->all();

        $outstanding_data = AuditPatrolTbl::find()
        ->where([
            'STATUS' => 'O',
            'FLAG' => 1,
            'CATEGORY' => 4,
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

    public function actionSolve($ID){
        $model = $this->findModel($ID);
        $custom_model = new \yii\base\DynamicModel([
            'ID', 'ACTION', 'upload_after_1'
        ]);

        if ($model->IMAGE_AFTER_1 == null) {
            $custom_model->addRule(['ID', 'ACTION', 'upload_after_1'], 'required');
        } else {
            $custom_model->addRule(['ID', 'ACTION'], 'required');
        }
        
        $custom_model->ID = $ID;
        $custom_model->upload_after_1 = $model->IMAGE_AFTER_1;

        if ($custom_model->load($_POST)) {
            $model->STATUS = 'C';
            $model->ACTION = $custom_model->ACTION;
            if ($model->save()) {
                $custom_model->upload_after_1 = UploadedFile::getInstance($custom_model, 'upload_after_1');
                if ($custom_model->upload_after_1) {
                    $new_filename_a1 = $custom_model->ID . '_SHE_PATROL_AFTER_1.' . $custom_model->upload_after_1->extension;
                    $filePath_a1 = \Yii::getAlias("@app/web/uploads/SHE_PATROL/") . $new_filename_a1;
                    $custom_model->upload_after_1->saveAs($filePath_a1);
                    Image::getImagine()->open($filePath_a1)->thumbnail(new Box(1280, 720))->save($filePath_a1 , ['quality' => 90]);
                    AuditPatrolTbl::UpdateAll(['IMAGE_AFTER_1' => $new_filename_a1], ['ID' => $custom_model->ID]);
                }
                
                return $this->redirect(Url::previous());
            }
        } else {
            return $this->render('solve', [
                'model' => $model,
                'custom_model' => $custom_model,
            ]);
        }
    }
}