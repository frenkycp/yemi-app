<?php

namespace app\models;

use Yii;
use \app\models\base\SunfishAttendanceData as BaseSunfishAttendanceData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.VIEW_YEMI_ATTENDANCE".
 */
class SunfishAttendanceData extends BaseSunfishAttendanceData
{
    public $post_date, $period, $shift;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public static function primaryKey()
    {
        return ['attend_id'];
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getCutiKhususDesc($attend_code)
    {
        $keterangan = '';
        if (strpos($attend_code, 'CK15')) {
            $keterangan = 'Saudara Kandung Menikah';
        } elseif (strpos($attend_code, 'CK13')) {
            $keterangan = 'Musibah';
        } elseif (strpos($attend_code, 'CK12')) {
            $keterangan = 'Ibadah Haji / Ziarah Keagamaan';
        } elseif (strpos($attend_code, 'CK11')) {
            $keterangan = 'Keguguran';
        } elseif (strpos($attend_code, 'CK10')) {
            $keterangan = 'Melahirkan';
        } elseif (strpos($attend_code, 'CK1')) {
            $keterangan = 'Keluarga Meninggal';
        } elseif (strpos($attend_code, 'CK2')) {
            $keterangan = 'Keluarga Serumah Meninggal';
        } elseif (strpos($attend_code, 'CK3')) {
            $keterangan = 'Menikah';
        } elseif (strpos($attend_code, 'CK4')) {
            $keterangan = 'Menikahkan';
        } elseif (strpos($attend_code, 'CK5')) {
            $keterangan = 'Menghitankan';
        } elseif (strpos($attend_code, 'CK6')) {
            $keterangan = 'Membaptiskan';
        } elseif (strpos($attend_code, 'CK7')) {
            $keterangan = 'Istri Keguguran / Melahirkan';
        } elseif (strpos($attend_code, 'CK8')) {
            $keterangan = 'Tugas Negara';
        } elseif (strpos($attend_code, 'CK9')) {
            $keterangan = 'Haid';
        }

        return $keterangan;
    }

    public function getDailyAttendance($post_date)
    {
        $filter_shift1 = 'PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0';
        $filter_shift2 = '(PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 OR PATINDEX(\'%MAINTENANCE%\', UPPER(shiftdaily_code)) > 0)';
        $filter_shift3 = 'PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0';
        $tmp_data = $this::find()
        ->select([
            'total_mp_s1' => 'SUM(CASE WHEN ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_hadir_s1' => 'SUM(CASE WHEN attend_judgement = \'P\' AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_cuti_s1' => 'SUM(CASE WHEN (attend_judgement = \'C\' OR attend_judgement = \'CKX\') AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_ijin_s1' => 'SUM(CASE WHEN attend_judgement = \'I\' AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_alpa_s1' => 'SUM(CASE WHEN (attend_judgement = \'A\' OR attend_judgement IS NULL) AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_sakit_s1' => 'SUM(CASE WHEN attend_judgement = \'S\' AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_mp_s2' => 'SUM(CASE WHEN ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_hadir_s2' => 'SUM(CASE WHEN attend_judgement = \'P\' AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_cuti_s2' => 'SUM(CASE WHEN (attend_judgement = \'C\' OR attend_judgement = \'CKX\') AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_ijin_s2' => 'SUM(CASE WHEN attend_judgement = \'I\' AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_alpa_s2' => 'SUM(CASE WHEN (attend_judgement = \'A\' OR attend_judgement IS NULL) AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_sakit_s2' => 'SUM(CASE WHEN attend_judgement = \'S\' AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_mp_s3' => 'SUM(CASE WHEN ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_hadir_s3' => 'SUM(CASE WHEN attend_judgement = \'P\' AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_cuti_s3' => 'SUM(CASE WHEN (attend_judgement = \'C\' OR attend_judgement = \'CKX\') AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_ijin_s3' => 'SUM(CASE WHEN attend_judgement = \'I\' AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_alpa_s3' => 'SUM(CASE WHEN (attend_judgement = \'A\' OR attend_judgement IS NULL) AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_sakit_s3' => 'SUM(CASE WHEN attend_judgement = \'S\' AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
        ])
        ->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_OrgUnit.Emp_no = VIEW_YEMI_ATTENDANCE.emp_no')
        ->where([
            'FORMAT(shiftendtime, \'yyyy-MM-dd\')' => $post_date
        ])
        ->andWhere('PATINDEX(\'YE%\', VIEW_YEMI_ATTENDANCE.emp_no) > 0 AND cost_center NOT IN (\'Expatriate\') AND shiftdaily_code <> \'OFF\'')
        ->andWhere([
            'OR',
            'end_date IS NULL',
            ['>=', 'end_date', $post_date]
        ])
        ->andWhere(['<=', 'start_date', $post_date])
        //->andWhere('PATINDEX(\'YE%\', VIEW_YEMI_ATTENDANCE.emp_no) > 0 AND cost_center_code NOT IN (\'10\', \'110X\', \'110D\') AND VIEW_YEMI_ATTENDANCE.shiftdaily_code <> \'OFF\'')
        ->asArray()->one();

        $total_mp = ($tmp_data['total_mp_s1'] + $tmp_data['total_mp_s2'] + $tmp_data['total_mp_s3']);
        $total_mp_hadir = ($tmp_data['total_hadir_s1'] + $tmp_data['total_hadir_s2'] + $tmp_data['total_hadir_s3']);
        $total_mp_cuti = ($tmp_data['total_cuti_s1'] + $tmp_data['total_cuti_s2'] + $tmp_data['total_cuti_s3']);
        $total_mp_ijin = ($tmp_data['total_ijin_s1'] + $tmp_data['total_ijin_s2'] + $tmp_data['total_ijin_s3']);
        $total_mp_alpa = ($tmp_data['total_alpa_s1'] + $tmp_data['total_alpa_s2'] + $tmp_data['total_alpa_s3']);
        $total_mp_sakit = ($tmp_data['total_sakit_s1'] + $tmp_data['total_sakit_s2'] + $tmp_data['total_sakit_s3']);

        $data = [
            [
                'title' => 'MP',
                'code' => '',
                'shift1' => $tmp_data['total_mp_s1'],
                'shift2' => $tmp_data['total_mp_s2'],
                'shift3' => $tmp_data['total_mp_s3'],
                'total' => $total_mp,
                'percentage' => 100,
            ],
            [
                'title' => 'MP Hadir',
                'code' => 'P',
                'shift1' => $tmp_data['total_hadir_s1'],
                'shift2' => $tmp_data['total_hadir_s2'],
                'shift3' => $tmp_data['total_hadir_s3'],
                'total' => $total_mp_hadir,
                'percentage' => $total_mp == 0 ? 0 : round(($total_mp_hadir / $total_mp) * 100, 1),
            ],
            [
                'title' => 'Cuti',
                'code' => 'C_ALL',
                'shift1' => $tmp_data['total_cuti_s1'],
                'shift2' => $tmp_data['total_cuti_s2'],
                'shift3' => $tmp_data['total_cuti_s3'],
                'total' => $total_mp_cuti,
                'percentage' => $total_mp == 0 ? 0 : round(($total_mp_cuti / $total_mp) * 100, 1),
            ],
            [
                'title' => 'Ijin',
                'code' => 'I',
                'shift1' => $tmp_data['total_ijin_s1'],
                'shift2' => $tmp_data['total_ijin_s2'],
                'shift3' => $tmp_data['total_ijin_s3'],
                'total' => $total_mp_ijin,
                'percentage' => $total_mp == 0 ? 0 : round(($total_mp_ijin / $total_mp) * 100, 1),
            ],
            [
                'title' => 'Alpa',
                'code' => 'A',
                'shift1' => $tmp_data['total_alpa_s1'],
                'shift2' => $tmp_data['total_alpa_s2'],
                'shift3' => $tmp_data['total_alpa_s3'],
                'total' => $total_mp_alpa,
                'percentage' => $total_mp == 0 ? 0 : round(($total_mp_alpa / $total_mp) * 100, 1),
            ],
            [
                'title' => 'Sakit',
                'code' => 'S',
                'shift1' => $tmp_data['total_sakit_s1'],
                'shift2' => $tmp_data['total_sakit_s2'],
                'shift3' => $tmp_data['total_sakit_s3'],
                'total' => $total_mp_sakit,
                'percentage' => $total_mp == 0 ? 0 : round(($total_mp_sakit / $total_mp) * 100, 1),
            ],
        ];

        return $data;
    }
}
