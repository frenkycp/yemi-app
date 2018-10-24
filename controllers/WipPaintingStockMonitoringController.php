<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;
use app\models\WipStock02;

class WipPaintingStockMonitoringController extends Controller
{
	/**
	* @var boolean whether to enable CSRF validation for the actions in this controller.
	* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	*/
	public $enableCsrfValidation = false;

    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
        $green_limit = 80;
    	$wip_stock_view = WipStock02::find()->orderBy('child_analyst_desc')->all();
        $factory1_area_arr = ['WW PROCESS', 'VACUUM PRESS', 'CAB ASSY', 'PAINTING', 'HANDY LAMINATE', 'SUB ASSY', 'AVITECS'];
        $factory2_area_arr = ['INJ SMALL', 'INJ LARGE', 'PCB AUTO INS.', 'SMT', 'ROM WRITING', 'PCB MANUAL INS.', 'SPEAKER PROJECT'];
        $kd_area_arr = ['PCB PACKING', 'SPU PACKING'];
        $category_area_arr = [
            1 => 'factory1',
            2 => 'factory2',
            3 => 'kd',
        ];

        $factory_title_arr = [
            'WW PROCESS' => 'Wood Working　（木工）',
            'VACUUM PRESS' => 'VACUUM PRESS （真空貼り）',
            'CAB ASSY' => 'CAB ASSY （箱組）',
            'PAINTING' => 'PAINTING （塗装）',
            'HANDY LAMINATE' => 'Hand Lamination （手貼り）',
            'SUB ASSY' => 'SUB ASSY （サブ組）',
            'AVITECS' => 'AVITECS （防音製品）',
            'INJ SMALL' => 'INJECTION SMALL （小型成形）',
            'INJ LARGE' => 'INJECTION LARGE　（大型成形）',
            'PCB AUTO INS.' => 'PCB AUTO （自動挿入）',
            'SMT' => 'SMT （実装）',
            'ROM WRITING' => 'ROM WRITING (ROM書込)',
            'PCB MANUAL INS.' => 'PCB MANUAL （手挿入)',
            'SPEAKER PROJECT' => 'SPEAKER PROJECT  （スピーカー）',
            'PCB PACKING' => 'PCB PACKING （基板ＫＤ）',
            'SPU PACKING' => 'SPU PACKING  （スピーカーKD）'
        ];

    	//$data = [];
    	foreach ($wip_stock_view as $value) {
            if (in_array($value->child_analyst_desc, $factory1_area_arr)) {
                $area = 'factory1';
            } elseif (in_array($value->child_analyst_desc, $factory2_area_arr)) {
                $area = 'factory2';
            } elseif (in_array($value->child_analyst_desc, $kd_area_arr)) {
                $area = 'kd';
            } else {
                $area = 'final_assy';
            }
            $categories[$area][] = $factory_title_arr[$value->child_analyst_desc];

            $fill_percentage = 0;
            if ($value->limit_qty > 0) {
                $fill_percentage = round((($value->onhand_qty / $value->limit_qty) * 100), 2);
            }

            $green_limit_qty = 0.8 * $value->limit_qty;

            if ($fill_percentage <= $green_limit) {
                $tmp_data[$area]['red'][] = [
                    'y' => null,
                    'qty' => 0,
                ];
                $tmp_data[$area]['green'][] = [
                    'y' => $fill_percentage,
                    'qty' => $value->onhand_qty,
                ];
                $tmp_data[$area]['white'][] = [
                    'y' => 100 - $fill_percentage,
                    'qty' => $value->limit_qty - $value->onhand_qty,
                ];
            } else {
                $tmp_data[$area]['red'][] = [
                    'y' => $fill_percentage - $green_limit,
                    'qty' => $value->onhand_qty - $green_limit_qty,
                ];
                $tmp_data[$area]['green'][] = [
                    'y' => $green_limit,
                    'qty' => $green_limit_qty,
                ];
                if (fill_percentage < 100) {
                    $tmp_data[$area]['white'][] = [
                        'y' => 100 - $fill_percentage,
                        'qty' => $value->limit_qty - $value->onhand_qty,
                    ];
                } else {
                    $tmp_data[$area]['white'][] = [
                        'y' => null,
                        'qty' => 0,
                    ];
                }
                
            }
    	}

        foreach ($category_area_arr as $key => $value) {
            $data2[$value] = [
                [
                    'name' => 'Empty Qty',
                    'data' => $tmp_data[$value]['white'],
                    'color' => 'rgba(240, 240, 240, 0)',
                    'showInLegend' => false
                ],
                [
                    'name' => 'Over (> 80% of Limit Qty)',
                    'data' => $tmp_data[$value]['red'],
                    'color' => 'rgba(255, 0, 0, 0.7)',
                ],
                [
                    'name' => 'Normal (≤ 80% of Limit Qty)',
                    'data' => $tmp_data[$value]['green'],
                    'color' => 'rgba(0, 255, 0, 0.7)',
                ],
            ];
        }

        /*$data2 = [
            'factory1' => [
                [
                    'name' => 'Empty Qty',
                    'data' => $tmp_data['factory1']['white'],
                    'color' => 'rgba(240, 240, 240, 0)',
                    'showInLegend' => false
                ],
                [
                    'name' => 'Over (more than 80% of Limit Qty)',
                    'data' => $tmp_data['factory1']['red'],
                    'color' => 'rgba(255, 0, 0, 0.7)',
                ],
                [
                    'name' => 'Normal (less than 80% of Limit Qty)',
                    'data' => $tmp_data['factory1']['green'],
                    'color' => 'rgba(0, 255, 0, 0.7)',
                ],
            ],
        ];*/

    	return $this->render('index', [
    		'data' => $data,
            'data2' => $data2,
            'categories' => $categories,
            'category_area_arr' => $category_area_arr
    	]);
    }
}