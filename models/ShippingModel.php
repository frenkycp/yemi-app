<?php
namespace app\models;

use yii\base\Model;
use app\models\WorkDayTbl;
use app\models\ContainerView;

class ShippingModel extends Model
{
    public function getTotalShipOut($post_date)
    {
        $period = date('Ym', strtotime($post_date));
        $tmp_ship_out = ContainerView::find()->select(['total_cntr' => 'SUM(total_cntr)'])->where([
            'EXTRACT(YEAR_MONTH FROM etd)' => $period
        ])
        ->andWhere(['<=', 'etd', $post_date])
        ->andWhere(['NOT IN', 'dst', ['JAKARTA', 'B4TSNI']])
        ->andWhere(['<>', 'back_order', 2])
        ->one();

        return $tmp_ship_out->total_cntr;
    }
}