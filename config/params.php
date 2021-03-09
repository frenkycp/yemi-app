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
        'WI03' => 'INJ MEDIUM',
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
    ],
    'clinic_last_status' => [
        'KEMBALI BEKERJA' => 'KEMBALI BEKERJA',
        'PULANG' => 'PULANG',
        'DIRUJUK' => 'DIRUJUK'
    ],
    'ext_dandori_status' => [
        0 => 'OPEN',
        1 => 'PROGRESS',
        2 => 'COMPLETE',
        3 => 'ONSITE',
    ],
    'ext_dandori_text_class' => [
        0 => ' text-red',
        1 => ' text-yellow',
        2 => ' text-yellow',
        3 => ' text-greem',
    ],
    'purple_color' => '#61258e',
    'green_color_j' => '#5aff00',
    'ww_wip_model' => ['HS', 'L85', 'P40', 'XXX'],
    'attendance_wip_arr' => [
        'WI02' => 'INJ LARGE',
        'WI03' => 'INJ MEDIUM',
        'WI01' => 'INJ SMALL',
        'WP01' => 'PAINTING',
        'WM02' => 'PCB AUTO INS.',
        'WM01' => 'PCB MANUAL INS.',
        'WM03' => 'SMT',
        'WU01' => 'SPEAKER PROJECT',
        'WS01' => 'SUB ASSY',
        'WW02' => 'WW PROCESS',
        'WF01' => 'FINAL ASSY',
    ],
    'wip_location_arr' => [
        'WW06' => 'AVITECS',
        'WW01' => 'CAB ASSY',
        'WF01' => 'FINAL ASSY',
        'WW03' => 'HANDY LAMINATE',
        'WI02' => 'INJ LARGE',
        'WI03' => 'INJ MEDIUM',
        'WI01' => 'INJ SMALL',
        'WP01' => 'PAINTING',
        'WP00' => 'PAINTING PACKING',
        'WM02' => 'PCB AUTO INS.',
        'WM01' => 'PCB MANUAL INS.',
        'WM00' => 'PCB PACKING',
        'WM04' => 'ROM WRITING',
        'WM03' => 'SMT',
        'WU01' => 'SPEAKER PROJECT',
        'WU00' => 'SPU PACKING',
        'WS01' => 'SUB ASSY',
        'WW04' => 'VACUUM PRESS',
        'WW02' => 'WW PROCESS',
    ],
    'iot_location_arr' => [
        'WI02' => 'INJ LARGE',
        'WI03' => 'INJ MEDIUM',
        'WI01' => 'INJ SMALL',
        'WP01' => 'PAINTING',
        'WU01' => 'SPEAKER PROJECT',
        'WW02' => 'WW PROCESS',
    ],
    'ng_rate_location_arr' => [
        'INJ' => 'INJECTION',
        'WP01' => 'PAINTING',
        'WM01' => 'PCB MANUAL INS.',
        'WU01' => 'SPEAKER PROJECT',
        'WW02' => 'WW PROCESS',
    ],
    'ng_found_dropdown' => [
        'AVMT' => 'AVMT',
        'FA' => 'FA',
        'FCT' => 'FCT',
        'ICT' => 'ICT',
        'RPA' => 'RPA',
        'OQC' => 'OQC',
    ],
    'ng_pcb_cause_dropdown' => [
        'BROKEN' => 'BROKEN',
        'DIRTY' => 'DIRTY',
        'FLOATING' => 'FLOATING',
        'INVERTED' => 'INVERTED',
        'MISSING PART' => 'MISSING PART',
        'MSB' => 'MSB',
        'OLNI' => 'OLNI',
        'POOR SOLDER' => 'POOR SOLDER',
        'SHIFTED' => 'SHIFTED',
        'SLANTING' => 'SLANTING',
        'SOLDER BRIDGE' => 'SOLDER BRIDGE',
        'UNSOLDER' => 'UNSOLDER',
        'WRONG POLARITY' => 'WRONG POLARITY',
        'OTHERS' => 'OTHERS',
    ],
    'ng_pcb_process_dropdown' => [
        'ELECTRIC' => 'ELECTRIC',
        'FA' => 'FA',
        'MATERIAL' => 'MATERIAL',
        'MI' => 'MI',
        'PCB' => 'PCB',
        'RPA' => 'RPA',
        'SMT' => 'SMT',
        'AI' => 'AI',
    ],
    'ng_pcb_repair_dropdown' => [
        'Change Part' => 'Change Part',
        //'Cleaning Part' => 'Cleaning Part',
        'Reinsert' => 'Reinsert',
        'Remount' => 'Remount',
        //'Reprocess' => 'Reprocess',
        'Resolder' => 'Resolder',
    ],
    'ng_pcb_cause_category_dropdown' => [
        'MACHINE' => 'MACHINE',
        'MAN' => 'MAN',
        'MATERIAL' => 'MATERIAL',
        'METHOD' => 'METHOD',
        'MEASUREMENT' => 'MEASUREMENT',
    ],
    'ng_pcb_occurance_dropdown' => [
        'FORMING' => 'FORMING',
        'INSERT' => 'INSERT',
        'TOUCH UP' => 'TOUCH UP',
        'BONDING' => 'BONDING',
        'FORMING' => 'FORMING',
        'MACHINE' => 'MACHINE',
        'FA' => 'FA',
        'RPA' => 'RPA',
    ],
    'ng_spu_line_dropdown' => [
        'WOOFER HS' => 'WOOFER HS',
        'WOOFER EF' => 'WOOFER EF',
        'TWEETER' => 'TWEETER',
        'DXS-18' => 'DXS-18',
        'CONE ASSY' => 'CONE ASSY',
        'SURROUND' => 'SURROUND',
        'PACKING DMI' => 'PACKING DMI',
    ],
    'ng_inj_line_dropdown' => [
        '1600 Ton' => 'WI02',
        '850 Ton' => 'WI02',
        '350 Ton' => 'WI03',
        '180 Ton' => 'WI01',
        '125 Ton' => 'WI01',
        '100 Ton' => 'WI01',
    ],
    'emp_shift_dropdown' => [
        1 => 1,
        2 => 2,
        3 => 3,
    ],
    'ng_fa_location_dropdown' => [
        'TOP' => 'TOP',
        'SIDE' => 'SIDE',
        'BAFFLE' => 'BAFFLE',
        'BACK' => 'BACK',
        'BOTTOM' => 'BOTTOM',
        'WOOFER' => 'WOOFER',
        'TWEETER' => 'TWEETER',
        'RPA' => 'RPA',
    ],
    'ng_fa_root_cause_dropdown' => [
        'WW' => 'WW',
        'HANDLAM' => 'HANDLAM',
        'PAINTING' => 'PAINTING',
        'MATERIAL' => 'MATERIAL',
        'WAREHOUSE' => 'WAREHOUSE',
        'SPU' => 'SPU',
        'PCB' => 'PCB',
        'Sub Assy' => 'Sub Assy',
        'FA' => 'FA',
    ], 
    'ng_ptg_part_dropdown' => [
        'CAB PTG' => 'CAB PTG',
        'XXX/PART SERIES' => 'XXX/PART SERIES',
        'DSR' => 'DSR'
    ],
    'ng_next_action_dropdown' => [
        'TRAINING' => 'TRAINING',
        'CHANGE JOB (IN SECTION)' => 'CHANGE JOB (IN SECTION)',
        'CHANGE JOB (OUT SECTION)' => 'CHANGE JOB (OUT SECTION)'
    ],
    'e_ng_location_arr' => [
        'WF01' => 'FINAL ASSY',
        'WW03' => 'HANDY LAMINATE',
        'WI02' => 'INJ LARGE',
        'WI03' => 'INJ MEDIUM',
        'WI01' => 'INJ SMALL',
        'WP01' => 'PAINTING',
        'WM01' => 'PCB MANUAL INS.',
        'WM03' => 'SMT',
        'WU01' => 'SPEAKER PROJECT',
        'WW02' => 'WW PROCESS',
    ],
    'live_cooking_photo_arr' => [
        'BAKSO' => 'bakso_01.jpg',
        'GADO-GADO' => 'gado_gado_01.jpg',
        'LALAPAN' => 'lalapan_01.jpg',
        'NASI-GORENG' => 'nasi_goreng_01.jpg',
        'NASI-PECEL' => 'nasi_pecel_01.jpg',
        'RAWON' => 'rawon_01.jpg',
        'SOTO-AYAM' => 'soto_ayam_01.jpg',
        'AYAM-GEPREK' => 'ayam_geprek_01.jpg',
    ],
    'department_signature' => [
        '110A' => 'HELMI.png', //HRGA
        '110B' => 'HELMI.png', //HRGA
        '110C' => 'HELMI.png', //HRGA
        '110D' => 'HELMI.png', //HRGA
        '120' => 'NUNUNG.png', //FINANCE & ACCOUNTING
        '130' => 'ARY H.png', //LOGISTIC
        '130A' => 'ARY H.png', //LOGISTIC
        '220A' => 'BAGUS.png', //MAINTENANCE
        '110E' => 'FREDY.png', //MIS
        '250' => 'SHIOJIMA.png', //PDC
        '251' => 'SHIOJIMA.png', //PDC
        '320' => 'YUNAN.png', //PRODUCTION
        '240' => 'YUNAN.png', //PRODUCTION
        '371' => 'YUNAN.png', //PRODUCTION
        '370' => 'YUNAN.png', //PRODUCTION
        '330' => 'YUNAN.png', //PRODUCTION
        '340A' => 'YUNAN.png', //PRODUCTION
        '340M' => 'YUNAN.png', //PRODUCTION
        '360' => 'YUNAN.png', //PRODUCTION
        '399' => 'YUNAN.png', //PRODUCTION
        '350' => 'YUNAN.png', //PRODUCTION
        '310' => 'YUNAN.png', //PRODUCTION
        '300' => 'YUNAN.png', //PRODUCTION
        '210' => 'HEMY.png', //PC
        '131' => 'HEMY.png', //PC
        '220' => 'ZAMRONI.png', //PE
        '200' => 'SOLEH.png', //PURCHASING
        '200A' => 'SOLEH.png', //PURCHASING
        '230' => 'ROSA.png', //QUALITY ASSURANCE
    ],
    'masker_genba_partno' => [
        'BPM007011',
        'BPM007012',
        'BPS118013',
        'BPS118015',
        'BPS118016',
        'BPS118017',
        'N000634',
        'N002754'
    ],
    'sunfish_cost_center' => [
        'Accounting' => 'Accounting',
        'Final Assembling' => 'Final Assembling',
        'Grinding' => 'Grinding',
        'HRGA - Driver' => 'HRGA - Driver',
        'HRGA - General Affairs' => 'HRGA - General Affairs',
        'HRGA - Security' => 'HRGA - Security',
        'HRGA - Staff' => 'HRGA - Staff',
        'Injection Big' => 'Injection Big',
        'Injection Medium' => 'Injection Medium',
        'Injection Small' => 'Injection Small',
        'Logistic' => 'Logistic',
        'Maintenance' => 'Maintenance',
        'MIS' => 'MIS',
        'Painting' => 'Painting',
        'PCB - Auto' => 'PCB - Auto',
        'PCB - Manual' => 'PCB - Manual',
        'Prod. Control' => 'Prod. Control',
        'Prod. Engineering' => 'Prod. Engineering',
        'Production' => 'Production',
        'Purchasing' => 'Purchasing',
        'Quality Assurance' => 'Quality Assurance',
        'R & D Audio' => 'R & D Audio',
        'SMT' => 'SMT',
        'SPC' => 'SPC',
        'SPU' => 'SPU',
        'Sub. Assembling' => 'Sub. Assembling',
        'Warehouse Finished Good' => 'Warehouse Finished Good',
        'Warehouse Parts' => 'Warehouse Parts',
        'Wood Working' => 'Wood Working',
    ],
    'ship_reservation_status_arr' => [
        'NO ACTION YET' => 'NO ACTION YET',
        'BOOKING REQUESTED' => 'BOOKING REQUESTED',
        'BOOKING UNACCEPTED' => 'BOOKING UNACCEPTED',
        'BOOKING CONFIRMED' => 'BOOKING CONFIRMED',
        'NO NEED ANYMORE' => 'NO NEED ANYMORE',
        'OTHER' => 'OTHER',
    ],
    'bu_conversion_arr' => [
        'AV' => 'AV',
        'CA' => 'PA',
        'DMI' => 'DMI',
        'GUITAR AMPLIFIER' => 'B&O',
        'MIPA' => 'PA',
        'PIANO' => 'PIANO',
        'SOUND PROOF' => 'SN'
    ],
    'bu_arr_production' => [
        'AV' => 'AV',
        'PA' => 'PA',
        'DMI' => 'DMI',
        'SN' => 'SN',
        'GA' => 'GA',
        'PIANO' => 'PIANO',
        'B&O' => 'B&O',
        'OTHER' => 'OTHER',
    ],
    'bu_arr_shipping' => [
        'AV' => 'AV',
        'PA' => 'PA',
        'DMI' => 'DMI',
        'SN' => 'SN',
        'PIANO' => 'PIANO',
        'B&O' => 'B&O',
    ],
    's_billing_stage_arr' => [
        1 => 'WAITING RECEIVED',
        2 => 'ON PROGRESS',
        3 => 'HANDOVER TO FINANCE',
    ],
    'kd_flag_arr' => [
        'KD to HY' => 'KD to HY',
        'KD to TY' => 'KD to TY',
        'KD to XY' => 'KD to XY',
        'KD to YES' => 'KD to YES',
        'KD to YEMI' => 'KD to YEMI',
        'KD to YI' => 'KD to YI',
        'KD to YMMA' => 'KD to YMMA',
        'KD to YMMI' => 'KD to YMMI',
        'KD to YMPI' => 'KD to YMPI',
        'KD to YEM' => 'KD to YEM',
        'KD to YMIN' => 'KD to YMIN',
        'KD to YMMJ' => 'KD to YMMJ',
    ],
    'interview_yubisashi_value_arr' => [
        0 => 'Χ',
        1 => 'Δ',
        2 => 'Ο'
    ],
    'audit_patrol_category' => [
        1 => 'S-Up Patrol',
        //2 => '5S Patrol'
    ],
    'audit_patrol_topic' => [
        '5S' => '5S',
        'Safety' => 'Safety',
    ],
    'rdr_category_arr' => [
        'SHORTAGE' => 'SHORTAGE',
        'OVER' => 'OVER',
        'WRONG PART' => 'WRONG PART',
        'NO PART NUMBER' => 'NO PART NUMBER',
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