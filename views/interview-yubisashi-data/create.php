<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\EmpInterviewYubisashi $model
*/

$this->title = Yii::t('models', 'Emp Interview Yubisashi');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Emp Interview Yubisashis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud emp-interview-yubisashi-create">

    <h1>
                <?= Html::encode($model->ID) ?>
        <small>
            <?= Yii::t('models', 'Emp Interview Yubisashi') ?>
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
