<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use yii\web\View;

/**
* @var yii\web\View $this
* @var app\models\MrbsEntry $model
*/

$this->title = [
    'page_title' => null,
    'tab_title' => 'Add Member',
    'breadcrumbs_title' => 'Add Member'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$this->registerCss("
    .content-header {text-align: center; }
    .users-list>li img {width: 80px; height: 80px; object-fit: cover;}
    .box {text-align: center;}
    ");

$this->registerJs("$(function() {
   $('#btn-complete').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );
?>

<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Room Name</h3>
            </div>
            <div class="box-body">
                <span><b><?= $room_tbl->room_desc; ?></b></span>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Meeting Description</h3>
            </div>
            <div class="box-body">
                <span><b><?= $room_tbl->room_event; ?></b></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">YEMI Employee</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab">Visitor</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php $form = ActiveForm::begin([
                    'id' => 'MrbsEntry',
                    //'layout' => 'horizontal',
                    'enableClientValidation' => true,
                    'errorSummaryCssClass' => 'error-summary alert alert-danger',
                    /*'fieldConfig' => [
                             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                             'horizontalCssClasses' => [
                                 'label' => 'col-sm-2',
                                 #'offset' => 'col-sm-offset-4',
                                 'wrapper' => 'col-sm-8',
                                 'error' => '',
                                 'hint' => '',
                             ],
                         ],*/
                    ]
                    );
                    ?>

                    <?= $form->field($model, 'nik', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus'
                        ]
                    ])->textInput(['placeholder' => 'Input NIK Here', 'class' => 'text-center form-control'])->label(false); ?>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php $form = ActiveForm::begin([
                        'method' => 'post',
                        //'layout' => 'horizontal',
                        'action' => Url::to(['mrbs-entry/add-visitor']),
                    ]); ?>
                    <div class="row">
                        <div class="col-md-9 com-sm-5">
                            <div class="form-group">
                                <?= Select2::widget([
                                    'name' => 'pk',
                                    'data' => ArrayHelper::map(app\models\Visitor::find()
                                        ->select([
                                            'pk',
                                            'id_name' => 'CONCAT(visitor_name, \' - \', visitor_comp)'
                                        ])
                                        ->where([
                                            'DATE(tgl)' => date('Y-m-d')
                                    ])->all(), 'pk', 'id_name'),
                                    'options' => [
                                        'placeholder' => 'Select visitor ...',
                                        'class' => 'form-control'
                                    ],
                                ]); ?>
                                <input type="hidden" name="room_id" value="<?= $room_tbl->room_id; ?>">
                                <input type="hidden" name="room_desc" value="<?= $room_tbl->room_desc; ?>">
                                <input type="hidden" name="event_id" value="<?= $room_tbl->event_id; ?>">
                                <input type="hidden" name="room_event" value="<?= $room_tbl->room_event; ?>">
                                <input type="hidden" name="start_time" value="<?= $room_tbl->start_time; ?>">
                                <input type="hidden" name="end_time" value="<?= $room_tbl->end_time; ?>">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <?= Html::submitButton('Add',
                            [
                            'class' => 'btn btn-success btn-block'
                            ]
                            );
                            ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="box box-primary box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Member List</h3>
    </div>
    <div class="box-body no-padding">
        <?php
        if ($total_member == null) {
            echo '<div class="col-md-12"><span>No Member</span></div>';
        } else {
            //echo '<ul class="users-list clearfix">';
            foreach ($total_member as $key => $value) {
                /*$filename = $value['NIK'] . '.jpg';
                $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;

                echo '<li>';
                if (file_exists($path)) {
                    echo Html::img('@web/uploads/yemi_employee_img/' . $value['NIK'] . '.jpg', [
                        'class' => 'img-circle',
                    ]);
                } else {
                    echo Html::img('@web/uploads/profpic_02.png', [
                        'class' => 'img-circle',
                    ]);
                }
                echo '<a class="users-list-name" href="#">' . $value['NAMA_KARYAWAN'] . '</a>';
                echo '<span class="users-list-date"><b>' . date('H:i', strtotime($value['last_update'])) . '</b></span>';
                echo '</li>';*/
                
            }
            //echo '</ul>';
        }
        ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php
        $options = [
            'class' => 'btn btn-lg btn-success btn-block',
        ];
        if ($total_member == null) {
            $options = [
                'class' => 'btn btn-lg btn-success btn-block',
                'disabled' => 'disabled',
                'onclick' => 'return false;'
            ];
        }
        ?>
        <?= Html::a('FINISH', ['finish-meeting', 'room_id' => $room_tbl->room_id, 'event_id' => $room_tbl->event_id], $options); ?>
    </div>
</div>