<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm; 

$this->title = [
    'page_title' => 'WIP Data Add Reason Form <span class="text-green japanesse"></span>',
    'tab_title' => 'WIP Data Add Reason Form',
    'breadcrumbs_title' => 'WIP Data Add Reason Form'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
?> 
<div class="giiant-crud wip-dtr-update">
    <div class="wip-dtr-form">
        <?php $form = ActiveForm::begin([ 
        'id' => 'WipDtr',
        //'method' => 'post',
        //'layout' => 'horizontal',
        //'action' => Url::to(['wip-plan-actual-report/reason']),
        'enableClientValidation' => true, 
        'errorSummaryCssClass' => 'error-summary alert alert-danger', 
        ] 
        ); 
        ?> 
        <?= '';//$form->field($model, 'dtr_id')->hiddenInput()->label(false); ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <?= $form->field($model, 'slip_id')->textInput(['readonly' => true])->label('Slip Number'); ?>
                                <div class="form-group">
                                    <?= Html::label('Location', 'location', ['class' => 'control-label']); ?>
                                    <?= Html::input('text', 'location', $location, ['class' => 'form-control', 'readonly' => true]); ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::label('Model', 'model_group', ['class' => 'control-label']); ?>
                                    <?= Html::input('text', 'model_group', $model_group, ['class' => 'form-control', 'readonly' => true]); ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::label('Child', 'child', ['class' => 'control-label']); ?>
                                    <?= Html::input('text', 'child', $child, ['class' => 'form-control', 'readonly' => true]); ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::label('Child Description', 'child_desc', ['class' => 'control-label']); ?>
                                    <?= Html::input('text', 'child_desc', $child_desc, ['class' => 'form-control', 'readonly' => true]); ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::label('Summary Qty', 'qty', ['class' => 'control-label']); ?>
                                    <?= Html::input('text', 'qty', $qty, ['class' => 'form-control', 'readonly' => true]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <?= $form->field($model, 'delay_userid')->textInput(['readonly' => true])->label('User ID'); ?>
                                <?= $form->field($model, 'delay_userid_desc')->textInput(['readonly' => true])->label('Username'); ?>
                                <?= $form->field($model, 'delay_category')->dropDownList(\Yii::$app->params['delay_category_arr'])->label('Category'); ?>
                                <?= $form->field($model, 'delay_detail')->textArea(['rows' => 8, 'style' => 'resize: none;'])->label('Detail'); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                
                


                <hr/> 
                <?php echo $form->errorSummary($model); ?>

                <?= Html::submitButton( 
                '<span class="glyphicon glyphicon-check"></span> Update Reason', 
                [ 
                'id' => 'save-' . $model->formName(), 
                'class' => 'btn btn-success' 
                ] 
                ); 
                ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        </div>
</div>