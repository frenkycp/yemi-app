<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MntShiftSch $model
*/

$this->title = Yii::t('models', 'Create Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Create Schedule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mnt-shift-sch-create">

    <h1 style="display: none;">
        <?= Yii::t('models', 'Mnt Shift Sch') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation" style="display: none;">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <!--<hr />-->

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
