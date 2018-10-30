<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\SernoLosstime;

/**
 * 
 */
class DprLosstimeCategoryController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$data = [];
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}
		$period = $year . $month;

		$data_losstime = SernoLosstime::find()
		->select([
			'period' => 'extract(year_month from proddate)',
			'category',
			'losstime' => 'SUM(losstime)'
		])
		->where([
			'not in', 'category', ['UNKNOWN', 'CANCELED', 'CM']
		])
		->andWhere(['>', 'losstime', 0])
		->groupBy('period, category')
		->having([
			'period' => $period
		])
		->orderBy('losstime DESC')
		->all();

		foreach ($data_losstime as $value) {
			$categories[] = $value->category;
			$tmp_data[] = [
				'y' => round($value->losstime, 2),
				'url' => Url::to(['get-remark', 'period' => $period, 'category' => $value->category])
			];
		}
		$data[] = [
			'name' => 'Loss Time',
			'data' => $tmp_data
		];

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionGetRemark($period, $category)
	{
		$data = '<h4>Category : ' . $category . '</h4>';
        $data .= '<table class="table table-bordered table-hover">';
        $data .= 
        '<thead><tr class="info">
            <th class="text-center">Prod. Date</th>
            <th class="text-center">Line</th>
            <th class="text-center">Start Time</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Lost Time (min)</th>
        </tr></thead>';
        $data .= '<tbody>';

        $get_arr_data = SernoLosstime::find()
        ->where([
        	'category' => $category,
        	'extract(year_month from proddate)' => $period
        ])
        ->orderBy('losstime DESC')
        ->asArray()
        ->all();

        foreach ($get_arr_data as $value) {

            $data .= '
                <tr>
                    <td class="text-center">' . $value['proddate'] . '</td>
                    <td class="text-center">' . $value['line'] . '</td>
                    <td class="text-center">' . $value['start_time'] . '</td>
                    <td class="text-center">' . $value['end_time'] . '</td>
                    <td class="text-center">' . number_format($value['losstime'], 2) . '</td>
                </tr>
            ';
            
        }
        $data .= '</tbody>';

        $data .= '</table>';
        return $data;
	}
}