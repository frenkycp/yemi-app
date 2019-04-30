<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\WipLimitQty $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="wip-limit-qty-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WipLimitQty',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>
      
      <div class="panel panel-primary">
          <div class="panel-body">
              <?= $form->field($model, 'child_analyst')->textInput(['readonly' => 'readonly']) ?>
              <?= $form->field($model, 'child_analyst_desc')->textInput(['readonly' => 'readonly']) ?>
              <?= $form->field($model, 'limit_qty')->textInput(['type' => 'number']) ?>
          </div>
          <div class="panel-footer">
              <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>
          </div>
      </div>      

<!-- attribute child_analyst -->
			

<!-- attribute child_analyst_desc -->
			

<!-- attribute limit_qty -->
			
        
        

        

        <?php ActiveForm::end(); ?>

    </div>

</div>

