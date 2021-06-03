<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SmtAiInsertPoint $model
*/

$this->title = Yii::t('models', 'Smt Ai Insert Point');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Smt Ai Insert Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud smt-ai-insert-point-create">

    <h1>
                <?= Html::encode($model->PART_NO) ?>
        <small>
            <?= Yii::t('models', 'Smt Ai Insert Point') ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
