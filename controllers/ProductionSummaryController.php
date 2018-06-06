<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\SernoPlanView;

class ProductionSummaryController extends Controller
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
        $title = 'Production Summary';
        $subtitle = date('d M Y');
        $sernoPlan = SernoPlanView::find()->where(['<>', 'balance', 0])->all();
        
        foreach ($sernoPlan as $value) {
            $presentase = round(($value->output_plan/$value->qty_plan)*100);
            $dataClose[] = (int)$presentase;
            $dataOpen[] = (int)(100 - $presentase);
            $dataName[] = $value->gmc_plan . '<br/>' . $value->model . ' ' . $value->dest . ' ' . $value->color;
            $data[] = [
                'y' => (int)$presentase,
                'name' => $value->gmc_plan
            ];
        }
        
        return $this->render('index', [
            'dataku' => $data, 
            'dataOpen' => $dataOpen,
            'dataClose' => $dataClose,
            'dataName' => $dataName,
            'title' => $title,
            'subtitle' => $subtitle,
        ]);
    }
}