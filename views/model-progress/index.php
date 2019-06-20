<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Model Progress <span class="japanesse text-green"></span>',
    'tab_title' => 'Model Progress',
    'breadcrumbs_title' => 'Model Progress'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

/*$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );*/

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['model-progress/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'gmc')->textInput(); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'year')->dropDownList(\Yii::$app->params['year_arr']); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'month')->dropDownList([
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ]); ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'location')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(app\models\WipLocation::find()->select('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc'),
        'options' => [
            'placeholder' => 'Select location ...',
            'multiple' => true
        ],
    ]); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
</div>

<?php ActiveForm::end(); ?>

<?php
foreach ($data as $key => $value) {
    ?>
    <div class="panel panel-primary">
        <div class="panel panel-heading">
            <h3 class="panel-title"><?= $value['title']; ?></h3>
        </div>
        <div class="panel-body">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/sand-signika',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'zoomType' => 'x',
                        'height' => 350
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        //'categories' => $value['category'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'allowDecimals' => false,
                        'title' => [
                            'text' => 'Percentage'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'xDateFormat' => '%A, %b %e %Y',
                        //'valueSuffix' => ' min'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.1f}%',
                            ],
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ],
                            'maxPointWidth' => 50
                        ]
                    ],
                    'series' => $value['series'],
                ],
            ]);
            ?>
        </div>
    </div>
<?php }
?>