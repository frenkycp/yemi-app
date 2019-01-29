<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->title = [
    'page_title' => '',
    'tab_title' => 'Plan Monitoring',
    'breadcrumbs_title' => 'Plan Monitoring'
];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-header {color: white;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}

    #run-tbl{
        border:1px solid #FFA726;
    }
    #run-tbl > thead > tr > th{
        border:1px solid #FFA726;
        background-color: #FFB74D;
        color: #E65100;
        font-size: 20px;
    }
    #run-tbl > tbody > tr > td{
        border:1px solid #FFA726;
        font-size: 3.5em;
        background-color: #FFE0B2;
        font-weight: bold;
        color: #E65100;
    }
");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 60000); // milliseconds
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
    //'layout' => 'horizontal',
    'action' => Url::to(['production-plan-monitoring/index']),
]); ?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="form-group">
                    <?= Html::label('LOCATION', 'location', [
                        'class' => 'control-label col-md-4'
                    ]); ?>
                    <div class="col-md-8">
                        <?= Html::dropDownList('location', $location, $location_dropdown, [
                            'class' => 'form-control',
                            'onchange'=>'this.form.submit()',
                            'style' => 'height: 40px; padding: 3px 12px; font-size:1.5em;'
                        ]); ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="form-group">
                    <?= Html::label('LINE', 'line', [
                        'class' => 'control-label col-md-5'
                    ]); ?>
                    <div class="col-md-7">
                        <?= Html::dropDownList('line', $line, [
                            '01' => '01',
                            '02' => '02',
                        ], [
                            'class' => 'form-control',
                            'onchange'=>'this.form.submit()',
                            'style' => 'height: 40px; padding: 3px 12px; font-size:1.5em;'
                        ]); ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<table class="table table-bordered" id="run-tbl">
    <thead>
        <tr>
            <th style="text-align: center;">Part Number</th>
            <th style="text-align: center;">Part Description</th>
            <th style="text-align: center;">Total Qty</th>
            <th style="text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center;"><?= $running['part_no']; ?></td>
            <td style="text-align: center;"><?= $running['part_desc']; ?></td>
            <td style="text-align: center;"><?= $running['qty']; ?></td>
            <td style="text-align: center;">RUNNING...</td>
        </tr>
        <tr>
            <?php
            foreach ($plan_data as $value) {
                echo '<td style="text-align: center; background-color: white; font-size: 2em;">' . $value['part_no'] . '</td>';
                echo '<td style="text-align: center; background-color: white; font-size: 2em;">' . $value['part_desc'] . '</td>';
                echo '<td style="text-align: center; background-color: white; font-size: 2em;">' . $value['qty'] . '</td>';
                echo '<td style="text-align: center; background-color: white; font-size: 2em;">' . $value['status'] . '</td>';
            }
            ?>
        </tr>
    </tbody>
</table>

<?php ActiveForm::end(); ?>