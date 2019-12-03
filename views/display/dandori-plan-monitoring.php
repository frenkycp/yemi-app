<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->title = [
    'page_title' => 'External Setup <span class="japanesse light-green">(外段取り)</span>',
    'tab_title' => 'External Setup',
    'breadcrumbs_title' => 'External Setup'
];

$this->registerCss("
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
    .running-row {
        font-size: 3em;
    }
    .normal-row {
        font-size: 2em;
    }
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
                $(".run-text").css("background-color", "#00ff00");
                //$(".run-text").css("color", "white");
            } else {
                $(".run-text").css("background-color", "yellow");
                //$(".run-text").css("color", "#555");
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
    'action' => Url::to(['display/dandori-plan-monitoring']),
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
</div>
<?php ActiveForm::end(); ?>

<table class="table table-bordered" id="run-tbl" cellspacing="5">
    <thead>
        <tr>
            <th style="text-align: center; vertical-align: middle;">Line</th>
            <th style="text-align: center; vertical-align: middle;">Lot Number</th>
            <th style="text-align: center; vertical-align: middle;">Part Number</th>
            <th style="text-align: center; vertical-align: middle;">Part Description</th>
            <th style="text-align: center; vertical-align: middle;">Total Qty</th>
            <th style="text-align: center; vertical-align: middle;">Dandori Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($no_plan) {
            echo '<tr>
                <td colspan="6" style="font-size: 3em;">There is no dandori plan remaining ...</td>
            </tr>';
        } else {
            if (count($data[1]) > 0) {
                foreach ($data[1] as $key => $value) {
                    echo '<tr>
                        <td style="background-color: yellow;" class="text-center running-row">' . $value['line'] . '</td>
                        <td style="background-color: yellow;" class="text-center running-row">' . $value['lot_no'] . '</td>
                        <td style="background-color: yellow;" class="text-center running-row">' . $value['part_no'] . '</td>
                        <td style="background-color: yellow;" class="text-center running-row">' . $value['part_desc'] . '</td>
                        <td style="background-color: yellow;" class="text-center running-row">' . $value['qty'] . '</td>
                        <td style="background-color: yellow;" class="text-center running-row run-text">' . \Yii::$app->params['ext_dandori_status'][1] . '</td>
                    </tr>';
                }
            }
            if (count($data[2]) > 0) {
                foreach ($data[2] as $key => $value) {
                    echo '<tr>
                        <td class="text-center normal-row">' . $value['line'] . '</td>
                        <td class="text-center normal-row">' . $value['lot_no'] . '</td>
                        <td class="text-center normal-row">' . $value['part_no'] . '</td>
                        <td class="text-center normal-row">' . $value['part_desc'] . '</td>
                        <td class="text-center normal-row">' . $value['qty'] . '</td>
                        <td class="text-center normal-row">' . \Yii::$app->params['ext_dandori_status'][2] . '</td>
                    </tr>';
                }
            }
            if (count($data[0]) > 0) {
                foreach ($data[0] as $key => $value) {
                    echo '<tr>
                        <td class="text-center normal-row">' . $value['line'] . '</td>
                        <td class="text-center normal-row">' . $value['lot_no'] . '</td>
                        <td class="text-center normal-row">' . $value['part_no'] . '</td>
                        <td class="text-center normal-row">' . $value['part_desc'] . '</td>
                        <td class="text-center normal-row">' . $value['qty'] . '</td>
                        <td class="text-center normal-row">' . \Yii::$app->params['ext_dandori_status'][0] . '</td>
                    </tr>';
                }
            }

            
        }
        ?>
    </tbody>
</table>