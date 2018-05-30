<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SernoOutput $model
*/

$this->title = Yii::t('app', 'Serno Output');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Serno Outputs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud serno-output-create">

    <h1>
        <?= Yii::t('app', 'Serno Output') ?>
        <small>
                        <?= $model->pk ?>
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
