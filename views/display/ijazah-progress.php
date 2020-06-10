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
    'page_title' => 'VMS Monthly Progress (Versus FLO) <span class="japanesse light-green"></span>',
    'tab_title' => 'VMS Monthly Progress (Versus FLO)',
    'breadcrumbs_title' => 'VMS Monthly Progress (Versus FLO)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



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
    #summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 16px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
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
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($actual_by_period);
echo '</pre>';*/
?>
<br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['ijazah-progress']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                //'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'line')->dropDownList(
            $line_arr,
            [
                'prompt' => 'Choose...',
            ]
        ); ?>
    </div>
    
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    <div class="col-md-1">
        <?= $form->field($model, 'category')->hiddenInput()->label(false); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<table class="table" id="summary-tbl">
    <thead>
        <tr>
            <th class="text-center" width="120px">ITEM</th>
            <th width="200px">ITEM DESC.</th>
            <?php foreach ($period_arr as $key => $value): ?>
                <th class="text-center" width="150px;"><?= $value; ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" class="bg-black text-center">Total</td>
            <?php foreach ($actual_by_period as $key => $value): ?>
                <td class="text-center bg-black"><?= number_format($value); ?></td>
            <?php endforeach ?>
        </tr>
        <?php
        if (count($tmp_data_arr) > 0) {
            ?>

            <?php foreach ($tmp_data_arr as $key => $value): 
                if (isset($value['total_actual'])) {
                    unset($value['total_actual']);
                }
                ?>
                <tr>
                    <td class="text-center"><?= $key; ?></td>
                    <td><?=
                    //$tmp_gmc_arr[$key] . ' (Total Actual Qty : ' . $total_actual . ')';
                    $tmp_gmc_arr[$key];
                    ?></td>
                    <?php
                    $total_period = count($value);
                    $index = 0;
                    
                    foreach ($value as $key2 => $value2):
                        //$pct = $value2['percentage'];
                        //
                        ?>
                        <?php
                        $actual_qty = 0;
                        if (isset($value2['plan_qty'])) {
                            $plan_qty = $value2['plan_qty'];
                            $actual_qty = $value2['actual_qty'];

                            $pct = 0;
                            if ($plan_qty > 0) {
                                $pct = round(($actual_qty / $plan_qty) * 100, 1);
                            }

                            if ($pct >= 100) {
                                $progress_bar = ' progress-bar-green';
                            } else {
                                if ($key2 < date('Ym')) {
                                    $progress_bar = ' progress-bar-red';
                                } else {
                                    $progress_bar = ' progress-bar-yellow';
                                }
                            }
                            ?>
                            <td class="text-center">
                                <?= ''; //$pct; ?>
                                <div class="progress-group">
                                    <span class="progress-text" style="color: rgba(0, 0, 0, 0);">.</span>
                                    <span class="progress-number" style="font-size: 0.7em;"><?= number_format($actual_qty); ?>/<?= number_format($plan_qty); ?></span>

                                    <div class="progress" style="margin-top: 0px;">
                                        <div class="progress-bar<?= $progress_bar; ?><?= $pct < 100 ? ' progress-bar-striped active' : '' ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pct > 100 ? 100 : $pct; ?>%; font-size: 11px;"><?= $pct; ?>%</div>
                                    </div>
                                </div>
                            </td>
                        <?php } else { ?>
                            <td class="text-center">-</td>
                        <?php }
                        $index++;
                        ?>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>

        <?php }
        ?>
    </tbody>
</table>