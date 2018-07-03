<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Monthly Shipping Container <span class="japanesse text-green">(月次コンテナー出荷)</span>',
    'tab_title' => 'Monthly Shipping Container',
    'breadcrumbs_title' => 'Monthly Shipping Container'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

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

<?php $form = ActiveForm::begin([
    'id' => 'form_index',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 //'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-7',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'year')->dropDownList(
                $year_arr
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr
            ); ?>
        </div>
        <button type="submit" class="btn btn-default">Update Chart</button>
    </div>

    

    <?php ActiveForm::end(); ?>

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
            'enabled' => false
        ],
        'title' => [
            'text' => $title
        ],
        'subtitle' => [
            'text' => $subtitle
        ],
        'xAxis' => [
            'type' => 'category',
            'categories' => $category,
            'title' => [
                'text' => 'Date (Tanggal)'
            ],
            'labels' => [
                'formatter' => new JsExpression('function(){ return \'<a href="serno-output/container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
            ],
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Container Completion'
            ],
            'stackLabels' => [
                //'enabled' => true,
                //'formatter' => new JsExpression('function(){ return this.qty + "aa"; }'),
            ]
        ],
        'tooltip' => [
            'enabled' => false
        ],
        'plotOptions' => [
            'column' => [
                'stacking' => 'normal',
                'dataLabels' => [
                    'enabled' => true,
                    'style' => [
                        'textOutline' => '0px',
                        'fontWeight' => '0'
                    ],
                    'format' => '{point.qty}/{point.total_qty}',
                    'color' => 'black',
                ],
            ],
        ],
        'series' => $data
    ],
]);