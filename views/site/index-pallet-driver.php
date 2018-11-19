<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = false;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead"><?= \Yii::$app->user->identity->name; ?></p>
        <p><?= Html::a('Start Application', ['pallet-transporter/index'], ['class' => 'btn btn-lg btn-success']); ?></p>
    </div>
</div>
