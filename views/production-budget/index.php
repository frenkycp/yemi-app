<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Production Budget/Forecast/Actual',
    'tab_title' => 'Production Budget/Forecast/Actual',
    'breadcrumbs_title' => 'Production Budget/Forecast/Actual'
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
                 'wrapper' => 'col-sm-6',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'budget_type')->dropDownList(
                [
                    'PRODUCT' => 'PRODUCT',
                    'KD_PART' => 'KD_PART'
                ]
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'qty_or_amount')->dropDownList(
                [
                    'QTY' => ' By QTY',
                    'AMOUNT' => 'By AMOUNT'
                ]
            ); ?>
        </div>
        <button type="submit" class="btn btn-default">Update Chart</button>
    </div>

    <?php ActiveForm::end(); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
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
                    'categories' => $categories
                ],
                'yAxis' => [
                    'allowDecimals' => false,
                    'min' => 0,
                    //'max' => 160000,
                    //'tickInterval' => 1000000,
                    'title' => [
                        'text' => $model->qty_or_amount
                    ]
                ],
                'legend' => [
                    'enabled' => false,
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal'
                    ]
                ],
                'series' => $series
            ],
        ]);
        ?>
    </div>
</div>