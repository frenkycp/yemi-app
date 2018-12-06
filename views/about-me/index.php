<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = [
    'page_title' => 'Site Map <span class="japanesse text-green"></span>',
    'tab_title' => 'About Me',
    'breadcrumbs_title' => 'About Me'
];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
                ...
                Content goes here
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
                ...
                Content goes here
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
                ...
                Content goes here
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
                ...
                Content goes here
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
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-bicycle bg-teal"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-09-26</span>

            <h3 class="timeline-header"><a href="#">GO-WIP Monitor <span class="japanesse">（仕掛り配達モニター）</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
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
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-calendar bg-green"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-08-20</span>

            <h3 class="timeline-header"><a href="#">Manpower Attendance <span class="japanesse">(勤怠管理)</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-balance-scale bg-aqua"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-08-02</span>

            <h3 class="timeline-header"><a href="#">Sales Control <span class="japanesse">(売上管理)</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
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
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-sitemap bg-maroon"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-07-30</span>

            <h3 class="timeline-header"><a href="#">Manpower Planning <span class="japanesse">(要員計画）</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-cubes bg-orange"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-07-03</span>

            <h3 class="timeline-header"><a href="#">WH FG Control <span class="japanesse">(完成品倉庫管理)</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
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
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-user-secret bg-yellow"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-06-04</span>

            <h3 class="timeline-header"><a href="#">Finish Good Inspection <span class="japanesse">(完成品出荷の管理検査)</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
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
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li>
        <i class="fa fa-truck bg-light-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 2018-05-03</span>

            <h3 class="timeline-header"><a href="#">Shipping Control <span class="japanesse">(出荷管理)</span></a></h3>

            <div class="timeline-body">
                ...
                Content goes here
            </div>
        </div>
    </li>

    <li class="time-label">
        <i class="fa fa-clock-o bg-gray"></i>
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