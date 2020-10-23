<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
	    div.centered 
		{
		    text-align: center;
		}

		div.centered table 
		{
		    margin: 0 auto; 
		    text-align: left;
		}

		.summary-tbl{
	        border-top: 0;
	        border-collapse: collapse;
	        border-spacing: 0;
	    }
	    .summary-tbl tbody tr td{
	        border:1px solid #777474;
	        font-size: 14px;
	        background: white;
	        color: black;
	        vertical-align: middle;
	        letter-spacing: 1.1px;
	    }
	    .summary-tbl thead tr th{
	        border:1px solid #777474 !important;
	        background-color: rgb(255, 229, 153);
	        color: black;
	        font-size: 16px;
	        vertical-align: middle;
	    }
	     .tbl-header{
	        border:1px solid #8b8c8d !important;
	        background-color: #518469 !important;
	        color: black !important;
	        font-size: 16px !important;
	        border-bottom: 7px solid #797979 !important;
	        vertical-align: middle !important;
	    }
	    .summary-tbl tfoot tr td{
	        border:1px solid #777474;
	        font-size: 20px;
	        background: #000;
	        color: white;
	        vertical-align: middle;
	        padding: 20px 10px;
	        letter-spacing: 1.1px;
	    }
	    .text-center {text-align: center;}
	    .text-red {color: #dd4b39;}
    </style>
</head>
<body>
    <?php $this->beginBody() ?>
	<div class="centered">
    	<table class="summary-tbl" id="" width="400">
	        <thead>
	            <tr>
	                <th colspan="2" class="">Production (<?= date('d M\' Y', strtotime($yesterday)); ?>) - FG<br/><span class="japanesse">生産予実績 （日次） - 完成品</span></th>
	                <th class="text-center">Daily</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td width="40%" class="text-left">Plan</td>
	                <td width="30%" class="text-center">計画</td>
	                <td width="30%" class="text-center"><?= number_format($prod_data_daily_fg->PLAN_QTY); ?></td>
	            </tr>
	            <tr>
	                <td class="text-left">Actual</td>
	                <td class="text-center">実績</td>
	                <td class="text-center"><?= number_format($prod_data_daily_fg->ACTUAL_QTY); ?></td>
	            </tr>
	            <tr>
	                <td class="text-left">Balance</td>
	                <td class="text-center">進度</td>
	                <td class="text-center"><?= number_format($prod_data_daily_fg->ACTUAL_QTY - $prod_data_daily_fg->PLAN_QTY); ?></td>
	            </tr>
	            <tr style="<?= $tmp_fg_minus_daily ? '' : 'display: none;'; ?>">
	                <td colspan="3" style="font-size: 12px;">
	                    <?php
	                    if ($tmp_fg_minus_daily) {
	                        echo '<u>Top 3 Balance :</u><br/>';
	                        foreach ($tmp_fg_minus_daily as $key => $value) { ?>
	                            - <?= $value->ITEM; ?> | <?= $value->ITEM_DESC . ' ' . $value->DESTINATION; ?> | <span class="text-red"><?= number_format($value->BALANCE_QTY); ?></span><br/>
	                        <?php
	                        }
	                    }
	                    ?>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <br/>
	    <table class="summary-tbl" id="" width="400">
	    	<thead>
	            <tr>
	                <th colspan="2" class="">Production (<?= date('d M\' Y', strtotime($yesterday)); ?>) - KD Parts<br/><span class="japanesse">生産予実績 （日次） - KDパーツ</span></th>
	                <th class="text-center">Daily</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td width="40%" class="text-left">Plan</td>
	                <td width="30%" class="text-center">計画</td>
	                <td width="30%" class="text-center"><?= number_format($prod_data_daily_kd->PLAN_QTY); ?></td>
	            </tr>
	            <tr>
	                <td class="text-left">Actual</td>
	                <td class="text-center">実績</td>
	                <td class="text-center"><?= number_format($prod_data_daily_kd->ACTUAL_QTY); ?></td>
	            </tr>
	            <tr>
	                <td class="text-left">Balance</td>
	                <td class="text-center">進度</td>
	                <td class="text-center"><?= number_format($prod_data_daily_kd->ACTUAL_QTY - $prod_data_daily_kd->PLAN_QTY); ?></td>
	            </tr>
	            <tr style="<?= $tmp_kd_minus_daily ? '' : 'display: none;'; ?>">
	                <td colspan="3" style="font-size: 12px;">
	                    <?php
	                    if ($tmp_kd_minus_daily) {
	                        echo '<u>Top 3 Balance :</u><br/>';
	                        foreach ($tmp_kd_minus_daily as $key => $value) { ?>
	                            - <?= $value->ITEM; ?> | <?= $value->ITEM_DESC . ' ' . $value->DESTINATION; ?> | <span class="text-red"><?= number_format($value->BALANCE_QTY); ?></span><br/>
	                        <?php
	                        }
	                    }
	                    ?>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <br/>
	    <table class="summary-tbl" id="" width="400">
	        <thead>
	            <tr>
	                <th colspan="2" class="">Production (<?= date('M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">生産予実績 （月次）</span></th>
	                <th class="text-center">Monthly</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td width="40%" class="">Plan Acc.</td>
	                <td width="30%" class="text-center">累計計画</td>
	                <td width="30%" class="text-center"><?= number_format($prod_data_monthly->PLAN_QTY); ?></td>
	            </tr>
	            <tr>
	                <td class="">Actual Acc.</td>
	                <td class="text-center">累計実績</td>
	                <td class="text-center"><?= number_format($prod_data_monthly->ACTUAL_QTY); ?></td>
	            </tr>
	            <tr>
	                <td class="">Balance</td>
	                <td class="text-center">進度</td>
	                <td class="text-center"><?= number_format($prod_data_monthly->ACTUAL_QTY - $prod_data_monthly->PLAN_QTY); ?></td>
	            </tr>
	            <tr style="<?= $tmp_top_minus ? '' : 'display: none;'; ?>">
	                <td colspan="3" style="font-size: 12px;">
	                    <?php
	                    if ($tmp_top_minus) {
	                        echo '<u>Top 3 Balance :</u><br/>';
	                        foreach ($tmp_top_minus as $key => $value) { ?>
	                            - <?= $value->ITEM; ?> | <?= $value->ITEM_DESC . ' ' . $value->DESTINATION; ?> | <span class="text-red"><?= number_format($value->BALANCE_QTY); ?></span><br/>
	                        <?php
	                        }
	                    }
	                    ?>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <br/>
	    <table class="summary-tbl" id="" width="400">
	        <thead>
	            <tr>
	                <th colspan="2" class="">Shipping (<?= date('d M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">出荷実績 (日次)</span></th>
	                <th class="text-center">Daily</th>
	            </tr>
	        </thead>
	        <tbody>
	            <?php foreach ($bu_arr as $key => $value): ?>
	                <tr style="<?= $value == 0 ? 'display: none;' : ''; ?>">
	                    <td width="40%" class=""><?= $key; ?></td>
	                    <td width="30%" class="text-center">実績</td>
	                    <td width="30%" class="text-center"><?= number_format($value); ?></td>
	                </tr>
	            <?php endforeach ?>
	            <tr>
	                <td class="" style="font-weight: bold;">Total</td>
	                <td class="text-center" style="font-weight: bold;">合計</td>
	                <td class="text-center" style="font-weight: bold;"><?= number_format($total_shipping); ?></td>
	            </tr>
	        </tbody>
	    </table>
	    <br/>
	    <table class="summary-tbl" id="" width="400">
	        <thead>
	            <tr>
	                <th colspan="2" class="">FA OQC NG Rate (<?= date('d M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">総組 OQC不良率</span></th>
	                <th class="text-center">Daily</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td width="40%" class="">Actual</td>
	                <td width="30%" class="text-center">実績</td>
	                <td width="30%" class="text-center"><?= $ng_rate; ?>%</td>
	            </tr>
	            <tr style="<?= $tmp_top_ng ? '' : 'display: none;'; ?>">
	                <td colspan="3" style="font-size: 12px;">
	                    <?php
	                    if ($tmp_top_ng) {
	                        echo '<u>Top 3 NG Qty :</u><br/>';
	                        foreach ($tmp_top_ng as $key => $value) { ?>
	                            - <?= $value->gmc_desc; ?> ( <span class="text-red"><?= 'NG : ' . number_format($value->ng_qty); ?></span>)<br/>
	                        <?php
	                        }
	                    }
	                    ?>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <br/>
	    <table class="summary-tbl" id="" width="400">
	        <thead>
	            <tr>
	                <th colspan="2" class="">Attendance Rate (<?= date('d M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">出勤率</span></th>
	                <th class="text-center column-3"><?= $attendance_rate; ?>%</th>
	            </tr>
	        </thead>
	    </table>

	    <i>Source : MITA</i>
    </div>
    
    
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
