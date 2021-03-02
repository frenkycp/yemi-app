<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SBillingSearch $searchModel
*/

$this->title = [
    'page_title' => 'Dashboard <span class="japanesse light-green"></span>',
    'tab_title' => 'Dashboard',
    'breadcrumbs_title' => 'Dashboard'
];
?>
<div class="row">
	<div class="col-sm-3">
		<div class="small-box bg-yellow">
			<div class="inner">
				<h3><?= $tmp_total->total_stage1; ?></h3>

				<p><?= \Yii::$app->params['s_billing_stage_arr'][1]; ?></p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3><?= $tmp_total->total_stage2; ?></h3>

				<p><?= \Yii::$app->params['s_billing_stage_arr'][2]; ?></p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<!-- <div class="col-sm-3">
		<div class="small-box bg-light-blue">
			<div class="inner">
				<h3><?= $tmp_total->total_stage3; ?></h3>

				<p><?= \Yii::$app->params['s_billing_stage_arr'][3]; ?></p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div> -->
</div>