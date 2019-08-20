<?php
namespace app\models;

use yii\base\Model;

class GeneralFunction extends Model
{
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
}