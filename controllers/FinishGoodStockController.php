<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;
use app\models\SernoInput;

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

        $stock_arr = SernoInput::find()
        ->select([
            'dst' => 'tb_serno_output.dst',
            'prod_output_qty' => 'SUM(CASE WHEN loct = 0 THEN 1 ELSE 0 END)',
            'in_transit_qty' => 'SUM(CASE WHEN loct = 1 THEN 1 ELSE 0 END)',
            'finish_goods_qty' => 'SUM(CASE WHEN loct = 2 THEN 1 ELSE 0 END)',
            'stock_qty' => 'COUNT(dst)'
        ])
        ->joinWith('sernoOutput')
        ->where(['>=', 'etd', date('Y-m-d')])
        ->groupBy('tb_serno_output.dst')
        ->orderBy('stock_qty DESC')
        ->all();

        $grand_total = 0;
        $grand_total_kubikasi = 0;
        $tmp_data = [];

        $tmp_kubikasi_arr = SernoOutput::find()
        ->select([
            'gmc' => 'gmc',
            'stock_qty' => 'SUM(output)'
        ])
        ->where(['>', 'output', 0])
        ->andWhere(['>=', 'etd', date('Y-m-d')])
        ->groupBy('gmc')
        ->all();

        $detail_stock = SernoInput::find()
        ->select([
            'tb_serno_input.gmc',
            'dst',
            'loct',
            'stock_qty' => 'COUNT(dst)'
        ])
        ->joinWith('sernoOutput')
        ->where(['>=', 'etd', date('Y-m-d')])
        ->groupBy('tb_serno_input.gmc, dst, loct')
        ->orderBy('stock_qty DESC')
        ->all();

    	foreach ($stock_arr as $stock_data) {
    		$x_categories[] = $stock_data->dst;
            $grand_total += (int)$stock_data->stock_qty;

            $total_kubikasi = 0;

            foreach ($tmp_kubikasi_arr as $value) {
                if ($value->dst == $stock_data->dst) {
                    $gmc = $value->gmc;
                    $m3 = (float)$value->getItemM3()->volume;
                    $total_kubikasi += (int)$value->stock_qty * $m3;
                }
            }

            $grand_total_kubikasi += $total_kubikasi;

    		$data[] = [
    			'y' => (int)$stock_data->stock_qty,
    			//'remark' => $remark,
                'total_kubikasi' => round($total_kubikasi, 1),
    		];
            $tmp_data[0][] = [
                'y' => (int)$stock_data->prod_output_qty,
                'remark' => $this->getRemarks($detail_stock, $stock_data->dst, 0),
                'total_kubikasi' => round($total_kubikasi, 1),
            ];
            $tmp_data[1][] = [
                'y' => (int)$stock_data->in_transit_qty,
                'remark' => $this->getRemarks($detail_stock, $stock_data->dst, 1),
                'total_kubikasi' => round($total_kubikasi, 1),
            ];
            $tmp_data[2][] = [
                'y' => (int)$stock_data->finish_goods_qty,
                'remark' => $this->getRemarks($detail_stock, $stock_data->dst, 2),
                'total_kubikasi' => round($total_kubikasi, 1),
            ];
    	}

        $total_kontainer = round($grand_total_kubikasi / 54, 1);

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'categories' => $x_categories,
    		'data' => $tmp_data,
            'grand_total' => $grand_total,
            'grand_total_kubikasi' => round($grand_total_kubikasi, 1),
            'total_kontainer' => $total_kontainer
    	]);
    }

    public function getRemarks($detail_stock, $dst, $loct)
    {
        $remark = '<table class="table table-bordered table-striped table-hover">';
        $remark .= '
        <tr>
            <th style="text-align: center;">GMC</th>
            <th>Description</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Cubic (m3)</th>
        </tr>
        ';

        foreach ($detail_stock as $detail) {
            if ($detail->dst == $dst && $detail->loct == $loct) {
                $remark .= '
                <tr>
                    <td style="text-align: center;">' . $detail->gmc . '</td>
                    <td>' . $detail->getPartName() . '</td>
                    <td style="text-align: center;">' . $detail->stock_qty . '</td>
                    <td style="text-align: center;">' . round(($detail->stock_qty * $detail->getItemM3()->volume), 1) . '</td>
                </tr>';
            }
        }

        $remark .= '</table>';

        return $remark;
    }
}