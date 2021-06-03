<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SmtAiInsertPoint $model
*/

$this->title = Yii::t('models', 'Smt Ai Insert Point');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Smt Ai Insert Point'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->PART_NO, 'url' => ['view', 'PART_NO' => $model->PART_NO]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud smt-ai-insert-point-update">

    <h1>
                <?= Html::encode($model->PART_NO) ?>

        <small>
            <?= Yii::t('models', 'Smt Ai Insert Point') ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'PART_NO' => $model->PART_NO], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
