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