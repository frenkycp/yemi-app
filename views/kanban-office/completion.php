<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SapPoRcvSearch $searchModel
*/

$this->title = [
    'page_title' => 'Kanban Progress Completion',
    'tab_title' => 'Kanban Progress Completion',
    'breadcrumbs_title' => 'Kanban Progress Completion'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
    .btn-action {font-size: 1.2em;}
    ");

$this->registerJs("$(function() {
   $('.btn-finish').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

?>
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">Main Information</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <strong>Job Description</strong>
                <p class="text-muted"><?= $header->job_desc; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <strong>Job Source</strong>
                <p class="text-muted"><?= $header->job_source; ?></p>
            </div>
            <div class="col-sm-4">
                <strong>Job Priority</strong>
                <p class="text-muted"><?= $header->job_priority; ?></p>
            </div>
            <div class="col-sm-4">
                <strong>Confirmed Schedule Date</strong>
                <p class="text-muted"><?= $header->confirm_schedule_date == null ? '-' : date('Y-m-d', strtotime($header->confirm_schedule_date)); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title"><?= $header->kanbanFlowHdr->job_flow_desc; ?> (<?= $header->job_dtr_step_close ?>/<?= $header->job_dtr_step_total ?>)</div>
    </div>
    <div class="panel-body">
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">Actions</th>
                    <th>Description</th>
                    <th class="text-center">Schedule Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Last Update</th>
                    <th>Last Update By</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $key => $value): ?>
                    <tr>
                        <td class="text-center btn-action">
                            <?php
                            if ($header->job_stage == 2) {
                                if ($value->job_dtr_close_open == 'O') {
                                    echo Html::a('<i class="glyphicon glyphicon-check"></i>', '#', [
                                        'data-pjax' => '0',
                                        'id' => 'btn-finish',
                                        'value' => Url::to(['finish-job','job_dtr_seq' => $value->job_dtr_seq, 'status' => 'C']),
                                        'title' => 'Finish Job',
                                        'class' => 'showModalButton text-green'
                                    ]);
                                } else {
                                    echo Html::a('<i class="fa fa-undo"></i>', '#', [
                                        'data-pjax' => '0',
                                        'id' => 'btn-open',
                                        'value' => Url::to(['finish-job','job_dtr_seq' => $value->job_dtr_seq, 'status' => 'O']),
                                        'title' => 'Re-Open Job',
                                        'class' => 'showModalButton text-yellow'
                                    ]);
                                }
                                
                            } else {
                                echo '<i class="glyphicon glyphicon-check disabled-link"></i>';
                            }
                            ?>
                        </td>
                        <td><?= $value->job_dtr_no . '. ' . $value->job_dtr_desc; ?></td>
                        <td class="text-center"><?= date('Y-m-d', strtotime($value->job_dtr_schedule)); ?></td>
                        <td class="text-center"><?= $value->job_dtr_close_open == 'O' ? '<span class="badge bg-red">OPEN</span>' : '<span class="badge bg-green">CLOSE</span>'; ?></td>
                        <td class="text-center"><?= $value->job_dtr_user_last_update == null ? '-' : date('Y-m-d H:i', strtotime($value->job_dtr_user_last_update)); ?></td>
                        <td><?= $value->job_dtr_close_open_user_desc; ?></td>
                        <td><?= $value->job_dtr_close_reason; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>