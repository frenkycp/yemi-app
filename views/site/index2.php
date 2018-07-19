<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'YEMI Production Monitoring Cockpit (製造コックピット)';
$this->title = [
    'page_title' => 'YEMI Production Monitoring Cockpit <span class="japanesse-word">(製造コックピット)',
    'tab_title' => 'YEMI Production Monitoring Cockpit',
    'breadcrumbs_title' => 'YEMI Production Monitoring Cockpit'
];

$this->registerCss("
    .japanesse-word { 
        font-family: 'MS PGothic', Osaka, Arial, sans-serif; 
    }
    .content-header {
        text-align: center;
    }
");
?>
<hr>
<div class="site-index">

    <div class="jumbotron" style="display: none;">
        <h1>WELCOME</h1>

        <p class="lead">You have successfully log in to <b><u>CIS</u></b>.</p>

    </div>

    <div class="body-content">
    	<div class="row">
    		<div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Material Monitoring<br/><span class="japanesse-word">材料モニタリング</span></div>
                    <div class="list-group">
                        <?= Html::a('Weekly MilkRun Parts （<span class="japanesse-word">週次ミルクラン部品納入）</span>', ['/parts-milk-run-weekly/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Weekly JIT Parts <span class="japanesse-word">（週次JIT部品納入)</span>', ['/parts-jit-weekly/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Weekly Picking Status <span class="japanesse-word">(週次ピッキング状況)</span>', ['parts-picking-status/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                    </div>
                </div>
    		</div>
    		<div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">WIP Monitoring <span class="text-red japanesse-word">(準備中)</span><br/><span class="japanesse-word">生産工程モニタリング</span></div>
                    <div class="list-group">
                        <div class="list-group-item disabled">PCB <span class="japanesse-word">基板組立（準備中）</span></div>
                        <div class="list-group-item disabled">WW <span class="japanesse-word">木工（準備中）</span></div>
                        <div class="list-group-item disabled">PAINT <span class="japanesse-word">塗装（準備中）</span></div>
                        <div class="list-group-item disabled">INJECTION　<span class="japanesse-word">プラ成形（準備中）</span></div>
                        <div class="list-group-item disabled">SPU <span class="japanesse-word">スピーカー組立（準備中）</span></div>
                        <div class="list-group-item disabled">SUBASSY <span class="japanesse-word">サブ組立（準備中）</span></div>
                        <?= ''; Html::a('PCB', ['#'], [
                            'class' => 'list-group-item list-group-item-danger'
                        ]); ?>
                        <?= ''; Html::a('WW', ['#'], [
                            'class' => 'list-group-item list-group-item-danger'
                        ]); ?>
                        <?= ''; Html::a('PAINT', ['#'], [
                            'class' => 'list-group-item list-group-item-danger'
                        ]); ?>
                        <?= ''; Html::a('INJECTION', ['#'], [
                            'class' => 'list-group-item list-group-item-danger'
                        ]); ?>
                        <?= ''; Html::a('SPU', ['#'], [
                            'class' => 'list-group-item list-group-item-danger'
                        ]); ?>
                        <?= ''; Html::a('SUBASSY', ['#'], [
                            'class' => 'list-group-item list-group-item-danger'
                        ]); ?>
                    </div>
                </div>
                <div class="text-center">
                    <i class="fa fa-fw fa-arrow-up fa-3x text-primary"></i>
                </div>
                <br/>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Production Support Monitoring<br/><span class="japanesse-word">生産支援モニタリング</span></div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <p>ManPower Planning <span class="japanesse-word">(要員計画）</span></p>
                            <ol class="list-unstyled">
                                <li><?= Html::a('1. By Status <span class="japanesse-word">(雇用形態別）</span>', ['/hrga-emp-level-monthly/index']); ?></li>
                                <li><?= Html::a('2. By Department <span class="japanesse-word">(部門別）</span>', ['/hrga-emp-dept-monthly/index']); ?></li>
                                <li><?= Html::a('3. By Grade <span class="japanesse-word">(等級別）</span>', ['/hrga-emp-grade/index']); ?></li>
                                <li><?= Html::a('4. By Position <span class="japanesse-word">(役職別)</span>', ['/hrga-emp-jabatan/index']); ?></li>
                                <!--<li>
                                    <span class="text-red">5. Attendance report (勤怠管理)</span>
                                </li>-->
                                <li><?= Html::a('5. Monthly Overtime Control <br/>&nbsp;&nbsp;&nbsp;&nbsp;<span class="japanesse-word">(月次残業管理)</span>', ['/hrga-spl-report-daily/index']); ?></li>
                                <li><?= Html::a('6. Monthly MP Contract Intake<br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="japanesse-word">(月次契約要員採用)</span>', ['/hrga-manpower-intake/index']); ?></li>
                                <li><?= Html::a('7. Daily Attendance Control<br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="japanesse-word">(日常勤怠管理)</span>', ['/hrga-attendance-report/index']); ?></li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>Maintenance <span class="japanesse-word">(保全)</span></p>
                            <ol class="list-unstyled">
                                <li><?= Html::a('1. Weekly Corrective <span class="japanesse-word">(週次修繕)</span>', ['/ng-report/index']); ?></li>
                                <li><?= Html::a('2. Weekly Preventive <span class="japanesse-word">(週次予防保全)</span>', ['/masterplan-report/index']); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
                
    		</div>
    		<div class="col-md-1 text-center">
    			<i class="fa fa-fw fa-arrow-right fa-3x text-primary"></i>
    		</div>
    		<div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Finish Goods Monitoring<br/><span class="japanesse-word">完成品モニタリング</span></div>
                    
                    <div class="list-group">
                        <?= Html::a('Sales Budget/Forecast/Actual <span class="japanesse-word">(売上予算・見込み・実績)</span>', ['/production-budget/index'], [
                            'class' => 'list-group-item',
                            'style' => 'font-size: 13px;'
                        ]); ?>
                        <?= Html::a('Current Sales Progress <span class="japanesse-word">(今月の売上進捗状況)</span>', ['/production-budget-current/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Finish Goods Stock <span class="japanesse-word">(完成品在庫)</span>', ['/finish-good-stock/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <div class="list-group-item">
                            <p>Weekly Shipping <span class="japanesse-word">(週次出荷)</span></p>
                            <ol class="list-unstyled">
                                <li><?= Html::a('1. Shipping Container Chart <span class="japanesse-word">週次出荷（コンテナー別）</span>', ['/serno-output/report']); ?></li>
                                <li><?= Html::a('2. Shipping Container Data <span class="japanesse-word">(出荷コンテナーデータ）</span>', ['/serno-output/index']); ?></li>
                                <li><?= Html::a('3. Shipping Summary <span class="japanesse-word">週次出荷表 (計画対実績)</span>', ['/weekly-plan/index']); ?></li>
                            </ol>
                        </div>
                        <?= Html::a('Monthly Shipping Container <span class="japanesse-word">(月次コンテナー出荷)</span>', ['/production-container-daily-report/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <div class="list-group-item">
                            <p>Monthly Production <span class="japanesse-word">(月次生産）</span></p>
                            <ol class="list-unstyled">
                                <li>
                                    <?= Html::a('1. Monthly Production Data <span class="japanesse-word">(月次生産計画)</span>', ['/yemi-internal/index']); ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <i class="fa fa-fw fa-arrow-up fa-3x text-primary"></i>
                </div>
                <br/>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Finish Good Inspection<br/><span class="japanesse-word">( 完成品出荷の管理検査)</span><br/></div>
                    <div class="list-group">
                        <?= Html::a('Weekly Final Inspection chart <span class="japanesse-word">(週次出荷管理検査)</span>', ['/production-inspection-chart/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Final Inspection Data <span class="japanesse-word">(出荷管理検査データ)</span>', ['/production-inspection/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                    </div>
                </div>
                <hr>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Production Engineering<br/></div>
                    <div class="list-group">
                        <a class="list-group-item" href="http://172.17.144.2/workflow/newmodel.php">New Model Development <span class="japanesse-word">（新製品開発日程）</span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" href="http://172.17.144.2">PRODUCTION ENGINEERING CONTROL DATA<br/><span class="japanesse-word">(技術管理データ)</span></a>
                    </div>
                </div>
    	   </div>
        </div>
    	<br/>
    </div>
</div>
