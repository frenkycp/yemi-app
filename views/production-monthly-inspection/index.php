<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => 'Production Monthly Inspection <span class="japanesse text-green">(週次出荷管理検査)</span>',
    'tab_title' => 'Production Monthly Inspection',
    'breadcrumbs_title' => 'Production Monthly Inspection'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
//$color = 'DarkSlateBlue';
$color = 'rgba(72,61,139,0.6)';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<?php
echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/sand-signika',
    ],
    'options' => [
        'chart' => [
            'type' => 'column',
        ],
        'credits' => [
            'enabled' =>false
        ],
        'title' => [
            'text' => null
        ],
        'subtitle' => [
            'text' => null
        ],
        'xAxis' => [
            'type' => 'category',
            'categories' => $categories,
        ],
        'plotOptions' => [
            'series' => [
                'cursor' => 'pointer',
                'point' => [
                    'events' => [
                        'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                        /*'click' => new JsExpression('
                            function(){
                                $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                            }
                        '),*/
                    ]
                ]
            ]
        ],
        'series' => $data
    ],
]);
?>
<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>