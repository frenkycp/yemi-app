<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\InspectionJudgementDataView;

class ProductionInspectionDailyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$categories = [];

		$etd = date('Y-m-d');

		$data_arr = InspectionJudgementDataView::find()
		->select([
			'cntr', 'dst', 'total_plan' => 'SUM(total_plan)', 'total_ok' => 'SUM(total_ok)'
		])
		->where([
			'etd' => $etd
		])
		->groupBy('cntr, dst')
		->all();

		$tmp_data_open = $tmp_data_close = [];

		foreach ($data_arr as $key => $value) {
			$categories[] = $value->cntr . ' - ' . $value->dst;
			$close_percentage = round(($value->total_ok / $value->total_plan) * 100, 2);
			$open_percentage = round((($value->total_plan - $value->total_ok) / $value->total_plan) * 100, 2);

			$tmp_data_close[] = [
				'y' => $close_percentage == 0 ? null : (float)$close_percentage,
				'qty' => $value->total_ok,
				'url' => Url::to(['get-remark', 'etd' => $etd, 'cntr' => $value->cntr, 'dst' => $value->dst, 'status' => 1]),
				//'remark' => $this->actionGetRemark($etd, $value->cntr, $value->dst, 1)
			];
			$tmp_data_open[] = [
				'y' => $open_percentage == 0 ? null : (float)$open_percentage,
				'qty' => ($value->total_plan - $value->total_ok),
				'url' => Url::to(['get-remark', 'etd' => $etd, 'cntr' => $value->cntr, 'dst' => $value->dst, 'status' => 0]),
				//'remark' => $this->actionGetRemark($etd, $value->cntr, $value->dst, 0)
			];
		}

		$data = [
			[
				'name' => 'Outstanding',
				'data' => $tmp_data_open,
				'color' => 'FloralWhite',
			],
			[
				'name' => 'Completed',
				'data' => $tmp_data_close,
				'color' => 'rgba(72,61,139,0.6)',
			]
		];

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'etd' => $etd,
		]);
	}

	public function getRemark($etd, $cntr, $dst, $status)
	{
		if ($status == 0) {
			$data_arr = InspectionJudgementDataView::find()
			->where([
				'etd' => $etd,
				'cntr' => $cntr,
				'dst' => $dst
			])
			->andWhere('total_ok <> total_plan')
			->all();
		} else {
			$data_arr = InspectionJudgementDataView::find()
			->where([
				'etd' => $etd,
				'cntr' => $cntr,
				'dst' => $dst
			])
			->andWhere('total_ok = total_plan')
			->all();
		}

		$data = '<h4>' . $cntr . ' - ' . $dst . '</h4>';
        $data .= '<table class="table table-bordered table-hover">';
        $data .= 
        '<thead style=""><tr class="info">
            <th class="text-center">GMC</th>
            <th class="text-center">Plan</th>
            <th class="text-center">Output</th>
            <th class="text-center">OK</th>
            
        </tr></thead>';
        $data .= '<tbody style="">';

        foreach ($data_arr as $value) {
            
            $data .= '
                <tr>
                    <td class="text-center">' . $value->gmc . '</td>
                    <td class="text-center">' . $value->total_plan . '</td>
                    <td class="text-center">' . $value->total_output . '</td>
                    <td class="text-center">' . $value->total_ok . '</td>
                    
                </tr>
            ';
        }

        $data .= '</tbody>';

        $data .= '</table>';
        return $data;
	}

	public function actionGetRemark($etd, $cntr, $dst, $status)
	{
		if ($status == 0) {
			$data_arr = InspectionJudgementDataView::find()
			->where([
				'etd' => $etd,
				'cntr' => $cntr,
				'dst' => $dst
			])
			->andWhere('total_ok <> total_plan')
			->orderBy('gmc')
			->all();
		} else {
			$data_arr = InspectionJudgementDataView::find()
			->where([
				'etd' => $etd,
				'cntr' => $cntr,
				'dst' => $dst
			])
			->andWhere('total_ok = total_plan')
			->orderBy('gmc')
			->all();
		}

		$data = '<h4>' . $cntr . ' - ' . $dst . '</h4>';
        $data .= '<table class="table table-bordered table-hover">';
        $data .= 
        '<thead style=""><tr class="info">
            <th class="text-center">GMC</th>
            <th class="text-center">Description</th>
            <th class="text-center">Plan</th>
            <th class="text-center">Output</th>
            <th class="text-center">OK</th>
            <th class="text-center">Balance</th>
        </tr></thead>';
        $data .= '<tbody style="">';

        foreach ($data_arr as $value) {
            
            $data .= '
                <tr>
                    <td class="text-center">' . $value->gmc . '</td>
                    <td class="text-center">' . $value->partName . '</td>
                    <td class="text-center">' . $value->total_plan . '</td>
                    <td class="text-center">' . $value->total_output . '</td>
                    <td class="text-center">' . $value->total_ok . '</td>
                    <td class="text-center">' . ($value->total_ok - $value->total_plan) . '</td>
                </tr>
            ';
        }

        $data .= '</tbody>';

        $data .= '</table>';
        return $data;
	}
}