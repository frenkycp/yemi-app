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