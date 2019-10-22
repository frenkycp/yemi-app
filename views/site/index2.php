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
                                    <?= Html::a('Weekly MilkRun Parts <span class="japanesse-word">(週次ミルクラン部品納入）</span>', ['/parts-milk-run-weekly']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Weekly JIT Parts <span class="japanesse-word">（週次JIT部品納入)</span>', ['/parts-jit-weekly']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>YEMI WH to Production <span class="japanesse-word">(YEMI 部品倉庫⇒生産職場)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Weekly Picking Status <span class="japanesse-word">(週次ピッキング状況)</span>', ['/parts-picking-status']); ?> <span class="text-red"><b>*IoT</b></span>
                                </li>
                                <li>
                                    <?= Html::a('Budomari Material Monitor <span class="japanesse-word">(材料歩留モニター）</span>', ['/parts-uncountable-monthly-report']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Picking Trouble by Vendor <span class="japanesse-word">(ベンダー別のピッキング問題）</span>', ['/parts-picking-pts']); ?>
                                </li><li>
                                    <?= Html::a('Picking Trouble by Model GMC <span class="japanesse-word">(製品ＧＭＣ別のピッキング問題）</span>', ['/parts-picking-pts-gmc']); ?>
                                </li>
                            </ol>
                        </div>
                        
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Part Supplement<br/><span class="japanesse-word"></span></div>
                    <div class="list-group">
                        <?= Html::a('Part Supplement Status Monitoring <span class="japanesse-word">(補充部品依頼のモニタリング）</span>', ['/part-supplement-daily-completion/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Management Support<br/><span class="japanesse-word"></span></div>
                    <div class="list-group">
                        <?= Html::a('Visitor Confirmation <span class="japanesse-word"></span>', ['before-load-url/visitor-confirm', 'url' => 'http://172.17.144.6:99/plus/index_visitor'], [
                            'class' => 'list-group-item',
                            'target' => '_blank'
                        ]) ?>
                    </div>
                    <div class="list-group">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="list-group-item">
                            CLINIC
                        </a>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="box-body">
                                <ol>
                                    <li>
                                        <?= Html::a('Clinic Confirmation <span class="japanesse-word"></span>', ['before-load-url/clinic-confirm', 'url' => 'http://172.17.144.6:99/plus/clinic'], [
                                            'target' => '_blank'
                                        ]) ?>
                                    </li>
                                    <li>
                                        <a target="_blank" href="http://172.17.144.6:86/clinic-daily-visit">Clinic Monthly Visit <span class="japanesse-word"></span></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="http://172.17.144.6:86/clinic-data">Clinic Data <span class="japanesse-word"></span></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="http://172.17.144.6:86/display/clinic-by-freq">Clinic FY Visit by Freq. <span class="japanesse-word"></span></a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="http://172.17.144.6:86/display/clinic-by-freq">Clinic FY Visit by Total Minutes <span class="japanesse-word"></span></a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:99/plus/driver/display.php">Company Car Monitoring <span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/mnt-shift-display">Shift Maintenance <span class="japanesse-word"></span></a>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Production Support Applications<br/><span class="japanesse-word"></span></div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.217/kaizen"><i class="fa fa-fw fa-tag"></i> E-Kaizen<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/line-performance-visual"><i class="fa fa-fw fa-tag"></i> Line Performance by Model<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:99/plus/index_prd/index_prd_efficiency.php"><i class="fa fa-fw fa-tag"></i> Line Efficiency (MITA+)<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:99/plus/plan/display.php"><i class="fa fa-fw fa-tag"></i> Priority Plan (MITA+)<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:99/plus/index_fg/display.php"><i class="fa fa-fw fa-tag"></i> FGS Loading Status (MITA+)<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/container-loading"><i class="fa fa-fw fa-tag"></i> Container Loading by Group <span class="japanesse-word">(グループ別コンテナー積み込み作業表)</span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/l-series-daily"><i class="fa fa-fw fa-tag"></i> Production Lead Time L-Series<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/mnt-kwh-report"><i class="fa fa-fw fa-tag"></i> Machine Operation Status<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/machine-status-range"><i class="fa fa-fw fa-tag"></i> Machine Operation Status (Long Range)<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/machine-status-range-shift"><i class="fa fa-fw fa-tag"></i> Machine Operation Status (Shift)<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/mnt-iot-utility"><i class="fa fa-fw fa-tag"></i> Machine Daily Utility<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/shift-patrol-tbl"><i class="fa fa-fw fa-tag"></i> Shift Daily Patrol<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/new-model-progress"><i class="fa fa-fw fa-tag"></i> Model Monthly Progress<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/crusher-chart"><i class="fa fa-fw fa-tag"></i> Crusher Chart<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:99/plus/vanning/monitor.php"><i class="fa fa-fw fa-tag"></i> Direct Vanning Monitor <span class="japanesse-word">( ダイレクトバンニング進捗表 )</span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:99/plus/vanning/summary.php"><i class="fa fa-fw fa-tag"></i> Direct Vanning Summary<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/fgs-stock"><i class="fa fa-fw fa-tag"></i> FGS Stock (Group by Days)<span class="japanesse-word"></span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/chourei"><i class="fa fa-fw fa-tag"></i> Chourei Menu<span class="japanesse-word"></span></a>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Production Defect (Daily)<br/><span class="japanesse-word"></span></div>
                    <div class="list-group">
                        <a class="list-group-item" target="_blank" href="http://172.17.144.6:86/display/defect-daily-pcb"><i class="fa fa-fw fa-tag"></i> PCB<span class="japanesse-word"></span></a>
                    </div>
                </div>
    		</div>
    		<div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">E-WIP Monitoring<br/>E-WIP<span class="japanesse-word"> 生産工程モニタリング</span></div>
                    <div class="list-group">
                        <?= Html::a('Monthly Production Data <span class="japanesse-word">(月次生産計画)</span>', ['/yemi-internal/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('E-WIP Monitor （E-WIP モニター）', ['wip-painting-monitoring/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('E-WIP Process-Flow Monitor<br/>（E-WIP 工程流れモニター）', ['wip-flow-process-monitoring/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('Stock WIP Monitor（仕掛在庫モニター）', ['wip-painting-stock-monitoring/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('WIP Data Record（仕掛りデーター）', ['wip-plan-actual-report/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('Machine IoT Output Data', ['machine-iot-output-hdr/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('Machine IoT Output Data (Detail)', ['machine-iot-output-dtr/index'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                        <?= Html::a('Wood Working Lot Waiting Next Process', ['display/ww-lot-waiting'], [
                            'class' => 'list-group-item', 'style' => 'font-size: 11.8px;'
                        ]); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">E-WIP Performance<br/><span class="japanesse-word"> (E-WIPパフォーマンス)</span></div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('GMC Efficiency Data <span class="japanesse-word">(GMC別能率データ）</span>', ['/dpr-gmc-eff-data']); ?>
                                </li>
                                <li>
                                    <?= Html::a('FA Line Efficiency & Loss Time<br/><span class="japanesse-word">(総組ライン能率&ロースタイム）</span>', ['/dpr-line-efficiency-daily']); ?>
                                </li>
                                <li>
                                    <?= Html::a('FA Line Efficiency & Loss Time Monthly<br/><span class="japanesse-word">(月次総組ライン能率&ロースタイム）</span>', ['/dpr-line-efficiency-monthly']); ?>
                                </li>
                                <li>
                                    <?= Html::a('SMT INJ Performance Data<br/><span class="japanesse-word">(SMT INJ パフォーマンスデータ）</span>', ['/smt-performance-data']); ?>
                                </li>
                                <li>
                                    <?= Html::a('SMT INJ Utility & Loss Time Management<br/><span class="japanesse-word">( SMT INJ 稼働率・ロスタイム管理）</span> | Daily', ['/smt-daily-utility-report']); ?>
                                </li>
                                <li>
                                    <?= Html::a('SMT INJ Utility & Loss Time Management<br/><span class="japanesse-word">( SMT INJ 稼働率・ロスタイム管理）</span> | Monthly', ['/smt-line-monthly-utility']); ?>
                                </li>
                                <!--<li>
                                    <?= ''; //Html::a('SMT Performance Ratio<br/><span class="japanesse-word">(SMT パフォーマンス)</span>', ['/smt-performance-ratio']); ?>
                                </li>-->
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading text-center">E-WIP TRANSPORT MANAGEMENT<br/><span class="japanesse-word">(E-WIP配達管理）</span></div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <p>GO-WIP Monitor <span class="japanesse-word">（仕掛り配達モニター）</span> <span class="text-red"><b>*IoT</b></span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Order Progress Monitor <span class="japanesse-word"> (配達進捗モニター）</span>', ['/gojek-order-completion']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Utilization <span class="japanesse-word">(配達の稼働率）</span>', ['/gojek-driver-utility']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Data <span class="japanesse-word">(配達データー)</span>', ['/gojek-order-tbl']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>GO-PALLET Monitor <span class="japanesse-word">（完成品配達モニター）</span> <span class="text-red"><b>*IoT</b></span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Order Progress Monitor <span class="japanesse-word"> (配達進捗モニター）</span>', ['/pallet-order-completion']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Utilization <span class="japanesse-word">(配達の稼働率）</span>', ['/pallet-driver-utility']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Data <span class="japanesse-word">(配達データー)</span>', ['/pallet-transporter-data']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>GO-PICKING Monitor <span class="japanesse-word"></span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Order Progress Monitor <span class="japanesse-word"> (配達進捗モニター）</span>', ['/go-picking-order-completion']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Utilization <span class="japanesse-word">(配達の稼働率）</span>', ['/go-picking-driver-utility']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Data <span class="japanesse-word">(配達データー)</span>', ['/go-picking-order-data']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>GO-MACHINE Monitor <span class="japanesse-word"></span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Order Progress Monitor <span class="japanesse-word"> (配達進捗モニター）</span>', ['/go-machine-order-completion']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Utilization <span class="japanesse-word">(配達の稼働率）</span>', ['/go-machine-driver-utility']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Data <span class="japanesse-word">(配達データー)</span>', ['/go-machine-order']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>GO-SUB ASSY Monitor <span class="japanesse-word"></span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Order Progress Monitor <span class="japanesse-word"> (配達進捗モニター）</span>', ['/go-sub-order-completion']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Utilization <span class="japanesse-word">(配達の稼働率）</span>', ['/gosub-operation-ratio']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Transport Data <span class="japanesse-word">(配達データー)</span>', ['/go-sa-tbl']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Operator Current Status <span class="japanesse-word"></span>', ['/display/go-sub-driver-status']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Movement Tracking <span class="japanesse-word"></span>', ['/display/gosub-location']); ?>
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
                    <div class="panel-heading text-center">Production Support Monitoring<br/><span class="japanesse-word">生産支援モニタリング</span></div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <p>Plant Maintenance <span class="japanesse-word">(工場保全管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li><?= Html::a('Weekly Corrective <span class="japanesse-word">(週次修繕)</span>', ['/ng-report/index']); ?></li>
                                <li><?= Html::a('Weekly Preventive <span class="japanesse-word">(週次予防保全)</span>', ['/masterplan-report/index']); ?></li>
                                <li><?= Html::a('Corrective Progress <span class="japanesse-word">(修理中設備の進捗)</span>', ['/mnt-progress/index']); ?></li>
                                <li><?= Html::a('Maintenance Spareparts <span class="japanesse-word">(スペアパーツ）</span>', ['/mnt-minimum-stock/index']); ?></li>
                                <li><?= Html::a('Temperature Monitoring <span class="japanesse-word"></span>', ['/display/temp-humidity-control?category=1']); ?></li>
                                <li><?= Html::a('Humidity Monitoring <span class="japanesse-word"></span>', ['/display/temp-humidity-control?category=2']); ?></li>
                            </ol>
                        </div>

                        <div class="list-group-item">
                            <p>Manpower Attendance <span class="japanesse-word">(勤怠管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li><?= Html::a('Daily Attendance Control <span class="japanesse-word">(日常勤怠管理)</span>', ['/hrga-attendance-report/index']); ?>
                                </li>
                                <li><?= Html::a('Monthly Overtime Control <span class="japanesse-word">(月次残業管理)</span>', ['/hrga-spl-report-daily/index']); ?>
                                </li>
                                <li><?= Html::a('Overtime Monthly Monitor <span class="japanesse-word">（月次残業モニター)</span>', ['/hrga-spl-yearly-report/index']); ?>
                                </li>
                                <li><?= Html::a('OT Management by NIK <span class="japanesse-word">(社員別残業管理）</span>', ['/top-overtime-data/index']); ?>
                                </li>
                                <li><?= Html::a('OT Management by Section <span class="japanesse-word">(部門別残業管理）</span>', ['/monthly-overtime-by-section/index']); ?>
                                </li>
                                <li><?= Html::a('Monthly OT Average <span class="japanesse-word"></span>', ['/overtime-monthly-summary/index']); ?>
                                </li>
                                <li><?= Html::a('Absent Report by Month <span class="japanesse-word"></span>', ['/hrga-rekap-absensi-data/index']); ?>
                                </li>
                                <li><?= Html::a('Absent Report by Year <span class="japanesse-word"></span>', ['/absent-report-year/index']); ?>
                                </li>
                            </ol>
                        </div>
                        
                        <div class="list-group-item">
                            <p>Manpower Planning <span class="japanesse-word">(要員計画）</span></p>
                            <ol style="padding-left: 1em">
                                <!--<li>
                                    <span class="text-red">5. Attendance report (勤怠管理)</span>
                                </li>-->
                                <li><?= Html::a('Monthly MP Contract Intake <span class="japanesse-word">(月次契約要員採用)</span>', ['/hrga-manpower-intake/index']); ?>
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
                                    <?= Html::a('Sales Budget/Forecast/Actual <span class="japanesse-word">(売上予算・見込み・実績)</span>', ['/production-budget/index']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Current Sales Progres (Proforma Invoice Based) <span class="japanesse-word">(今月の売上実績)</span>', ['/production-budget-current/index']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>WH FG Control <span class="japanesse-word">(完成品倉庫管理)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Finish Goods Stock <span class="japanesse-word">(完成品在庫)</span>', ['/finish-good-stock']); ?> <span class="text-red"><b>*IoT</b></span>
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
                                    <?= Html::a('Shipping Container Chart <span class="japanesse-word">週次出荷（コンテナー別）</span> - IN', ['/serno-output/report']); ?> <span class="text-red"><b>*IoT</b></span>
                                </li>
                                <li>
                                    <?= Html::a('Shipping Container Chart <span class="japanesse-word">週次出荷（コンテナー別）</span> - OUT', ['/weekly-shipping-out/index']); ?> <span class="text-red"><b>*IoT</b></span>
                                </li>
                                <li>
                                    <?= Html::a('Shipping Container Data <span class="japanesse-word">(出荷コンテナーデータ）</span>', ['/serno-output/index']); ?>
                                </li>
                            </ol>
                        </div>
                        <div class="list-group-item">
                            <p>Shipping Performance <span class="japanesse-word">(出荷パフォーマンス)</span></p>
                            <ol style="padding-left: 1em">
                                <li>
                                    <?= Html::a('Weekly Summary <span class="japanesse-word">週次出荷表 (計画対実績)</span>', ['/weekly-plan']); ?>
                                </li>
                                <li>
                                    <?= Html::a('Monthly Summary <span class="japanesse-word">月次出荷表 (計画対実績)</span>', ['/so-achievement-data']); ?>
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
                    <div class="list-group-item">
                        <ol style="padding-left: 1em">
                            <li>
                                <?= Html::a('Weekly Shipping Inspection Monitor <span class="japanesse-word">(週次出荷対応管理検査モニター)</span>', ['/production-inspection-daily']); ?>
                            </li>
                            <li>
                                <?= Html::a('Monthly Production Inspection Chart <span class="japanesse-word">(月次出荷管理検査)</span>', ['/production-monthly-inspection']); ?>
                            </li>
                            <li>
                                <?= Html::a('Final Inspection Data <span class="japanesse-word">(出荷管理検査データ)</span>', ['/production-inspection']); ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <hr>
                <div class="panel panel-success" style="display: <?= in_array(Yii::$app->user->identity->role->id, [15]) ? 'none' : ''; ?>;">
                    <div class="panel-heading text-center">Production Engineering<br/></div>
                    <div class="list-group">
                        <a class="list-group-item" href="http://172.17.144.2/yamaha/project/index" target="_blank">New Model Development <span class="japanesse-word">（新製品開発日程）</span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" href="http://172.17.144.2" target="_blank">PRODUCTION ENGINEERING CONTROL DATA <span class="japanesse-word">(技術管理データ)</span></a>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" href="http://172.17.144.2/repair" target="_blank">PCB Repair Database <span class="japanesse-word"></span></a>
                    </div>
                </div>
    	   </div>
        </div>
    	<br/>
    </div>
</div>
