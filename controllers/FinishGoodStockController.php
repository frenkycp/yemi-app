<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;
use app\models\SernoInput;
use yii\helpers\Url;

/**
 * summary
 */
class FinishGoodStockController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/

    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$x_categories = [];
    	$remark = '';

        $stock_arr = SernoInput::find()
        ->select([
            'dst' => 'tb_serno_output.dst',
            //'prod_output_qty' => 'SUM(CASE WHEN loct = 0 THEN 1 ELSE 0 END)',
            //'in_transit_qty' => 'SUM(CASE WHEN loct = 1 THEN 1 ELSE 0 END)',
            'fa_output_qty' => 'SUM(CASE WHEN loct = 1 AND qa_ok = \'\' THEN 1 ELSE 0 END)',
            'fa_output_ok_qty' => 'SUM(CASE WHEN loct = 1 AND qa_ok = \'OK\' THEN 1 ELSE 0 END)',
            'finish_goods_qty' => 'SUM(CASE WHEN loct = 2 AND qa_ok = \'\' THEN 1 ELSE 0 END)',
            'finish_goods_ok_qty' => 'SUM(CASE WHEN loct = 2 AND qa_ok = \'OK\' THEN 1 ELSE 0 END)',
            'stock_qty' => 'COUNT(dst)'
        ])
        ->joinWith('sernoOutput')
        ->where(['>=', 'etd', date('Y-m-d')])
        ->groupBy('tb_serno_output.dst')
        ->orderBy('stock_qty DESC')
        ->asArray()
        ->all();

        $grand_total = 0;
        $grand_total_kubikasi = 0;
        $tmp_data = [];

        $tmp_kubikasi_arr = SernoOutput::find()
        ->select([
            'gmc' => 'gmc',
            'dst',
            'stock_qty' => 'SUM(output)'
        ])
        ->where(['>', 'output', 0])
        ->andWhere(['>=', 'etd', date('Y-m-d')])
        ->groupBy('gmc')
        ->all();

    	foreach ($stock_arr as $stock_data) {
    		$x_categories[] = $stock_data['dst'];
            $grand_total += (int)$stock_data['stock_qty'];

            $total_kubikasi = 0;

            foreach ($tmp_kubikasi_arr as $value) {
                if ($value->dst == $stock_data['dst']) {
                    $gmc = $value->gmc;
                    $m3 = (float)$value->getItemM3()->VOLUME;
                    $total_kubikasi += (int)$value->stock_qty * $m3;
                }
            }

            $grand_total_kubikasi += $total_kubikasi;

            /*$tmp_data[0][] = [
                'y' => (int)$stock_data['prod_output_qty'],
                'url' => Url::to(['get-remark', 'dst' => $stock_data['dst'], 'loct' => 0]),
            ];*/
            /*$tmp_data[1][] = [
                'y' => (int)$stock_data['in_transit_qty'],
                'url' => Url::to(['get-remark', 'dst' => $stock_data['dst'], 'loct' => 1]),
            ];*/
            $tmp_data[0][] = [
                'y' => (int)$stock_data['finish_goods_qty'],
                'url' => Url::to(['get-remark', 'dst' => $stock_data['dst'], 'loct' => 2]),
            ];
            $tmp_data[1][] = [
                'y' => (int)$stock_data['finish_goods_ok_qty'],
                'url' => Url::to(['get-remark', 'dst' => $stock_data['dst'], 'loct' => 2]),
            ];
            $tmp_data[2][] = [
                'y' => (int)$stock_data['fa_output_qty'],
                'url' => Url::to(['get-remark', 'dst' => $stock_data['dst'], 'loct' => 1]),
            ];
            $tmp_data[3][] = [
                'y' => (int)$stock_data['fa_output_ok_qty'],
                'url' => Url::to(['get-remark', 'dst' => $stock_data['dst'], 'loct' => 1]),
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

    public function actionGetRemark($dst, $loct)
    {
        $detail_stock = SernoInput::find()
        ->select([
            'tb_serno_input.gmc',
            'dst',
            'loct',
            'stock_qty' => 'COUNT(dst)'
        ])
        ->joinWith('sernoOutput')
        ->where(['>=', 'etd', date('Y-m-d')])
        ->andWhere([
            'dst' => $dst,
            'loct' => $loct
        ])
        ->groupBy('tb_serno_input.gmc, dst, loct')
        ->orderBy('stock_qty DESC')
        ->all();

        switch ($loct) {
            case 1:
                $location = 'InTransit Area (トランジットエリア）';
                break;

            case 2:
                $location = 'Finish Good WH  (完成品倉庫)';
                break;
            
            default:
                $location = 'Production Floor (生産職場)';
                break;
        }

        $remark = '<h4>' . $location . ' <small>' . $dst . '</small></h4>';
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '
        <tr>
            <th style="text-align: center;">GMC</th>
            <th>Description</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Cubic (m3)</th>
        </tr>
        ';

        foreach ($detail_stock as $detail) {
            //if ($detail->dst == $dst && $detail->loct == $loct) {
            $remark .= '
            <tr>
                <td style="text-align: center;">' . $detail->gmc . '</td>
                <td>' . $detail->getPartName() . '</td>
                <td style="text-align: center;">' . $detail->stock_qty . '</td>
                <td style="text-align: center;">' . round(($detail->stock_qty * $detail->getItemM3()->one()->VOLUME), 2) . '</td>
            </tr>';
            //}
        }

        $remark .= '</table>';

        return $remark;
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
                    <td style="text-align: center;">' . round(($detail->stock_qty * $detail->getItemM3()->VOLUME), 2) . '</td>
                </tr>';
            }
        }

        $remark .= '</table>';

        return $remark;
    }
}