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
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
	.content-header {color: white;}
    .box-body {background-color: #000;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}

    #run-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #run-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 30px;
        border-bottom: 7px solid #ddd;
    }
    #run-tbl > tbody > tr > td{
        //border:1px solid #29B6F6;
        //font-size: 3.5em;
        background-color: #B3E5FC;
        font-weight: 1000;
        color: #555;
        vertical-align: middle;
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
    $(document).ready(function() {
        var i = 0;
        setInterval(function() {
            i++;
            if(i%2 == 0){
                $("#run-text").css("background-color", "#00ff00");
                //$("#run-text").css("color", "white");
            } else {
                $("#run-text").css("background-color", "yellow");
                //$("#run-text").css("color", "#555");
            }
        }, 300);
    });
JS;

$this->registerJs($script, View::POS_END);

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
        <div class="box box-default box-solid">
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
        <div class="box box-default box-solid">
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
            <th style="text-align: center; vertical-align: middle;">Lot Number</th>
            <th style="text-align: center; vertical-align: middle;">Part Number</th>
            <th style="text-align: center; vertical-align: middle;">Part Description</th>
            <th style="text-align: center; vertical-align: middle;">Total Qty</th>
            <th style="text-align: center; vertical-align: middle;">Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            if ($running['part_no'] != '-') {
                echo '<td style="text-align: center; font-size: 50px; background-color: yellow;">' . $running['lot_no'] . '</td>';
                echo '<td style="text-align: center; font-size: 50px; background-color: yellow;">' . $running['part_no'] . '</td>';
                echo '<td style="text-align: center; font-size: 45px; background-color: yellow;">' . $running['part_desc'] . '</td>';
                echo '<td style="text-align: center; font-size: 50px; background-color: yellow;">' . $running['qty'] . '</td>';
                echo '<td id="run-text" style="text-align: center; font-size: 50px; background-color: yellow;">RUN</td>';
            } else {
                if (count($plan_data) == 0) {
                    echo '<td colspan="5" style="background-color: white; font-size: 40px;">There is no unfinished plan...</td>';
                }
            }
            ?>
        </tr>
        <?php
        foreach ($plan_data as $value) {
            $status_class = '';
            if ($value['status'] == 'CLOSED') {
                $status_class = 'text-green';
            }
            echo '<tr>';
            echo '<td class="' . $status_class . '" style="text-align: center; background-color: white; font-size: 30px;">' . $value['lot_no'] . '</td>';
            echo '<td class="' . $status_class . '" style="text-align: center; background-color: white; font-size: 30px;">' . $value['part_no'] . '</td>';
            echo '<td class="' . $status_class . '" style="text-align: center; background-color: white; font-size: 30px;">' . $value['part_desc'] . '</td>';
            echo '<td class="' . $status_class . '" style="text-align: center; background-color: white; font-size: 30px;">' . $value['qty'] . '</td>';
            echo '<td class="' . $status_class . '" style="text-align: center; background-color: white; font-size: 30px;">' . $value['status'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<?php ActiveForm::end(); ?>