<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;

/**
 * summary
 */
class FinishGoodStockController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$x_categories = [];
    	$remark = '';

    	$stock_arr = SernoOutput::find()
    	->select([
    		'dst' => 'dst',
    		'stock_qty' => 'SUM(output)'
    	])
    	->where(['>', 'output', 0])
    	->andWhere(['>=', 'etd', date('Y-m-d')])
    	->andWhere(['!=', 'stc', 'ADVANCE'])
        ->andWhere(['!=', 'stc', 'NOSO'])
    	->groupBy('dst')
    	->orderBy('stock_qty DESC')
    	->all();

        $grand_total = 0;

    	foreach ($stock_arr as $stock_data) {
    		$x_categories[] = $stock_data->dst;

            $grand_total += (int)$stock_data->stock_qty;

    		$detail_stock = SernoOutput::find()
    		->select([
    			'gmc' => 'gmc',
    			'stock_qty' => 'SUM(output)'
    		])
    		->where(['>', 'output', 0])
    		->andWhere(['>=', 'etd', date('Y-m-d')])
    		->andWhere(['dst' => $stock_data->dst])
    		->groupBy('gmc')
    		->orderBy('stock_qty DESC')
    		->all();

    		$remark = '<table class="table table-bordered table-striped table-hover">';
    		$remark .= '
    		<tr>
    			<th style="text-align: center;">GMC</th>
    			<th>Description</th>
    			<th style="text-align: center;">Qty</th>
    		</tr>
    		';

    		foreach ($detail_stock as $detail) {
    			$remark .= '
    			<tr>
    				<td style="text-align: center;">' . $detail->gmc . '</td>
    				<td>' . $detail->getPartName() . '</td>
    				<td style="text-align: center;">' . $detail->stock_qty . '</td>
    			</tr>
    			';
    		}

    		$remark .= '</table>';

    		$data[] = [
    			'y' => (int)$stock_data->stock_qty,
    			'remark' => $remark
    		];
    	}

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'categories' => $x_categories,
    		'data' => $data,
            'grand_total' => $grand_total
    	]);
    }
}