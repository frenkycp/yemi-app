<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Budget Expenses By ETA <span class="japanesse light-green">(経費モニター部門別・ETA YEMI基準)</span>',
    'tab_title' => 'Budget Expenses By ETA',
    'breadcrumbs_title' => 'Budget Expenses By ETA'
];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
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
    'method' => 'get',
    'action' => Url::to(['budget-expenses/index']),
]); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'dept')->dropDownList($dept_dropdown, [
            'prompt' => 'Select Section...',
            'onchange'=>'this.form.submit()'
        ])->label('Section') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'fiscal')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->limit(10)->all(), 'FISCAL', 'FISCAL'), [
            'prompt' => 'Select FISCAL...',
            'onchange'=>'this.form.submit()'
        ])->label('FISCAL') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'budget_type')->dropDownList([
            'EXPENSE' => 'EXPENSE',
            'ASSET' => 'ASSET'
        ], [
            'prompt' => 'Select Type...',
            'onchange'=>'this.form.submit()'
        ])->label('Budget Type') ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
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
                    'enabled' => false
                ],
                'title' => [
                    'text' => null
                ],
                'legend' => [
                    'enabled' => false,
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    'stackLabels' => [
                        'enabled' => true,
                    ],
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'events' => [
                            'legendItemClick' => new JsExpression('
                                function(){
                                    return false;
                                }
                            '),
                        ]
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]
                    ],
                ],
                'series' => $data
            ],
        ]);

        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>