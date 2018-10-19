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
    ol {
        font-size: 12px;
    }
    .panel-heading {
        font-weight: bold;
        font-size: 13px;
    }
    .list-group-item {
        font-size: 13px;
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
    		<div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Material Monitoring<br/><span class="japanesse-word">材料モニタリング</span></div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <p>Vendor to YEMI <span class="japanesse-word">(ベンダー⇒YEMI)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Weekly MilkRun Parts <span class="japanesse-word">(週次ミルクラン部品納入）</span>', ['/parts-milk-run-weekly/index']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Weekly JIT Parts <span class="japanesse-word">（週次JIT部品納入)</span>', ['/parts-jit-weekly/index']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>YEMI WH to Production<br/><span class="japanesse-word">(YEMI 部品倉庫⇒生産職場)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Weekly Picking Status <span class="japanesse-word">(週次ピッキング状況)</span>', ['parts-picking-status/index']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Budomari Material Monitor <span class="japanesse-word">(材料歩留モニター）</span>', ['parts-uncountable-monthly-report/index']); ?>
                                </li>
                            </ol>
                        </div>
                        
                    </div>
                </div>
    		</div>
    		<div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">E-WIP Monitoring <span class="text-red japanesse-word">(準備中)</span><br/>E-WIP<span class="japanesse-word"> 生産工程モニタリング</span></div>
                    <div class="list-group">
                        <?= Html::a('E-WIP Monitor （E-WIP モニター）', ['wip-painting-monitoring/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('E-WIP Process-Flow Monitor<br/>（E-WIP 工程流れモニター）', ['wip-flow-process-monitoring/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Stock WIP Monitor（仕掛在庫モニター）', ['wip-painting-stock-monitoring/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('WIP Data Record（仕掛りデーター）', ['wip-plan-actual-report/index'], [
                            'class' => 'list-group-item'
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
                            <p>Plant Maintenance <span class="japanesse-word">(工場保全管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li><?= Html::a('Weekly Corrective <span class="japanesse-word">(週次修繕)</span>', ['/ng-report/index']); ?></li>
                                <li><?= Html::a('Weekly Preventive <span class="japanesse-word">(週次予防保全)</span>', ['/masterplan-report/index']); ?></li>
                                <li><?= Html::a('Corrective Progress <span class="japanesse-word">(修理中設備の進捗)</span>', ['/mnt-progress/index']); ?></li>
                            </ol>
                        </div>

                        <div class="list-group-item">
                            <p>Manpower Attendance <span class="japanesse-word">(勤怠管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li><?= Html::a('Daily Attendance Control<br/>
                                    <span class="japanesse-word">(日常勤怠管理)</span>', ['/hrga-attendance-report/index']); ?>
                                </li>
                                <li><?= Html::a('Monthly Overtime Control <br/><span class="japanesse-word">(月次残業管理)</span>', ['/hrga-spl-report-daily/index']); ?>
                                </li>
                                <li><?= Html::a('Overtime Monthly Monitor <br/><span class="japanesse-word">（月次残業モニター)</span>', ['/hrga-spl-yearly-report/index']); ?>
                                </li>
                            </ol>
                        </div>
                        
                        <div class="list-group-item">
                            <p>Manpower Planning <span class="japanesse-word">(要員計画）</span></p>
                            <ol style="padding-left: 1em">
                                <!--<li>
                                    <span class="text-red">5. Attendance report (勤怠管理)</span>
                                </li>-->
                                <li><?= Html::a('Monthly MP Contract Intake<br/>
                                    <span class="japanesse-word">(月次契約要員採用)</span>', ['/hrga-manpower-intake/index']); ?>
                                </li>
                            </ol>
                        </div>
                        
                        <div class="list-group-item">
                            <p>Manpower Database <span class="japanesse-word">(社員構成)</span></p>
                            <ol style="padding-left: 1em">
                                <li><?= Html::a('By Status <span class="japanesse-word">(雇用形態別）</span>', ['/hrga-emp-level-monthly/index']); ?></li>
                                <li><?= Html::a('By Department <span class="japanesse-word">(部門別）</span>', ['/hrga-emp-dept-monthly/index']); ?></li>
                                <li><?= Html::a('By Grade <span class="japanesse-word">(等級別）</span>', ['/hrga-emp-grade/index']); ?></li>
                                <li><?= Html::a('By Position <span class="japanesse-word">(役職別)</span>', ['/hrga-emp-jabatan/index']); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
                
    		</div>
    		<div class="col-sm-1 text-center">
    			<i class="fa fa-fw fa-arrow-right fa-3x text-primary"></i>
    		</div>
    		<div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Finish Goods Monitoring<br/><span class="japanesse-word">完成品モニタリング</span></div>
                    
                    <div class="list-group">
                        <div class="list-group-item">
                            <p>Sales Control <span class="japanesse-word">(売上管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Sales Budget/Forecast/Actual<br/><span class="japanesse-word">(売上予算・見込み・実績)</span>', ['/production-budget/index']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Current Sales Progres (Proforma Invoice Based)<br/><span class="japanesse-word">(今月の売上実績)</span>', ['/production-budget-current/index']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>WH FG Control <span class="japanesse-word">(完成品倉庫管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Finish Goods Stock <span class="japanesse-word">(完成品在庫)</span>', ['/finish-good-stock']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Finish Goods Tracer <span class="japanesse-word">(完成品トレーサ）</span>', ['/serno-input']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Shipping Container Evidence <span class="japanesse-word">(出荷時の状況写真)</span>', ['/production-container-evidence']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>Shipping Control <span class="japanesse-word">(出荷管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Monthly Shipping Container <span class="japanesse-word">(月次コンテナー出荷)</span>', ['/production-container-daily-report/index']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Shipping Container Chart <span class="japanesse-word">週次出荷（コンテナー別）</span>', ['/serno-output/report']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Shipping Container Data <span class="japanesse-word">(出荷コンテナーデータ）</span>', ['/serno-output/index']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Shipping Summary <span class="japanesse-word">週次出荷表 (計画対実績)</span>', ['/weekly-plan/index']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>Monthly Production <span class="japanesse-word">(月次生産）</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Monthly Production Data <span class="japanesse-word">(月次生産計画)</span>', ['/yemi-internal/index']); ?>
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
                        <?= Html::a('Monthly Production Inspection Chart<br/><span class="japanesse-word">(月次出荷管理検査)</span>', ['/production-monthly-inspection/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                        <?= Html::a('Final Inspection Data <span class="japanesse-word">(出荷管理検査データ)</span>', ['/production-inspection/index'], [
                            'class' => 'list-group-item'
                        ]); ?>
                    </div>
                </div>
                <hr>
                <div class="panel panel-success" style="display: <?= in_array(Yii::$app->user->identity->role->id, [15]) ? 'none' : ''; ?>;">
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
