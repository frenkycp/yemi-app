<?php

return [
    'adminEmail' => 'admin@example.com',
    'japanesse_update_chart' => 'Update Chart <span class="japanesse">(更新)',
    'update_chart_btn' => '<button type="submit" class="btn btn-success">Update Chart <span class="japanesse">(更新)</button>',
    'year_arr' => getYearArray(),
    'grade_arr' => [
    	'G1' => 'G1',
    	'G2' => 'G2',
    	'E1' => 'E1',
    	'E2' => 'E2',
    	'E3' => 'E3',
    	'E4' => 'E4',
    	'E5' => 'E5',
    	'E6' => 'E6',
    	'E7' => 'E7',
    	'E8' => 'E8',
    	'L1' => 'L1',
    	'L2' => 'L2',
    	'L3' => 'L3',
    	'L4' => 'L4',
    	'M1' => 'M1',
    	'M2' => 'M2',
    	'M3' => 'M3',
    	'M4' => 'M4',
    ],
    'fav_color_arr' => [
        '#00a0a0',
        '#c5d0b7',
        '#f5f5dc',
        '#ccdee2',
        '#313131',
        '#c1d6a7',
        '#ffc7c7',
        '#a5c151',
        '#359245',
        '#00432c',
        '#005b50',
        '#362e52',
        '#68132e',
        '#c04829',
        '#e9a139',
        '#0a509e',
        '#4d9ad4',
        '#9fddf9',
        '#adc7dc',
        '#00205b',
        '#5cb373',
        '#1272d3',
        '#ff9494',
        '#8b9dc3',
        '#3b5998'
    ],
    'wip_stage_arr' => [
        '00-ORDER' => '00-ORDER',
        '01-CREATED' => '01-CREATED',
        '02-STARTED' => '02-STARTED',
        '03-COMPLETED' => '03-COMPLETED',
        '04-HAND OVER' => '04-HAND OVER'
    ],
    'delay_category_arr' => [
        'MACHINE' => 'MACHINE',
        'MAN' => 'MAN',
        'MATERIAL' => 'MATERIAL',
        'METHOD' => 'METHOD',
        'QUALITY' => 'QUALITY',
    ],
    'shift_patrol_type' => [
        1 => 'POSITIF',
        2 => 'NEGATIF'
    ],
    'line_eff_target' => [
        '306' => 55,
        '1600' => 60,
        '2700' => 60,
        '5600' => 50,
        'AW' => 75,
        'BR' => 50,
        'CEFINE' => 50,
        'DBR' => 80,
        'DSR' => 50,
        'HS' => 90,
        'L85' => 110,
        'P40' => 80,
        'PNT' => 50,
        'PTG' => 50,
        'SML' => 60,
        'SRT' => 50,
        'SW' => 60,
        'SW2' => 60,
        'TB' => 60,
        'VX' => 55,
        'VX2' => 55,
        'XXX' => 100,
    ],
    'smt_inj_loc_arr' => [
        'WM03' => 'SMT',
        'WI01' => 'INJ SMALL',
        'WI02' => 'INJ LARGE',
        'WM02' => 'PCB AUTO INS.',
    ],
    'bg-yellow' => 'rgba(243, 156, 18, 1)',
    'bg-green' => 'rgba(0, 166, 90, 1)',
    'bg-blue' => 'rgba(60, 141, 188, 1)',
    'bg-red' => 'rgba(221, 75, 57, 1)',
    'bg-gray' => 'rgba(244, 244, 244, 1)',
    'fixed_asset_status' => [
        'OK' => 'OK',
        'NG' => 'NG',
        'REPAIR' => 'REPAIR',
        'STANDBY' => 'STANDBY',
    ]
];

function getYearArray()
{
	$start_year = 2018;
	$end_year = ((int)date('Y') + 1);
	for ($i = $start_year; $i <= $end_year; $i++) { 
		$year_arr[$i] = $i;
	}
	return $year_arr;
}