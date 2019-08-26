<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Weekly Picking Status <span class="japanesse text-green">(週次ピッキング状況)</span> - Handover based <span class="japanesse text-green">(使用工程との引渡し基準）</span>',
    'tab_title' => 'Weekly Picking Status',
    'breadcrumbs_title' => 'Weekly Picking Status'
];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

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
print_r($series);
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
                 'label' => 'col-sm-5',
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
        <?= $form->field($model, 'location')->dropDownList($dropdown_loc); ?>
    </div>
    <button type="submit" class="btn btn-success btn-lg">Update Chart <span class="japanesse" style="color: white;">(更新)</button>
</div>

<?php ActiveForm::end(); ?>
<h4 class="box-title" style="color: white;"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i') ?></h4>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        foreach ($data as $key => $value) {
            if($key == $this_week)
            {
                echo '<li class="active"><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
            else
            {
                echo '<li><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
        }
        ?>
        <li class="pull-right" style="display: <?= Yii::$app->user->identity->role->name == 'Picking List Editor' ? '' : 'none'; ?>"><?= Html::a('<i class="fa fa-gear"></i>', ['visual-picking-list/index']); ?></li>
    </ul>
    <div class="tab-content">
        <hr>
        <?php
        foreach ($data as $key => $value) {
            if($key == $this_week)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $key .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $key .'">';
            }

            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 500,
                        'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => ''
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'category',
                        'categories' => $value[0]['category'],
                        'labels' => [
                            'style' => [
                                'fontSize' => '18px',
                                'fontWeight' => 'bold'
                            ],
                        ],
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Completion'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'legend' => [
                        'enabled' => true,
                        'itemStyle' => [
                            'fontSize' => '26px',
                        ],
                    ],
                    'tooltip' => [
                        'enabled' => false,
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " pcs"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.2f}%',
                                'color' => 'black',
                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                'style' => [
                                    'fontSize' => '18px',
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                            ],
                        ],
                        /*'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('
                                        function(){
                                            $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                        }
                                    '),
                                ]
                            ]
                        ]*/
                    ],
                    'series' => $value[0]['data']
                ],
            ]);

            echo '</div>';
        }

        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>
<h4 class="text-center bg-navy" style="padding: 5px; display: none;">
    <span>ORDERED</span>
    <i class="fa fa-fw fa-long-arrow-right"></i>
    <span>STARTED</span>
    <i class="fa fa-fw fa-long-arrow-right"></i>
    <span>COMPLETED</span>
    <i class="fa fa-fw fa-long-arrow-right"></i>
    <span class="text-green">HAND OVER</span>
</h4>