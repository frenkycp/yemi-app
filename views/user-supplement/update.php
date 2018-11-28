<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\UserSupplement $model
*/

$this->title = Yii::t('models', 'User Supplement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'User Supplement'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id_user, 'url' => ['view', 'id_user' => $model->id_user]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud user-supplement-update">

    <h1>
        <?= Yii::t('models', 'User Supplement') ?>
        <small>
                        <?= Html::encode($model->id_user) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id_user' => $model->id_user], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
