<?php

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
            Oct. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-02-24</span>

            <h3 class="timeline-header"><a href="#">FA Defect Ratio<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                FA Defect Ratio
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202010_defect_ratio.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Oct. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-10-24</span>

            <h3 class="timeline-header"><a href="#">Ship Reservation Data (internal) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Ship Reservation Data
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202010_ship_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Oct. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-10-24</span>

            <h3 class="timeline-header"><a href="#">Parking Efficiency (RFID) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Parking Efficiency
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202010_rfid_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>


    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Oct. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-10-24</span>

            <h3 class="timeline-header"><a href="#">Koyemi Visitor Max-Capacity <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Koyemi Visitor Max-Capacity
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202010_koyemi_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Sept. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-09-24</span>

            <h3 class="timeline-header"><a href="#">Daily Driver Report<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Daily Driver Report
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202009_driver_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Sept. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-09-24</span>

            <h3 class="timeline-header"><a href="#">Digital Stock Taking<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Digital Stock Taking
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202009_stocktake_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


 <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Sept. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-09-24</span>

            <h3 class="timeline-header"><a href="#">Air Pressure Monitoring (IoT) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Air Pressure Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202009_air_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Aug. 20
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-08-24</span>

            <h3 class="timeline-header"><a href="#">Manager Trip Report<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Laporan perjalanan Tol dan besin
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202008_bentol_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Aug. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-08-24</span>

            <h3 class="timeline-header"><a href="#">Printer Usage Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Printer Usage
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202008_print_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Aug. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-08-24</span>

            <h3 class="timeline-header"><a href="#">Information Status Meetingroom and Toilet<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Information Status Meetingroom and Toilet
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202008_office_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jul. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-07-24</span>

            <h3 class="timeline-header"><a href="#">Hai MITA ( YEMI ChatBot )<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                YEMI ChatBot
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202007_chatbot_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>


