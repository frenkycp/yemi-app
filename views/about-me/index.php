﻿<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = [
    'page_title' => 'Data Flow & Site Timeline MITA (<b><u>M</u></b>anufacturing <b><u>I</u></b>nformation <b><u>T</u></b>echnology <b><u>A</u></b>rchitecture) <span class="japanesse light-green"></span>',
    'tab_title' => 'Data Flow & Site Timeline',
    'breadcrumbs_title' => 'Data Flow & Site Timeline'
];

$this->registerJs("$(function() {
   $('.btn-video').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");


date_default_timezone_set('Asia/Jakarta');
$image_height = '300px';

?>
<div>
    <?= Html::a(Html::img('@web/uploads/mita-dfd.png', [
        'class' => 'media-object',
        'width' => '100%',
    ]), ['uploads/mita-dfd.pdf'], ['target' => '_blank']);
    ?>
</div>
<hr>
<h2>Timeline</h2>
<ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Mar. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-03-24</span>

            <h3 class="timeline-header"><a href="#">Visitor Display Information <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Display Visitor Information
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202003_visitor_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-03-12</span>

            <h3 class="timeline-header"><a href="#">Fix Asset Stock Take <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Fix Asset Digital Stock Take
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202003_stock_take_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Feb. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-02-12</span>

            <h3 class="timeline-header"><a href="#">E-NG Production <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring NG on Production
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202002_ng_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>&nbsp;&nbsp;&nbsp;
                <?= Html::img('@web/uploads/ABOUT/202002_ng_02.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jan. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-01-10</span>

            <h3 class="timeline-header"><a href="#">PCB Repair Database <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring Repair on PCB
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202001_repair_04.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

	<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Dec. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-12-02</span>

            <h3 class="timeline-header"><a href="#">Solder Dross Recycle Monitoring <span class="japanesse">はんだドロスのリサイクル管理</span></a></h3>

            <div class="timeline-body">
                Monitoring In & Out Dross quantity & ratio.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/dross_monitoring.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

	<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Nov. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-11-01</span>

            <h3 class="timeline-header"><a href="#">Wood Working Beacon (Location)</a></h3>

            <div class="timeline-body">
                Add beacon to WIP on Wood Working to detect location.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/ww_beacon.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

	<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Oct. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-10-28</span>

            <h3 class="timeline-header"><a href="#">Sensor Monitoring</a></h3>

            <div class="timeline-body">
                Add sensors that connected to the network to help monitoring process.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/temp_humi.jpg', ['class' => 'attachment-img', 'height' => $image_height, 'width' => '650px']); ?>&nbsp;&nbsp;&nbsp;
                <?= Html::img('@web/uploads/ABOUT/temp_humi_2.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Sep. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-09-16</span>

            <h3 class="timeline-header"><a href="#">Sub Assy Beacon (Location)</a></h3>

            <div class="timeline-body">
                Add beacon to Sub Assy employee to track the movemnent & current location.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/beacon_sa.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

	<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Aug. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-08-19</span>

            <h3 class="timeline-header"><a href="#">Visitor Welcome Display</a></h3>

            <div class="timeline-body">
                Display welcome message for incoming visitor.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/visitor_welcome.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-08-12</span>

            <h3 class="timeline-header"><a href="#">Meeting Room Display Information</a></h3>

            <div class="timeline-body">
                Display meeting schedule for each meeting room and show current meeting.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/mrbs.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

	<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jul. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-07-10</span>

            <h3 class="timeline-header"><a href="#">Vanning Project L-Sries</a></h3>

            <div class="timeline-body">
                Vanning project for L-Series model.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/direct_vanning.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-07-04</span>

            <h3 class="timeline-header"><a href="#">Container Loading Progress Monitoring</a></h3>

            <div class="timeline-body">
                Add display for monitoring daily container progress.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/container_loading.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-07-01</span>

            <h3 class="timeline-header"><a href="#">Receiving Calendar</a></h3>

            <div class="timeline-body">
                Monitoring Incoming Material ETD YEMI.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/receiving_calendar.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

	<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jun. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-06-28</span>

            <h3 class="timeline-header"><a href="#">Crusher Data Monitoring</a></h3>

            <div class="timeline-body">
                Monitoring crusher data on Injection Location.
                <br/>
                <?= Html::img('@web/uploads/ABOUT/crusher.jpg', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-06-10</span>

            <h3 class="timeline-header"><a href="#">Shift Daily Patrol</a></h3>

            <div class="timeline-body">
                Night daily patrol for monitoring production area if there is something abnormal.
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            May. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-05-17</span>

            <h3 class="timeline-header"><a href="#">Data Acquisition Network</a></h3>

            <div class="timeline-body">
                Monitoring network stability on production.
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-yellow"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-05-02</span>

            <h3 class="timeline-header"><a href="#">IoT Production Machine Performance</a></h3>

            <div class="timeline-body">
                Monitoring machine performance on production if there is something abnormal.
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-05-02</span>

            <h3 class="timeline-header"><a href="#">IPQA Daily Patrol</a></h3>

            <div class="timeline-body">
                IPQA daily patrol for monitoring process on production if there is something abnormal.
            </div>
        </div>
    </li>
    <!-- END timeline item -->
    <!-- /.timeline-label -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Apr. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-green"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-04-01</span>

            <h3 class="timeline-header"><a href="#">Clinic System</a></h3>

            <div class="timeline-body">
                Monitoring people visit on clinic
            </div>
        </div>
    </li>
    <!-- END timeline item -->
    <!-- /.timeline-label -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Mar. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-maroon"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-03-04</span>

            <h3 class="timeline-header"><a href="#">Visitor System</a></h3>

            <div class="timeline-body">
                Monitoring people visit on Factory
            </div>
        </div>
    </li>
    <!-- END timeline item -->
    <!-- /.timeline-label -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Feb. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-orange"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-02-28</span>

            <h3 class="timeline-header"><a href="#">GO-MACHINE Monitor</a></h3>

            <div class="timeline-body">
                Monitoring efficency of machine setting on Wood Working
            </div>
        </div>
    </li>
    <!-- END timeline item -->
    <!-- /.timeline-label -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jan. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-08</span>

            <h3 class="timeline-header"><a href="#">GO-PICKING Monitor</a></h3>

            <div class="timeline-body">
                Monitoring efficency of material movements from Warehouse to Production
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>GO-PICKING</u></b></span>
                                <?= '<video width="100%" controls>
                                    <source src="http://172.17.144.6:86/uploads/video/go_picking_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <!-- END timeline item -->
    <!-- /.timeline-label -->

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Dec. 2018
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-yellow"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-12-04</span>

            <h3 class="timeline-header"><a href="#">My HR</a></h3>

            <div class="timeline-body">
                Employee self service information
            </div>
        </div>
    </li>
    <!-- END timeline item -->
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Nov. 2018
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-line-chart bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-11-27</span>

            <h3 class="timeline-header"><a href="#">SMT Utility & Loss Time</a></h3>

            <div class="timeline-body">
                Real time monitoring SMT performance ( Utilization & Losstime)  based on line output
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>SMT</u></b></span>
                                <?= '<video width="100%" controls>
                                    <source src="http://172.17.144.6:86/uploads/video/smt_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li>
        <!-- timeline icon -->
        <i class="fa fa-bicycle bg-green"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-11-21</span>

            <h3 class="timeline-header"><a href="#">GO-PALLET Monitor <span class="japanesse">（完成品配達モニター）</span></a></h3>

            <div class="timeline-body">
                Monitoring efficency of transporter finish good from production to Warehouse Finish Good
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>GO-PALLET</u></b></span>
                                <?= '<video width="100%" controls>
                                    <source src="http://172.17.144.6:86/uploads/video/go_pallet_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <!-- END timeline item -->

    <li class="time-label">
        <span class="bg-purple">
            Oct. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-dropbox bg-maroon"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-10-23</span>

            <h3 class="timeline-header"><a href="#">Material Monitoring <span class="japanesse">（材料モニタリング）</span></a></h3>

            <div class="timeline-body">
                Material picking status for production plan
            </div>
        </div>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Sep. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-bar-chart bg-orange"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-09-27</span>

            <h3 class="timeline-header"><a href="#">E-WIP Performance <span class="japanesse">(E-WIPパフォーマンス)</span></a></h3>

            <div class="timeline-body">
                Monitoring Production line efficency and lost time
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>DPR</u></b></span>
                                <?= '<video width="100%" controls>
                                    <source src="http://172.17.144.6:86/uploads/video/dpr_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-bicycle bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-09-26</span>

            <h3 class="timeline-header"><a href="#">GO-WIP Monitor <span class="japanesse">（仕掛り配達モニター）</span></a></h3>

            <div class="timeline-body">
                Transporter performance monitoring
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>GO-WIP</u></b></span>
                                <?= '<video width="100%" controls>
                                    <source src="http://172.17.144.6:86/uploads/video/go_wip_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Aug. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-bar-chart bg-yellow"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-10-23</span>

            <h3 class="timeline-header"><a href="#">E-WIP Monitoring <span class="japanesse">（E-WIP 生産工程モニタリング）</span></a></h3>

            <div class="timeline-body">
                E-WIP Status monitoring
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-calendar bg-green"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-08-20</span>

            <h3 class="timeline-header"><a href="#">Manpower Attendance <span class="japanesse">(勤怠管理)</span></a></h3>

            <div class="timeline-body">
                Real time displaying attendance employes
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-balance-scale bg-aqua"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-08-02</span>

            <h3 class="timeline-header"><a href="#">Sales Control <span class="japanesse">(売上管理)</span></a></h3>

            <div class="timeline-body">
                Monitoring expense base on budget and actual
            </div>
        </div>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Jul. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-database bg-light-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-07-30</span>

            <h3 class="timeline-header"><a href="#">Manpower Database <span class="japanesse">(社員構成)</span></a></h3>

            <div class="timeline-body">
                Manpower category by Status, Department, Grade and Position
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-sitemap bg-maroon"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-07-30</span>

            <h3 class="timeline-header"><a href="#">Manpower Planning <span class="japanesse">(要員計画）</span></a></h3>

            <div class="timeline-body">
                Man power planning base on sales
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-cubes bg-orange"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-07-03</span>

            <h3 class="timeline-header"><a href="#">WH FG Control <span class="japanesse">(完成品倉庫管理)</span> - <span class="text-red">*IoT</span></a></h3>

            <div class="timeline-body">
                Monitoring finish good stock according in and out goods
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>RFID</u></b></span>
                                <?= '<video width="100%" controls>
                                    <source src="http://172.17.144.6:86/uploads/video/rfid_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Jun. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-calendar-check-o bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-06-11</span>

            <h3 class="timeline-header"><a href="#">Plant Maintenance <span class="japanesse">(工場保全管理)</span></a></h3>

            <div class="timeline-body">
                Maintenance activity based on preventive and corrective
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-user-secret bg-yellow"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-06-04</span>

            <h3 class="timeline-header"><a href="#">Finish Good Inspection <span class="japanesse">(完成品出荷の管理検査)</span></a></h3>

            <div class="timeline-body">
                Information from QA inspection
            </div>
        </div>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            May. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-bar-chart bg-aqua"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-05-25</span>

            <h3 class="timeline-header"><a href="#">Shipping Performance <span class="japanesse">(出荷パフォーマンス)</span></a></h3>

            <div class="timeline-body">
                Information shipping based on shipping plan vs actual output
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-truck bg-light-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-05-03</span>

            <h3 class="timeline-header"><a href="#">Shipping Control <span class="japanesse">(出荷管理)</span></a></h3>

            <div class="timeline-body">
                To Control production  appropiate shipping plan
            </div>
        </div>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Apr. 2018
        </span>
    </li>

    <li>
        <i class="fa fa-star bg-maroon"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-04-24</span>

            <h3 class="timeline-header"><a href="#">MITA Initial Release <span class="japanesse"></span></a></h3>
        </div>
    </li>
    <!--<li class="time-label">
        <span class="bg-purple">
            Apr. 2018
        </span>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Mar. 2018
        </span>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Feb. 2018
        </span>
    </li>

    <li class="time-label">
        <span class="bg-purple">
            Jan. 2018
        </span>
    </li>-->
</ul>
