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
    public $post_date, $period, $shift, $start_date, $end_date, $total_present, $total_mp, $department, $grade, $total_absent, $total_permit, $total_sick, $total_cuti, $total_late, $total_early_out, $total_shift2, $total_shift3, $total_shift4, $total_ck, $total_ck_no_disiplin;

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

    public function getMyHrSummary($this_year, $emp_no)
    {
        $absensi_data_sunfish = $this::find()
        ->select([
            'emp_no',
            'period' => 'FORMAT(shiftendtime, \'yyyyMM\')',
            'total_absent' => 'SUM(CASE WHEN attend_judgement = \'A\' THEN 1 ELSE 0 END)',
            'total_present' => 'SUM(CASE WHEN attend_judgement = \'P\' THEN 1 ELSE 0 END)',
            'total_permit' => 'SUM(CASE WHEN attend_judgement = \'I\' THEN 1 ELSE 0 END)',
            'total_sick' => 'SUM(CASE WHEN attend_judgement = \'S\' THEN 1 ELSE 0 END)',
            'total_cuti' => 'SUM(CASE WHEN (attend_judgement = \'C\') THEN 1 ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN come_late = \'1\' THEN 1 ELSE 0 END)',
            'total_early_out' => 'SUM(CASE WHEN home_early = \'1\' THEN 1 ELSE 0 END)',
            'total_shift2' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 OR PATINDEX(\'%MAINTENANCE%\', UPPER(shiftdaily_code)) > 0) AND attend_judgement = \'P\' THEN 1 ELSE 0 END)',
            'total_shift3' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND attend_judgement = \'P\' THEN 1 ELSE 0 END)',
            'total_shift4' => 'SUM(CASE WHEN PATINDEX(\'%4G_SHIFT%\', UPPER(shiftdaily_code)) > 0 AND attend_judgement = \'P\' THEN 1 ELSE 0 END)',
            'total_ck' => 'SUM(CASE WHEN (PATINDEX(\'%CK%\', Attend_Code) > 0 OR PATINDEX(\'%UPL%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
            'total_ck_no_disiplin' => 'SUM(CASE WHEN Attend_Code IN (\'CK9\', \'CK10\', \'CK11\') AND PATINDEX(\'%Izin%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
        ])
        ->where([
            'FORMAT(shiftendtime, \'yyyy\')' => $this_year,
            'emp_no' => $emp_no,
        ])
        ->andWhere(['<>', 'shiftdaily_code', 'OFF'])
        ->andWhere(['>=', 'FORMAT(shiftendtime, \'yyyyMM\')', '202003'])
        ->groupBy(['emp_no', 'FORMAT(shiftendtime, \'yyyyMM\')'])
        ->orderBy('period')
        ->all();

        return $absensi_data_sunfish;
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
        } elseif (strpos($attend_code, 'UPL')) {
            $keterangan = 'Tambahan Cuti Melahirkan';
        }

        return $keterangan;
    }

    public function getMonthlyOtBySection($period)
    {
        $return_data = [];
        $tmp_data = $this::find()
        ->select([
            'cost_center', 'total_ot' => 'SUM(total_ot)'
        ])
        ->where([
            'FORMAT(shiftendtime, \'yyyyMM\')' => $period
        ])
        ->andWhere('total_ot IS NOT NULL')
        ->andWhere(['NOT IN', 'cost_center', ['Board of Director']])
        ->groupBy('cost_center')
        ->orderBy('cost_center')
        ->asArray()
        ->all();

        return $tmp_data;
    }

    public function getDailyAttendanceRange($from_date, $to_date)
    {
        $return_data = [];
        $tmp_data = $this::find()
        ->select([
            'shiftendtime' => 'CONVERT(DATE, shiftendtime)',
            'emp_no', 'full_name', 'shiftdaily_code',
            'start_date',
            'end_date',
            'shiftdaily_code', 'Attend_Code', 'attend_judgement', 'starttime', 'endtime', 'cost_center'
        ])
        ->where('PATINDEX(\'YE%\', emp_no) > 0 AND cost_center NOT IN (\'Expatriate\') AND shiftdaily_code <> \'OFF\'')
        ->andWhere([
            'AND',
            ['>=', 'shiftendtime', $from_date . ' 00:00:00'],
            ['<=', 'shiftendtime', $to_date . ' 23:59:59'],
        ])
        ->orderBy('shiftendtime, emp_no')
        ->asArray()
        ->all();

        foreach ($tmp_data as $value) {
            if ($value['start_date'] <= $value['shiftendtime'] && ($value['end_date'] == null || $value['end_date'] >= $value['shiftendtime'])) {
                if (strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_1') !== false
                    || strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_08_17') !== false
                    || strpos(strtoupper($value['shiftdaily_code']), 'GARDENER') !== false
                    || strpos(strtoupper($value['shiftdaily_code']), 'DRIVER') !== false) {
                    $shift =  1;
                } elseif (strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_2') !== false || strpos(strtoupper($value['shiftdaily_code']), 'MAINTENANCE') !== false) {
                    $shift =  2;
                } elseif (strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_3') !== false) {
                    $shift =  3;
                } else {
                    $shift =  '-';
                }

                $attend_judgement = $value['attend_judgement'];
                if ($attend_judgement == 'CKX') {
                    $attend_judgement = 'C';
                } elseif ($attend_judgement == null || $attend_judgement == 'OFF') {
                    $attend_judgement = 'A';
                }

                $data[$value['shiftendtime']][] = [
                    'nik' => $value['emp_no'],
                    'name' => $value['full_name'],
                    'shift' => $shift,
                    'Attend_Code' => $value['Attend_Code'],
                    'shiftdaily_code' => $value['shiftdaily_code'],
                    'attend_judgement' => $attend_judgement,
                    'starttime' => $value['starttime'],
                    'endtime' => $value['endtime'],
                    'start_date' => $value['start_date'],
                    'cost_center' => $value['cost_center'],
                ];
            }
        }

        return $data;
    }
    public function getDataForTemperature($from_date, $to_date)
    {
        $return_data = [];
        $tmp_data = $this::find()
        ->select([
            'shiftendtime' => 'CONVERT(DATE, shiftendtime)',
            'VIEW_YEMI_ATTENDANCE.emp_no', 'VIEW_YEMI_ATTENDANCE.full_name', 'shiftdaily_code',
            'start_date' => 'CONVERT(DATE, VIEW_YEMI_Emp_OrgUnit.start_date)',
            'end_date' => 'CONVERT(DATE, VIEW_YEMI_Emp_OrgUnit.end_date)',
            'shiftdaily_code', 'Attend_Code', 'attend_judgement', 'starttime', 'endtime', 'cost_center'
        ])
        ->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_OrgUnit.Emp_no = VIEW_YEMI_ATTENDANCE.emp_no')
        ->where('PATINDEX(\'YE%\', VIEW_YEMI_ATTENDANCE.emp_no) > 0 AND shiftdaily_code <> \'OFF\'')
        ->andWhere([
            'AND',
            ['>=', 'shiftendtime', $from_date . ' 00:00:00'],
            ['<=', 'shiftendtime', $to_date . ' 23:59:59'],
        ])
        ->andWhere(['VIEW_YEMI_Emp_OrgUnit.status' => 1])
        ->orderBy('shiftendtime, emp_no')
        ->all();

        foreach ($tmp_data as $value) {
            if ($value->start_date <= $value->shiftendtime && ($value->end_date == null || $value->end_date >= $value->shiftendtime)) {
                if (strpos(strtoupper($value->shiftdaily_code), 'SHIFT_1') !== false
                    || strpos(strtoupper($value->shiftdaily_code), 'SHIFT_08_17') !== false
                    || strpos(strtoupper($value->shiftdaily_code), 'GARDENER') !== false) {
                    $shift =  1;
                } elseif (strpos(strtoupper($value->shiftdaily_code), 'SHIFT_2') !== false || strpos(strtoupper($value->shiftdaily_code), 'MAINTENANCE') !== false) {
                    $shift =  2;
                } elseif (strpos(strtoupper($value->shiftdaily_code), 'SHIFT_3') !== false) {
                    $shift =  3;
                } else {
                    $shift =  '-';
                }

                $attend_judgement = $value->attend_judgement;
                if ($attend_judgement == 'CKX') {
                    $attend_judgement = 'C';
                } elseif ($attend_judgement == null || $attend_judgement == 'OFF') {
                    $attend_judgement = 'A';
                }

                $data[$value->shiftendtime][] = [
                    'nik' => $value->emp_no,
                    'name' => $value->full_name,
                    'shift' => $shift,
                    'Attend_Code' => $value->Attend_Code,
                    'shiftdaily_code' => $value->shiftdaily_code,
                    'attend_judgement' => $attend_judgement,
                    'starttime' => $value->starttime,
                    'endtime' => $value->endtime,
                    'cost_center' => $value->cost_center,
                ];
            }
        }

        return $data;
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
            'total_alpa_s1' => 'SUM(CASE WHEN (attend_judgement = \'A\' OR attend_judgement IS NULL OR attend_judgement = \'OFF\') AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_sakit_s1' => 'SUM(CASE WHEN attend_judgement = \'S\' AND ' . $filter_shift1 . ' THEN 1 ELSE 0 END)',
            'total_mp_s2' => 'SUM(CASE WHEN ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_hadir_s2' => 'SUM(CASE WHEN attend_judgement = \'P\' AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_cuti_s2' => 'SUM(CASE WHEN (attend_judgement = \'C\' OR attend_judgement = \'CKX\') AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_ijin_s2' => 'SUM(CASE WHEN attend_judgement = \'I\' AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_alpa_s2' => 'SUM(CASE WHEN (attend_judgement = \'A\' OR attend_judgement IS NULL OR attend_judgement = \'OFF\') AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_sakit_s2' => 'SUM(CASE WHEN attend_judgement = \'S\' AND ' . $filter_shift2 . ' THEN 1 ELSE 0 END)',
            'total_mp_s3' => 'SUM(CASE WHEN ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_hadir_s3' => 'SUM(CASE WHEN attend_judgement = \'P\' AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_cuti_s3' => 'SUM(CASE WHEN (attend_judgement = \'C\' OR attend_judgement = \'CKX\') AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_ijin_s3' => 'SUM(CASE WHEN attend_judgement = \'I\' AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
            'total_alpa_s3' => 'SUM(CASE WHEN (attend_judgement = \'A\' OR attend_judgement IS NULL OR attend_judgement = \'OFF\') AND ' . $filter_shift3 . ' THEN 1 ELSE 0 END)',
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
