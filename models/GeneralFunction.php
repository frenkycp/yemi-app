<?php
namespace app\models;

use yii\base\Model;
use app\models\WorkDayTbl;
use app\models\ContainerView;
use app\models\IjazahPlanActual;
use app\models\VmsPlanActual;

class GeneralFunction extends Model
{
    public function getIjazahPlanActualLastUpdate($value='')
    {
        $tmp_last_update = IjazahPlanActual::find()->select(['ACT_LAST_UPDATE' => 'MAX(ACT_LAST_UPDATE)'])->one();
        $last_update = date('d M\' Y H:i', strtotime($tmp_last_update->ACT_LAST_UPDATE));
        return $last_update;
    }

    public function getVmsPlanActualLastUpdate($value='')
    {
        $tmp_last_update = VmsPlanActual::find()->select(['ACT_QTY_LAST_UPDATE' => 'MAX(ACT_QTY_LAST_UPDATE)'])->one();
        $last_update = date('d M\' Y H:i', strtotime($tmp_last_update->ACT_QTY_LAST_UPDATE));
        return $last_update;
    }

    public function getTotalShipOut($post_date)
    {
        $period = date('Ym', strtotime($post_date));
        $tmp_ship_out = ContainerView::find()->select(['total_cntr' => 'SUM(total_cntr)'])->where([
            'EXTRACT(YEAR_MONTH FROM etd)' => $period
        ])
        ->andWhere(['<=', 'etd', $post_date])
        ->one();

        return $tmp_ship_out->total_cntr;
    }

    public function getYesterdayDate()
    {
        $today = date('Y-m-d');
        $tmp_yesterday = WorkDayTbl::find()
        ->select([
            'cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'
        ])
        ->where([
            '<', 'FORMAT(cal_date, \'yyyy-MM-dd\')', $today
        ])
        ->andWhere('holiday IS NULL')
        ->orderBy('cal_date DESC')
        ->one();
        $yesterday = date('Y-m-d', strtotime($tmp_yesterday->cal_date));

        return $yesterday;
    }

	public function getWorkingTime($start_time, $end_time)
	{
        $start_date = new \DateTime($start_time);
        $end_date = new \DateTime($end_time);
        $break_time1 = new \DateTime(date('Y-m-d 09:20:00'));
        $break_time1_end = new \DateTime(date('Y-m-d 09:30:00'));
        $break_time2 = new \DateTime(date('Y-m-d 12:10:00'));
        $break_time2_end = new \DateTime(date('Y-m-d 12:50:00'));
        $break_time3 = new \DateTime(date('Y-m-d 14:20:00'));
        $break_time3_end = new \DateTime(date('Y-m-d 14:30:00'));
        $min1 = $min3 = 10;
        $min2 = 40;
        if ($value['status'] == 2) {
            $end_date = new \DateTime($value['tgl']);
        }
        $since_start = $start_date->diff($end_date);

        $minutes = $since_start->days * 24 * 60;
        $minutes += $since_start->h * 60;
        $minutes += $since_start->i;

        if ($today_name == 'Fri') {
            $min2 = 70;
            $break_time2 = new \DateTime(date('Y-m-d 12:00:00'));
            $break_time2_end = new \DateTime(date('Y-m-d 13:10:00'));
            $break_time3 = new \DateTime(date('Y-m-d 14:50:00'));
            $break_time3_end = new \DateTime(date('Y-m-d 15:00:00'));
        }

        if ($start_date < $break_time1 && $end_date > $break_time1_end) {
            $minutes -= $min1;
        }

        if ($start_date < $break_time2 && $end_date > $break_time2_end) {
            $minutes -= $min2;
        }

        if ($start_date < $break_time3 && $end_date > $break_time3_end) {
            $minutes -= $min3;
        }

        return $minutes;
	}

    public function getJsDateFormat($datetime)
    {
        date_default_timezone_set('Asia/Jakarta');
        $new_datetime = (strtotime($datetime . " +7 hours") * 1000);
        return $new_datetime;
    }

    public function getPeriodByRange($start_date, $end_date)
    {
        $d1 = strtotime($start_date . ' -1 month');
        $d2 = strtotime($end_date);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;
        $period_arr = [];

        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $period_arr[] = date('Ym', $min_date);
            $i++;
        }
        
        return $period_arr;
    }

    public function getPeriodBetweenDates($start_date, $end_date)
    {
        $tmp_arr = [];
        $start    = (new \DateTime($start_date))->modify('first day of this month');
        $end      = (new \DateTime($end_date))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period   = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $tmp_arr[] = $dt->format("Ym");
            //echo $dt->format("Y-m") . "<br>\n";
        }

        return $tmp_arr;
    }
}