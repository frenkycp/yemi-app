<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoFg;
use app\models\SernoFgSumView;
use app\models\SernoFgSumViewMonth;

class ShippingController extends Controller
{
    /* public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    } */
    
    public function weekOfMonth($date) {
        //Get the first day of the month.
        $firstOfMonth = strtotime(date("Y-m-01", $date));
        //Apply above formula.
        return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
    }
    
    public function actionIndexCopy()
    {
        //$sernoFg = 
        $title = 'Daily Report';
        $subtitle = date('d M Y');
        $planActual = \app\models\PlanActual::find()->where(['tgl_cont' => date('d.m.Y')])->orderBy('shipto ASC')->all();

        if(isset($_GET['category']))
        {
            if($_GET['category'] == 1)
            {
                $title = 'Weekly Report';
                $week = $this->weekOfMonth(strtotime(date('Y-m-d')));
                $subtitle = 'Week ' . $week;
                $planActual = \app\models\PlanActual::find()->all();
            }else{
                $title = 'Monthly Report';
                $subtitle = date('M Y');
                $planActual = \app\models\PlanActualMonthly::find()->where(['bulan' => date('m.Y')])->orderBy('shipto ASC')->all();
            }
        }
        
        foreach ($planActual as $value) {
            $dataOpen[] = (int)(100 - $value->persentase);
            $dataClose[] = (int)$value->persentase;
            $dataName[] = $value->shipto;
            $data[] = [
                'y' => (int)$value->persentase,
                'name' => $value->shipto
            ];
        }
        //print_r($data);
        return $this->render('index', 
                [
                    'dataku' => $data, 
                    'dataOpen' => $dataOpen,
                    'dataClose' => $dataClose,
                    'dataName' => $dataName,
                    'title' => $title,
                    'subtitle' => $subtitle,
                ]);
    }
    
    public function actionIndex()
    {
        $title = 'Daily Report';
        $subtitle = date('d M Y');
        
        $sernoFg = SernoFgSumView::find()->where(['tgl_cont' => date('d.m.Y')])->orderBy('shipto ASC')->all();
        
        if(isset($_GET['category']))
        {
            if($_GET['category'] == 1)
            {
                
            } else {
                $title = 'Monthly Report';
                $subtitle = date('M Y');
                $sernoFg = SernoFgSumViewMonth::find()->where(['bulan' => date('m.Y')])->orderBy('shipto ASC')->all();
            }
        }
        
        foreach ($sernoFg as $value) {
            $presentase = round(($value->actual/$value->plan)*100);
            $dataClose[] = (int)$presentase;
            $dataOpen[] = (int)(100 - $presentase);
            $dataName[] = $value->shipto;
            $data[] = [
                'y' => (int)$presentase,
                'name' => $value->shipto
            ];
        }
        
        return $this->render('index', 
                [
                    'dataku' => $data, 
                    'dataOpen' => $dataOpen,
                    'dataClose' => $dataClose,
                    'dataName' => $dataName,
                    'title' => $title,
                    'subtitle' => $subtitle,
                ]);
    }
}