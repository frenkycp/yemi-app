<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\ContainerView;
use yii\helpers\Url;

class DailyContainerDisplayController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';

		$etd = date('Y-m-d');
    	$container = ContainerView::find()->where(['etd' => $etd])->orderBy('dst ASC')->all();
    	$total_container = 0;
        $total_airshipment = 0;

		foreach ($container as $key => $value) {
			$close_percentage = (int)floor(($value->output / $value->qty) * 100);
			$open_percentage = (int)(100 - $close_percentage);
			$dataOpen[] = [
				'y' => $open_percentage > 0 ? $open_percentage : null,
				'qty' => $value->balance,
				'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd, 'dst' => $value->dst, 'back_order' => $value->back_order]),
			];
            $dataClose[] = [
				'y' => $close_percentage > 0 ? $close_percentage : null,
				'qty' => $value->output,
				'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd, 'dst' => $value->dst, 'back_order' => $value->back_order]),
			];
            //$dataOpen[] = 50;
            //$dataClose[] = 50;
            $str_container = '_container)';
            if ($value->back_order == 2) {
                $str_container = '_airshipment)';
            }
            $str_airplane = '_airplane';
            if($value->total_cntr > 1)
            {
            	$str_container = '_containers)';
                if ($value->back_order == 2) {
                    $str_container = '_airshipments)';
                }
            }
            $total_container += $value->back_order != 2 ? $value->total_cntr : 0;
            $total_airshipment += $value->back_order == 2 ? $value->total_cntr : 0;
            $dataName[] = $value->dst . ' (' . $value->total_cntr . $str_container;
		}
		//return json_encode($dataOpen);
		$containerStr = $total_container . ' Container || ' . $total_airshipment . ' Air Shipment';
		if($total_container > 1)
		{
			$containerStr = $total_container . ' Containers || ' . $total_airshipment . ' Air Shipments';
		}

    	return $this->render('index', [
    		'dataOpen' => $dataOpen,
    		'dataClose' => $dataClose,
    		'dataName' => $dataName,
    		'containerStr' => $containerStr,
    		'etd' => $etd
    	]);
	}
}