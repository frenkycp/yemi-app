<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'SHE Patrol Set Area <span class="japanesse text-green"></span>',
    'tab_title' => 'SHE Patrol Set Area',
    'breadcrumbs_title' => 'SHE Patrol Set Area'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

?>

<?php $form = ActiveForm::begin([
'id' => 'AuditPatrolTbl',
//'layout' => 'horizontal',
'enableClientValidation' => true,
'errorSummaryCssClass' => 'error-summary alert alert-danger',
'fieldConfig' => [
         'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
         /*'horizontalCssClasses' => [
             'label' => 'col-sm-2',
             #'offset' => 'col-sm-offset-4',
             'wrapper' => 'col-sm-8',
             'error' => '',
             'hint' => '',
         ],*/
     ],
]
);
?>

<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'area')->dropDownList(ArrayHelper::map(app\models\ShePatrolArea::find()->select('NAME')->groupBy('NAME')->orderBy('NAME')->all(), 'NAME', 'NAME')); ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'team')->dropDownList(\Yii::$app->params['she_patrol_team']); ?>
    </div>
</div>
<?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> Submit',
                [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
                ]
                );
                ?>

                <?=             Html::a(
                    'Cancel',
                    \yii\helpers\Url::previous(),
                    ['class' => 'btn btn-warning']) ?>

<?php ActiveForm::end(); ?>