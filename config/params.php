<?php

return [
    'adminEmail' => 'admin@example.com',
    'japanesse_update_chart' => 'Update Chart <span class="japanesse">(更新)',
    'update_chart_btn' => '<button type="submit" class="btn btn-success">Update Chart <span class="japanesse">(更新)</button>',
    'year_arr' => getYearArray(),
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