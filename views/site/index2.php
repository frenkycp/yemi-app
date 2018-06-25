<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Centered Information System';
?>
<div class="site-index">

    <div class="jumbotron" style="display: none;">
        <h1>WELCOME</h1>

        <p class="lead">You have successfully log in to <b><u>CIS</u></b>.</p>

    </div>

    <div class="body-content">
    	<div class="row">
    		<div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">Material Monitoring<br/>材料モニタリング</div>
                    <div class="panel-body" style="height: 200px;"></div>
                </div>
    		</div>
            <div class="col-md-1">
                <i class="fa fa-fw fa-arrow-right fa-5x text-primary"></i>
            </div>
    		<div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">WIP Monitoring<br/>生産工程モニタリング</div>
                    <div class="list-group">
                        <?= Html::a('PCB', ['/job-order-report/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('WW', ['#'], [
                            'class' => 'list-group-item disabled'
                        ]); ?>
                        <?= Html::a('PAINT', ['#'], [
                            'class' => 'list-group-item disabled'
                        ]); ?>
                        <?= Html::a('INJECTION', ['#'], [
                            'class' => 'list-group-item disabled'
                        ]); ?>
                        <?= Html::a('SPU', ['#'], [
                            'class' => 'list-group-item disabled'
                        ]); ?>
                        <?= Html::a('SUBASSY', ['#'], [
                            'class' => 'list-group-item disabled'
                        ]); ?>
                    </div>
                </div>
    		</div>
    		<div class="col-md-1">
    			<i class="fa fa-fw fa-arrow-right fa-5x text-primary"></i>
    		</div>
    		<div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">Finish Goods Monitoring<br/>完成品モニタリング</div>
                    
                    <div class="list-group">
                        <?= Html::a('Finish Goods Stock (完成品在庫)', ['/finish-good-stock/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <div class="list-group-item">
                            <p>Weekly Shipping (週次出荷)</p>
                            <ol>
                                <li><?= Html::a('Shipping Container Chart', ['/serno-output/report']); ?></li>
                                <li><?= Html::a('Shipping Container Data', ['/serno-output/index']); ?></li>
                                <li><?= Html::a('Shipping Summary', ['/weekly-plan/index']); ?></li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>Monthly Production(月次生産）</p>
                            <ol>
                                <li>
                                    <?= Html::a('Monthly Production Data', ['/yemi-internal/index']); ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
    	   </div>
        </div>
    	<div class="row">
    		<div class="col-md-3 col-md-offset-4 text-center">
    			<i class="fa fa-fw fa-arrow-up fa-5x text-primary"></i>
    		</div>
            <div class="col-md-4 col-md-offset-1 text-center">
                <i class="fa fa-fw fa-arrow-up fa-5x text-primary"></i>
            </div>
    	</div>
    	<br/>
    	<div class="row">
    		<div class="col-md-3 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">Production Support Monitoring<br/>生産支援モニタリング</div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <p>ManPower Planning (要員計画）</p>
                            <ol>
                                <li><?= Html::a('By Status (雇用形態別）', ['/hrga-emp-level-monthly/index']); ?></li>
                                <li><?= Html::a('By Department (部門別）', ['/hrga-emp-dept-monthly/index']); ?></li>
                                <li><?= Html::a('By Grade (等級別）', ['/hrga-emp-grade/index']); ?></li>
                                <li><?= Html::a('By Position (役職別)', ['/hrga-emp-jabatan/index']); ?></li>
                                <li>
                                    <p class="text-red">Attendance report (勤怠管理)</p>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>Maintenance (保全)</p>
                            <ol>
                                <li><?= Html::a('Corrective Weekly (週次修繕)', ['/ng-report/index']); ?></li>
                                <li><?= Html::a('Preventive Weekly (週次予防保全)', ['/masterplan-report/index']); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
    		</div>
            <div class="col-md-4 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">Finish Good Inspection<br/></div>
                    <div class="list-group">
                        <?= Html::a('Inspection Chart', ['/production-inspection-chart/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Inspection Data', ['/production-inspection/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
