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
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    #summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 16px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
        font-weight: normal;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    #summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

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
<br/>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'location')->dropDownList($dropdown_loc); ?>
    </div>
    <?= Yii::$app->params['update_chart_btn']; ?>
</div>

<?php ActiveForm::end(); ?>
<h4 class="box-title" style="color: silver;"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h4>
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
                    'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 600,
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
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Completion'
                        ],
                        //'gridLineWidth' => 0,
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
                                    //'fontSize' => '14px',
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                            ],
                            //'borderWidth' => 1,
                            //'borderColor' => $color,
                        ],
                        'series' => [
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
                        ]
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