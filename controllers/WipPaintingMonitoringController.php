<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\WipFilterModel;
use app\models\WipPlanActualReport;
use app\models\WipLocation;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class WipPaintingMonitoringController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$year_arr = [];
		$month_arr = [];

        $year_now = date('Y');
        $star_year = 2017;
        for ($year = $star_year; $year <= ($year_now + 1); $year++) {
            $year_arr[$year] = $year;
        }

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

    	$period = date('Ym');
    	$model = new WipFilterModel();
    	$model->month = date('m');
		$model->year = date('Y');
        $str_where = $str_where2 = '';
    	if ($model->load($_GET)) {
    		$period = $model->year . $model->month;
            if ($model->category == 1) {
                $str_where .= "delay_category IS NOT NULL AND delay_category != ''";
            }
            if ($model->loc == 'FINAL ASSY' && $model->line != null) {
                $line = $model->line;
                $str_where2 = "LINE = '$line'";
            }
    	}

    	if ($model->loc != null) {
            $model_loc = $model->loc;
            if ($model->loc == 'KD') {
                $model_loc = ['WS01', 'WP00', 'WU00', 'WM00'];
            }
    		$wip_painting_data_arr = WipPlanActualReport::find()
	    	->select([
	    		'week',
	    		'due_date',
	    		'total_plan' => 'SUM(summary_qty)',
	    		'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
	    		//'total_created' => 'SUM(CASE WHEN stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
	    		'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN summary_qty ELSE 0 END)',
	    		'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN summary_qty ELSE 0 END)',
	    		'total_handover' => 'SUM(CASE WHEN stage=\'04-HAND OVER\' THEN summary_qty ELSE 0 END)'
	    	])
	    	->where([
	    		'period' => $period,
	    		'child_analyst' => $model_loc
	    	])
            ->andWhere($str_where)
            ->andWhere($str_where2)
	    	->groupBy('week, due_date')
	    	->orderBy('due_date, week')
            ->asArray()
	    	->all();
    	} else {
            $wip_painting_data_arr = WipPlanActualReport::find()
            ->select([
                'week',
                'due_date',
                'total_plan' => 'SUM(summary_qty)',
                'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
                //'total_created' => 'SUM(CASE WHEN stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
                'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN summary_qty ELSE 0 END)',
                'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN summary_qty ELSE 0 END)',
                'total_handover' => 'SUM(CASE WHEN stage=\'04-HAND OVER\' THEN summary_qty ELSE 0 END)'
            ])
            ->where([
                'period' => $period
            ])
            ->andWhere($str_where)
            ->andWhere($str_where2)
            ->groupBy('week, due_date')
            ->orderBy('due_date, week')
            ->asArray()
            ->all();
        }

    	//$data = [];
    	$week_arr = [];
    	$tmp_data = [];
    	foreach ($wip_painting_data_arr as $wip_painting_data) {
    		$tmp_data[$wip_painting_data['week']]['category'][] = date('Y-m-d', strtotime($wip_painting_data['due_date']));

    		$order_percentage = $wip_painting_data['total_plan'] == 0 ? 0 : round(($wip_painting_data['total_order'] / $wip_painting_data['total_plan']) * 100, 2);
    		//$created_percentage = $wip_painting_data['total_plan'] == 0 ? 0 : round(($wip_painting_data->total_created / $wip_painting_data['total_plan']) * 100, 2);
    		$started_percentage = $wip_painting_data['total_plan'] == 0 ? 0 : round(($wip_painting_data['total_started'] / $wip_painting_data['total_plan']) * 100, 2);
    		$completed_percentage = $wip_painting_data['total_plan'] == 0 ? 0 : round(($wip_painting_data['total_completed'] / $wip_painting_data['total_plan']) * 100, 2);
    		$handover_percentage = $wip_painting_data['total_plan'] == 0 ? 0 : round(($wip_painting_data['total_handover'] / $wip_painting_data['total_plan']) * 100, 2);

    		$tmp_data[$wip_painting_data['week']]['order_percentage'][] = [
    			'y' => $order_percentage == 0 ? null : $order_percentage,
                'url' => Url::to(['get-remark', 'due_date' => $wip_painting_data['due_date'], 'loc' => $model->loc, 'stage' => '00-ORDER', 'category' => $model->category, 'line' => $model->line]),
                'qty' => round($wip_painting_data['total_order'])
    		];
    		$tmp_data[$wip_painting_data['week']]['started_percentage'][] = [
    			'y' => $started_percentage == 0 ? null : $started_percentage,
                'url' => Url::to(['get-remark', 'due_date' => $wip_painting_data['due_date'], 'loc' => $model->loc, 'stage' => '02-STARTED', 'category' => $model->category, 'line' => $model->line]),
                'qty' => round($wip_painting_data['total_started'])
    		];
    		$tmp_data[$wip_painting_data['week']]['completed_percentage'][] = [
    			'y' => $completed_percentage == 0 ? null : $completed_percentage,
                'url' => Url::to(['get-remark', 'due_date' => $wip_painting_data['due_date'], 'loc' => $model->loc, 'stage' => '03-COMPLETED', 'category' => $model->category, 'line' => $model->line]),
                'qty' => round($wip_painting_data['total_completed'])
    		];
    		$tmp_data[$wip_painting_data['week']]['handover_percentage'][] = [
    			'y' => $handover_percentage <= 0 ? null : $handover_percentage,
                'url' => Url::to(['get-remark', 'due_date' => $wip_painting_data['due_date'], 'loc' => $model->loc, 'stage' => '04-HAND OVER', 'category' => $model->category, 'line' => $model->line]),
                'qty' => round($wip_painting_data['total_handover'])
    		];

    		$week_arr[] = $wip_painting_data['week'];
    	}

    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
		if (!in_array($this_week, $week_arr)) {
			$this_week = end($week_arr);
		}

		$data = [];

		foreach ($tmp_data as $week_no => $value) {
			$data[$week_no] = [
				'category' => $value['category'],
				'data' => [
					[
						'name' => 'ORDERED （受注）',
						'data' => $value['order_percentage'],
						'color' => 'rgba(200, 200, 200, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
					],
					/*[
						'name' => 'CREATED',
						'data' => $value['created_percentage'],
						'color' => new JsExpression('Highcharts.getOptions().colors[6]'),
					],*/
					[
						'name' => 'STARTED （加工中）',
						'data' => $value['started_percentage'],
						'color' => 'rgba(240, 240, 0, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
					],
					[
						'name' => 'COMPLETED （加工上がり）',
						'data' => $value['completed_percentage'],
						'color' => 'rgba(0, 150, 255, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
					],
					[
						'name' => 'PULLED BY NEXT (後工程の引取り)',
						'data' => $value['handover_percentage'],
						'color' => 'rgba(0, 240, 0, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
					]
				]
			];
		}

        /*$dropdown_loc = ArrayHelper::map(WipLocation::find()->select('child_analyst_desc')->groupBy('child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc');*/
        $dropdown_loc = \Yii::$app->params['wip_location_arr'];

        unset($dropdown_loc['WS01']);
        unset($dropdown_loc['WP00']);
        unset($dropdown_loc['WU00']);
        unset($dropdown_loc['WM00']);
        $dropdown_loc['KD'] = 'KD PART';
        asort($dropdown_loc);

    	return $this->render('index', [
    		'data' => $data,
    		'this_week' => $this_week,
    		'model' => $model,
    		'dropdown_loc' => $dropdown_loc,
    		'year_arr' => $year_arr,
    		'month_arr' => $month_arr
    	]);
    }

    public function actionGetRemark($due_date, $loc = null, $stage, $category = null, $line = null)
    {
        $stage_arr = [$stage];
        switch ($stage) {
            case '00-ORDER':
                $status = 'ORDERED';
                $stage_arr = ['00-ORDER', '01-CREATED'];
                break;

            /*case '01-CREATED':
                $status = 'ORDERED';
                break;*/

            case '02-STARTED':
                $status = 'STARTED';
                break;

            case '03-COMPLETED':
                $status = 'COMPLETED';
                break;

            case '04-HAND OVER':
                $status = 'PULLED BY NEXT';
                break;
            
            default:
                // code...
                break;
        };

        $str_where = '';
        if ($category == 1) {
            $str_where = "delay_category IS NOT NULL AND delay_category != ''";
        }
        $str_where2 = '';
        if ($loc == 'WF01' && $line != null) {
            $str_where2 = "LINE = '$line'";
        }

        

        if ($loc != null) {
            if ($loc == 'KD') {
                $loc = ['WS01', 'WP00', 'WU00', 'WM00'];
            }
            $remark_data_arr = WipPlanActualReport::find()
            ->select($selected_column)
            ->where([
                'due_date' => $due_date,
                'stage' => $stage_arr,
                'child_analyst' => $loc
            ])
            ->andWhere($str_where)
            ->andWhere($str_where2)
            ->orderBy('child_analyst_desc, model_group, parent, child')
            ->asArray()->all();
        } else {
            $remark_data_arr = WipPlanActualReport::find()
            ->select($selected_column)
            ->where([
                'due_date' => $due_date,
                'stage' => $stage_arr,
                //'urut' => '02'
            ])
            ->andWhere($str_where)
            ->andWhere($str_where2)
            ->orderBy('child_analyst_desc, model_group, parent, child')
            ->asArray()->all();
        }

        $data = '<h4>' . $status . ' <small>on ' . date('Y-m-d', strtotime($due_date)) . '</small></h4>';
        $data .= '<table class="table table-bordered table-hover">';
        $data .= 
        '<thead style="font-size: 10px;"><tr class="info">
            <th class="text-center">Location</th>
            <th class="text-center">Line</th>
            <th class="text-center">Slip No.</th>
            <th class="text-center">Session</th>
            <th class="text-center">GMC</th>
            <th>Model</th>
            <th class="text-center">Child</th>
            <th>Child Description</th>
            <th class="text-center">Lot Qty</th>
            <th class="text-center">Qty</th>
            <th class="text-center" style="min-width: 70px;">FA Start</th>
            <th class="text-center" style="min-width: 70px;">Start Plan</th>
            <th class="text-center" style="min-width: 70px;">End Plan</th>
            <th class="text-center" style="min-width: 70px;">Start Actual</th>
            <th class="text-center" style="min-width: 70px;">Complete Actual</th>
            <th class="text-center" style="min-width: 70px;">Pulled By Next Actual</th>
            <th class="text-center" style="min-width: 70px;">Delay Category</th>
            <th class="" style="min-width: 70px;">Delay Remark</th>
        </tr></thead>';
        $data .= '<tbody style="font-size: 10px;">';

        foreach ($remark_data_arr as $value) {
            $start_plan = $value['start_date'] == null ? '-' : date('Y-m-d', strtotime($value['start_date']));
            $end_plan = $value['due_date'] == null ? '-' : date('Y-m-d', strtotime($value['due_date']));
            $start_actual = $value['start_job'] == null ? '-' : $value['start_job'];
            $end_actual = $value['end_job'] == null ? '-' : $value['end_job'];
            $handover_actual = $value['hand_over_job'] == null ? '-' : $value['hand_over_job'];
            $fa_start = $value['source_date'] == null ? '-' : date('Y-m-d', strtotime($value['source_date']));
            $row_class = '';
            if ($value['delay_last_update'] != null) {
                $row_class = 'danger';
            }

            $data .= '
                <tr class="' . $row_class . '">
                    <td class="text-center">' . $value['child_analyst_desc'] . '</td>
                    <td class="text-center">' . $value['LINE'] . '</td>
                    <td class="text-center">' . $value['slip_id'] . '</td>
                    <td class="text-center">' . $value['session_id'] . '</td>
                    <td class="text-center">' . $value['parent'] . '</td>
                    <td>' . $value['model_group'] . '</td>
                    <td>' . $value['child'] . '</td>
                    <td>' . $value['child_desc'] . '</td>
                    <td class="text-center">' . (int)$value['fa_lot_qty'] . '</td>
                    <td class="text-center">' . (int)$value['summary_qty'] . '</td>
                    <td class="text-center">' . $fa_start . '</td>
                    <td class="text-center">' . $start_plan . '</td>
                    <td class="text-center">' . $end_plan . '</td>
                    <td class="text-center text-green">' . $start_actual . '</td>
                    <td class="text-center text-green">' . $end_actual . '</td>
                    <td class="text-center text-green">' . $handover_actual . '</td>
                    <td class="text-center text-red">' . $value['delay_category'] . '</td>
                    <td class="text-red">' . $value['delay_detail'] . '</td>
                </tr>
            ';
            
        }
        $data .= '</tbody>';

        $data .= '</table>';
        return $data;
    }

}