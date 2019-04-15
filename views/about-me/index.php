<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = [
    'page_title' => 'Data Flow & Site Timeline <span class="japanesse text-green"></span>',
    'tab_title' => 'Data Flow & Site Timeline',
    'breadcrumbs_title' => 'Data Flow & Site Timeline'
];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$this->registerJs("$(function() {
   $('.btn-video').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");


date_default_timezone_set('Asia/Jakarta');

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
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <span><b><u>GO-WIP</u></b></span>
                                <?= '<video width="100%" height="240" controls>
                    <source src="http://localhost/yemi-app/web/uploads/video/Go WIP.mp4" type="video/mp4">
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

            <h3 class="timeline-header"><a href="#">WH FG Control <span class="japanesse">(完成品倉庫管理)</span></a></h3>

            <div class="timeline-body">
                Monitoring finish good stock according in and out goods
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
