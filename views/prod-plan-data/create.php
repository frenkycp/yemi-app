<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WipEffTbl $model
*/

$this->title = Yii::t('models', 'Wip Eff Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Wip Eff Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud wip-eff-tbl-create">

    <h1>
        <?= Yii::t('models', 'Wip Eff Tbl') ?>
        <small>
                        <?= Html::encode($model->lot_id) ?>
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
