<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\EmpPermitTbl $model
*/

$this->title = Yii::t('models', 'Emp Permit Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Emp Permit Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud emp-permit-tbl-create">

    <h1>
                <?= Html::encode($model->ID) ?>
        <small>
            <?= Yii::t('models', 'Emp Permit Tbl') ?>
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