<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jul. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-07-24</span>

            <h3 class="timeline-header"><a href="#">Power Consumption Monitoring (IoT) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Power Consumption Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202007_power_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Jun. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-06-24</span>

            <h3 class="timeline-header"><a href="#">Network Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Network Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202006_network_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
                <?= Html::img('@web/uploads/ABOUT/202006_network_02.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            May. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-05-24</span>

            <h3 class="timeline-header"><a href="#">Phone Daily Usage Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Phone Daily Usage
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202005_pabx_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
                <?= Html::img('@web/uploads/ABOUT/202005_pabx_02.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Apr. 2020
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2020-04-24</span>

            <h3 class="timeline-header"><a href="#">Daily Attendance Visualizaztion<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Daily Attendance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202004_Att_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2020-03-25</span>

            <h3 class="timeline-header"><a href="#">SCM vs FLO Progress<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Display Progress
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202003_SCMvsFLO_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
                <?= Html::img('@web/uploads/ABOUT/202003_SCMvsFLO_02.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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

            <h3 class="timeline-header"><a href="#">Live Cooking Service<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Live Cooking Service
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202004_canteen_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2020-01-24</span>

            <h3 class="timeline-header"><a href="#">Server Status Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Server Status Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202001_server_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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

    !-- timeline time label -->
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
            <span class="time"><i class="fa fa-clock-o"></i> 2020-12-24</span>

            <h3 class="timeline-header"><a href="#">Speaker - Seasoning and Finish Product Monitoring ( Beacon ) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
               Seasoning and Finish Product Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201912_spu_beacon_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>




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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-02-24</span>

            <h3 class="timeline-header"><a href="#">E-News<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                E-News for My Company News
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201912_enews1.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
                <?= Html::img('@web/uploads/ABOUT/201912_enews2.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-12-24</span>

            <h3 class="timeline-header"><a href="#">Dandori Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
               Dandori Monitoring Long Range
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201912_dandori_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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
            Nov. 19
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-11-24</span>

            <h3 class="timeline-header"><a href="#">Maintenance Sparepart Control<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                System untuk mengontrol Sparepart Miantenance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201909_mnt_part_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-11-24</span>

            <h3 class="timeline-header"><a href="#">Lot WIP Monitoring ( Beacon ) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                WIP Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201911_lot_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Nov. 2019
        </span>
    </li>


    <!-- /.timeline-label -->


    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-11-24</span>

            <h3 class="timeline-header"><a href="#">Ovenroom Monitoring ( Beacon ) <span class="japanesse"></span></a></h3>

            <div class="timeline-body">
               Oven Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201911_pnt_beacon_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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
            Sept. 19
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-09-08</span>

            <h3 class="timeline-header"><a href="#">Preventive and Corrective Action Maintenance</a></h3>

            <div class="timeline-body">
                Digital Preventive and Corrective Action
                <hr>
                <div class="row">
                    <div class="col-sm-12" style="height: <?=  $image_height;?>">
                        <?= '<video height="' . $image_height . '" controls>
                                    <source src="http://10.110.52.5:86/uploads/video/202008_mnt_01.mp4" type="video/mp4">
                                </video>' ?>
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
            Aug. 2019
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-08-24</span>

            <h3 class="timeline-header"><a href="#">MTTR and MTBF Average Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                MTTR and MTBF
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201908_mttr_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-07-24</span>

            <h3 class="timeline-header"><a href="#">Picking Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Picking Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201907_picking.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-08-24</span>

            <h3 class="timeline-header"><a href="#">E-Setlist SMT<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Auto setlist and Control Stock Material SMT
                <br/>
                <?= Html::img('@web/uploads/ABOUT/202008_SMT.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-08-24</span>

            <h3 class="timeline-header"><a href="#">Overtime Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Overtime Mnitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201908_ot_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-07-24</span>

            <h3 class="timeline-header"><a href="#">IoT Utilization Machine<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                IoT Machine
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201907_iotww_01.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
                <?= Html::img('@web/uploads/ABOUT/201907_iotww_02.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
                <?= Html::img('@web/uploads/ABOUT/201907_iotww_03.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>
            </div>
        </div>
    </li>

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
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-04-24</span>

            <h3 class="timeline-header"><a href="#">Milkrun Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Milkrun Material Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201904_milkrun.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


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
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-03-24</span>

            <h3 class="timeline-header"><a href="#">JIT Monitoring<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                JIT Material Monitoring
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201903_jit.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>



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
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2019-02-24</span>

            <h3 class="timeline-header"><a href="#">My-HR<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Self Service My HR and Q&A
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201902_my_hr.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">FA Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring Final Assy Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_fa_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>



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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">Injection Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring Injection Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_inj_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>



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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">Woodworking Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring Woodworking Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_ww_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>



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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">Painting Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring Painting Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_ptg_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>



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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">PCB Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring PCB Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_pcb_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">SPU Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring SPU Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_spu_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>

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
            <span class="time"><i class="fa fa-clock-o"></i> 2019-01-24</span>

            <h3 class="timeline-header"><a href="#">SMT Today<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                Monitoring SMT Performance
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201901_smt_today.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>
    </li>


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
                                    <source src="http://10.110.52.5:86/uploads/video/go_picking_new.mp4" type="video/mp4">
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
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-12-24</span>

            <h3 class="timeline-header"><a href="#">E-Kaizen<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                System E-Kaizen  
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201902_Kaizen.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>      
    </li>


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
                                    <source src="http://10.110.52.5:86/uploads/video/smt_new.mp4" type="video/mp4">
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
                                    <source src="http://10.110.52.5:86/uploads/video/go_pallet_new.mp4" type="video/mp4">
                                </video>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <!-- END timeline item -->



<!-- timeline time label -->
    <li class="time-label">
        <span class="bg-purple">
            Oct. 2018
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-10-24</span>

            <h3 class="timeline-header"><a href="#">PE Development<span class="japanesse"></span></a></h3>

            <div class="timeline-body">
                PE Product Development 
                <br/>
                <?= Html::img('@web/uploads/ABOUT/201810_pe.png', ['class' => 'attachment-img', 'height' => $image_height]); ?>

            </div>
        </div>      
    </li>



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
                                    <source src="http://10.110.52.5:86/uploads/video/dpr_new.mp4" type="video/mp4">
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
                                    <source src="http://10.110.52.5:86/uploads/video/go_wip_new.mp4" type="video/mp4">
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
                                    <source src="http://10.110.52.5:86/uploads/video/rfid_new.mp4" type="video/mp4">
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
