<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SernoInput;
use app\models\SernoMaster;
use yii\helpers\Url;

class DailyInspectionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex($value='')
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = [];

		$model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        $model->load($_GET);

		$serno_input_data = SernoInput::find()
		->select([
			'proddate',
			'total' => 'COUNT(pk)',
			'total_check' => 'SUM(CASE WHEN qa_ok != \'\' OR qa_ng != \'\' THEN 1 ELSE 0 END)',
			'total_no_check' => 'SUM(CASE WHEN qa_ok = \'\' AND qa_ng = \'\' THEN 1 ELSE 0 END)'
		])
		->where(['AND', ['>=', 'proddate', $model->from_date], ['<=', 'proddate', $model->to_date]])
		->groupBy('proddate')
		->asArray()
		->all();

		$tmp_data = [];
		foreach ($serno_input_data as $key => $value) {
			$proddate = (strtotime($value['proddate'] . " +7 hours") * 1000);
			$tmp_data['open'][] = [
				'x' => $proddate,
                'y' => $value['total_no_check'] == 0 ? null : (int)$value['total_no_check'],
                'url' => Url::to(['get-inspection-detail', 'proddate' => $value['proddate'], 'status' => 'qa_ok = \'\' AND qa_ng = \'\''])
			];
			$tmp_data['close'][] = [
				'x' => $proddate,
                'y' => $value['total_check'] == 0 ? null : (int)$value['total_check'],
                'url' => Url::to(['get-inspection-detail', 'proddate' => $value['proddate'], 'status' => 'qa_ok != \'\' OR qa_ng != \'\''])
			];
		}

		$data = [
			[
				'name' => 'OPEN',
				'data' => $tmp_data['open'],
				'color' => \Yii::$app->params['bg-red'],
			],
			[
				'name' => 'CLOSE',
				'data' => $tmp_data['close'],
				'color' => \Yii::$app->params['bg-green'],
			],
		];

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}

	public function actionGetInspectionDetail($proddate, $status)
	{
		$detail_arr = SernoInput::find()
		->select([
			'gmc',
			'total' => 'COUNT(pk)'
		])
		->where([
			'proddate' => $proddate
		])
		->andWhere($status)
		->groupBy('gmc')
		->orderBy('COUNT(pk) DESC')
		->asArray()
		->all();

		$gmc_arr = [];
		foreach ($detail_arr as $key => $value) {
			$gmc_arr[] = $value['gmc'];
		}

		$tmp_master = SernoMaster::find()
		->where([
			'gmc' => $gmc_arr
		])
		->asArray()
		->all();

		$gmc_desc_arr = [];
		foreach ($tmp_master as $key => $value) {
			$desc = $value['model'];
			if ($value['color'] != '') {
				$desc .= ' // ' . $value['color'];
			}
			if ($value['dest'] != '') {
				$desc .= ' // ' . $value['dest'];
			}
			$gmc_desc_arr[$value['gmc']] = $desc;
		}

	    $remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Prod. Date : ' . $proddate . '</h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
	    $remark .= '<tr>
	    	<th class="text-center">GMC</th>
	    	<th>Description</th>
	    	<th class="text-center">Qty</th>
	    </tr>';

	    foreach ($detail_arr as $value) {
    		$remark .= '<tr>
    			<td class="text-center">' . $value['gmc'] . '</td>
    			<td>' . $gmc_desc_arr[$value['gmc']] . '</td>
	    		<td class="text-center">' . $value['total'] . '</td>
	    	</tr>';
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}