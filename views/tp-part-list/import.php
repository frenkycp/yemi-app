<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\bootstrap\Tabs;
use kartik\spinner\Spinner;

$this->title = 'Import Data';
$this->params['breadcrumbs'][] = ['label' => 'TP Part List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="giiant-crud gmc-material-import">
    <p class="pull-left">
        <?= Html::a('Cancel', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
    </p>
    
    <div class="clearfix"></div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
        	<h2>TP Part List</h2>
    	</div>
        <div class="panel-body">
            <div class="vendor-import-form">
                <?php $form = ActiveForm::begin([
                'id' => 'MaterialTable',
                'layout' => 'horizontal',
                'enableClientValidation' => true,
                'errorSummaryCssClass' => 'error-summary alert alert-error',
                'options' => ['enctype' => 'multipart/form-data']
                ]
                );
                ?>
                
                <div class="">
                    <?php $this->beginBlock('main'); ?>
                    <p>
                        <?= $form->field($model, 'speaker_model')->input('text') ?>
                        <?= $form->field($model, 'uploadFile')->fileInput() ?>
                    </p>
                    <?php $this->endBlock(); ?>
                    <?=
                    Tabs::widget(
                        [
                            'encodeLabels' => false,
                            'items' => [[
                                'label'   => 'Input Form',
                                'content' => $this->blocks['main'],
                                'active'  => true,
                            ]],
                        ]
                    );
                    ?>
                    <hr/>
                    <?php echo $form->errorSummary($model); ?>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-check"></span> Import',
                        [
                            'id' => 'import-btn',
                            'class' => 'btn btn-success'
                        ]
                    );
                    ?>
                    
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>